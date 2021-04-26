<?php

namespace App\Http\Controllers\Other;

use App\Original\Util\SessionUtil;
use App\Original\Util\MailSenderUtil;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Models\EmailSettings;
use App\Console\Commands\MailBlogRegisterPerlCommand;
use Session;
use DB;

/**
 * 投稿アドレス画面用コントローラー
 *
 * @author yhatsutori
 *
 */
class MailRegisterController  extends Controller{
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        // 表示部分で使うオブジェクトを作成
        $this->initDisplayObj();
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
    }

    #######################
    ## initalize
    #######################

    /**
     * 表示部分で使うオブジェクトを作成
     * @return [type] [description]
     */
    public function initDisplayObj(){
        // 表示部分で使うオブジェクトを作成
        $this->displayObj = app('stdClass');
        // カテゴリー名
        $this->displayObj->category = "other";
        // 画面名
        $this->displayObj->page = "mail_register";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "Other\MailRegisterController";
    }

    #######################
    ## Controller method
    #######################

    /**
     * メールアドレスの登録画面
     * @return object
     */
    public function getRegister(SearchRequest $request) {
        
        // 販社コード
        $hanshaCode = $this->loginAccountObj->getHanshaCode();
        // システム名
        $systemName = $request->system_name;
        // 送信先のメールアドレス
        $targetEmail = "{$hanshaCode}.{$systemName}@hondanet.co.jp";
        
        return view(
            $this->displayObj->tpl . '.form'
        )
        ->with('targetEmail', $targetEmail) // 送信先のメールアドレス
        ->with( 'displayObj', $this->displayObj )
        ->with( 'title', "メールアドレスの登録" );
    }

    /**
     * メールアドレスの登録完了画面
     * @return object
     */
    public function getCompleted(SearchRequest $request){
        
        // 販社コード
        $hanshaCode = $this->loginAccountObj->getHanshaCode();
        // システム名
        $systemName = $request->system_name;
        // 送信先のメールアドレス
        $targetEmail = "{$hanshaCode}.{$systemName}@hondanet.co.jp";
        
        return view(
            $this->displayObj->tpl . '.completed'
        )
        ->with('targetEmail', $targetEmail) // 送信先のメールアドレス
        ->with( 'displayObj', $this->displayObj )
        ->with( 'title', "メールアドレスの登録" );
    }

    /**
     * メールアドレスの登録処理
     * @param Request $request リクエスト
     * @return object
     */
    public function postRegister(MailRegisterRequest $request) {
        
        // 販社コード
        $hanshaCode = $this->loginAccountObj->getHanshaCode();
        // システム名
        $systemName = $request->system_name;
        
        if ($systemName == 'infobbs') {
            // 送信者名
            $sender_name = '店舗ブログ管理システム';
            // ID
            $grBbsId = "{$hanshaCode}.{$systemName}.{$request->shop}";
        } else if ($systemName == 'staff') {
            // 送信者名
            $sender_name = 'スタッフブログ管理システム';
            // ID
            $grBbsId = "{$hanshaCode}.{$systemName}.{$request->shop}.{$request->staff_code}";
        }
        // 送信先のメールアドレス
        $targetEmail = "{$grBbsId}@hondanet.co.jp";
        // 件名
        $subject = MailBlogRegisterPerlCommand::EMAIL_REGISTRATION_SUBJECT . ' - '
                . $grBbsId;
        // 本文
        $body = $request->email;
        // メールサーバーのメールアドレス
        $email = MailBlogRegisterPerlCommand::MY_EMAIL_ADDRESS;
        
        // 通知をメールに送信
        MailSenderUtil::awsSendMail([
            'MailSendAddress' => $email,
            'mail_format' => $body,
            'MailSubject' => $subject,
            'MailName' => $sender_name,
        ]);
        
        // 遷移画面のURL
        $redirectUrl = action_auto( $this->displayObj->ctl . '@getCompleted' )
                . "?system_name={$systemName}";
        
        return redirect( $redirectUrl );
    }

}
