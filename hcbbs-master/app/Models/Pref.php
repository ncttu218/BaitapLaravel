<?php

namespace App\Models;

/**
 * 県のモデル
 *
 * @author yhatsutori
 *
 */
class Pref extends AbstractModel {

    // テーブル名
    protected $table = 'tb_pref';
    
    // 変更可能なカラム
    protected $fillable = [
        'pref_name',
        'area_id'
    ];

    ######################
    ## other(検索部分)
    ######################

    /**
     * ViewComposerで使用
     * @return [type] [description]
     */
    public static function options() {
        return Pref::orderBys( ['id' => 'asc'] )
                   ->pluck( 'pref_name', 'id' );
    }
    
    ###########################
    ## List Commands
    ###########################
    
    /**
     * 検索条件を指定するメソッド
     * @param  [type] $query      [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function scopeWhereRequest( $query, $requestObj ){
        return $query;
    }

}
