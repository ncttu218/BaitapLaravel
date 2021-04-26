<?php

namespace App\Http\Controllers\Admin\Common\Controllers\Parents;

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
     * 通知の種類
     * 
     * @var array
     */
    protected $notificationTypes = [];
    
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

        // 設定ファイルからメール通知の種類を読み込む
        $customTypes = config("{$this->hanshaCode}.general.notification.infobbs.custom_types");
        if ($customTypes !== null && is_array($customTypes)) {
            $this->notificationTypes = $customTypes;
        }
    }
    
    /**
     * テンプレート番号をセット
     */
    public function setTemplateNo() {
        // テンプレート番号
        $this->templateNo = '1351100';
    }
    
}
