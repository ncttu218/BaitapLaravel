<?php

namespace App\Http\ViewComposers;

use App\Original\Util\SessionUtil;
use Illuminate\Contracts\View\View;

/**
 * ログインしているユーザー情報を取得する
 * ビューコンポーサー用のクラス
 */
class LoginAccountComposer{
    
    protected $loginAccountObj;

    /**
     * ログイン情報の取得
     */
    public function __construct(){
        // 現在のセッションのシステム名を取得する
        $systemName = SessionUtil::getSystemName();
        // セッションのシステム名を変える
        if ($systemName == '_staffbbs') {
            SessionUtil::setSystemName('_infobbs');
        }
        
        // ユーザー情報を取得(セッション)
        $loginAccountObj = SessionUtil::getUser();
        
        // セッションのシステム名を元に戻す
        if ($systemName == '_staffbbs') {
            SessionUtil::setSystemName($systemName);
        }
        
        if ( !empty( $loginAccountObj ) ) {
            $this->loginAccountObj = $loginAccountObj;
        } else {
            $this->loginAccountObj = null;
        }
    }

    public function compose( View $view ){
        $view->with( 'loginAccountObj', $this->loginAccountObj );
    }

}