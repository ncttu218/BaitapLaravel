<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Webklex\IMAP\Client;
use App\Original\Util\SessionUtil;
use App\Original\Util\DBUtil;
use App\Original\Util\ImageUtil;
use App\Original\Util\MailSenderUtil;
use App\Models\EmailSettings;
use App\Lib\Util\MailParserUtil;
use DB;

/**
 * 新着メールを受信する
 *
 * @author ahmad
 */
class MailBlogRegisterPerlCommand extends Command {

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mailblog:perl-fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perlで新着メールを受信する';

    /**
     * メールアドレスのリスト
     * @var array
     */
    private $emails = [];

    /**
     * メールデータの月
     * @var string
     */
    private $month;

    /**
     * 記事の登録完了の通知
     */
    const NOTIFICATION_TYPE_POST_SUCCEEDED = 0;

    /**
     * 記事の登録失敗の通知
     */
    const NOTIFICATION_TYPE_POST_FAILED = 1;

    /**
     * 未登録メールの通知
     */
    const NOTIFICATION_TYPE_UNREGISTERED_EMAIL = 2;

    /**
     * メールアドレスを登録
     */
    const NOTIFICATION_TYPE_EMAIL_REGISTRATION_SUCCEED = 3;

    /**
     * 未登録のアドレス
     */
    const NOTIFICATION_TYPE_EMAIL_REGISTRATION_FAILED = 4;
    
    /**
     * 内部サーバーに画像アップ
     */
    const UPLOAD_SERVER_INTERNAL = 0;
    /**
     * 外部サーバーに画像アップ
     */
    const UPLOAD_SERVER_EXTERNAL = 1;
    /**
     * 画像アップの対象
     * @var int
     */
    private $uploadServer;
    /**
     * ホスト名
     * @var string
     */
    private $hostname;
    
    /**
     * 公開フォルダー名
     */
    const PUBLIC_DIRECTORY_NAME = 'hcBbs';
    /**
     * ステージング環境の情報
     */
    const STAGING_SERVER_HOSTNAME = 'ip-10-90-20-31.ap-northeast-1.compute.internal';
    const STAGING_SERVER_BASE_URL = 'https://cgi3-aws.hondanet.staging-hondanet.net';
    /**
     * 本番環境の情報
     */
    const PRODUCTION_SERVER_HOSTNAME = 'ip-10-0-20-31.ap-northeast-1.compute.internal';
    const PRODUCTION_SERVER_BASE_URL = 'https://cgi3-aws.hondanet.co.jp';
    /**
     * 画像サーバー
     */
    //const IMAGE_UPLOADING_URL = 'http://10.90.20.40/cgi/upload_img.php';
    const IMAGE_UPLOADING_URL = 'http://image.hondanet.co.jp/cgi/upload_img.php';
    
    /**
     * 使うメールアドレス → 自分に送る防止のため
     */
    const MY_EMAIL_ADDRESS = 'aws-upload2@hondanet.co.jp';
    //const MY_EMAIL_ADDRESS = 'aws-upload-test@hondanet.co.jp';
    
    /**
     * 転送メールアドレスのパターン
     */
    const FORWARD_EMAIL_FORMAT = '{hanshaCode}.{systemName}@hondanet.co.jp';
    //const FORWARD_EMAIL_FORMAT = '{hanshaCode}.{systemName}-test@hondanet.co.jp';
    
    /**
     * メールサーバーのホスト → 転送メール機能のために
     */
    const EMAIL_HOST = 'hondanet.co.jp';
    
    /**
     * メール設定登録用の件名
     */
    const EMAIL_REGISTRATION_SUBJECT = 'EMAIL SETTING REGISTRATION';
    
    /**
     * サーバーからの通知のメールアドレス
     */
    const SERVER_NOTIFICATION_EMAIL = 'cgi@hondanet.co.jp';

    /**
     * メインの処理
     * @return void
     */
    public function handle() {
        try {
            $this->runCore();
        } catch (\Exception $ex) {
            echo $ex->getMessage() . PHP_EOL;
            $logFile = storage_path('logs/debug.log');
            $file = $ex->getFile() . ':' . $ex->getLine();
            $this->writeLog($file . ': ' . $ex->getMessage(), $logFile);
        }
    }

    /**
     * メインの処理
     * @return void
     */
    public function runCore() {
        // ホスト名
        $this->hostname = exec('hostname');
        // アップ流れ
        if ($this->hostname == self::PRODUCTION_SERVER_HOSTNAME) {
            // 本番は外部サーバーにアップ
            $this->uploadServer = self::UPLOAD_SERVER_EXTERNAL;
        } else {
            // ステージングとローカルは内部サーバーにアップ
            $this->uploadServer = self::UPLOAD_SERVER_INTERNAL;
        }
        
        $time = date('d/m/Y H:i:s');
        $this->comment("メールで自動投稿の処理が開始しました。【{$time}】");

        // 一時的なメールのファイル
        $path = storage_path('mailer/temp');
        $files = array_diff(
            preg_grep('/\.(eml)$/', scandir($path)),
            array('.', '..')
        );
        
        // メールを受信する
        $emailCount = (int)$this->fetchEmail();
        // メールがない、一時的なメールのファイルがない場合
        if ($emailCount == 0 && count($files) == 0) {
            $this->closingMessage();
            return;
        }

        // メールデータの月
        $this->month = date('Ym');
        // メール投稿データの削除
        $this->dataRotating();

        // メールデータの月のフォルダー
        $monthDirName = storage_path("mailer/{$this->month}");
        // 月のフォルダー名
        if (!file_exists($monthDirName)) {
            mkdir($monthDirName, 0777, true);
        }
        
        foreach ($files as $tempMailFile) {
            $tempMailFile = "{$path}/{$tempMailFile}";
            
            $mailParser = new MailParserUtil();
            $emailData = $this->parseEmailFile($tempMailFile);
            // データ取得が失敗した場合
            if (count($emailData) === 0) {
                continue;
            }
            // 変数解凍
            extract($emailData);
            
            $mailAddr = $from->address;
            $senderName = $from->name;
            
            // 自分宛のメールアドレスが届いたら、削除
            // 無限大なループを避けるために
            if ($mailAddr == self::MY_EMAIL_ADDRESS) {
                $this->comment("自分宛のメールアドレスが届いたため、削除します。");
                $this->trashFile($tempMailFile);
                continue;
            }
            
            // メール種類の確認
            if ($from->mailbox . '@' . $from->host == self::SERVER_NOTIFICATION_EMAIL) {
                // 種類　→　メール登録
                $body = preg_replace('/<br\s*?\/?>/', '', $body);
                $emailAddr = trim($body);
                // メール内容の確認　→　メールアドレス
                if (!filter_var($emailAddr, FILTER_VALIDATE_EMAIL)) {
                    // ファイルを削除して、終了
                    $this->trashFile($tempMailFile);
                    $this->closingMessage();
                    return;
                }
                // メール件名の確認　→　販社コード・システム名・拠点コード・スタッフコード
                $pattern = self::EMAIL_REGISTRATION_SUBJECT .
                        ' - ([0-9]{7})\.(infobbs|staff)\.([0-9]+?)'
                        . '\.?(data[0-9]{6})?$/';
                if (!preg_match('/^' . $pattern, $subject, $match)) {
                    // ファイルを削除して、終了
                    $this->trashFile($tempMailFile);
                    $this->closingMessage();
                    return;
                }
                // 販社コード
                $hanshaCode = $match[1];
                // システム名
                $systemName = $match[2];
                // 店舗コード
                $shopCode = $match[3];
                // スタッフコード
                $staffCode = $match[4] ?? null;
                $this->createEmailSetting(
                        $emailAddr,
                        $systemName, 
                        $hanshaCode, 
                        $shopCode, 
                        $staffCode);
                // ファイルを削除して、終了
                $this->trashFile($tempMailFile);
                $this->closingMessage();
                return;
            } else if ($to->host == self::EMAIL_HOST &&
                    preg_match('/^([0-9]+?)\.(infobbs|staff)/', $to->mailbox, $match)) {
                // 種類　→　転送メール投稿
                // 販社コード
                $hanshaCode = $match[1];
                // システム名
                $systemName = $match[2];
                
                // 転送メールアドレス
                $forwardEmail = $to->address;
                // メールアドレスのリスト
                $this->loadEmailConfig($mailAddr, 'forwarded_' . $systemName, $forwardEmail);
                if (isset($this->emails[$mailAddr])) {
                    $this->emails[$mailAddr]['hanshaCode'] = $hanshaCode;
                }
            } else {
                // 種類　→　直接メール投稿
                // メールアドレスのリスト
                $this->loadEmailConfig($mailAddr, 'staff');
                if (!isset($this->emails[$mailAddr])) {
                    $this->loadEmailConfig($mailAddr, 'infobbs');
                }
            }

            // メールアドレスが登録しない場合
            if (!isset($this->emails[$mailAddr])) {
                // 登録されていないメールを削除
                $this->comment("「{$mailAddr}」が登録されていないため、削除します。");
                // 通知
                $this->sendNotificationMail(
                    $mailAddr, 
                    $senderName, 
                    null, 
                    null, 
                    self::NOTIFICATION_TYPE_UNREGISTERED_EMAIL,
                    ['recipient' => $to->address]
                );
                // メールファイルを削除
                $this->trashFile($tempMailFile);
                continue;
            }
            
            // 販社コード
            $hanshaCode = $this->emails[$mailAddr]['hanshaCode'] ?? null;
            // システム名
            $systemName = $this->emails[$mailAddr]['systemName'] ?? null;
            // 転送メールのシステム名を変更
            if ($systemName == 'forwarded_infobbs') {
                $systemName = 'infobbs';
            } else if ($systemName == 'forwarded_staff') {
                $systemName = 'staff';
            }
            
            // 拠点コード
            $shopCode = $this->emails[$mailAddr]['shopCode'] ?? null;
            // スタッフ番号
            $staffCode = $this->emails[$mailAddr]['staffCode'] ?? null;
            
            //ファイル名
            $mailAddrCode = preg_replace('/[\W]/', '_', $mailAddr);
            if ($systemName == 'infobbs') {
                $baseName = "{$sendDate}-{$hanshaCode}-{$systemName}-"
                        . "{$shopCode}-{$mailAddrCode}";
            } else {
                // 拠点コード
                $baseName = "{$sendDate}-{$hanshaCode}-{$systemName}-"
                        . "{$shopCode}-{$staffCode}-{$mailAddrCode}";
            }
            
            // 記事の情報
            $postInfo = [
                'hanshaCode' => $hanshaCode,
                'systemName' => $systemName
            ];
            // メールの内容ボディー
            $mailContent = $this->appendImage($body, $images, $postInfo);
            
            // フォルダー名
            $regName = "{$monthDirName}/{$baseName}.eml";

            // 登録されたメールをスキップ
            if (file_exists($regName)) {
                // 登録されていないメールを削除
                $this->comment("「{$baseName}」が登録されため、削除します。");
                // 通知
                $this->sendNotificationMail(
                    $mailAddr, 
                    $senderName, 
                    $hanshaCode, 
                    $systemName, 
                    self::NOTIFICATION_TYPE_POST_FAILED,
                    ['recipient' => $to->address]
                );
                // メールファイルを削除
                $this->trashFile($tempMailFile);
                continue;
            }

            // 本文が空欄の場合、スキップ
            if (empty($mailContent)) {
                // 通知
                $this->sendNotificationMail(
                    $mailAddr, 
                    $senderName, 
                    $hanshaCode, 
                    $systemName, 
                    self::NOTIFICATION_TYPE_POST_FAILED,
                    ['recipient' => $to->address]
                );
                // メールファイルを削除
                $this->trashFile($tempMailFile);
                continue;
            }

            // コールバック
            $callback = function ($hanshaCode) use(
                $systemName,
                $regName,
                $mailAddr,
                $senderName,
                $tempMailFile
            ) {
                // 登録されたメールをリネーム
                rename($tempMailFile, $regName);
                $this->cleanEmailTemp($tempMailFile);

                // 販社名
                $hanshaName = config('original.hansha_code')[$hanshaCode];

                // コンソールで情報を表示
                $this->comment("記事を登録しました。");
                $this->comment("\tメール： {$mailAddr}");
                $this->comment("\t販社： {$hanshaName}");
                $this->comment("----------------------------");

                // 通知
                $this->sendNotificationMail(
                    $mailAddr, 
                    $senderName, 
                    $hanshaCode, 
                    $systemName, 
                    self::NOTIFICATION_TYPE_POST_SUCCEEDED
                );
            };

            // 記事を登録
            $this->postBlog(
                $subject, 
                $mailContent, 
                $hanshaCode, 
                $shopCode, 
                $staffCode, 
                $systemName,
                $callback,
                ['mail' => $mailAddr]
            );
        }

        $this->closingMessage();
    }
    
    /**
     * 内容と画像のコンビ
     * 
     * @param string $body メールの内容
     * @param string $images 画像リスト
     * @param array $postInfo 投稿情報
     * @return string
     */
    public function appendImage($body, $images, $postInfo) {
        $imageStr = '';
        if (!preg_match('/\n$/', trim($body, ' '))) {
            $imageStr .= '<br />';
        }
        foreach ($images as $image) {
            $imageUrl = $this->uploadImage($image, $postInfo);
            $info = pathinfo($image);
            $imageStr .= '<img src="' . $imageUrl . '" alt="' . $info['filename'] . '" />';
        }
        
        return $body . $imageStr;
    }
    
    /**
     * メールファイルの情報を取得する
     * 
     * @param string $emailFile メールファイルのパス
     * @return array
     */
    public function parseEmailFile($emailFile) {
        // パス
        $info = pathinfo($emailFile);
        $filePath = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'];
        $jsonFile = $filePath . '.json';
        $jsonStr = file_get_contents($jsonFile);
        $jsonData = json_decode($jsonStr);
        if (!is_object($jsonData)) {
            return [];
        }
        
        // メール情報
        $body = nl2br($jsonData->body);
        $subject = $jsonData->subject;
        $sendDate = date('YmdHis', strtotime($jsonData->sendDate));
        
        // 画像
        $images = [];
        if (file_exists($filePath)) {
            $scan = array_diff(
                scandir($filePath),
                array('.', '..')
            );
            foreach ($scan as $item) {
                $images[] = $filePath . DIRECTORY_SEPARATOR . $item;
            }
        }
        
        $parseEmailAddr = function($emailAddr) {
            $emailAddr = trim($emailAddr);
            // 名前
            $name = null;
            if (preg_match('/^(.+?)<.+?>$/', $emailAddr, $match)) {
                $name = trim($match[1]);
            }
            // メールボックス
            $mailbox = null;
            // ホスト
            $host = null;
            if (preg_match('/^.*?<(.+?)>$/', $emailAddr, $match)) {
                list($mailbox, $host) = explode('@', $match[1]);
            } else {
                list($mailbox, $host) = explode('@', $emailAddr);
            }
            return [$name, $mailbox, $host];
        };
        
        // 宛先
        $to = app('stdClass');
        $match = $parseEmailAddr($jsonData->to);
        $to->name = trim($match[0]);
        $to->mailbox = $match[1];
        $to->host = $match[2];
        $to->address = $match[1] . '@' . $match[2];
        
        // 送信者
        $from = app('stdClass');
        $match = $parseEmailAddr($jsonData->from);
        $from->name = trim($match[0]);
        $from->mailbox = $match[1];
        $from->host = $match[2];
        $from->address = $match[1] . '@' . $match[2];
        
        return compact([
            'body',
            'subject',
            'from',
            'to',
            'sendDate',
            'images'
        ]);
    }
    
    /**
     * ファイルをゴミ箱に移動する
     * 
     * @param string $filename ファイル名
     */
    private function trashFile($filename) {
    	if (!file_exists($filename)) {
            return;
    	}
        // 1年前の先週
        $month = date('Ym');
        // 1年前のフォルダーを削除
        $dirName = storage_path("mailer/trash/{$month}");
        if (!file_exists($dirName)) {
            mkdir($dirName, 0777, true);
        }
        $info = pathinfo($filename);
        $trashFilename = $dirName . '/' . $info['basename'];
        rename($filename, $trashFilename);
        
        $this->cleanEmailTemp($filename);
    }
    
    /**
     * 一時的なメールファイルのデータを削除する
     * 
     * @param string $filename メールのファイル名
     */
    private function cleanEmailTemp($filename) {
        // JSONファイルを削除
        $info = pathinfo($filename);
        $fileDir = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'];
        $jsonFile = $fileDir . '.json';
        if (file_exists($jsonFile)) {
            echo 'DEL ' . $jsonFile . PHP_EOL;
            unlink($jsonFile);
        }
        
        // 画像ファイルを削除
        if (file_exists($fileDir)) {
            echo 'DEL ' . $fileDir . PHP_EOL;
            rmdir_recursively($fileDir);
        }
    }
    
    /**
     * 完了メッセージを表示
     */
    private function closingMessage() {
        $time = date('d/m/Y H:i:s');
        $this->comment("メールで自動投稿の処理が完了しました。【{$time}】");
    }

    /**
     * メールを受信する
     * @return string リスポンス
     */
    private function fetchEmail() {
        $command = 'perl ' . __DIR__ . '/pop3_mail_fetch.pl';
        $result = exec($command);
        return $result;
    }

    /**
     * 
     * @param string $emailAddr メールアドレス
     * @param string $recipientName 名前
     * @param string $hanshaCode 販社コード
     * @param string $systemName システム名
     * @param int $notificationType 通知のタイプ
     * @param array $extra エクストラ
     * @return string リスポンス
     */
    private function sendNotificationMail(
        $emailAddr,
        $recipientName,
        $hanshaCode,
        $systemName,
        $notificationType,
        array $extra = []
    ) {
        if ($systemName == 'infobbs') {
            // 送信者名
            $sender_name = '店舗ブログ管理システム';
            // 宛先の名前
            if (empty($recipientName)) {
                $recipientName = '店舗ブログ投稿者';
            }
        } else if ($systemName == 'staff') {
            // 送信者名
            $sender_name = 'スタッフブログ管理システム';
            // 宛先の名前
            if (empty($recipientName)) {
                $recipientName = 'スタッフブログ投稿者';
            }
        } else {
            // 送信者名
            $sender_name = '情報掲示板管理システム';
            // 宛先の名前
            $recipientName = '投稿者';
        }

        switch ($notificationType) {
            // 記事登録完了
            case self::NOTIFICATION_TYPE_POST_SUCCEEDED:
                // 掲載モード
                $published_mode = config("original.para.{$hanshaCode}."
                    . "published_mode") ?? '0';
                // 件名
                $subject = '投稿を受け付けました';
                if ($published_mode == '0') {
                    // 本文
                    $body = "{$recipientName}様\n\nメールによる投稿を受け付けました。"
                            . "公開ページにてご確認ください。";
                } else if ($published_mode == '1') {
                    // 本文
                    $body = "{$recipientName}様\n\nメールによる投稿を受け付けました。"
                            . "本社にて承認後公開されます。";
                }
                // ログ
                $this->writeLog("【登録完了】\n"
                        . "\tメールアドレス: {$emailAddr}\n"
                        . "\tシステム名: {$systemName}\n"
                        . "\t販社コード: {$hanshaCode}");
                break;

            // 記事登録失敗
            case self::NOTIFICATION_TYPE_POST_FAILED:
                // 件名
                $subject = '投稿エラーです';
                // 本文
                $body = "大変申し訳ございませんが、"
                        . "何らかのエラーが発生して投稿された記事を登録できませんでした。";
                // ログ
                $this->writeLog("【登録失敗】\n"
                        . "\tメールアドレス: {$emailAddr}\n"
                        . "\tシステム名: {$systemName}\n"
                        . "\t販社コード: {$hanshaCode}\n"
                        . "\t理由: 存在している記事・データエラー");
                break;

            // 未登録メール
            case self::NOTIFICATION_TYPE_UNREGISTERED_EMAIL:
                // 件名
                $subject = '未登録のアドレスです';
                // 本文
                $body = "大変申し訳ございませんが、"
                        . "このメールアドレス({$recipientName})はシステムに"
                        . "登録されておりません。\n"
                        . "管理画面の「携帯投稿用アドレス管理ページ」にて"
                        . "投稿用メールアドレスの登録をお願いします。";
                // ログ
                $this->writeLog("【登録失敗】\n"
                        . "\tメールアドレス: {$emailAddr}\n"
                        . "\t転送メール: {$extra['recipient']}\n"
                        . "\t理由: 未登録メールアドレス");
                break;

            // メール登録が完了する通知
            case self::NOTIFICATION_TYPE_EMAIL_REGISTRATION_SUCCEED:
                // 件名
                $subject = 'メールアドレスを登録しました';
                // 送信先のメールアドレス
                $targetEmail = "{$hanshaCode}.{$systemName}@" . self::EMAIL_HOST;
                // 差出人
                if (isset($extra['recipientName'])) {
                    $recipientName = $extra['recipientName'];
                }
                
                // 本文
                $body = "{$recipientName}様\n\n"
                        . "メール投稿システムにメールアドレスを登録しました。\n"
                        . "投稿は\n{$targetEmail}\n宛てにメールを送ると1分ほどで記事が登録されます。\n"
                        . "・メールの件名→タイトル\n"
                        . "・メールの本文→記事の本文\nとなります。\n"
                        . "画像を添付することもできます。\n";
                // ログ
                $this->writeLog("【メール投稿の設定完了】\n"
                        . "\tメールアドレス: {$emailAddr}\n"
                        . "\t転送メール: {$extra['recipient']}");
                break;

            // メール登録が完了する通知
            case self::NOTIFICATION_TYPE_EMAIL_REGISTRATION_FAILED:
                // 件名
                $subject = '未登録のアドレスです';
                // 送信先のメールアドレス
                $targetEmail = "{$hanshaCode}.{$systemName}@" . self::EMAIL_HOST;
                // 差出人
                if (isset($extra['recipientName'])) {
                    $recipientName = $extra['recipientName'];
                }
                
                // 本文
                $body = "大変申し訳ございませんが、"
                        . "このメールアドレス($emailAddr)はシステムに登録されておりません。\n"
                        . "管理画面の「携帯投稿用アドレス管理ページ」にて"
                        . "投稿用メールアドレスの登録をお願いします。\n";
                // ログ
                $this->writeLog("【メール投稿の設定失敗】\n"
                        . "\tメールアドレス: {$emailAddr}\n"
                        . "\t転送メール: {$extra['recipient']}");
                break;
        }

        $this->comment('通知メールを送信しました。');

        // AWSサービスでメールの送信
        return MailSenderUtil::awsSendMail([
            'MailSendAddress' => $emailAddr,
            'mail_format' => $body,
            'MailSubject' => $subject,
            'MailName' => $sender_name,
        ]);
    }
    
    /**
     * メールアドレス設定の登録
     * 
     * @param string $emailAddr メールアドレス
     * @param string $systemName システム名
     * @param string $hanshaCode 販社コード
     * @param string $shopCode 店舗コード
     * @param string $staffCode スタッフコード
     */
    private function createEmailSetting(
        $emailAddr,
        $systemName,
        $hanshaCode,
        $shopCode,
        $staffCode = null
    ) {
        // 送信先のメールアドレス
        $targetEmail = "{$hanshaCode}.{$systemName}@" . self::EMAIL_HOST;
        $realSystemName = "forwarded_{$systemName}";
        // メールの存在確認
        $emailData = EmailSettings::where('email', $emailAddr)
                ->where('shop_code', $shopCode)
                ->where('forward_email', $targetEmail);
        // 宛先の名前
        $recipientName = '店舗ブログ投稿者';
        // スタッフブログ
        if ($realSystemName == 'forwarded_staff') {
            // スタッフコードの絞込
            $emailData = $emailData->where('staff_code', $staffCode);
            // 宛先の名前
            $recipientName = 'スタッフブログ投稿者';
        }
        // 実行してみる
        try {
            $emailData = $emailData->first();
        } catch (\Exception $ex) {
            // 失敗したら、やめる
            return;
        }
        
        // メールアドレスが登録された場合、スキップ
        if ($emailData !== null) {
            return;
        }
        
        // メール設定の登録
        $emailSettingsMObj = new EmailSettings();
        // システム名
        $emailSettingsMObj->system_name = $realSystemName;
        // 転送メールアドレス
        $emailSettingsMObj->forward_email = $targetEmail;
        // メールアドレス
        $emailSettingsMObj->email = $emailAddr;
        // 拠点コード
        $emailSettingsMObj->shop_code = $shopCode;
        // スタッフ番号
        if ($staffCode !== null) {
            if (preg_match('/^data[0-9]+$/', $staffCode)) {
                $emailSettingsMObj->staff_code = $staffCode;
            } else {
                $emailSettingsMObj->staff_code = "data{$staffCode}";
            }
        }
        
        // メールアドレスを登録
        if ($emailSettingsMObj->save()) {
            $this->sendNotificationMail(
                $emailAddr,
                $recipientName,
                $hanshaCode,
                $systemName,
                self::NOTIFICATION_TYPE_EMAIL_REGISTRATION_SUCCEED,
                [
                    'recipientName' => $recipientName,
                    'recipient' => $targetEmail
                ]
            );
        }
    }

    /**
     * 記事を登録
     * @param string $title 記事のタイトル
     * @param string $content 記事の内容
     * @param string $hanshaCode 販社コード
     * @param string $shopCode 拠点コード
     * @param string $staffCode スタッフ番号
     * @param string $systemName システム名
     * @param Closure $callback コールバック
     */
    private function postBlog(
    $title, $content, $hanshaCode, $shopCode, $staffCode, $systemName, $callback,
            array $options = []
    ) {
        // テーブル名
        $tableName = "tb_{$hanshaCode}_{$systemName}";
        // 現在の日時
        $dateTime = date('Y-m-d H:i:s');
        // 記事番号
        list($registNumber, $postNumber) = $this->generateNewPostNumber($tableName);
        // 記事内容のエンコーディング調整
        $encType = mb_detect_encoding($content, mb_detect_order(), true);
        $content = iconv($encType . '//IGNORE', "UTF-8//IGNORE", $content);
        // メール
        $mailInfo = isset($options['mail']) && !empty($options['mail']) ?
                ': ' . $options['mail'] : '';
        // 記事をデータベースに登録
        $columns = [
            'title' => $title,
            'comment' => $content,
            'regist' => $registNumber,
            'number' => $postNumber,
            'shop' => $shopCode,
            'pos' => '3',
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
            'published' => 'ON',
            'add' => 'localhost',
            'agent' => 'PHP-Mailer' . $mailInfo,
        ];
        
        // 本社認証機能が有効する場合
        if ($systemName == 'infobbs') {
            $published_mode = config("original.para.{$hanshaCode}.published_mode") ?? '0';
            if ($published_mode == '1') {
                $columns['published'] = 'OFF';
                $columns['editflag'] = 'draft';
            }
        }
        // スタッフブログの場合
        else if ($systemName == 'staff') {
            $columns['treepath'] = $staffCode;
        }

        try {
            DB::table($tableName)->insert($columns);
            //　登録が完了した場合
            $callback($hanshaCode);
        } catch (\Exception $ex) {
            $this->comment($ex->getMessage());
        }
    }

    /**
     * メール投稿データの削除
     */
    private function dataRotating() {
        // 1年前
        $time = strtotime('-1 years');
        // 1年前の先週
        $month = date('Ym', $time);
        // 受信した1年前のフォルダーを削除
        $sentMailDirName = storage_path("mailer/{$month}");
        if (!file_exists($sentMailDirName)) {
            return;
        }
        rmdir_recursively($sentMailDirName);
        
        // ゴミ箱の1年前のフォルダーを削除
        $trashMailDirName = storage_path("mailer/trash/{$month}");
        if (!file_exists($trashMailDirName)) {
            return;
        }
        rmdir_recursively($trashMailDirName);
    }

    /**
     * 設定ファイルからメールアドレスのリストを作成
     * @param string $mailAddr メールアドレス
     */
    private function loadEmailConfig($mailAddr, $systemName, $forwardEmail = null) {
        // 配列に存在するなら、スキップ
        if (isset($this->emails[$mailAddr])) {
            return;
        }
        // 投稿アドレスモデルオブジェクトを取得
        $emailSettingsMObj = EmailSettings::where('email', $mailAddr)
                ->where('system_name', $systemName);
        // 転送メールの場合、絞り込み条件を追加する
        if ($systemName == 'forwarded_infobbs' || $systemName == 'forwarded_staff') {
            $emailSettingsMObj = $emailSettingsMObj
                    ->where('forward_email', $forwardEmail);
        }
        $emailSettingsMObj = $emailSettingsMObj->first();
        // メールアドレスが登録していない場合
        if ($emailSettingsMObj === null) {
            return;
        }

        $this->emails[$mailAddr] = [
            // 販社コード
            'hanshaCode' => $emailSettingsMObj->hansha_code,
            // 拠点コード
            'shopCode' => $emailSettingsMObj->shop_code,
            // スタッフ番号
            'staffCode' => $emailSettingsMObj->staff_code,
            // システム名
            'systemName' => $emailSettingsMObj->system_name,
            // 転送メール
            'forwardEmail' => $emailSettingsMObj->forward_email,
        ];
    }
    
    /**
     * アセットURLを取得
     * @param string $url 末尾のURL
     * @return string URL
     */
    private function getAssetUrl($url = '') {
        // ベースURL
        $baseUrl = '';
        // ホスト名
        $hostname = exec('hostname');
        // ステージング環境
        if ($hostname == self::STAGING_SERVER_HOSTNAME) {
            $baseUrl = self::STAGING_SERVER_BASE_URL . '/'
                    . self::PUBLIC_DIRECTORY_NAME;
        }
        // 本番環境
        else if ($hostname == self::PRODUCTION_SERVER_HOSTNAME) {
            $baseUrl = self::PRODUCTION_SERVER_BASE_URL . '/'
                    . self::PUBLIC_DIRECTORY_NAME;
        }
        // ローカル環境
        else {
            // ベースフォルダー
            $baseDir = preg_replace('/^.*?([a-zA-Z0-9-_]+?)[^a-zA-Z0-9-_]app$/',
                '$1', app_path());
            $baseDir .= '/' . self::PUBLIC_DIRECTORY_NAME;
            $baseUrl = url_auto($baseDir);
        }
        // アセットURL
        return $baseUrl . ($url != '' ? '/' . $url : '');
    }
    
    /**
     * 画像ファイルをアップして画像のURLを取得する
     * @param string $path 画像ファイルのパス
     * @param string $postInfo 記事情報
     *  ・hanshaCode 販社コード
     *  ・systemName システム名
     * @return string 画像のURL
     */
    private function copyImageToInternalServer($path, $postInfo) {
        // 販社コード
        $hanshaCode = $postInfo['hanshaCode'];
        // システム名
        $systemName = $postInfo['systemName'];
        
        // 画像のパス情報
        $fileName = basename($path);
        $this->comment("{$fileName} -> 画像コピー中");
        
        // ローカルにある画像を調整する
        $response = ImageUtil::copyAndAdjustLocalImage(
                $path, self::PUBLIC_DIRECTORY_NAME, $hanshaCode, $systemName);
        // アセットURLを取得
        return $this->getAssetUrl($response);
    }
    
    /**
     * 画像ファイルをアップして画像のURLを取得する
     * @param string $path 画像ファイルのパス
     * @param string $postInfo 記事情報
     *  ・hanshaCode 販社コード
     *  ・systemName システム名
     * @return string 画像のURL
     */
    private function uploadImageToExternalServerUsingExec($path, $postInfo) {
        // 日時
        $time = date('YmdHis');
        // 販社コード
        $hanshaCode = $postInfo['hanshaCode'];
        // システム名
        $systemName = $postInfo['systemName'];
        
        $url = self::IMAGE_UPLOADING_URL . "?id={$hanshaCode}/{$systemName}&time={$time}&debug=1";
        $command = "curl -s -F 'file=@{$path}' {$url}";
        $response = exec($command);
        
        if ($this->isInvalidImageServeResponse($response)) {
            $this->comment($response);
            // 画像のパス情報
            $fileName = basename($path);
            // エラーログ
            $logPath = dirname($path) . '/error.log';
            $logText = '[' . $fileName . '] ' . $response;
            $this->writeLog($logText, $logPath);
            return '';
        } else {
            // URLを作成
            return "//image.hondanet.co.jp/cgi/{$hanshaCode}/{$systemName}/"
                . "data/image/{$response}";
        }
    }

    /**
     * 画像ファイルをアップして画像のURLを取得する
     * @param string $path 画像ファイルのパス
     * @param string $postInfo 記事情報
     *  ・hanshaCode 販社コード
     *  ・systemName システム名
     * @return string 画像のURL
     */
    private function uploadImageToExternalServerUsingPhp($path, $postInfo) {
        $url = '';
        // 日時
        $time = date('YmdHis');
        // 販社コード
        $hanshaCode = $postInfo['hanshaCode'];
        // システム名
        $systemName = $postInfo['systemName'];
        // ターゲットURL
        $targetUrl = self::IMAGE_UPLOADING_URL . 
                "?id={$hanshaCode}/{$systemName}&time={$time}";
        // 画像のパス情報
        $fileName = basename($path);
        // MIMEタイプ
        $mimeType = mime_content_type($path);
        // 添付画像のデータ
        $options = [
            'useCookie' => false,
            'attachments' => [
                ['path' => $path, 'name' => $fileName, 'type' => $mimeType]
            ],
        ];

        // 画像アップサーバーの名前
        $remoteFileName = '';
        // 画像をアップする
        $this->comment("{$fileName} -> 画像アップ中");
        if (($response = http_get_contents($targetUrl, $options)) !== false) {
            if (preg_match('/Request Error:/', $response) ||
                    $this->isInvalidImageServeResponse($response)
            ) {
                $this->comment($response);
                // エラーログ
                $logPath = dirname($path) . '/error.log';
                $logText = '[' . $fileName . '] ' . $response;
                $this->writeLog($logText, $logPath);
                return '';
            }
            // リスポンスがURL
            $remoteFileName = $response;
        }
        // URLを作成
        $url = "//image.hondanet.co.jp/cgi/{$hanshaCode}/{$systemName}/"
                . "data/image/{$remoteFileName}";

        return $url;
    }
    
    /**
     * ログを書き込む
     * @param string $text ログのテキスト
     * @param string|null $filename ログファイルのパス
     */
    private function writeLog($text, $filename = null) {
        if ($filename === null) {
            $filename = storage_path("mailer/{$this->month}/summary.log");
        }
        $isExist = file_exists($filename);
        $text = date('Y-m-d H:i:s') . ' ' . $text . PHP_EOL;
        file_put_contents($filename, $text, FILE_APPEND);
        if (!$isExist) {
            @chmod($filename, 0777);
        }
    }

    /**
     * 画像アップサーバーのリスポンスをチェックする
     * @param string $response リスポンス
     * @return bool
     */
    private function isInvalidImageServeResponse($response) {
        return !preg_match('/\.(?:[jJ][pP][eE][gG]|'
                        . '[jJ][pP][gG]|'
                        . '[pP][nN][gG]|'
                        . '[gG][iI][fF]|'
                        . '[bB][mM][pP])$/', $response);
    }
    
    /**
     * 画像をアップロードする
     * 
     * @param string $filename 画像ファイル名
     * @param array $postInfo アップロードのデータ
     */
    private function uploadImage($filename, $postInfo) {
        if ($this->uploadServer == self::UPLOAD_SERVER_EXTERNAL) {
            // 外部サーバーに保存
            $url = $this->uploadImageToExternalServerUsingPhp(
                $filename,
                $postInfo
            );
        } else {
            // 内部サーバーに保存
            $url = $this->copyImageToInternalServer(
                $filename,
                $postInfo
            );   
        }
        return $url;
    }

    /**
     * 本文を添付画像に置換
     * @param string $mailContent 本文
     * @param array $files 画像ファイルのリスト
     * @param string $postInfo 記事情報
     *  ・hanshaCode 販社コード
     *  ・systemName システム名
     * @return string
     */
    private function replaceContentWithAttachmentImages(
        $mailContent, 
        $files,
        $postInfo = []
    ) {
        $mailContent = preg_replace_callback(
            '/(<img[\w\W]+?src=")cid:(.*?)(")/',
            function($match) use($files, $postInfo) 
            {
            // 添付ID
            $attachmentId = $match[2];
            // 画像のURL
            $this->uploadImage($files[$attachmentId], $postInfo);
            // 元のテキストに画像ファイルのURLを置換
            return $match[1] . $url . $match[3];
        }, $mailContent);

        return $mailContent;
    }

    /**
     * 新しい記事番号を生成する
     * @param string $tableName テーブル名
     * @return array
     *  0 -> 登録番号
     *  1 -> 記事番号
     */
    private function generateNewPostNumber($tableName) {
        // 新規テーブル
        $row = DB::table($tableName)
                ->orderBy('regist', 'DESC')
                ->take(1)
                ->get();
        // 最大番号計算
        if (count($row) == 0) {
            $num = 0;
        } else {
            $num = intval($row['0']->regist);
        }
        $num++;
        $number = "data" . substr("00000" . strval($num), -6);

        return [$num, $number];
    }

}
