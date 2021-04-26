<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Commands\Ranking\StaffCountReaderCommand;
use App\Original\Util\SessionUtil;
use App\Original\Util\RankingUtil;
use App\Lib\Util\DateUtil;
use App\Http\Controllers\tCommon;
use App\Models\Base;
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
class StaffbbsController extends Controller
{
    const MAX_RANKING_SHOP = 4;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        // テンプレートNo
        $this->hanshaCode = ( !empty( $req['hansha_code'] ) )? $req['hansha_code'] : ""; // 販社コード
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        $this->staffCode = ( !empty( $req['staff'] ) )? $req['staff'] : ""; // スタッフコード
        $this->showLimitNum = ( !empty( $req['show_limit_num'] ) )? $req['show_limit_num'] : ""; // 表示最大数
        $this->pageNum = ( !empty( $req['page_num'] ) )? $req['page_num'] : ""; // ページング最大数
        $this->tableName = 'tb_' . $this->hanshaCode . '_staff'; // 使用するテーブル名
        $this->page = isset($req['page']) ? (int)$req['page'] : 1; // ページングの数値
        $this->showType = isset($req['show_type']) ? $req['show_type'] : ""; // 表示タイプ JSONなど
        $this->shopFilter = isset($req['shop_filter']) ? explode('|', $req['shop_filter']) : []; // 拠点フィルター(表示したい拠点だけ)
        $this->viewStyle = isset($req['view_style']) ? $req['view_style'] : ""; // ビューのスタイル
        // 本文の長さ
        $this->contentLength = isset($req['content_length']) &&
                !empty($req['content_length']) ? $req['content_length'] : '';
        // タイトルの長さ
        $this->titleLength = isset($req['title_length']) &&
                !empty($req['title_length']) ? $req['title_length'] : '';
        
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
        
        // API設定の拠点除外
        $this->shopExclusion = [];
        if (!isset($req['shop_exclusion']) || empty($req['shop_exclusion'])) {
            $api_para = config('original.api_para');
            if (isset($api_para[$this->hanshaCode])) {
                $api_para = $api_para[$this->hanshaCode];
                $this->shopExclusion = $api_para['shop_exclusion'] ?? []; // 拠点の除外
            }
        } else {
            $this->shopExclusion = explode('|', $req['shop_exclusion']);
        }
    }
    
    /**
     * 表示順の条件
     * 
     * @param object $query
     * @return object
     */
    private function buildOrderBy( $query, $prefix = '' ) {
        // 公開日時があれば公開日時を、無ければ、更新日時のソート順にする
        if ($prefix !== '') {
            $prefix .= '.';
        }
        return $query->orderBy( $prefix . 'updated_at', 'desc' );
    }
    
    /**
     * 最新ブログ1件のみを出力する
     * 
     */
    public function getStaffList()
    {
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 拠点
        $shopData = DB::table( 'base' )
                    ->select( 'base_name' )
                    ->where( 'hansha_code', $this->hanshaCode )
                     ->where( 'base_code', $this->shopCode )
                    ->where( 'deleted_at', null )
                    ->where( 'base_published_flg', '<>', 2 ) // 非公開の拠点は除く
                    ->orderBy( 'base_code','asc' )
                    ->first();

        $shopName = $shopData->base_name ?? '';

        // 一覧表示
        $query = DB::table( $this->tableName );
        
        if (!empty($this->shopCode)) {
            $query = $query->where( 'shop', '=', $this->shopCode );
        }
        
        $query = $query
            // 親がないレコード
            ->whereNull('treepath')
            // 表示
            ->whereRaw("(disp = 'ON' OR disp = 'disp')")
            // 登録日時ソート
            ->orderBy('number', 'asc');
        
        $staffData = $query->get();
        
        // 拠点の絞り込み
        $list['staffs'] = $staffData;
        
        // 表示タイプがJSONのとき
        if ($this->showType == 'json') {
            
            // リスト
            $data = [];
            foreach ($staffData as $item) {
                $data[] = [
                    'number'    => $item->number,
                    'name'      => $item->name,
                    'name_furi' => $item->name_furi,
                    'msg'       => $item->msg,
                ];
            }
            
            /*
             *   JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
            return response()->json( $data, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
        
        return view( $this->templateDir . '.staff-list', $list )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopName', $shopName )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'templateDir', $this->templateDir );
    }
    
    /**
     * 最新ブログ1件のみを出力する
     * 
     */
    public function getProfile()
    {
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" /*&& $this->shopCode === ""*/ && $this->staffCode === ""  ){
            return "<p>表示エラー</p>";
        }

        // 拠点
        $shopData = DB::table( 'base' )
                    ->select( 'base_name' )
                    ->where( 'hansha_code', $this->hanshaCode )
                    ->where( 'base_code', $this->shopCode )
                    ->whereNull( 'deleted_at' )
                    ->where( 'base_published_flg', '<>', 2 ) // 非公開の拠点は除く
                    ->first();

        // 拠点データが無いときエラー
        /*if( empty( $shopData ) ){
            return "<p>エラー： 拠点が登録されていません</p>";
        }*/

        $shopName = $shopData->base_name ?? '';

        // 一覧表示
        $query = DB::table( $this->tableName );
        
        // 拠点の絞り込み
        $list['staff'] = // $query->where( 'shop', '=', $this->shopCode )
            // 親がないレコード
            $query->whereNull('treepath')
            // 削除されていない
            ->whereNull('deleted_at')
            // 公開
            ->where('published', 'ON')
            // 削除されていない
            ->whereRaw("(disp = 'ON' OR disp = 'disp')")
            // 番号
            ->where( 'number', '=', 'data' . $this->staffCode )
            ->first();
        
        // 拠点データが無いときエラー
        if( empty( $list['staff'] ) ){
            return "<p>エラー： スタッフが登録されていません</p>";
        }
        
        // 拠点名
        $list['shopName'] = $shopName;
            
        // プロフィール
        $list['staff'] = $this->renderProfileAsViewData( $list );
        
        // ビューのデータ
        $view = view( $this->templateDir . '.profile', $list )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'templateDir', $this->templateDir );
        
        // 表示タイプがJSONのとき
        if ($this->showType == 'json_html') {
            // スタッフのデータ
            $staffData = app('stdClass');
        
            // HTML内容
            $staffData->html = $view->render();
            // プロフィールのデータ
            $staffData->data = $list['staff'];
            
            /*
             *   JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
            return response()->json( $staffData, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        } else if ($this->showType == 'json') {
            /*
             *   JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
            return response()->json( $list['staff'], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
        
        return $view;
    }
    
    /**
     * 一般なブログの画面
     * ブログ一覧画面
     */
    public function getBlog()
    {
        $req = Request::all();

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 表示最大数の指定
        if( $this->pageNum !== "" ){
            $perPage = (int)$this->pageNum;
        } else {
            // 1ページの表示件数
            $perPage = \Config( 'original.para' )[$this->hanshaCode] ['page_num'];
        }
        
        // 一覧表示
        $query = DB::table( $this->tableName . ' AS info' );

        ###############################
        ## 検索処理
        ###############################

        // 拠点コード
        if( $this->shopCode !== "" ){
            $query = $query->where( 'staff.shop', $this->shopCode);
        }
        // カテゴリー
        /*if( isset( $req['category'] ) && $req['category'] !== "" ){
            /// カテゴリーを検索するSQL
            $category = mb_convert_encoding($req['category'], 'UTF-8', 'Shift-JIS');
            $query = $query->whereRaw( DB::Raw( " ARRAY['{$category}'] <@ regexp_split_to_array( info.category, ',' ) "  ) );
        }*/
        
        if ($this->staffCode !== '') {
            // スタッフ番号
            $query = $query->where('info.treepath', "data{$this->staffCode}");
        } else {
            $query = $query->whereRaw('info.treepath IS NOT NULL');
        }
        
        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();

        //->where( 'shop', '=', $this->shopCode)
        $blogs = $query->where( 'info.published', 'ON' )
                // 表示するカラム
                ->selectRaw('info.*, staff.name, staff.shop AS staff_shop_code, b.*') // , b.base_name')
                // 削除日時がNULLのとき
                ->whereNull( 'info.deleted_at' )
                // スタッフとのJOIN
                ->leftJoin( $this->tableName . ' AS staff', function ($join) {
                    // $join->on('staff.shop', 'info.shop'); // 拠点コード
                    $join->on('staff.number', 'info.treepath'); // 親
                    $join->whereRaw("(staff.disp = 'ON' OR staff.disp = 'disp')"); // 親
                })
                // 拠点テーブルとのJOIN
                ->leftJoin( $baseTableName . ' AS b', function ($join) {
                    $join->on('b.base_code', 'staff.shop'); // 拠点コード
                    $join->on('b.hansha_code', DB::raw("'{$this->hanshaCode}'")); // 販社コード
                });
                // 削除フラグ
                // ->whereNull('b.deleted_at')
                // 非公開の拠点は除く
                // ->where( 'b.base_published_flg', '<>', 2 );
                
        $blogs = $this->buildOrderBy($blogs, 'info');
        // ページネーション
        $blogs = $blogs->paginate($perPage);
        
        // ページ情報   
        $pageInfo = [
            'total' => $blogs->total(),
            'lastPage' => $blogs->lastPage(),
            'perPage' => $blogs->perPage(),
            'currentPage' => $blogs->currentPage(),
        ];
        
        $list['blogs'] = $blogs;
        
        // 読者を計算
        $this->dispatch(
            new StaffCountReaderCommand(
                $this->hanshaCode,
                $this->shopCode,
                $this->staffCode,
                $pageInfo
            )
        );
        
        $items = $this->renderAsViewData($list, false);
        
        // 表示タイプがJSONのとき
        if( $this->showType == "json"){
            /*
             * JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
           return response()->json( $items, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }else{
            // ビューのスタイル
            $viewStyle = $this->viewStyle !== '' ? '.' . $this->viewStyle : '';
        
            return view( $this->templateDir . '.blog' . $this->viewStyle, compact(
                'blogs',
                'items'
            ))
                ->with( 'hanshaCode', $this->hanshaCode)
                ->with( 'shopCode', $this->shopCode)
                ->with( 'templateDir', $this->templateDir );
        }
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
            $query2 = $query2->whereNotIn( 'main.shop', $this->shopExclusion );
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

    /**
     * ランキング画面
     * 
     */
    public function getRanking()
    {
        // 販社コードが存在しないときエラー
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 画面表示用配列の初期化
        $list = [];
        $rankingData = [];
        
        // 先週のログファイルを読み込む
        $path = storage_path( 'ranking' ) . '/' . $this->hanshaCode . '/staffbbs/';
        $dir = realpath($path) . DIRECTORY_SEPARATOR;
        $summaryFileName = 'staff_ranking.txt';
        $path = $dir . $summaryFileName;
        //  ログファイルのパスが存在するとき
        if( file_exists( $path ) ) {
            $content = file_get_contents($path);
            $rankingData = $this->retrieveRankingData( $content );
        }
        
        // ログファイルのランキングデータが空の時
        /*if( count( $rankingData ) == 0 ) {
            // 旧ブログシステムのランキング取得URL
            $url = 'http://cgi2-aws.hondanet.co.jp/cgi/' . $this->hanshaCode . '/blog_ranking.txt';
            // URLからのレスポンスがあるとき
            if ($content = http_get_contents($url)) {
                // ランキングデータを取得する。
                $rankingData = $this->retrieveRankingData( $content );
            }
        }*/
        // ランキングデータをViewに渡す
        $list['ranking'] = $rankingData;
        
        // 表示タイプがJSONのとき
        if ($this->showType == 'json') {
            
            /*
             *   JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
            return response()->json( $rankingData, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
        
        // ビューのスタイル
        $viewStyle = $this->viewStyle == '1' ? '1' : '';
        
        return view( $this->templateDir . '.ranking' . $viewStyle, $list)
            ->with( 'hanshaCode', $this->hanshaCode)
            ->with( 'templateDir', $this->templateDir );
    }
    
    /**
     * ランキングデータの取り込み
     * 
     * @param string $content
     * @return array
     */
    private function retrieveRankingData( $content ) {
        $match = null;
        if (!preg_match_all( '/([0-9a-z]+?)\|([0-9]+?)\:([0-9]+?)/', $content, $match)) {
            return [];
        }
        
        $rankingData = [];

        // 表示最大数の指定
        if( $this->showLimitNum !== "" ){
            $maxRankingNum = $this->showLimitNum;
        }else{
            $maxRankingNum = self::MAX_RANKING_SHOP;
        }

        // ランキングデータを生成するループ
        foreach ( $match[1] as $i => $shopCode ) {
            if ( $i >= $maxRankingNum ) {
                break;
            }
            
            // スタッフ番号
            $staffCode = $match[2][$i];
            // 件数
            $count = $match[3][$i];
            
            // 0を数えない
            if ($count == 0) {
                continue;
            }
            
            // 拠点データ
            $shopData = $this->shopData( $shopCode );
            // 拠点データが存在しない場合
            if (empty($shopData)) {
                continue;
            }
            
            // 一覧表示
            $query1 = DB::table( $this->tableName );

            ###############################
            ## 検索処理
            ###############################

            // 拠点コード
            $query1 = $query1->where( 'shop', $shopCode);
            
            // 表示順の条件
            $query1 = $this->buildOrderBy( $query1 );

            $blog = $query1->where( 'published', 'ON' )
                    // 親
                    ->where( 'treepath', "data{$staffCode}" )
                    ->first();
            
            ###############################
            ## スタッフ情報
            ###############################
            
            $staffInfo = DB::table( $this->tableName )
                    ->selectRaw('name, position, photo')
                    // スタッフ番号
                    ->where('number', "data{$staffCode}")
                    // 親
                    ->whereNull( 'treepath' )
                    // 拠点コード
                    ->where('shop', $shopCode)
                    // 表示
                    ->where( 'disp', 'ON' )
                    ->first();
                    
            // スタッフが存在しない場合
            if (empty($staffInfo)) {
                continue;
            }
        
            $rankingData[$i] = [
                'shop_code' => $shopCode,
                'shop_name' => $shopData->base_name,
                'staff_code' => $staffCode,
                'staff_name' => $staffInfo->name,
                'staff_position' => $staffInfo->position,
                'staff_photo' => $staffInfo->photo,
                'ranking' => $i + 1,
                'count' => $count,
                'blog' => $blog,
            ];
        }
        
        return $rankingData;
    }
    
    /**
     * 拠点データを取得する関数
     * 
     * @param string $shopCode
     * @return object
     */
    private function shopData( $shopCode ) {
        // 拠点データ
        $query1 = DB::table( 'base' )->select( 'base_name' )
            ->where( 'hansha_code', $this->hanshaCode)
            ->where( 'base_code', $shopCode);

        $shopData = $query1->where( 'deleted_at', null)
                        ->where( 'base_published_flg', '<>', 2 ) // 非公開の拠点は除く
                        ->orderBy( 'base_code','asc' )->first();
        return $shopData;
    }
    
    /**
     * 時間を計算する関数
     * 
     * @param string $number
     * @return int
     */
    private function calculateTime( $number )
    {
        if ($number > 0) {
            $number = '+' . $number;
        }
        return strtotime($number . ' day', time());
    }
    
    /**
     * 最新ブログかを判定する関数
     * 
     * @param string $time
     */
    private function isNewBlog( $time="" ) {
        // 時間が空でないとき
        if( !empty( $time ) == True ){
            // 1週間前の日付を取得する
            $tagetDay = date( "Y-m-d", strtotime( "-7 day" ) );
            // 時間の値を加工
            $day = date( 'Y-m-d', strtotime( $time ) );

            // 記事の日付が、1週間前より新しいときは、true
            return strtotime( $day ) > strtotime( $tagetDay );
        }else{
            return false;
        }
    }
    
    private function checkImageUrl( $url ) {
        $pattern = '/((?:https?|\/\/).+?\.(?:[jJ][pP][eE][gG]|[jJ][pP][gG]|[pP][nN][gG]|[gG][iI][fF]|[bB][mM][pP])).*/';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        return false;
    }
    
    private function renderProfileAsViewData($list) {
        // プロフィールのデータ
        $data = app('stdClass');
        $data->id = $list['staff']->id;
        $data->staff_code = substr($list['staff']->number, 4);
        $data->name = $list['staff']->name;
        $data->name_furi = $list['staff']->name_furi;
        $data->position = $list['staff']->position;
        $data->qualification = $list['staff']->qualification;
        //$data->degree = $list['staff']->degree;
        //$data->phone_number = $list['staff']->phone_number;
        //$data->birtday = $list['staff']->birtday;
        $data->hobby = $list['staff']->hobby;
        $data->photo = $list['staff']->photo;
        $data->caption = $list['staff']->caption;
        $data->message = $list['staff']->msg;
        $data->shop_code = $list['staff']->shop;
        $data->shop_name = $list['shopName'];

        // エキストラ値
        $extNum = 5;
        $data->extra = [];
        for ($i = 1; $i <= $extNum; $i++) {
            $keyName = "ext_field{$i}";
            $valName = "ext_value{$i}";
            
            if (!isset($list['staff']->{$valName}) ||
                empty($list['staff']->{$valName})) {
                continue;
            }
            $data->extra[$list['staff']->{$keyName}] = $list['staff']->{$valName};
        }
        
        return $data;
    }
    
    /**
     * ブログデータをJSONにレンダリングする
     * 
     * @param array $list ブログデータ
     * @param bool $useSequentialKey 自動的なキーを使うフラグ
     * @return string
     */
    private function renderAsViewData($list, $useSequentialKey = true) {
        if ($useSequentialKey) {
            $shop_code = "";
        } else {
            $shop_code = 0;
        }
        $blogData = [];

        if( !empty( $list['blogs'] ) == True ){    
            foreach( $list['blogs'] as $value ){

                // 記事番号
                $blogData[$shop_code]['number'] = str_replace('data', '', $value->number);
                // 拠点コード
                $blogData[$shop_code]['shop'] = $value->staff_shop_code;
                // 拠点コードを格納
                if ($useSequentialKey) {
                    $shop_code = $value->shop;                    
                    // 拠点データ
                    $shopData = $this->shopData( $shop_code );
                    // 拠点名
                    $blogData[$shop_code]['shop_name'] = $shopData->base_name ?? null;
                } else {
                    // 拠点名
                    $blogData[$shop_code]['shop_name'] = $value->base_name ?? null;
                }
                // スタッフ名
                $blogData[$shop_code]['name'] = $value->name ?? null;
                // 日付
                $blogData[$shop_code]['time'] = date( 'Y.m.d', strtotime( $value->updated_at ) );
                // 新着フラグ
                $blogData[$shop_code]['new_fig'] = $this->isNewBlog( $value->updated_at );
                // 公開日時が指定されているとき
                if( !empty( $value->from_date ) ) {
                    $blogData[$shop_code]['time'] = date( 'Y.m.d', strtotime( $value->from_date ) );
                    $blogData[$shop_code]['new_fig'] = $this->isNewBlog( $value->from_date );
                }

                /**
                 * サムネイル画像
                 */
                $contentStr = $value->comment;

                // 定形画像 3枚アップロードする画像があるとき
                $blogData[$shop_code]['image'] = asset_auto('img/no_image.gif');
                // 3枚アップロードするがぞうがあるとき
                $hasImage = false;
                if( !empty( $value->file ) == True && $image = $this->checkImageUrl($value->file)){
                    $blogData[$shop_code]['image'] = $image;
                    $hasImage = true;
                }else if( !empty( $value->file2 ) == True && $image = $this->checkImageUrl($value->file2)){
                    $blogData[$shop_code]['image'] = $image;
                    $hasImage = true;
                }else if( !empty( $value->file3 ) == True && $image = $this->checkImageUrl($value->file3)){
                    $blogData[$shop_code]['image'] = $image;
                    $hasImage = true;
                }

                // 3枚画像が無いときは、本文の画像を参照
                if(!$hasImage && $image = $this->checkImageUrl($contentStr)) {
                    $blogData[$shop_code]['image'] = $image;
                }

                // タイトル
                $blogData[$shop_code]['title'] = !empty($value->title) &&
                        $value->title !== null ? $value->title : 'No Title';

                /**
                 * 本文の表示
                 */
                $content = $value->comment;
                if ($this->contentLength !== '') {
                    // コンテンツの概要
                    $content = '無し';
                    $contentStr = strip_tags($contentStr);
                    // 本文から指定文字列分のみ抜き出す
                    $str_length = mb_strlen($contentStr);
                    $contentStr = mb_substr($contentStr, 0, $this->contentLength, 'utf-8');
                    if ($str_length > 0) {
                        $content = trim($contentStr) . "...";
                    }
                }

                // 本文
                $blogData[$shop_code]['content'] = $content;
                
                if (!$useSequentialKey) {
                    $shop_code++;
                }
            }
        }
        
        return $blogData;
    }
    
}