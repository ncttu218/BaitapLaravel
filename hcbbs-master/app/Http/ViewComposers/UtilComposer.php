<?php

namespace App\Http\ViewComposers;

use App\Lib\Util\ArrayUtil;
use App\Lib\Util\DateUtil;
use App\Original\Util\CodeUtil;
use App\Original\Util\SessionUtil;
use App\Original\Util\ViewUtil;

use Illuminate\Contracts\View\View;

/**
 * Utilクラスを使う為の
 * ビューコンポーサー用のクラス
 */
class UtilComposer
{
    protected $loginAccountObj;

    /**
     * Utilクラスのオブジェクトを取得
     */
    public function __construct(){
        $this->ArrayUtil = new ArrayUtil();
        $this->DateUtil = new DateUtil();
        $this->CodeUtil = new CodeUtil();
        $this->SessionUtil = new SessionUtil();
        $this->ViewUtil = new ViewUtil();
    }

    public function compose( View $view ){
        $view->with( 'ArrayUtil', $this->ArrayUtil );
        $view->with( 'DateUtil', $this->DateUtil );
        $view->with( 'CodeUtil', $this->CodeUtil );
        $view->with( 'SessionUtil', $this->SessionUtil );
        $view->with( 'ViewUtil', $this->ViewUtil );
    }

}