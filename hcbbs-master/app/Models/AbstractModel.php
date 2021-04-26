<?php

namespace App\Models;

use App\Lib\Util\QueryUtil;
use App\Original\Codes\DeleteCodes;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Modelクラスを継承したクラス
 * 他のモデルクラスは、基本的にこのクラスを継承する
 */
class AbstractModel extends Model {

    /**
     * サブクラスで使用するテーブル名を取得する
     * @return サブクラスのテーブル名
     */
    public static function getTableName() {
        return ( new static )->getTable();
    }
    
    /**
     * 指定されているidが空かどうかを調べる
     * @return boolean [description]
     */
    public function isNew() {
        return empty( $this->id );
    }

    /**
     * 更新者を動的にバインド
     */
    public function updator() {
        return $this->hasOne( 'App\Models\UserAccount', 'id', 'updated_by' );
    }

    ###########################
    ## スコープメソッド(条件式)
    ###########################
    
    /**
     * 値が合致するかの条件文を追加
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereMatch( $query, $key, $value ){
        if( !empty( $value ) ) {
            $query->where( $key, $value );
        }
        return $query;
    }

    /**
     * Likeの条件文を追加
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereLike( $query, $key, $value ){
        if( !empty( $value ) ) {
            $query->where( $key, 'like', '%'.$value.'%' );
        }
        return $query;
    }

    /**
     * 期間の条件文を追加
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $from  [description]
     * @param  [type] $to    [description]
     * @return [type]        [description]
     */
    public function scopeWherePeriod( $query, $key, $from, $to ){
        if( !empty( $from ) ) {
            $query = QueryUtil::between( $query, $key, $from, $to );
        }
        return $query;
    }

    /**
     * 期間の条件文を追加
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $from  [description]
     * @param  [type] $to    [description]
     * @return [type]        [description]
     */
    public function scopeWherePeriodNormal( $query, $key, $from, $to ){
        if( !empty( $from ) ) {
            $query = QueryUtil::betweenNormal( $query, $key, $from, $to );
        }
        return $query;
    }

    /**
     * 有無の判定の条件文を追加
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereUmuNull( $query, $key, $value ){
        if( !empty( $value ) ) {
            if ( $value === '1' ) {
                $query->whereNotNull( $key );
                
            } elseif ( $value === '0' ) {
                $query->whereNull( $key );
                
            }
        }
        return $query;
    }
    
    /**
     * チェックボックスで有無の判定をする時のスコープメソッド
     * @param  object $query QueryBuilder
     * @param  string $key   指定のカラム
     * @param  array $value 検索した値
     * @return object        QueryBuilder
     */
    public function scopeWhereUmuNullCheckbox($query, $key, $value)
    {
        //$s = microtime(true);
        if (is_array($value)) {
            $query->where(function ($query) use ($key, $value) {
                foreach ($value as $v) {
                    if ($v === '0') {
                        $query->orWhereNull($key);
                    } elseif ($v === '1') {
                        $query->orWhereNotNull($key);
                    }
                }
            });
        }

        return $query;
    }
    
    /**
     * 取得するデータに削除データを含めるかどうかのメソッド
     * @param  query $query それまでのクエリ
     * @param  [type] $value [description]
     * @return query
     */
    public function scopeIncludeDeleted( $query, $value ) {
        if( !empty( $value ) ) {
            // 削除データのみを対象
            if( DeleteCodes::isDelete( $value ) ) {
                $query->onlyTrashed();

            }else if( $value == "1" ){
                // 削除されていないものを表示
                $query->withTrashed()
                      ->whereNull( $this->getTableName().'.'.$this->getDeletedAtColumn() );

            // 両方を対象
            } else {
                $query->withTrashed();
                
            }
            return $query;
        }
    }

    ###########################
    ## スコープメソッド(並び替え)
    ###########################
    
    /**
     * 複数のorder byを指定するメソッド
     * @param  [type] $query  [description]
     * @param  [type] $orders [description]
     * @return [type]         [description]
     */
    public static function scopeOrderBys( $query, $orders ) {
        if( !empty( $orders ) ) {
            foreach ( $orders as $key => $value ) {
                $query->orderBy( DB::raw($key), $value );
            }
        }
        return $query;
    }

}
