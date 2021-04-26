<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Commands\Ranking\StaffCountReaderCommand;
use App\Original\Util\SessionUtil;
use App\Original\Util\RankingUtil;
use App\Lib\Util\DateUtil;
use App\Http\Controllers\tCommon;
use App\Original\Codes\StaffDepartmentCodes;
use App\Models\Base;
use App\Models\SrInfo;
use App\Models\Staffbbs;
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
trait StaffbbsRepository
{
    use tCommon;
    
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
     * スタッフ紹介集合写真
     */
    public function getShopInfo() {
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" && $this->shopCode === "" ){
            return;
        }
        
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        $shopInfo = $srInfoObj->where( 'shop', '=', $this->shopCode )
                ->where('deleted_at', null )
                ->first();
        
        // 値が無いときはエラーを出力
        if( $shopInfo === null ){
            return;
        }
        
        return view( $this->templateDir . '.shop-info', compact('shopInfo') )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'templateDir', $this->templateDir );
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
                    ->orderBy( 'base_code', 'asc' )
                    ->first();

        $shopName = $shopData->base_name ?? '';

        // 一覧表示
        $query = DB::table( $this->tableName )
                ->where( 'deleted_at', null );
        
        // 拠点コード
        if (!empty($this->shopCode)) {
            $query = $query->where( 'shop', '=', $this->shopCode );
        }
        
        // 職種
        if (isset($this->department) && !empty($this->department)) {
            $departments = explode('|', $this->department);
            $query = $query->whereIn( 'department', $departments );
        }
        
        $query = $query
            // 親がないレコード
            ->whereNull('treepath');
        // 表示
        if ($this->hasPublishingConfig) {
            if ($this->hanshaCode != '5551803' &&
                    $this->hanshaCode != '1103901') {
                $query = $query->whereRaw("(disp = 'ON' OR disp = 'disp' OR published = 'ON')");
            }
        }
        // 並び順
        if ($this->hasPublishingConfig) {
            if ($this->hanshaCode == '1581055' ||
                    $this->hanshaCode == '8812701') {
                $query = $query->orderByRaw('listing_order::int');
            } else if ($this->hanshaCode == '5551803') {
                $query = $query->orderBy('regist', 'asc');
            } else {
                $query = $query->orderBy('department', 'asc')
                    ->orderByRaw('grade::int asc');
            }
        } else {
            $query = $query->orderBy('number', 'asc');
        }
        
        $staffData = $query->get();
        
        // 絵文字変換のカラム一覧
        $conversionCols = ['name', 'name_furi', 'comment', 'ext_field1', 'ext_value1',
            'ext_field2', 'ext_value2', 'ext_field3', 'ext_value3', 
            'ext_value3_2', 'ext_value3_3', 'ext_value3_4', 'ext_value3_5', 'ext_value3_6',
            'ext_value4', 'ext_value4_2', 'ext_value4_3', 'ext_value4_4', 'ext_value4_5', 'ext_value4_6',
            'ext_field5', 'ext_value5', 'ext_value6'];
        
        // 拠点の絞り込み
        $normalizedData = [];
        foreach ($staffData as $key => $data) {
            // リスト用画像
            if (preg_match('/thumb\/thu_/', $data->photo)) {
                $data->photo = str_replace('thumb/thu_', '', $data->photo);
                $data->photo_thumb = $data->photo;
            } else {
                $data->photo = $data->photo;
                $data->photo_thumb = $data->photo;
            }
            // 個人ページ用画像
            if (preg_match('/thumb\/thu_/', $data->photo2)) {
                $data->photo2 = str_replace('thumb/thu_', '', $data->photo2);
                $data->photo2_thumb = $data->photo2;
            } else {
                $data->photo2 = $data->photo2;
                $data->photo2_thumb = $data->photo2;
            }
            // ブログの更新日時
            $infobbsInstance = Staffbbs::createNewInstance($this->hanshaCode);
            $infobbsInstance = $infobbsInstance->selectRaw('updated_at')
                    ->where('treepath', $data->number)
                    ->where('published', 'ON')
                    ->orderBy('updated_at', 'desc')
                    ->first();
            if ($infobbsInstance !== null) {
                $data->blog_updated_at = $infobbsInstance->updated_at;
            }
            
            // 絵文字変換
            foreach ($data as $dataKey => $dataValue) {
                if (empty($dataValue) || !in_array($dataKey, $conversionCols)) {
                    continue;
                }
                $data->{$dataKey} = $this->convertEmoji($dataValue);
            }
            
            $normalizedData[$key] = $data;
        }
        $list['staffs'] = $normalizedData;
        
        // 項目を絞り込んだデータ
        $list['filteredStaffData'] = [];
        if ($this->hasPublishingConfig) {
            foreach ($staffData as $item) {
                $list['filteredStaffData'][] = $this->renderProfileAsViewData(['staff' => $item]);
            }
        }
        
        // 役職コード
        $code = new StaffDepartmentCodes($this->staffPopulationStyle);
        $departmentCodes = $code->getOptions();
        
        // 表示タイプがJSONのとき
        if ($this->showType == 'json') {
            
            // リスト
            if ($this->hasPublishingConfig) {
                $data = [];
                foreach ($staffData as $item) {
                    $data[] = [
                        'number'    => $item->number,
                        'name'      => $item->name,
                        'name_furi' => $item->name_furi,
                        'msg'       => $item->msg,
                    ];
                }
            } else {
                $data = $list['filteredStaffData'];
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
            ->with( 'departmentCodes', $departmentCodes )
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
            ->whereRaw("(disp = 'ON' OR disp = 'disp' OR published = 'ON')")
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
        
        /**
         * スタッフ削除確認
         */
        // 拠点の絞り込み
        $isActiveStaff = DB::table( $this->tableName )->whereNull('treepath') // 親がないレコード
            // 削除されていない
            ->whereNull('deleted_at')
            // 公開
            ->whereRaw("(disp = 'ON' OR disp = 'disp' OR published = 'ON')")
            // 番号
            ->where( 'number', '=', 'data' . $this->staffCode )
            ->first();
        if (empty($isActiveStaff)) {
            return $this->viewStyle == '' ? '' : response()->json([]);
        }
        
        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();

        //->where( 'shop', '=', $this->shopCode)
        $blogs = $query->where( 'info.published', 'ON' )
                // 表示するカラム
                ->selectRaw('info.*, staff.name, staff.shop AS staff_shop_code, b.base_name')
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
        
        // 店舗コード
        if ($this->shopCode == '' && count($blogs) > 0) {
            $this->shopCode = $blogs[0]->staff_shop_code;
        }
        
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
            
            $list = compact(
                'blogs',
                'items'
            );
            $list['convertEmojiToHtmlEntity'] = Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']);
        
            return view( $this->templateDir . '.blog' . $this->viewStyle, $list)
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
                    ->selectRaw('name, position, photo, photo2')
                    // スタッフ番号
                    ->where('number', "data{$staffCode}")
                    // 親
                    ->whereNull( 'treepath' )
                    // 拠点コード
                    ->where('shop', $shopCode)
                    // 表示
                    ->whereRaw( "(disp = 'ON' OR disp = 'disp')" )
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
                'staff_photo' => str_replace('thumb/thu_', '', $staffInfo->photo),
                'staff_photo_thumb' => $staffInfo->photo,
                'staff_photo2' => str_replace('thumb/thu_', '', $staffInfo->photo2),
                'staff_photo2_thumb' => $staffInfo->photo2,
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
    
    private function checkImageUrl( $url, $isText = false ) {
        if (!$isText) {
            $pattern = '/([^\"\']+?(?:[jJ][pP][eE][gG]|'
                    . '[jJ][pP][gG]|'
                    . '[pP][nN][gG]|'
                    . '[gG][iI][fF]|'
                    . '[bB][mM][pP])).*?[\"\']/';
        } else {
            $pattern = '/<img.*?src=[\"\']([^\"\']+?(?:[jJ][pP][eE][gG]|'
                . '[jJ][pP][gG]|'
                . '[pP][nN][gG]|'
                . '[gG][iI][fF]|'
                . '[bB][mM][pP])).*?[\"\']/';
        }
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        return false;
    }
    
    private function renderProfileAsViewData($list) {
        // プロフィールのデータ
        $data = app('stdClass');
        $data->id = $list['staff']->id ?? null;
        $data->staff_code = substr($list['staff']->number, 4);
        $data->name = $list['staff']->name;
        $data->name_furi = $list['staff']->name_furi;
        $data->position = $list['staff']->position;
        $data->created_at = $list['staff']->created_at;
        $data->updated_at = $list['staff']->updated_at;
        // ブログの更新日時
        if (isset($list['staff']->blog_updated_at)) {
            $data->blog_updated_at = $list['staff']->blog_updated_at;
        }
        
        if ($this->hanshaCode == '8812701') {
            // 資格
            if (isset($list['staff']->qualification)) {
                $data->qualification = $list['staff']->qualification;
            }
            // 趣味
            if (isset($list['staff']->hobby)) {
                $data->hobby = $list['staff']->hobby;
            }
            
            // エクストラ
            $keys = ['ext_field1', 'ext_field2', 'ext_field3', 'ext_field4', 'ext_field5'];
            $values = ['ext_value1', 'ext_value2', 'ext_value3', 'ext_value4', 'ext_value5'];
            $extra = [];
            foreach ($keys as $key => $keyName) {
                if (empty($list['staff']->{$keyName})) {
                    continue;
                }
                $valueName = $values[$key];
                $keyName = $list['staff']->{$keyName};
                if ($keyName == '国家資格') {
                    $extra[$keyName][] = $list['staff']->{$valueName};
                } else {
                    $extra[$keyName] = $list['staff']->{$valueName};
                }
            }
            $data->extra = $extra;
            // コメント
            $data->message = $list['staff']->msg;
        } else if ($this->hasPublishingConfig) {
            $data->qualification = $list['staff']->qualification;
            //$data->degree = $list['staff']->degree;
            //$data->phone_number = $list['staff']->phone_number;
            //$data->birtday = $list['staff']->birtday;
            $data->hobby = $list['staff']->hobby;
            $data->message = $list['staff']->msg;
        } else {
            // 資格
            $cert_keys = ['ext_value3', 'ext_value3_2', 'ext_value3_3', 'ext_value3_4',
                'ext_value3_5', 'ext_value3_6'];
            $certs = [];
            foreach ($cert_keys as $key) {
                if (empty($list['staff']->{$key})) {
                    continue;
                }
                $certs[] = $list['staff']->{$key};
            }
            $data->qualification = $certs;
            
            // 趣味
            $hobby_keys = ['ext_value4', 'ext_value4_2', 'ext_value4_4', 'ext_value4_4',
                'ext_value4_5', 'ext_value4_6'];
            $hobbies = [];
            foreach ($hobby_keys as $key) {
                if (empty($list['staff']->{$key})) {
                    continue;
                }
                $hobbies[] = $list['staff']->{$key};
            }
            $data->hobby = $hobbies;
            // コメント
            $data->message = $list['staff']->comment;
            // 所属・役職
            $data->department = $list['staff']->department;
        }
        
        // リスト用画像
        if (preg_match('/thumb\/thu_/', $list['staff']->photo)) {
            $data->photo = str_replace('thumb/thu_', '', $list['staff']->photo);
            $data->photo_thumb = $list['staff']->photo;
        } else {
            $data->photo = $list['staff']->photo;
            $data->photo_thumb = $list['staff']->photo;
        }
        // 個人ページ用画像
        if (preg_match('/thumb\/thu_/', $list['staff']->photo2)) {
            $data->photo2 = str_replace('thumb/thu_', '', $list['staff']->photo2);
            $data->photo2_thumb = $list['staff']->photo2;
        } else {
            $data->photo2 = $list['staff']->photo2;
            $data->photo2_thumb = $list['staff']->photo2;
        }
        // ローカル画像に対応
        if (preg_match('/^data\/image\/' . $this->hanshaCode . '/', $data->photo)) {
            $data->photo = asset_auto( $data->photo );
        } else if (empty($data->photo)) {
            $imageUrl = asset_auto('img/sozai/no_photo.jpg');
        }
        if (preg_match('/^data\/image\/' . $this->hanshaCode . '/', $data->photo2)) {
            $data->photo2 = asset_auto( $data->photo2 );
        } else if (empty($data->photo2)) {
            $imageUrl = asset_auto('img/sozai/no_photo.jpg');
        }
        
        $data->caption = $list['staff']->caption;
        $data->shop_code = $list['staff']->shop;
        $data->shop_name = $list['shopName'] ?? null;

        // エキストラ値
        if ($this->hanshaCode != '8812701') {
            $data->extra = [];
            if ($this->hasPublishingConfig) {
                $extNum = 5;
                for ($i = 1; $i <= $extNum; $i++) {
                    $keyName = "ext_field{$i}";
                    $valName = "ext_value{$i}";

                    if (!isset($list['staff']->{$valName}) ||
                        empty($list['staff']->{$valName})) {
                        continue;
                    }
                    $data->extra[$list['staff']->{$keyName}] = $list['staff']->{$valName};
                }
            } else {
                // エクストラ
                $data->extra = [
                    'bloodType' => $list['staff']->ext_value1,  // 血液型
                    'hometown' => $list['staff']->ext_value2,   // 出身地
                ];
            }
        }
        
        foreach ($data as $key => $value) {
            // 絵文字の変換
            if (is_array($value)) {
                $data->{$key} = [];
                foreach ($value as $subKey => $subValue) {
                    $subKey = $this->convertEmojiToHtmlEntity($subKey);
                    $data->{$key}[$subKey] = $this->convertEmojiToHtmlEntity($subValue);
                }
                continue;
            }
            $key = $this->convertEmojiToHtmlEntity($key);
            $data->{$key} = $this->convertEmojiToHtmlEntity($value);
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
                // スタッフコード
                $blogData[$shop_code]['staff_code'] = $value->staff_code ?? null;
                $blogData[$shop_code]['staff_code'] = str_replace('data', '', $blogData[$shop_code]['staff_code']);
                // 日付
                $blogData[$shop_code]['time'] = date( $this->timeFormat, strtotime( $value->updated_at ) );
                // 新着フラグ
                $blogData[$shop_code]['new_fig'] = $this->isNewBlog( $value->updated_at );
                // 公開日時が指定されているとき
                if( !empty( $value->from_date ) ) {
                    $blogData[$shop_code]['time'] = date( $this->timeFormat, strtotime( $value->from_date ) );
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
                if(!$hasImage && $image = $this->checkImageUrl($contentStr, true)) {
                    $blogData[$shop_code]['image'] = $image;
                }

                // タイトル
                $blogData[$shop_code]['title'] = !empty($value->title) &&
                        $value->title !== null ? $value->title : 'No Title';
                $blogData[$shop_code]['title'] = $this->convertEmojiToHtmlEntity($blogData[$shop_code]['title']);

                /**
                 * 本文の表示
                 */
                $content = $value->comment;
                if ($this->contentLength !== '') {
                    // コンテンツの概要
                    $content = '無し';
                    $contentStr = strip_tags($contentStr);
                    $contentStr = str_replace('&nbsp;', '', $contentStr);
                    $contentStr = str_replace("\r\n", '', $contentStr);
                    $contentStr = str_replace("\n", '', $contentStr);
                    $content = $contentStr;
                    // 本文から指定文字列分のみ抜き出す
                    $str_length = mb_strlen($content);
                    if ($str_length > $this->contentLength) {
                        $content = mb_substr($content, 0, $this->contentLength, 'utf-8');
                        $content = trim($content) . "...";
                    }
                }

                // 本文
                $blogData[$shop_code]['content'] = $this->convertEmojiToHtmlEntity($content);
                
                if (!$useSequentialKey) {
                    $shop_code++;
                }
            }
        }
        
        return $blogData;
    }
    
}