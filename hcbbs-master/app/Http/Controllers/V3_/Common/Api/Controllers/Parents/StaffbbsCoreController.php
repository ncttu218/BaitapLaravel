<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Api\Interfaces\IStaffbbsCoreRepository;
use App\Original\Codes\StaffDepartmentCodes;
use Request;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InfobbsController
 *
 * @author ahmad
 */
class StaffbbsCoreController extends Controller implements IStaffbbsCoreRepository {
    
    /**
     * 最大ランキング数
     */
    const MAX_RANKING_SHOP = 4;
    
    /**
     *  販社コード
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
     * スタッフ番号
     *  
     * @var string
     */
    protected $staffCode;
    
    /**
     * 最大の店舗の表示
     * 
     * @var int
     */
    protected $showLimitNum;
    
    /**
     * 何件のページ
     * 
     * @var int
     */
    protected $pageNum;
    
    /**
     * テーブル名
     * 
     * @var string
     */
    protected $tableName;
    
    /**
     * 表示の種類
     *  
     * @var string
     */
    protected $showType;
    
    /**
     * 店舗の絞込
     * 
     * @var array
     */
    protected $shopFilter;
    
    /**
     * ビューのスタイル
     * 
     * @var string
     */
    protected $viewStyle;
    
    /**
     * 記事内容の長さ
     * 
     * @var int
     */
    protected $contentLength;
    
    /**
     * タイトルの長さ
     * 
     * @var int
     */
    protected $titleLength;

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
     * 店舗の除外
     * 
     * @var array
     */
    protected $shopExclusion;

    /**
     * 公開設定があるかのフラグ
     * 
     * @var bool
     */
    protected $hasPublishingConfig = false;
    
    /**
     * 役職のデータのスタイル
     * 
     * @var int
     */
    protected $staffPopulationStyle;
    
    /**
     * 日時のフォーマット
     * 
     * @var string
     */
    protected $timeFormat = 'Y.m.d';
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        // テンプレートNo
        $this->hanshaCode = Request::segment(3); // 販社コード
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        $this->staffCode = ( !empty( $req['staff'] ) )? $req['staff'] : ""; // スタッフコード
        $this->showLimitNum = ( !empty( $req['show_limit_num'] ) )? $req['show_limit_num'] : ""; // 表示最大数
        $this->pageNum = ( !empty( $req['page_num'] ) )? $req['page_num'] : ""; // ページング最大数
        $this->tableName = 'tb_' . $this->hanshaCode . '_staff'; // 使用するテーブル名
        $this->page = isset($req['page']) ? (int)$req['page'] : 1; // ページングの数値
        $this->showType = isset($req['show_type']) ? $req['show_type'] : ""; // 表示タイプ JSONなど
        $this->shopFilter = isset($req['shop_filter']) ? explode('|', $req['shop_filter']) : []; // 拠点フィルター(表示したい拠点だけ)
        $this->viewStyle = isset($req['view_style']) ? $req['view_style'] : ""; // ビューのスタイル
        // 本文の長さ
        $this->contentLength = isset($req['content_length']) &&
                !empty($req['content_length']) ? $req['content_length'] : '';
        // タイトルの長さ
        $this->titleLength = isset($req['title_length']) &&
                !empty($req['title_length']) ? $req['title_length'] : '';
        // 日時のフォーマット
        if (isset($req['time_format']) && !empty($req['time_format'])) {
            $this->timeFormat = $req['time_format'];
        }
        
        // スタッフデータのスタイル
        if ($this->staffPopulationStyle === null) {
            $this->staffPopulationStyle = StaffDepartmentCodes::DEPARTMENT_POPULATION_DEFAULT;
        }
        
        /**
         * テンプレートのフォルダー
         */
        // デバイスのタイプ
        $this->deviceType = isset($req['device_type']) ? $req['device_type'] : null;
        if ($this->deviceType === 'pc' || $this->deviceType === 'lite') {
            $this->templateDir = 'api.' . $this->hanshaCode . '.api.staffbbs.' . $this->deviceType;
        } else {
            $this->templateDir = 'api.' . $this->hanshaCode . '.api.staffbbs.pc';
        }
        
        // API設定の拠点除外
        $this->shopExclusion = [];
        if (!isset($req['shop_exclusion']) || empty($req['shop_exclusion'])) {
            $api_para = config('original.api_para');
            if (isset($api_para[$this->hanshaCode])) {
                $api_para = $api_para[$this->hanshaCode];
                $this->shopExclusion = $api_para['shop_exclusion'] ?? []; // 拠点の除外
            }
        } else {
            $this->shopExclusion = explode('|', $req['shop_exclusion']);
        }
        
        // 公開設定があるかのフラグ
        $admin_menu_para = config('original.admin_menu_para')[$this->hanshaCode] ?? [];
        foreach ($admin_menu_para as $menu) {
            if ($menu['menu_type'] == '2' || $menu['menu_type'] == '3') {
                $this->hasPublishingConfig = true;
                break;
            }
        }
    }
    
}
