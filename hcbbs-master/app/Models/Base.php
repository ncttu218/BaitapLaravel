<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StaffInfo;
use App\Models\SrInfo;
use DB;

/**
 * 拠点のモデル
 *
 * @author yhatsutori
 *
 */
class Base extends AbstractModel {

    use SoftDeletes;

    // テーブル名
    protected $table = 'base';
    
    // 変更可能なカラム
    protected $fillable = [
        'hansha_code', // 販社コード
        'base_code', // 拠点コード
        'base_name', // 拠点名
        'show_flg', // 表示フラグ
        'base_published_flg', // 公開/非公開
    ];

    /**
     * ユーザーIDの重複をチェックする
     * カスタムバリデーション用メソッド
     * @param unknown $value
     * @return boolean
     */
    public function unique( $value ) {
        $count = Base::where( 'hansha_code', $value )
                    ->whereNull( $this->getTableName().'.'.$this->getDeletedAtColumn() )
                    ->count();

        return $count == 0;
    }

    /**
     * 販社プルダウンの値を取得する。
     */
    public static function getHanshaOptions(){
        // 販社プルダウンの値
        $hanshaOptions = [];
        // 設定ファイルから販社の値を取得する
        $hanshaList = \Config::get('original.hansha_code');
        // プルダウンの値を生成する
        foreach( $hanshaList as $key => $value ){
            $hanshaOptions[$key] = $key . ": " . $value;
        }

        return $hanshaOptions;
    }

    /**
     * 販社の値を取得する。
     */
    public static function getHanshaName( $hansha_code ){
        $hanshaName = "";
        $hanshaOptions = self::getHanshaOptions();

        if( isset( $hanshaOptions[$hansha_code] ) == True ){
            return $hanshaOptions[$hansha_code];
        }
        return $hanshaName;
    }

    /**
     * 拠点プルダウンの値を取得する。
     * 
     * @param string $hansha_code 販社コード
     * @param bool $onlyPublishedShop 非公開の絞込条件を使うフラグ
     * @return array
     */
    public static function getShopOptions(
        $hansha_code,
        $onlyPublishedShop = false,
        $showFlg = 0
    ) {
        $base = Base::where( 'hansha_code', '=' , $hansha_code ); // 販社コードの指定
        if ($onlyPublishedShop === true) {
            $base = $base->where('base_published_flg', 1);
        }
        
        // 表示フラグの絞り込み
        if( !empty( $showFlg ) == True ){
            $sql = " (
                        -- 表示フラグが指定のとき　1: 店舗ブログ  2:スタッフブログ
                        show_flg = {$showFlg} OR
                        -- 表示フラグがすべて表示のもの
                        show_flg IS NULL
                    ) ";
            $base->whereRaw( DB::Raw( $sql ) );
        }
        
        // 緊急掲示板の拠点コード
        $bulletinId = self::getEmergencyBulletinShopId($hansha_code);
        // 緊急掲示板の除外
        if (isset($bulletinId) && !empty($bulletinId)) {
            $base->whereNotIn('base_code', [$bulletinId]);
        }
        
        $base = $base->orderBys( ['base_code' => 'asc'] ) // 拠点コードの昇順
                   ->pluck( 'base_name', 'base_code' );
        return $base;
    }
    
    /**
     * 緊急掲示板の店舗コード
     * 
     * @return string|null
     */
    public static function getEmergencyBulletinShopId($hanshaCode) {
        return config("{$hanshaCode}.general.emergency_bulletin_board_id");
    }

    /**
     * 拠点プルダウンの値を取得する。
     * スタッフ集合写真がある店舗のみ
     * 
     * @param string $hansha_code 販社コード
     * @param bool $onlyPublishedShop 非公開の絞込条件を使うフラグ
     * @return array
     */
    public static function getShowroomBlogShopOptions( $hansha_code, $onlyPublishedShop = false ){
        // テーブル名
        $baseTable = (new self)->getTable();
        $srInfoObj = SrInfo::createNewInstance( $hansha_code );
        $srInfoTable = $srInfoObj->getTable();
        
        $base = self::selectRaw("DISTINCT base.base_code, base.base_name")
                ->where( "{$baseTable}.hansha_code", '=' , $hansha_code ); // 販社コードの指定
        
        if ($onlyPublishedShop === true) {
            $base = $base->where('b.base_published_flg', 1);
        }
        $base = $base->rightJoin($srInfoTable . ' AS si', function($join)
                use($baseTable) {
            $join->on("si.shop", "{$baseTable}.base_code");
        })
        ->orderBys( ["{$baseTable}.base_code" => 'asc'] ) // 拠点コードの昇順
        ->pluck( "{$baseTable}.base_name", "{$baseTable}.base_code" );
        
        return $base;
    }

    /**
     * 拠点プルダウンの値を取得する。
     * スタッフブログがある店舗のみ
     * 
     * @param string $hansha_code 販社コード
     * @param bool $onlyPublishedShop 非公開の絞込条件を使うフラグ
     * @return array
     */
    public static function getStaffBlogShopOptions( $hansha_code, $onlyPublishedShop = false ){
        // テーブル名
        $baseTable = (new self)->getTable();
        $staffInfoObj = StaffInfo::createNewInstance( $hansha_code );
        $staffInfoTable = $staffInfoObj->getTable();
        
        $base = self::selectRaw("DISTINCT base.base_code, base.base_name")
                ->where( "{$baseTable}.hansha_code", '=' , $hansha_code ); // 販社コードの指定
        
        if ($onlyPublishedShop === true) {
            $base = $base->where('b.base_published_flg', 1);
        }
        $base = $base->rightJoin($staffInfoTable . ' AS si', function($join)
                use($baseTable) {
            $join->on("si.shop", "{$baseTable}.base_code");
        })
        ->orderBys( ["{$baseTable}.base_code" => 'asc'] ) // 拠点コードの昇順
        ->pluck( "{$baseTable}.base_name", "{$baseTable}.base_code" );
        
        return $base;
    }

    /**
     * 拠点プルダウンの値を取得する。
     * スタッフブログがない店舗のみ
     * 
     * @param string $hansha_code 販社コード
     * @param bool $onlyPublishedShop 非公開の絞込条件を使うフラグ
     * @return array
     */
    public static function getNoStaffBlogShopOptions( $hansha_code, $onlyPublishedShop = false ){
        // テーブル名
        $baseTable = (new self)->getTable();
        $staffInfoObj = StaffInfo::createNewInstance( $hansha_code );
        $staffInfoTable = $staffInfoObj->getTable();
        
        $base = self::selectRaw("DISTINCT base.base_code, base.base_name")
                ->where( "{$baseTable}.hansha_code", '=' , $hansha_code ); // 販社コードの指定
        
        if ($onlyPublishedShop === true) {
            $base = $base->where('b.base_published_flg', 1);
        }
        $base = $base->leftJoin($staffInfoTable . ' AS si', function($join)
                use($baseTable) {
            $join->on("si.shop", "{$baseTable}.base_code");
        })
        ->whereNull('si.shop')
        ->orderBys( ["{$baseTable}.base_code" => 'asc'] ) // 拠点コードの昇順
        ->pluck( "{$baseTable}.base_name", "{$baseTable}.base_code" );
        
        return $base;
    }

    /**
     * 拠点の値を取得する。
     */
    public static function getShopName( $hansha_code, $shop_code ){
        $shopName = "";
        $shopOptions = self::getShopOptions( $hansha_code );

        if( isset( $shopOptions[$shop_code] ) == True ){
            return $shopOptions[$shop_code];
        }
        return $shopName;
    }

    /**
     * 検索条件を指定するメソッド
     * @param  [type] $query      [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function scopeWhereRequest( $query, $requestObj ){
        // 検索条件を指定
        $query
            // 販社コード
            ->whereMatch( 'hansha_code', $requestObj->hansha_code )
            // 拠点コード
            ->whereMatch( 'base_code', $requestObj->base_code )
            // 拠点名
            ->whereLike( 'base_name', $requestObj->base_name )
            // 表示フラグ
            ->whereMatch( 'show_flg', $requestObj->show_flg );

        return $query;
    }

}
