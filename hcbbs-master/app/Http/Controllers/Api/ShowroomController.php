<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Commands\Ranking\StaffCountReaderCommand;
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
class ShowroomController extends Controller
{
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        // テンプレートNo
        $this->hanshaCode = ( !empty( $req['hansha_code'] ) )? $req['hansha_code'] : ""; // 販社コード
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        
        /**
         * テンプレートのフォルダー
         */
        // デバイスのタイプ
        $this->deviceType = isset($req['device_type']) ? $req['device_type'] : null;
        if ($this->deviceType === 'pc' || $this->deviceType === 'lite') {
            $this->templateDir = 'api.' . $this->hanshaCode . '.staffbbs.' . $this->deviceType;
        } else {
            $this->templateDir = 'api.' . $this->hanshaCode . '.staffbbs.pc';
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
        
        return view( $this->templateDir . '.shop-info', compact('shopInfo') )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'templateDir', $this->templateDir );
    }
    
}