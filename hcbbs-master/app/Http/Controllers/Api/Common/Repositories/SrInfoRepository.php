<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use App\Commands\Ranking\StaffCountReaderCommand;
use App\Http\Controllers\Api\Common\Traits\Infobbs\ConvertEmojis;
use App\Original\Util\SessionUtil;
use App\Original\Util\RankingUtil;
use App\Lib\Util\DateUtil;
use App\Http\Controllers\tCommon;
use App\Models\Base;
use App\Models\SrInfo;
use Validator;
use Request;
use Closure;
use Image;
use DB;

/**
 * 本社用管理画面コントローラー
 *
 * @author ahmad
 *
 */
trait SrInfoRepository
{
    use ConvertEmojis;
    
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
    }
    
    /**
     * ショールームの情報
     */
    public function getInfo() {
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" && $this->shopCode === "" ){
            return;
        }
        
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        $shopInfo = $srInfoObj->where( 'shop', '=', $this->shopCode )
                ->where('deleted_at', null )
                ->first();
        
        // 値が無いときはエラーを出力
        if( $shopInfo === null ){
            return;
        }
        
        // 拠点
        $shopData = DB::table( 'base' )
            ->select( 'base_name' )
            ->where( 'hansha_code', $this->hanshaCode )
            ->where( 'base_code', $this->shopCode )
            ->where( 'deleted_at', null )
            ->where( 'base_published_flg', '<>', 2 ) // 非公開の拠点は除く
            ->orderBy( 'base_code', 'asc' )
            ->first();
        $shopName = $shopData->base_name ?? '';
        
        // 絵文字の変換
        $shopInfo->comment = $this->convertEmoji($shopInfo->comment);
        
        return view( $this->templateDir . '.shop-info', compact('shopInfo') )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'shopName', $shopName )
            ->with( 'templateDir', $this->templateDir );
    }
    
}