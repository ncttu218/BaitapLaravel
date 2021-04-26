<?php

namespace App\Http\Controllers\Admin\Common\Controllers\Parents;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Original\Codes\Aichi\BackgroundDesignCodes;
use App\Original\Codes\Aichi\ImageFrameCodes;
use App\Http\Controllers\Controller;
use App\Original\Util\SessionUtil;
use Request;

/**
 * Description of DesignCoreController
 *
 * @author ahmad
 */
class DesignCoreController extends Controller {
    
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
     * コード一覧
     * 
     * @var array
     */
    protected $codes = [];
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        // 販社コード
        $this->hanshaCode = Request::segment(3);
        
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();

        // コード
        $this->codes = [];
        $this->codes['backgroundDesign'] = (new BackgroundDesignCodes())->getOptions();
        $this->codes['imageFrame'] = (new ImageFrameCodes())->getOptions();
    }
    
}
