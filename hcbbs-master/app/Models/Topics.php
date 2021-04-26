<?php

namespace App\Models;

use App\Original\Util\CodeUtil;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * トピックスのモデル
 *
 * @author yhatsutori
 *
 */
class Topics extends AbstractModel {

    use Authenticatable, CanResetPassword, SoftDeletes;
    
    // テーブル名
    protected $table = 'tb_topics';
    
    // 変更可能なカラム
    protected $fillable = [
        'title',
        'description',
        'view_flg',
        'view_date_min',
        'view_date_max',
        'period_flg',
        'category',
        'fix_flg',
        'topics_img',
        'topics_link_url',
        'topics_link_url_target',
        'campaign_img',
        'campaign_link_url',
        'campaign_link_url_target',
        'memo',
        'hansha_ids',
        'hansha_all_flg',
        'car_ids',
        'car_all_flg',
        'campaign_flg'
    ];

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
            // カテゴリー
            ->whereCategory( 'category', $requestObj->category )
            // エリア
            ->whereArea( $requestObj->area )
            // 県
            ->wherePref( $requestObj->pref )
            // 販社コード
            ->whereHanshaCode( $requestObj->hansha_cd )
            // 車種
            ->whereCar( $requestObj->car )
            // フリーワード（タイトル・本文）の絞り込み
            ->whereFreeword( $requestObj->word )
            // 表示
            ->whereView( $requestObj->view_flg, $requestObj->view_date )
            // キャンペーン
            ->whereCampaign( $requestObj->campaign_flg_db )
            // 全販社共通
            ->whereCommonHansha( $requestObj->hansha_all_flg )
            // 全車種共通
            ->whereCommonCar( $requestObj->car_all_flg )
            // ダミーデータ
            ->whereDummyFlg( $requestObj->dummy_flg );
            
        return $query;
    }

    /**
     * 検索条件を指定するメソッド(削除済)
     * @param  [type] $query      [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function scopeWhereDelRequest( $query, $requestObj ){
        
        $query = $query
            // 削除のみを表示
            ->onlyTrashed()
            // カテゴリー
            ->whereCategory( 'category', $requestObj->category )
            // エリア
            ->whereArea( $requestObj->area )
            // 県
            ->wherePref( $requestObj->pref )
            // 販社コード
            ->whereHanshaCode( $requestObj->hansha_cd )
            // 車種
            ->whereCar( $requestObj->car )
            // フリーワード（タイトル・本文）の絞り込み
            ->whereFreeword( $requestObj->word )
            // 表示
            ->whereView( $requestObj->view_flg, $requestObj->view_date )
            // キャンペーン
            ->whereCampaign( $requestObj->campaign_flg_db )
            // 全販社共通
            ->whereCommonHansha( $requestObj->hansha_all_flg )
            // 全車種共通
            ->whereCommonCar( $requestObj->car_all_flg )
            // ダミーデータ
            ->whereDummyFlg( $requestObj->dummy_flg );
            
        return $query;
    }

    /**
     * カテゴリーの検索をする時のスコープメソッド
     * @param  object $query QueryBuilder
     * @param  string $key   指定のカラム
     * @param  array $value 検索した値
     * @return object        QueryBuilder
     */
    public function scopeWhereCategory( $query, $key, $value ){
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
                    $sql .= " {$key} = {$v} ";
                }
            }
            
            $sql .= ")";
            
            $query->whereRaw( DB::raw( $sql ) );

        }
        
        return $query;
    }

    /**
     * エリアの検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $area  [description]
     * @return [type]        [description]
     */
    public function scopeWhereArea( $query, $area ){
        if( !empty( $area ) ){
            // 指定されたエリアに属する販社のidを取得
            $idsList = CodeUtil::getAreaHanshaIds( $area );
            
            $sql =  "";
            
            if( !empty( $idsList ) ){
                $whereIdsSql = " ( ";
                $whereIdsSqlList = [];

                foreach( $idsList as $key => $value ){
                    $whereIdsSqlList[] = "hansha_ids::text like '%\"{$value}\"%'";
                }

                if( !empty( $whereIdsSqlList ) == True ){
                    $whereIdsSql .=  implode( " AND ", $whereIdsSqlList );
                }

                $whereIdsSql .= " ) ";
                
                $whereIdsSql .= " OR hansha_all_flg = 1 ";
                
                $whereList[] = $whereIdsSql;
            }

            if( !empty( $whereList ) == True ){
                $sql =  " ( ";
                $sql .= implode( " AND ", $whereList );
                $sql .= " ) ";
                
                $query->whereRaw( DB::raw( $sql ) );

            }
        }

        return $query;
    }

    /**
     * 県の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $pref  [description]
     * @return [type]        [description]
     */
    public function scopeWherePref( $query, $pref ){
        if( !empty( $pref ) ){
            // 指定された県に属する販社のidを取得
            $idsList = CodeUtil::getPrefHanshaIds( $pref );
            
            $sql =  "";

            if( !empty( $idsList ) ){
                $whereIdsSql = " ( ";
                $whereIdsSqlList = [];

                foreach( $idsList as $key => $value ){
                    $whereIdsSqlList[] = "hansha_ids::text like '%\"{$value}\"%'";
                }

                if( !empty( $whereIdsSqlList ) == True ){
                    $whereIdsSql .=  implode( " AND ", $whereIdsSqlList );
                }

                $whereIdsSql .= " ) ";
                
                $whereIdsSql .= " OR hansha_all_flg = 1 ";
                
                $whereList[] = $whereIdsSql;
            }

            if( !empty( $whereList ) == True ){
                $sql =  " ( ";
                $sql .= implode( " AND ", $whereList );
                $sql .= " ) ";
                
                $query->whereRaw( DB::raw( $sql ) );
            }
        }

        return $query;
    }

    /**
     * 販社の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $hansha  [description]
     * @return [type]        [description]
     */
    public function scopeWhereHanshaCode( $query, $hansha_cd ){
        if( !empty( $hansha_cd ) ){
            // 指定された販社のidを取得
            $idsList = CodeUtil::getHanshaHanshaIds( $hansha_cd );
            
            $sql =  "";

            if( !empty( $idsList ) ){

                $whereIdsSql = " ( ";
                $whereIdsSqlList = [];

                foreach( $idsList as $key => $value ){
                    $whereIdsSqlList[] = "hansha_ids::text like '%\"{$value}\"%'";
                }

                if( !empty( $whereIdsSqlList ) == True ){
                    $whereIdsSql .=  implode( " AND ", $whereIdsSqlList );
                }

                $whereIdsSql .= " ) ";
                
                $whereIdsSql .= " OR hansha_all_flg = 1 ";
                
                $whereList[] = $whereIdsSql;
            }

            if( !empty( $whereList ) == True ){
                $sql =  " ( ";
                $sql .= implode( " AND ", $whereList );
                $sql .= " ) ";
                
                $query->whereRaw( DB::raw( $sql ) );
            }
        }
        
        return $query;
    }

    /**
     * 車種の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $car  [description]
     * @return [type]        [description]
     */
    public function scopeWhereCar( $query, $car ){
        if( !empty( $car ) ){
            $sql = "    (
                            car_ids::text like '%\"{$car}\"%' OR
                            car_all_flg = 1
                        ) ";
            
            $query->whereRaw( DB::raw( $sql ) );
        }

        return $query;
    }

    /**
     * フリーワードの検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $car  [description]
     * @return [type]        [description]
     */
    public function scopeWhereFreeword( $query, $word ){
        if( !empty( $word ) ){
            $sql = "    ( 
                            title ILIKE '%{$word}%' OR
                            description ILIKE '%{$word}%'
                        ) ";
            
            $query->whereRaw( DB::raw( $sql ) );
        }

        return $query;
    }

    /**
     * 表示の検索をする時のスコープメソッド
     * @param  [type] $query         [description]
     * @param  [type] $view_flg      [description]
     * @param  [type] $view_date_min [description]
     * @return [type]                [description]
     */
    public function scopeWhereView( $query, $view_flg, $view_date ){
        // 秒の初期化
        $view_date = date( "Y-m-d H:i:00", strtotime( $view_date ) );
        
        if( $view_flg == "1" ){
            $sql = "    view_flg != 2 AND
                        view_date_min <= '{$view_date}' AND
                        view_date_min IS NOT NULL AND
                        ( view_date_max > '{$view_date}' OR period_flg = 1 ) ";

            $query->whereRaw( DB::raw( $sql ) );

        }else if( $view_flg == "2" ){
            $sql = "(
                        view_flg != 2 AND
                        view_date_min <= '{$view_date}' AND
                        view_date_min IS NOT NULL AND
                        ( view_date_max > '{$view_date}' OR period_flg = 1 )
                    ) is False ";

            $query->whereRaw( DB::raw( $sql ) );
        }
        
        return $query;
    }

    /**
     * キャンペーンの検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereCampaign( $query, $value ){
        if( $value == "1" ){
            $query->whereRaw( DB::raw( " campaign_flg = 1 " ) );

        }else if( $value == "2" ){
            $query->whereRaw( DB::raw( " campaign_flg != 1 " ) );
        }

        return $query;
    }

    /**
     * 共通の販社の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereCommonHansha( $query, $value ){
        if( $value == "1" ){
            $query->whereRaw( DB::raw( " hansha_all_flg = 1 " ) );

        }else if( $value == "2" ){
            $query->whereRaw( DB::raw( " ( hansha_all_flg = 0 AND hansha_ids is not null ) " ) );
        }

        return $query;
    }

    /**
     * 共通の車種の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereCommonCar( $query, $value ){
        if( $value == "1" ){
            $query->whereRaw( DB::raw( " car_all_flg = 1 " ) );

        }else if( $value == "2" ){
            $query->whereRaw( DB::raw( " ( car_all_flg = 0 AND car_ids is not null ) " ) );
        }

        return $query;
    }

    /**
     * ダミー表示の検索をする時のスコープメソッド
     * @param  [type] $query [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function scopeWhereDummyFlg( $query, $value ){
        if( empty( $value ) == True ){
            $query->whereRaw( DB::raw( " dummy_flg = 0 " ) );

        }
        
        return $query;
    }

}
