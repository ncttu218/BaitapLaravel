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
 * Description of HobbsCoreController
 *
 * @author ahmad
 */
class HobbsCoreController extends Controller {
    
    /**
     * 販社コード
     * 
     * @var string
     */
    protected $hanshaCode;
    
    /**
     * テンプレート番号
     * 
     * @var string
     */
    protected $templateNo;
    
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
        
        // テンプレート番号
        $this->setTemplateNo();
        
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
    }
    
    /**
     * テンプレート番号をセット
     */
    public function setTemplateNo() {
        // テンプレート番号
        $this->templateNo = '1351100';
    }
    
}
