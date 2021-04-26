<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers\Parents;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use App\Original\Util\SessionUtil;
use Request;

/**
 * Description of MessageCoreController
 *
 * @author ahmad
 */
class MessageCoreController extends Controller {
    
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
     * テーブル名
     * 
     * @var int
     */
    protected $tableName;
    
    /**
     * 販社名の設定パラメータを取得
     * 
     * @var array
     */
    protected $para_list;
    
    /**
     * 店舗が指定するフラグ
     * 
     * @var bool
     */
    protected $shopDesignation;
    
    /**
     * 店舗コード
     * 
     * @var string
     */
    protected $shopCode;
    
    /**
     * ページ
     * 
     * @var string
     */
    protected $page;
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        // リクエスト
        $req = Request::all();
        
        // 販社コード
        $this->hanshaCode = Request::segment(3);
        
        $this->controller = "V3\Common\Admin\Controllers\MessageController";
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        // 販社名の設定パラメータを取得
        $this->para_list = ( config('original.para')[$this->hanshaCode] );
        
        // 店舗が指定するフラグ
        $this->shopDesignation = $this->para_list['message'] === '2';
        
        // 拠点コード
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : "";
        // ページ
        $this->page = isset($req['page']) ? (int)$req['page'] : 1;
        // テーブル名
        $this->tableName = 'tb_' . $this->loginAccountObj->getHanshaCode() . '_message';
    }
    
}
