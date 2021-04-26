<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Webklex\IMAP\Client;
use App\Original\Util\SessionUtil;
use App\Original\Util\DBUtil;
use App\Original\Util\MailSenderUtil;
use App\Models\EmailSettings;
use DB;

/**
 * 新着メールを受信する
 *
 * @author ahmad
 */
class MailBlogRegisterPhpCommand extends Command {

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mailblog:php-fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PHPで新着メールを受信する';
    
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
    const NOTIFICATION_TYPE_UNREGISTERED_MAIL = 2;

    /**
     * メインの処理
     * @return void
     */
    public function handle() {
        
        // メールデータの月
        $this->month = date('Ym');
        // メール投稿データの削除
        $this->dataRotating();

        //Connect to the IMAP Server
        $oClient = new Client();
        $oClient->connect();

        //Get all Mailboxes
        /** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
        $aFolder = $oClient->getFolders();
        
        $time = date('d/m/Y H:i:s');
        $this->comment("メールで自動投稿の処理が開始しました。【{$time}】");

        //Loop through every Mailbox
        /** @var \Webklex\IMAP\Folder $oFolder */
        foreach ($aFolder as $oFolder) {

            //Get all Messages of the current Mailbox $oFolder
            /** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
            $aMessage = $oFolder->messages()->all()->get();
            
            $count = count($aMessage);
            $this->comment("新着メールが{$count}件見つかりました。");

            /** @var \Webklex\IMAP\Message $oMessage */
            foreach ($aMessage as $oMessage) {
                $senderObj = $oMessage->getFrom()[0];
                // メールアドレス
                $mailAddr = $senderObj->mail;
                // 名前
                $senderName = $senderObj->personal;
                
                echo $mailAddr . PHP_EOL;
                continue;
                
                // メールアドレスのリスト
                $this->loadEmailConfig( $mailAddr );
                
                // メールアドレスが登録しない場合
                if (!isset($this->emails[$mailAddr])) {
                    // 登録されていないメールを削除
                    $this->comment("「{$mailAddr}」が登録されていないため、削除します。");
                    $this->deleteMessage($oMessage);
                    continue;
                }
                
                // 販社コード
                $hanshaCode = $this->emails[$mailAddr]['hanshaCode'];
                // システム名
                $systemName = $this->emails[$mailAddr]['systemName'];
                // 拠点コード
                $shopCode = $this->emails[$mailAddr]['shopCode'];
                // スタッフ番号
                $staffCode = $this->emails[$mailAddr]['staffCode'];
                
                // メールの日時
                $mailTime = date('YmdHis', strtotime($oMessage->getDate()->toDateTimeString()));
                
                //ファイル名
                $mailAddrCode = preg_replace('/[\W]/', '_', $mailAddr);
                if ($systemName == 'infobbs') {
                    $baseName = "{$mailTime}-{$hanshaCode}-{$systemName}-"
                        . "{$shopCode}-{$mailAddrCode}";
                } else {
                    // 拠点コード
                    $staffCode = $this->emails[$mailAddr]['staffCode'];
                    $baseName = "{$mailTime}-{$hanshaCode}-{$systemName}-"
                        . "{$shopCode}-{$staffCode}-{$mailAddrCode}";
                }
                
                // フォルダー名
                $regName = '';
                $mailTempDir = '';
                $monthDirName = storage_path("mailer/{$this->month}");
                if ($oMessage->hasAttachments()) {
                    $regName = "{$monthDirName}/{$baseName}";
                    // 一時的なメールのファイルパス
                    $mailTempDir = "{$monthDirName}/_{$baseName}";
                    $mailTempFilePath = "{$mailTempDir}/email.eml";
                } else {
                    $regName = "{$monthDirName}/{$baseName}.eml";
                    $mailTempFilePath = "{$monthDirName}/_{$baseName}.eml";
                }
                
                // 登録されたメールをスキップ
                if (file_exists($regName)) {
                    // 登録されていないメールを削除
                    $this->comment("「{$baseName}」が登録されため、削除します。");
                    $this->deleteMessage($oMessage);
                    continue;
                }
                
                // 月のフォルダー名
                if (!file_exists($monthDirName)) {
                    mkdir($monthDirName, 0777, true);
                }
                // 添付あるメールのフォルダー
                if ($oMessage->hasAttachments() && !file_exists($mailTempDir)) {
                    mkdir($mailTempDir, 0777, true);
                }
                
                // メールの全体ボディー
                $mailBody = $oMessage->getRawBody();
                // ファイルにメールの情報を書き込む
                file_put_contents($mailTempFilePath, $mailBody);
                
                // 添付ファイル
                $files = [];
                if ($oMessage->hasAttachments()) {
                    $files = $this->retrieveAttachmentFiles($oMessage, $baseName);
                }
                
                // メールの内容ボディー
                $mailContent = '';
                if ($oMessage->hasHTMLBody()) {
                    // メールのHTML内容
                    $mailContent = $oMessage->getHTMLBody();
                    if ($oMessage->hasAttachments()) {
                        // 記事の情報
                        $postInfo = [
                            'hanshaCode' => $hanshaCode,
                            'systemName' => $systemName
                        ];
                        // 本文を添付画像に置換
                        $mailContent = $this->replaceContentWithAttachmentImages(
                            $mailContent,
                            $files,
                            $postInfo
                        );
                    }
                } else if ($oMessage->hasTextBody()) {
                    $mailContent = $oMessage->getTextBody();
                }
                
                // 本文が空欄の場合、スキップ
                if (empty($mailContent)) {
                    // 空メールを削除
                    $this->deleteMessage($oMessage);
                    continue;
                }
                
                // 件名を記事のタイトルに
                $mailSubject = $oMessage->getSubject();
                
                // コールバック
                $callback = function ($hanshaCode) use(
                    $oMessage,
                    $systemName,
                    $regName,
                    $mailAddr,
                    $senderName,
                    $mailTempDir, 
                    $mailTempFilePath
                ) {
                    // 登録されたメールをリネーム
                    if ($oMessage->hasAttachments()) {
                        rename($mailTempDir, $regName);
                    } else {
                        rename($mailTempFilePath, $regName);
                    }

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

                    // 登録してからメールを削除
                    $this->deleteMessage($oMessage);
                };
                
                // 記事を登録
                $this->postBlog(
                    $mailSubject,
                    $mailContent,
                    $hanshaCode, 
                    $shopCode, 
                    $staffCode, 
                    $systemName, 
                    $callback
                );
            }
        }
        
        $time = date('d/m/Y H:i:s');
        $this->comment("メールで自動投稿の処理が完了しました。【{$time}】");
    }
    
    /**
     * 
     * @param string $emailAddr メールアドレス
     * @param string $recipientName 名前
     * @param string $hanshaCode 販社コード
     * @param string $systemName システム名
     * @param int $notificationType 通知のタイプ
     * @return string リスポンス
     */
    private function sendNotificationMail(
        $emailAddr,
        $recipientName,
        $hanshaCode,
        $systemName,
        $notificationType
    ) {
        // 掲載モード
        $published_mode = config("original.para.{$hanshaCode}.published_mode") ?? '0';
        
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
        }
        
        switch ($notificationType) {
            // 記事登録完了
            case self::NOTIFICATION_TYPE_POST_SUCCEEDED:
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
                break;
            
            // 記事登録失敗
            case self::NOTIFICATION_TYPE_POST_FAILED:
                // 件名
                $subject = '投稿エラーです';
                // 本文
                $body = "大変申し訳ございませんが、"
                        . "何らかのエラーが発生して投稿された記事を登録できませんでした。";
                break;
            
            // 未登録メール
            case self::NOTIFICATION_TYPE_UNREGISTERED_MAIL:
                // 件名
                $subject = '未登録のアドレスです';
                // 本文
                $body = "大変申し訳ございませんが、"
                        . "このメールアドレス({$recipientName})はシステムに"
                        . "登録されておりません。"
                        . "管理画面の「携帯投稿用アドレス管理ページ」にて"
                        . "投稿用メールアドレスの登録をお願いします。";
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
        $title, 
        $content, 
        $hanshaCode, 
        $shopCode, 
        $staffCode, 
        $systemName, 
        $callback 
    ) {
        // テーブル名
        $tableName = "tb_{$hanshaCode}_{$systemName}";
        // 現在の日時
        $dateTime = date('Y-m-d H:i:s');
        // 記事番号
        list($registNumber, $postNumber) = $this->generateNewPostNumber($tableName);
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
            'agent' => 'PHP-Mailer',
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
     * サーバーからメッセージを削除
     * @param object $oMessage メッセージデータ
     */
    private function deleteMessage($oMessage) {
        $oMessage->delete();
    }
    
    /**
     * メール投稿データの削除
     */
    private function dataRotating() {
        // 1年前
        $time = strtotime('-1 years');
        // 1年前の先週
        $month = date('Ym', $time);
        // 1年前のフォルダーを削除
        $dirName = storage_path("mailer/{$month}");
        if (!file_exists($dirName)) {
            return;
        }
        rmdir_recursively($dirName);
    }
    
    /**
     * 設定ファイルからメールアドレスのリストを作成
     * @param string $mailAddr メールアドレス
     */
    private function loadEmailConfig( $mailAddr ) {
        // 配列に存在するなら、スキップ
        if (isset($this->emails[$mailAddr])) {
            return;
        }
        // 投稿アドレスモデルオブジェクトを取得
        $emailSettingsMObj = EmailSettings::where('email', $mailAddr)
                ->first();
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
        ];
    }
    
    /**
     * 画像ファイルをアップして画像のURLを取得する
     * @param string $path 画像ファイルのパス
     * @param string $postInfo 記事情報
     *  ・hanshaCode 販社コード
     *  ・systemName システム名
     * @return string 画像のURL
     */
    private function uploadImageAndGetUrl($path, $postInfo) {
        $url = '';
        // 日時
        $time = date('YmdHis');
        // 販社コード
        $hanshaCode = $postInfo['hanshaCode'];
        // システム名
        $systemName = $postInfo['systemName'];
        // ターゲットURL
        $targetUrl = "http://image.hondanet.co.jp/cgi/upload_img.php?id="
                . "{$hanshaCode}/{$systemName}&time={$time}";
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
                $logText = date('Y-m-d H:i:s') . ' [' . $fileName . '] ' . $response . PHP_EOL;
                file_put_contents($logPath, $logText, FILE_APPEND);
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
            function($match) use($files, $postInfo) {
                // 添付ID
                $attachmentId = $match[2];
                // 画像のURL
                $url = $this->uploadImageAndGetUrl(
                    $files[$attachmentId],
                    $postInfo
                );
                // 元のテキストに画像ファイルのURLを置換
                return $match[1] . $url . $match[3];
            }, 
            $mailContent);
            
        return $mailContent;
    }
    
    /**
     * メールに添付されたファイルを取得する
     * @param string $oMessage メッセージのオブジェクト
     * @param string $baseName メール名
     */
    private function retrieveAttachmentFiles($oMessage, $baseName) {
        $files = [];
        $attachments = $oMessage->getAttachments();
        
        $count = count($attachments);
        $this->comment("{$count}件画像の保存中");
        
        foreach ($attachments as $attachmentId => $attachment) {
            // 画像ファイル名
            $attachmentName = $attachment->getName();
            $attachmentName = urlencode_unicode($attachmentName);
            // MIMEタイプ
            $mimeType = $attachment->getMimeType();
            
            // 画像以外のファイルをスキップ
            if (!preg_match('/^image\//', $mimeType)) {
                continue;
            }
            
            // ファイルの内容
            $content = $attachment->getContent();
            // フォルダー名
            $dirName = storage_path("mailer/{$this->month}/_{$baseName}");
            // フォルダーが存在しない場合、作成する
            if (!file_exists($dirName)) {
                mkdir($dirName, 0777, true);
            }
            
            // 画像のファイルパス
            $imageFilePath = "{$dirName}/{$attachmentName}";
            // 画像ファイルを書き込む
            file_put_contents($imageFilePath, $content);
            
            // 画像ファイルのパスを配列
            $imageFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $imageFilePath);
            $files[$attachmentId] = str_replace('/', DIRECTORY_SEPARATOR, $imageFilePath);
        }
        return $files;
    }
    
    /**
     * 新しい記事番号を生成する
     * @param string $tableName テーブル名
     * @return array
     *  0 -> 登録番号
     *  1 -> 記事番号
     */
    private function generateNewPostNumber( $tableName ) {
        // 新規テーブル
        $row = DB::table($tableName)
            ->orderBy('regist', 'DESC')
            ->take(1)
            ->get();
        // 最大番号計算
        if( count($row) == 0 ){
            $num = 0;
        }else{
            $num = intval($row['0']->regist);
        }
        $num++;
        $number = "data" . substr("00000" . strval($num),-6);
        
        return [$num, $number];
    }

}
