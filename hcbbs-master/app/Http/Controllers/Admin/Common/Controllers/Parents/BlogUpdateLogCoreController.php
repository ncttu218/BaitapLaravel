<?php

namespace App\Http\Controllers\Admin\Common\Controllers\Parents;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use App\Http\Controllers\tCommon;
use App\Original\Util\SessionUtil;
use Request;

/**
 * Description of BlogUpdateLogCoreController
 *
 * @author ahmad
 */
class BlogUpdateLogCoreController extends Controller {
    
    use tCommon;
    
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
        // 販社コード
        $this->hanshaCode = Request::segment(3);
        
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        
        // 表示部分で使うオブジェクトを作成
        $this->initDisplayObj();
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
        $this->displayObj->category = "api.{$this->hanshaCode}.admin.infobbs";
        if (!view()->exists($this->displayObj->category)) {
            $this->displayObj->category = 'api.common.admin.infobbs';
        }
        
        // 画面名
        $this->displayObj->page = "update_log";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "Admin\Common\Controllers\BlogUpdateLogController";
    }
    
}
