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
class Car extends AbstractModel {
    
    use Authenticatable, CanResetPassword, SoftDeletes;
    
    // テーブル名
    protected $table = 'tb_car';
    
    // 変更可能なカラム
    protected $fillable = [
        'car_name',
        'car_img',
        'memo',
        'bodytype',
        'car_img2',
        'spec',
        'fuel',
        'car_url',
        'low_gas_standard',
        'low_fuel_standard',
        'car_cd',
        'car_name_ja',
        'hybrid_flg',
        'capacity',
        'displacement',
        'drive_system',
    ];
    
    ######################
    ## other(検索部分)
    ######################
    
    /**
     * ViewComposerで使用
     * @return [type] [description]
     */
    public static function options() {
        return Car::orderBys( ['car_name' => 'asc'] )
                   ->pluck( 'car_name', 'id' );
    }

    ###########################
    ## スコープメソッド(Join文)
    ###########################

    /**
     * 検索条件を指定するメソッド
     * @param  [type] $query      [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function scopeWhereRequest( $query, $requestObj ){
        $query = $query
            //車種名
            ->whereLike( 'car_name', $requestObj->car_name )
            //車種コード
            ->whereLike( 'car_cd', $requestObj->car_cd )
            //ボディタイプ
            ->whereBodyType( 'bodytype', $requestObj->bodytype )
            //ハイブリットフラグ
            ->whereHybrid( $requestObj->hybrid_flg );
            
        return $query;
    }

    /**
     * ボディタイプの検索をする時のスコープメソッド
     * @param  object $query QueryBuilder
     * @param  string $key   指定のカラム
     * @param  array $value 検索した値
     * @return object        QueryBuilder
     */
    public function scopeWhereBodyType( $query, $key, $value ){
        if( is_array( $value ) == True && !empty( $value[0] ) ){
            // 指定する値のSQL
            $sql = "(";
            
            foreach( $value as $k => $v ){
                if( $k != 0 ){
                    // or条件の追加
                    $sql .= " OR ";
                }

                // 値の追加
                if( !empty( $v ) ){
                    $sql .= "ARRAY[{$v}::text] <@ regexp_split_to_array( REPLACE( REPLACE(bodytype::text, '[', '') , ']', ''), ',' )";
                }
            }

            $sql .= ")";
        
            $query->whereRaw( DB::raw( $sql ) );        
        }
        
        return $query;
    }

    /**
     * ハイブリッドの車種の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereHybrid( $query, $value ){
        if( $value == "1" ){
            $query->whereRaw( DB::raw( " hybrid_flg = 1 " ) );

        }else if( $value == "2" ){
            $query->whereRaw( DB::raw( " hybrid_flg = 0 " ) );
        }

        return $query;
    }

}