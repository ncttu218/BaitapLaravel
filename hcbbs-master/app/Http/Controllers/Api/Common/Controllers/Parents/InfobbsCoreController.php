<?php

namespace App\Http\Controllers\Api\Common\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Interfaces\IInfobbsCoreRepository;
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
class InfobbsCoreController extends Controller implements IInfobbsCoreRepository {
    
    /**
     * 最大ランキング数
     */
    const MAX_RANKING_SHOP = 4;
    
    /**
     * 設定ファイルからの拠点除外
     */
    const SHOP_EXCLUSION_FROM_CONFIG_FILE = 0;
    
    /**
     * URLクエリーからの拠点除外
     */
    const SHOP_EXCLUSION_FROM_URL_QUERY = 1;
    
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
     * json, view
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
     * 文字を切る関数名
     * 
     * @var string
     */
    protected $cuttingMethod = 'mb_substr';

    /**
     * JSONの出力スタイル
     * 
     * @var string
     */
    protected $jsonStyle = 'data';
    
    /**
     * 日時のフォーマット
     * 
     * @var string
     */
    protected $timeFormat = 'Y.m.d';
    
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
     * 拠点除外のタイプ
     * 
     * @var int
     */
    protected $shopExclusionType;

    /**
     * 複数レコードのフラグ
     * 
     * @var bool
     */
    protected $isMultipleRecord = false;

    /**
     * カテゴリー
     * 
     * @var string
     */
    protected $category;

    /**
     * 並び順
     * 
     * @var string
     */
    protected $order;

    /**
     * テキストを置換する方法
     * 
     * @var string
     */
    protected $stringReplacementMethod = 'general';

    /**
     * 絞込種類
     * 
     * @var string
     */
    protected $filterType = 'all';
    
    /**
     * 開始公開日時を使わない販社
     * 
     * @var array
     */
    protected $fromDateEx = [
        '7251883', // 山形
        '7556029', // 十和田
        '8153883', // 福島
    ];

    /**
     * mb_stringwidthで切られる販社コード
     * 
     * @var array
     */
    protected $mbStringWidthCutShops = [
        '8153883', // 福島
        '7251883', // 山形
    ];
    
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
        
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        $this->showLimitNum = ( !empty( $req['show_limit_num'] ) )? $req['show_limit_num'] : ""; // 表示最大数
        $this->pageNum = ( !empty( $req['page_num'] ) )? $req['page_num'] : ""; // ページング最大数
        $this->tableName = 'tb_' . $this->hanshaCode . '_infobbs'; // 使用するテーブル名
        $this->page = isset($req['page']) ? (int)$req['page'] : 1; // ページングの数値
        $this->showType = isset($req['show_type']) ? $req['show_type'] : ""; // 表示タイプ JSONなど
        $this->shopFilter = isset($req['shop_filter']) ? explode('|', $req['shop_filter']) : []; // 拠点フィルター(表示したい拠点だけ)
        $this->viewStyle = isset($req['view_style']) ? $req['view_style'] : ""; // ビューのスタイル
        $this->viewStyle = ucfirst($this->viewStyle);
        
        $this->num = isset($req['num']) && !empty($req['num']) ? $req['num'] : -1; // ナンバーの指定
        // ナンバーの指定
        $this->order = isset($req['order']) && !empty($req['order']) ? $req['order'] : 'updated_at';
        // 複数レコードのフラグ
        $this->isMultipleRecord = $this->num === -1;
        // 本文の長さ
        $this->contentLength = isset($req['content_length']) &&
                !empty($req['content_length']) ? $req['content_length'] : '';
        // タイトルの長さ
        $this->titleLength = isset($req['title_length']) &&
                !empty($req['title_length']) ? $req['title_length'] : '';
        // タイトルの長さ
        if (isset($req['cutting_method']) && !empty($req['cutting_method'])) {
            $this->cuttingMethod = $req['cutting_method'];
        }
        // JSON出力スタイル
        $this->jsonStyle = isset($req['json_style']) &&
                !empty($req['json_style']) ? $req['json_style'] : 'data';
        // 日時のフォーマット
        if (isset($req['time_format']) && !empty($req['time_format'])) {
            $this->timeFormat = $req['time_format'];
        }
        // テキストを置換する方法
        if (isset($req['string_replacement']) && !empty($req['string_replacement'])) {
            $this->stringReplacementMethod = $req['string_replacement'];
        }
        // 絞込種類
        if (isset($req['filter_type']) && !empty($req['filter_type'])) {
            $this->filterType = $req['filter_type'];
        }
        
        /**
         * テンプレートのフォルダー
         */
        // デバイスのタイプ
        $this->deviceType = isset($req['device_type']) ? $req['device_type'] : 'pc';
        if ($this->deviceType === 'pc' || $this->deviceType === 'lite') {
            $this->templateDir = 'api.' . $this->hanshaCode . '.api.infobbs.' . $this->deviceType;
        } else {
            $this->templateDir = 'api.' . $this->hanshaCode . '.api.infobbs.pc';
        }
        
        // API設定の拠点除外
        $this->shopExclusion = [];
        if (!isset($req['shop_exclusion']) || empty($req['shop_exclusion'])) {
            $api_para = config('original.api_para');
            if (isset($api_para[$this->hanshaCode])) {
                $api_para = $api_para[$this->hanshaCode];
                $this->shopExclusion = $api_para['shop_exclusion'] ?? []; // 拠点の除外
                $this->shopExclusionType = self::SHOP_EXCLUSION_FROM_CONFIG_FILE;
            }
        } else {
            $this->shopExclusion = explode('|', $req['shop_exclusion']);
            $this->shopExclusionType = self::SHOP_EXCLUSION_FROM_URL_QUERY;
        }
        
        $this->category = isset($req['category']) ? 
                mb_convert_encoding($req['category'], 'UTF-8', 'Shift-JIS') : ''; // カテゴリー
    }
    
}
