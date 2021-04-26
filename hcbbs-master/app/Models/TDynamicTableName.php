<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of DynamicTableName
 *
 * @author ohishi
 */
trait TDynamicTableName {
    
    // テーブル名
    protected static $new_table;
    
    /**
     * 新しいインスタンスを生成される時の対応
     * 
     * @param array $attributes
     * @param bool $exists
     * @return object
     */
    public static function createNewInstance($table = '', $attributes = [], $exists = false)
    {
        // 新規モデル生成
        $model = new self();
        // テーブル名
        if ( $table !== '' && method_exists($model, 'onTableNameChanging') ) {
            $table = $model->onTableNameChanging( $table );
        }
        $model::$new_table = $table;
        
        // インスタンス
        $model = $model->newInstance($attributes, $exists);
        $model->setTable( $model::$new_table );

       return $model;
    }
    
    /**
     * 新しいインスタンスを生成される時の対応
     * 
     * @param array $attributes
     * @param bool $exists
     * @return object
     */
    public function newInstance($attributes = [], $exists = false)
    {
        // インスタンス
        $model = parent::newInstance($attributes, $exists);
        // テーブル名を変更
        $model->setTable( self::$new_table );

       return $model;
    }
}
