<?php

namespace App\Http\Controllers\Admin\Common\Controllers\Parents;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use App\Http\Controllers\tInitSearch;
use App\Original\Util\SessionUtil;
use Request;

/**
 * Description of AccessCounterController
 *
 * @author ahmad
 */
class AccessCounterCoreController extends Controller {

    use tInitSearch;
    
    /**
     * 表示のデータ
     * 
     * @var object
     */
    protected $displayObj;
    
    /**
     * 販社コード
     * 
     * @var string
     */
    protected $hanshaCode;
    
    /**
     * ユーザ情報
     * 
     * @var object
     */
    protected $loginAccountObj;
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        // 表示部分で使うオブジェクトを作成
        $this->initDisplayObj();
        // 販社コード
        $this->hanshaCode = Request::segment(3);
        
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
    private function initDisplayObj() {
        // 表示部分で使うオブジェクトを作成
        $this->displayObj = app('stdClass');
        // カテゴリー名
        $this->displayObj->category = "bbs_count";
        // 画面名
        $this->displayObj->page = "base";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "Admin\Common\Controllers\AccessCounterController";
    }

    #######################
    ## 検索・並び替え
    #######################

    /**
     * 画面固有の初期条件設定
     *
     * @return array
     */
    private function extendSearchParams(){
        $search = [];

        return $search;
    }
    
}
