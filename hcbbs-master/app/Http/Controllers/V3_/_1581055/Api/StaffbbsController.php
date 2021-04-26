<?php

namespace App\Http\Controllers\V3\_1581055\Api;

use App\Http\Controllers\V3\Common\Api\Controllers\Parents\StaffbbsCoreController;
use App\Http\Controllers\V3\Common\Api\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\StaffbbsRepository;

use App\Original\Codes\StaffDepartmentCodes;

use App\Models\Base;
use Closure;
use DB;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class StaffbbsController extends StaffbbsCoreController implements IStaffbbsRepository
{
    use StaffbbsRepository;
    
    /**
     * 役職のデータのスタイル
     * 
     * @var int
     */
    protected $staffPopulationStyle;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // スタッフデータのスタイル
        $this->staffPopulationStyle = StaffDepartmentCodes::DEPARTMENT_POPULATION_STYLE2;
        
        parent::__construct();
    }
    
    /**
     * 最新ブログの画面
     * 
     */
    public function getLatestBlog() {
        // 最新ブログの絞り込み
        $query = DB::table( $this->tableName )
                // 各拠点の最新記事の絞り込み
                ->selectRaw('DISTINCT ON (treepath) *');
        // 表示順の条件
        $query = $this->buildOrderBy( $query->orderBy( 'treepath' ) )
                ->orderBy( 'updated_at', 'desc' );
        // 絞り込み条件
        $query = $query->where( 'published', 'ON' );
        
        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();
        
        /**
         * 2段階のソート
         */
        $query2 = DB::table( DB::raw("({$query->toSql()}) AS sub") )
                ->selectRaw(''
                        . 'main.*, '
                        . 'b.base_name AS base_name, '
                        . 'staff.shop AS staff_shop_code, '
                        . 'staff.number AS staff_code, '
                        . 'staff.name, '
                        . 'staff.position AS staff_position, '
                        . 'staff.photo AS staff_photo')
                /**
                 * 2段階のJOIN
                 */
                ->mergeBindings( $query )
                ->join( $this->tableName . ' AS main', 'main.id', 'sub.id' )
                /**
                 * スタッフ情報
                 */
                ->join( $this->tableName . ' AS staff', function ($join) {
                    $join->on('staff.number', 'main.treepath'); // 番号
                    $join->whereRaw("(staff.disp = 'ON' OR staff.disp = 'disp')"); // 表示
                })
                /**
                 * 拠点テーブルとのJOIN
                 */
                ->join( $baseTableName . ' AS b', function ($join) {
                    $join->on('b.base_code', 'staff.shop'); // 拠点コード
                    $join->on('b.hansha_code', DB::raw("'{$this->hanshaCode}'")); // 販社コード
                });
                // 削除フラグ
                // ->whereNull('b.deleted_at')
                // 非公開の拠点は除く
                // ->where( 'b.base_published_flg', '<>', 2 );
        // 表示順の条件
        $query2 = $this->buildOrderBy( $query2, 'main' );
        
        // 拠点の除外
        if (is_array($this->shopExclusion) && count($this->shopExclusion) > 0) {
            $query2 = $query2->whereNotIn( 'staff.shop', $this->shopExclusion );
        }
        
        // 表示最大数の指定
        if( $this->showLimitNum !== "" ){
            $query2 = $query2->limit( $this->showLimitNum );
        }
        
        $blogs = $query2->get();
        
        // 拠点コードによる並び順
        if (!empty($this->shopFilter)) {
            // 拠点コードごとに配列にいれる
            $temp = [];
            foreach( $blogs as $value ){
                // 拠点コードを格納
                $shopCode = $value->shop;
                $temp[$shopCode] = $value;
            }
            // 拠点コードをフィルター
            $list['blogs'] = [];
            foreach ( $this->shopFilter as $shopCode ) {
                // 存在しなかったら、スキップ
                if (!isset($temp[$shopCode])) {
                    continue;
                }
                // 登録
                $list['blogs'][] = $temp[$shopCode];
            }
        } else {
            $list['blogs'] = $blogs;
        }
        
        // 関数をビューに渡す
        $list['isNewBlog'] = Closure::fromCallable([$this, 'isNewBlog']);

        // 表示タイプがJSONのとき
        if( $this->showType == "json" ){
            $data = $this->renderAsViewData( $list, false );
            /*
             * JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
           return response()->json( $data, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }else{
            return view( $this->templateDir . '.latest-blog', $list )
                ->with( 'hanshaCode', $this->hanshaCode )
                ->with( 'templateDir', $this->templateDir );
        }
    }
}
