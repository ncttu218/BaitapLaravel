<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * 販社のモデル
 *
 * @author yhatsutori
 *
 */
class Hansha extends AbstractModel {

    use Authenticatable, CanResetPassword, SoftDeletes;
    
    // テーブル名
    protected $table = 'tb_hansha';
    
    // 変更可能なカラム
    protected $fillable = [
        'hansha_name',
        'hansha_cd',
        'pref',
        'url',
        'memo'
    ];

    ######################
    ## other(検索部分)
    ######################
    
    /**
     * ViewComposerで使用
     * @return [type] [description]
     */
    public static function options() {
        return Hansha::JoinArea()
                    ->orderBys( ['tb_area.id' => 'asc', 'tb_hansha.pref' => 'asc', 'hansha_cd' => 'asc'] )
                    ->pluck( 'hansha_name', 'hansha_cd' );
    }
    
    ###########################
    ## スコープメソッド(Join文)
    ###########################

    /**
     * エリアテーブルとJoinするスコープメソッド
     *
     * @param unknown $query
     */
    public function scopeJoinArea( $query ) {
        $query = $query->leftJoin(
                    'tb_area',
                    function( $join ){
                        $join->on( DB::raw("ARRAY[tb_hansha.pref::text]"), '<@', DB::raw("regexp_split_to_array( REPLACE( REPLACE(tb_area.pref::text, '[', '') , ']', ''), ',' )") )
                             ->whereNull( 'tb_area.deleted_at' );
                    }
                );

        //dd( $query->toSql() );
        return $query;
    }

    /**
     * 県テーブルとJoinするスコープメソッド
     *
     * @param unknown $query
     */
    public function scopeJoinPref( $query ) {
        $query = $query->leftJoin(
                    'tb_pref',
                    function( $join ){
                        $join->on( "tb_hansha.pref", "=", DB::raw("tb_pref.id::text") )
                             ->whereNull( 'tb_pref.deleted_at' );
                    }
                );

        //dd( $query->toSql() );
        return $query;
    }

    /**
     * 検索条件を指定するメソッド
     * @param  [type] $query      [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function scopeWhereRequest( $query, $requestObj ){
        $query = $query
            //意向結果
            ->whereMatch( 'tb_area.id', $requestObj->area )
            //意向結果
            ->whereMatch( 'tb_hansha.pref', $requestObj->pref )
            //販社コード
            ->whereLike( 'tb_hansha.hansha_cd', $requestObj->hansha_cd )
            //販社名
            ->whereLike( 'tb_hansha.hansha_name', $requestObj->hansha_name );

        return $query;
    }

}
