<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use App\Models\Message;
use App\Original\Util\SessionUtil;
use App\Http\Requests\MessageRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tCommon;
use App\Models\Base;
use Closure;
use Request;
use Session;
use DB;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
trait MessageRepository
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
     * 拠点指定ありなしのフラグ
     * 
     * @var bool
     */
    protected $shopDesignation;
    
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
     * 表示の種類
     * json, view
     * 
     * @var string
     */
    protected $showType;
    
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
        // 販社コード
        if (isset($_GET['hansha_code'])) {
            $this->hanshaCode = $_GET['hansha_code'];
        } else {
            $this->hanshaCode = Request::segment(3);
        }
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード

        $this->controller = "Api\MessageController";
        // 販社名の設定パラメータを取得
        $para_list = ( config('original.para')[$this->hanshaCode] );
        
        // 店舗が指定するフラグ
        $this->shopDesignation = $para_list['message'] === '2';
        $this->featureUnavailable = !isset($para_list['message']) || 
                $para_list['message'] == 0;
        // 表示
        $this->showType = isset($req['show_type']) ? $req['show_type'] : ""; // 表示タイプ JSONなど
        // 日時のフォーマット
        if (isset($req['time_format']) && !empty($req['time_format'])) {
            $this->timeFormat = $req['time_format'];
        }
        
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
        $this->templateDir = 'api.' . $this->hanshaCode . '.api.message' . $devicePath;
    }

    /**
     * インデックス
     */
    public function getIndex() {
        // 店舗が指定するフラグ
        if ($this->featureUnavailable) {
            return '一行メッセージの機能がついていません。';
        }
        
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopDesignation && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 店舗のチェック
        $shopName = null;
        if ($this->shopDesignation) {
            $shopName = Base::where('hansha_code', $this->hanshaCode)
                    ->where('base_code', $this->shopCode)
                    ->value('base_name');

            if ($shopName === null) {
                return 'エラー：店舗が存在しません。';
            }
        }
        
        // 1行メッセージのモデルインスタンス
        $showData = Message::createNewInstance( $this->hanshaCode )
                ->where('deleted_at', null )
                ->orderBy('regist', 'desc')
                // 公開期間内のとき
                ->whereRaw( ' ( ( date(from_date) <= date(now()) AND date(to_date) >= date(now())) OR '
                        . ' ( date(from_date) <= date(now()) AND to_date IS NULL) OR '
                        . ' ( from_date IS NULL AND date(to_date) >= date(now())) OR '
                        . ' ( from_date IS NULL AND to_date IS NULL))' );
        if ($this->shopDesignation) {
            $showData = $showData->where('shop', $this->shopCode );
        }
        $showData = $showData->first();
        
        if( $this->showType == "json" ) {
            $jsonData = app('stdClass');
            if ($showData !== null) {
                // タイトル
                $jsonData->title = !empty($showData->title) ? $showData->title : '';
                $jsonData->title = $this->convertEmojiToHtmlEntity($jsonData->title);
                // URL
                $jsonData->url = !empty($showData->url) ? $showData->url : '';
                // ウィンドウ開き
                $jsonData->url_target = !empty($showData->url_target) ? $showData->url_target : '';
                // 更新日時
                $jsonData->updated_at = !empty($showData->updated_at) ? date($this->timeFormat, strtotime($showData->updated_at)) : '';
            }
            /*
             *   JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
            return response()->json( $jsonData, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        } else {
            if ($showData === null) {
                return '';
            }

            // タイトル
            $title = !empty($showData->title) ? $showData->title : '';
            $title = $this->convertEmojiToHtmlEntity($title);
            // URL
            $url = !empty($showData->url) ? $showData->url : '';
            // ウィンドウ開き
            $url_target = !empty($showData->url_target) ? $showData->url_target : '';
            // 更新日時
            $updated_at = !empty($showData->updated_at) ? date($this->timeFormat, strtotime($showData->updated_at)) : '';

            $convertEmojiToHtmlEntity = Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']);

            return view( $this->templateDir . '.index', 
                compact(
                    'title',
                    'url',
                    'url_target',
                    'updated_at',
                    'convertEmojiToHtmlEntity',
                    'showData'
                )
            )
            ->with( 'controller', $this->controller )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'shopDesignation', $this->shopDesignation );
        }
    }
    
}
