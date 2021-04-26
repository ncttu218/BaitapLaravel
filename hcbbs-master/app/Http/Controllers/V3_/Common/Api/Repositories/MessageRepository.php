<?php

namespace App\Http\Controllers\V3\Common\Api\Repositories;

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
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        // テンプレートNo
        $this->hanshaCode = Request::segment(3); // 販社コード
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード

        $this->controller = "Api\MessageController";
        // 販社名の設定パラメータを取得
        $para_list = ( config('original.para')[$this->hanshaCode] );
        
        // 店舗が指定するフラグ
        $this->shopDesignation = $para_list['message'] === '2';
        $this->featureUnavailable = !isset($para_list['message']) || 
                $para_list['message'] == 0;
        
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
        
        // タイトル
        $title = $showData->value('title');
        
        $convertEmojiToHtmlEntity = Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']);

        return view( $this->templateDir . '.index', 
            compact(
                'title',
                'convertEmojiToHtmlEntity'
            )
        )
        ->with( 'controller', $this->controller )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'shopDesignation', $this->shopDesignation );
    }
    
}
