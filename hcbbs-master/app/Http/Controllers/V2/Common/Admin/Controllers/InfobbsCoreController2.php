<?php

namespace App\Http\Controllers\V2\Common\Admin\Controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IInfobbsCoreRepository;
use App\Original\Util\SessionUtil;
use Request;

/**
 * Description of InfobbsCoreController
 *
 * @author ahmad
 */
class InfobbsCoreController2 extends Controller implements IInfobbsCoreRepository {
    
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
     * テーブル番号
     * 
     * @var int
     */
    protected $tableNo;
    
    /**
     * 6件の画像アップロードかのフラグ
     * 
     * @var bool
     */
    protected $use6FileInput = false;
    
    /**
     * テンプレートNo
     * 
     * @var string 
     */
    protected $templateNo;
    
    /**
     * 公開モード
     * 
     * @var int
     */
    protected $published_mode;
    
    /**
     * コメントを使うフラグ
     * 
     * @var string
     */
    protected $comment;
    
    /**
     * カテゴリーを使うフラグ
     * 
     * @var string
     */
    protected $category;
    
    /**
     * テーブルのタイプ
     * 
     * @var string
     */
    protected $tableType;
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        // 販社コード
        $this->hanshaCode = Request::segment(3);
        
        $this->controller = "V2\_{$this->hanshaCode}\Admin\InfobbsController";
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        // テーブル名をセッションに保存(販社コードがテーブル名)
        SessionUtil::putTableName('tb_' . $this->loginAccountObj->getHanshaCode() . '_infobbs');
        // テンプレートNo
        $this->templateNo = '1351100';
        // 掲載モード
        $para = Config('original.para')[$this->loginAccountObj->getHanshaCode()];
        $this->published_mode = $para['published_mode'];
        $this->comment = $para['comment'];
        
        // カテゴリー
        $categories = [];
        if($para['category']){
            foreach (explode(',', $para['category']) as $category) {
                $categories[] = trim($category);
            }
        }
        $this->category = $categories;

        // テーブル番号
        $this->tableNo = $this->loginAccountObj->gethanshaCode();

        // テーブルのタイプ
        $this->tableType = 'infobbs';
    }
    
}
