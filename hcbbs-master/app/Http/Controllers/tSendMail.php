<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Common\Controllers\Parents\InfobbsCoreController;
use App\Original\Util\MailSenderUtil;
use App\Original\Util\SessionUtil;
use App\Models\UserAccount;
use App\Models\Role;
use DB;

/**
 * 共通関数のトレイト
 */
trait tSendMail {
    
    /**
     * 販社毎の宛先メールのメールアドレス
     * @var array
     */
    private static $recipientEmails = [];

    /**
     * 本社承認ではなくメール通知送信をする販社一覧
     * 
     * @var array
     */
    private $forciblyNotifyHanshaList = [
        '1351901', // 埼玉
    ];

    /**
     * 宛先メールの取得
     * @param string $hansha_code 販社コード
     * @param string $shop 拠点コード
     * @return array メールアドレス
     */
    private function retrieveRecipientEmails( $hansha_code, $shop ) {
        // メールリストに販社コードのデータが存在したら、それをリターン
        if (isset(self::$recipientEmails[$hansha_code])) {
            return self::$recipientEmails[$hansha_code];
        }

        $loginAccountObj = SessionUtil::getUser();
        
        // 宛先のユーザーデータ
        $userData = DB::table((new UserAccount)->getTable())
                ->selectRaw('mail_mut, mail_user')
                // 販社コード
                ->where('hansha_code', $hansha_code);

        //if (!in_array($hansha_code, $this->forciblyNotifyHanshaList)) {
            // 権限
            // ・2　→　本社
            // ・3　→　拠点長　＋　拠点コード
        if ($loginAccountObj->getAccountLevel() === 5 && $hansha_code ==='3751804'){
            // 岡山
            $userData = $userData->whereRaw("(account_level = 2 OR (account_level = 3 AND shop = '{$shop}'))");
        }else{
            $userData = $userData->whereRaw("(account_level = 2 OR (account_level = 3 AND shop = '{$shop}') OR account_level = 5 )");
        }
        //}


        $userData = $userData->get();

        // 複数のメール
        $emails = [];
        foreach ($userData as $row) {
            // 六三用のメール
            $row->mail_mut = trim($row->mail_mut);
            if (!empty($row->mail_mut)) {
                foreach (explode(',', $row->mail_mut) as $mail){
                    // 正しくないメールアドレスを除外する
                    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        continue;
                    }
                    $emails[] = trim($mail);
                }
            }
            // お客様用のメール
            $row->mail_user = trim($row->mail_user);
            if (empty($row->mail_user)) {
                continue;
            }
            foreach (explode(',', $row->mail_user) as $mail){
                // 正しくないメールアドレスを除外する
                if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                $emails[] = trim($mail);
            }
        }
        // リストに登録
        self::$recipientEmails[$hansha_code] = $emails;


        return $emails;
    }

    /**
     * メール送信
     * 
     * @param array $data 記事のデータ
     * @param string $systemType システム名
     *  -> infobbs  : 拠点ブログ
     *  -> staffbbs : スタッフブログ
     * @param int $notificationType 通知の種類
     * @param string $shop_code 拠点コード
     * @return string 送信ステータス
     */
    public function sendUploadMail(
        $data = null,
        $systemType = 'infobbs',
        $notificationType = InfobbsCoreController::NOTIFICATION_POST_REGISTERED,
        $shop_code = null
    ) {
        $loginAccountObj = SessionUtil::getUser();

        // 掲載モード
        $hansha_code = $loginAccountObj->getHanshaCode();
        $para = config('original.para')[$hansha_code];
        // 承認機能がない場合、
        // メール通知の機能が動かない
        if ($para['published_mode'] == 0 && 
            !in_array($hansha_code, $this->forciblyNotifyHanshaList)) {
            // 販社一覧に登録されない
            // 本社機能なし
            return;
        }
        
        // 販社名
        $hansha_name = config('original.hansha_code')[$hansha_code];

        // 送信内容
        if ($data === null) {
            $data = SessionUtil::getData();
        }
        
        // 拠点名
        $shopList = $this->shopList( $hansha_code );
        $shop_code = $shop_code ?? SessionUtil::getShop();
        // 拠点が存在していない場合、
        // メール通知の機能が動かない
        if (!isset($shopList[$shop_code])) {
            return;
        }
        $shop_name = $shopList[$shop_code];
        
        // 宛先メール
        $recipients = $this->retrieveRecipientEmails($hansha_code, $shop_code);

        // 本社アカウントにメールアドレスを入力されていない場合、
        // メール通知の機能が動かない
        if (count($recipients) == 0) {
            return;
        }
        $recipients = implode(',', $recipients);
        
        // ブログページのURL
        $api_cfg = config('original.api_para')[$hansha_code] ?? null;
        if ($api_cfg !== null) {
            $public_page_url = str_replace('{shop}', $shop_code, $api_cfg['post_url'] ?? '');
        } else {
            $public_page_url = '＜未定義＞';
        }

        // スタッフ用のURL
        $admin_page_url = "http://www.hondanet.co.jp/admin/{$hansha_code}/";
        if ($hansha_code === '5104199' || $hansha_code === '3751804') { // 北九州様と岡山
            // 本社用の管理画面URL
            $admin_page_url = "http://www.hondanet.co.jp/admin/{$hansha_code}m/";
            if ($loginAccountObj->getAccountLevel() === 5){
                $admin_page_url = "http://www.hondanet.co.jp/admin/{$hansha_code}ma/";
            }
        }
        
        // データベースからパスワードを取得する
        if (!in_array($hansha_code, $this->forciblyNotifyHanshaList)) {
            $user_login_id = "m{$hansha_code}";
        } else {
            $user_login_id = "d{$hansha_code}";
        }
        $adminData = DB::table((new UserAccount)->getTable())
                ->select('user_password')
                ->where('user_login_id', $user_login_id)
                ->first();
        // ユーザーのパスワード
        $user_password = '';
        if (!empty($adminData)) {
            $user_password = $adminData->user_password;
        }

        // 通知の種類によってビュー名を切り替える
        switch ($notificationType) {
            // 投稿した時の通知
            case InfobbsCoreController::NOTIFICATION_POST_REGISTERED:
                $viewFileName = 'upload';
                break;

            // 本社担当の承認の時
            case InfobbsCoreController::NOTIFICATION_POST_HONSHA_TANTOO_CONFIRMED:
                $viewFileName = 'confirm';
                break;
            
            // 公開申請が変わる時の通知
            case InfobbsCoreController::NOTIFICATION_POST_EDIT_FLAG_CHANGED:
                $viewFileName = 'submission_changed';
                break;
            
            // 掲載処理OKの時の通知
            case InfobbsCoreController::NOTIFICATION_POST_HONSHA_CONFIRMED:
                $viewFileName = 'honsha_confirmed';
                break;
            
            default:
                $viewFileName = 'upload';
                break;
        }
        // メールのビュー名
        $emailViewName = "emails.{$hansha_code}.{$viewFileName}";
        if (!view()->exists($emailViewName)) {
            $emailViewName = "emails.{$viewFileName}";
        }
        // ビューの再確認
        if (!view()->exists($emailViewName)) {
            // 送信する処理を止める
            return;
        }
        // メールのフォーマット
        $mailFormat = view($emailViewName, [
            'hansha_name' => $hansha_name,
            'shop_code' => $shop_code,
            'shop_name' => $shop_name,
            'post_title' => $data['title'],
            'post_message' => $data['msg1'] ?? '',
            'post_content' => isset($data['comment']) ? html_entity_decode($data['comment']) : '',
            'public_page_url' => $public_page_url,
            'admin_page_url' => $admin_page_url,
        ]);
        
        if ($systemType == 'infobbs') {
            if ($loginAccountObj->getAccountLevel() === 5 && $hansha_code ==='3751804'){
                // 岡山
                $mail_subject = '拠点ブログで本社承認がありました';
                $sender_name = '店舗ブログ管理システム';
            }
            else{
            // 件名
            $mail_subject = '拠点ブログに記事がアップされました';
            // 送信者名
            $sender_name = '店舗ブログ管理システム';
            // 通知設定
            $notifConfig = config("{$hansha_code}.general.notification.infobbs");
            if (!empty($notifConfig)) {
                // 件名
                $mail_subject = $notifConfig['subject'] ?? '';
                // 送信者名
                $sender_name = $notifConfig['sender_name'] ?? '';
            }
            }
        } else {
            // 件名
            $mail_subject = 'スタッフブログに記事がアップされました';
            // 送信者名
            $sender_name = 'スタッフブログ管理システム';
        }
        // AWSサービスでメールの送信
        return MailSenderUtil::awsSendMail([
            'MailSendAddress' => $recipients,
            'mail_format' => $mailFormat,
            'MailSubject' => $mail_subject,
            'MailName' => $sender_name,
        ]);
    }

}
