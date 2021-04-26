<?php

namespace App\Http\Controllers\Api\Common\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Interfaces\IDesignCoreRepository;
use Request;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DesignController
 *
 * @author ahmad
 */
class DesignCoreController extends Controller implements IDesignCoreRepository {

    /**
     *　販社コード
     * 
     * @var string
     */
    protected $hanshaCode;
    
    /**
     * 店舗コード
     * 
     * @var string
     */
    protected $shopCode;
    
    /**
     * デバイスの種類
     * pc, lite
     * 
     * @var string
     */
    protected $deviceType;
    
    /**
     * テンプレートのフォルダー
     * 
     * @var string
     */
    protected $templateDir;
    
    /**
     * コントローラー名
     * 
     * @var string
     */
    protected $controller;
    
    /**
     * 表示の種類
     * json, html
     * 
     * @var string
     */
    protected $showType;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        // テンプレートNo
        // 販社コード
        if (isset($_GET['hansha_code'])) {
            $this->hanshaCode = $_GET['hansha_code'];
        } else {
            $this->hanshaCode = Request::segment(3);
        }
        
        $this->controller = "Api\DesignController";

        // 拠点コード
        $this->shopCode = "";
        if (isset($req['shop']) && !empty($req['shop'])) {
            $this->shopCode = $req['shop'];
        }

        // 表示タイプ JSONなど
        $this->showType = isset($req['show_type']) ? $req['show_type'] : "json";

        /**
         * テンプレートのフォルダー
         */
        // デバイスのタイプ
        $this->deviceType = isset($req['device_type']) ? $req['device_type'] : 'pc';
        if ($this->deviceType === 'pc' || $this->deviceType === 'lite') {
            $this->templateDir = 'api.' . $this->hanshaCode . '.api.design.' . $this->deviceType;
        } else {
            $this->templateDir = 'api.' . $this->hanshaCode . '.api.design.pc';
        }
    }
}