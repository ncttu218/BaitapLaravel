<?php

namespace App\Models;

/**
 * エリアのモデル
 *
 * @author yhatsutori
 *
 */
class Area extends AbstractModel {

    // テーブル名
    protected $table = 'tb_area';
    
    // 変更可能なカラム
    protected $fillable = [
        'area_name',
        'pref'
    ];

    ######################
    ## other(検索部分)
    ######################

    /**
     * ViewComposerで使用
     * @return [type] [description]
     */
    public static function options() {
        return Area::orderBys( ['id' => 'asc'] )
                   ->pluck( 'area_name', 'id' );
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
