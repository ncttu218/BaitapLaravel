<?php

namespace App\Http\Controllers\V3\Common\Api\Repositories;

use App\Original\Util\SessionUtil;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tCommon;
use App\Models\Base;
use App\Models\Infobbs;
use Closure;
use Request;
use Session;
use DB;

/**
 * 緊急掲示板公開APIのコントローラー
 * 
 * @author ahmad
 */
trait EmergencyBulletinRepository
{
    use tCommon;
    
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
    private $shopCode;
    
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
     * 機能を使わない販社のフラグ
     * 
     * @var bool
     */
    protected $featureUnavailable = false;
    
    /**
     * デバッグのフラグ
     * 
     * @var bool
     */
    protected $debug = false;
    
    /**
     * 日時のフォーマット
     * 
     * @var string
     */
    protected $timeFormat = null;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        // テンプレートNo
        $this->hanshaCode = Request::segment(3); // 販社コード
        $this->shopCode = config("{$this->hanshaCode}.general.emergency_bulletin_board_id"); // 拠点コード

        $this->controller = "Api\EmergencyBulletinController";
        // 販社名の設定パラメータを取得
        $para_list = ( config('original.para')[$this->hanshaCode] );
        
        // 店舗が指定するフラグ
        $this->featureUnavailable = empty($this->shopCode);
        
        // 日時のフォーマット
        $this->timeFormat = isset($req['time_format']) ? $req['time_format'] : null;
        
        /**
         * テンプレートのフォルダー
         */
        // デバイスのタイプ
        $this->deviceType = isset($req['device_type']) ? $req['device_type'] : null;
        $devicePath = '';
        if ($this->deviceType === 'pc' || $this->deviceType === 'lite') {
            $devicePath = '.' . $this->deviceType;
        } else {
            $devicePath = '.pc';
        }
        $this->templateDir = 'api.' . $this->hanshaCode . '.api.emergency-bulletin' . $devicePath;
    }
    
    /**
     * 共通データ
     * 
     * @return object
     */
    private function getData() {
        return Infobbs::createNewInstance( $this->hanshaCode )
                ->where('deleted_at', null )
                ->where('published', 'ON' )
                ->orderBy('regist', 'desc')
                // 公開期間内のとき
                ->whereRaw( ' ( ( date(from_date) <= date(now()) AND date(to_date) >= date(now())) OR '
                        . ' ( date(from_date) <= date(now()) AND to_date IS NULL) OR '
                        . ' ( from_date IS NULL AND date(to_date) >= date(now())) OR '
                        . ' ( from_date IS NULL AND to_date IS NULL))' )
                ->where('shop', $this->shopCode );
    }

    /**
     * インデックス
     */
    public function getIndex() {
        // 店舗が指定するフラグ
        if ($this->featureUnavailable) {
            return '緊急掲示板の機能がついていません。';
        }
        
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 店舗のチェック
        $shopName = Base::where('hansha_code', $this->hanshaCode)
                ->where('base_code', $this->shopCode)
                ->value('base_name');

        if ($shopName === null) {
            return 'エラー：店舗が存在しません。';
        }
        
        // 1行メッセージのモデルインスタンス
        $recordData = $this->getData()
                ->selectRaw('title, created_at')
                ->first();
        
        if ($recordData === null) {
            return '';
        }
        
        // 正規化
        $showData = app('stdClass');
        $showData->title = $this->convertEmojiToHtmlEntity($recordData->title);
        // デフォルトの日時のフォーマット
        if ($this->timeFormat === null) {
            $this->timeFormat = 'Y/m/d';
        }
        $showData->created_at = date($this->timeFormat, strtotime($recordData->created_at));
        
        return view( $this->templateDir . '.index', 
            compact(
                'showData'
            )
        )
        ->with( 'controller', $this->controller )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode );
    }

    /**
     * 詳細画面
     */
    public function getDetail() {
        // 店舗が指定するフラグ
        if ($this->featureUnavailable) {
            return '緊急掲示板の機能がついていません。';
        }
        
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 店舗のチェック
        $shopName = Base::where('hansha_code', $this->hanshaCode)
                ->where('base_code', $this->shopCode)
                ->value('base_name');

        if ($shopName === null) {
            return 'エラー：店舗が存在しません。';
        }
        
        // 1行メッセージのモデルインスタンス
        $recordData = $this->getData()
                ->selectRaw('title, comment, created_at')
                ->first();
        
        if ($recordData === null) {
            return '';
        }
        
        // 正規化
        $showData = app('stdClass');
        $showData->title = $this->convertEmojiToHtmlEntity($recordData->title);
        // デフォルトの日時のフォーマット
        if ($this->timeFormat === null) {
            $this->timeFormat = 'Y.m.d';
        }
        $showData->created_at = date($this->timeFormat, strtotime($recordData->created_at));
        $showData->comment = $this->convertEmojiToHtmlEntity($recordData->comment);
        
        return view( $this->templateDir . '.detail', 
            compact(
                'showData'
            )
        )
        ->with( 'controller', $this->controller )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode );
    }
    
}
