<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use App\Original\Util\CodeUtil;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Api\Common\Traits\Infobbs\RecordModifier;
use App\Commands\Ranking\BaseCountReaderCommand;
use App\Original\Util\SessionUtil;
use App\Original\Util\RankingUtil;
use App\Lib\Util\DateUtil;
use App\Http\Controllers\tCommon;
use App\Models\Infobbs;
use App\Models\Base;
use Illuminate\Support\Facades\Storage;
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
trait InfobbsRepository
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use tCommon;
    use RecordModifier;

    /**
     * 共通出力フォーマット
     *
     * @var array
     */
    private $jsonExtractHanshaCodes = [
        '3301076'/*北大阪*/, '7556029'/*十和田*/,
    ];

    /**
     * 表示順の条件
     *
     * @param object $query
     * @return object
     */
    private function buildOrderBy($query, $prefix = '', $dir = 'desc')
    {
        // 公開日時があれば公開日時を、無ければ、更新日時のソート順にする
        if ($prefix !== '') {
            $prefix .= '.';
        }

        // 高崎東のみ
        if ($this->hanshaCode == '1652022') {
            $this->order = 'regist';
        }

        if ($this->order == 'regist') {
            return $query->orderByRaw("{$prefix}{$this->order} desc")
                ->orderBy($prefix . 'to_date', $dir)
                ->orderBy($prefix . 'title', 'DESC');
        } else if ($this->order == 'updated_at' && isset($_GET['order'])) {
            return $query->orderByRaw("{$prefix}{$this->order} desc")
                ->orderBy($prefix . 'from_date', 'DESC')
                ->orderBy($prefix . 'to_date', $dir)
                ->orderBy($prefix . 'regist', 'DESC')
                ->orderBy($prefix . 'title', 'DESC');
        } else {
            return $query->orderByRaw("CASE WHEN {$prefix}from_date IS NULL "
                . "THEN {$prefix}{$this->order} ELSE {$prefix}from_date END DESC")
                ->orderBy($prefix . 'to_date', $dir)
                ->orderBy($prefix . 'regist', 'DESC')
                ->orderBy($prefix . 'title', 'DESC');
        }
    }

    /**
     * 最新ブログ1件のみを出力する
     *
     */
    public function getFirst()
    {
        // 値が無いときはエラーを出力
        if ($this->hanshaCode === "" && $this->shopCode === "") {
            return "<p>表示エラー</p>";
        }

        // 拠点
        $shopData = DB::table('base')
            ->select('base_name')
            ->where('hansha_code', $this->hanshaCode)
            ->where('base_code', $this->shopCode)
            ->where('deleted_at', null)
            ->where('base_published_flg', '<>', 2) // 非公開の拠点は除く
            ->whereRaw("(show_flg = '1' OR show_flg IS NULL)") // 表示機能
            ->orderBy('base_code', 'asc')
            ->first();

        // 拠点データが無いときエラー
        if (empty($shopData)) {
            return "<p>エラー： 拠点が登録されていません</p>";
        }

        $shopName = $shopData->base_name;

        // 一覧表示
        $query = $this->getResultSet();

        // 表示順の条件
        $query = $this->buildOrderBy($query);

        // 拠点の絞り込み
        $list['blog'] = $query->where('shop', '=', $this->shopCode)
            // ステータスが公開の時
            ->where('published', 'ON')
            // 削除日時がNULLのとき
            ->whereNull('deleted_at')
            // 公開期間内のとき
            ->whereRaw(' ( ( from_date <= now() AND to_date >= now()) OR '
                . ' ( from_date <= now() AND to_date IS NULL) OR '
                . ' ( from_date IS NULL AND to_date >= now()) OR '
                . ' ( from_date IS NULL AND to_date IS NULL))')
            ->first();

        // レコードのデータの変更
        $this->modifyResultRecord($list['blog'], false);

        return view($this->templateDir . '.first', $list)
            ->with('hanshaCode', $this->hanshaCode)
            ->with('shopName', $shopName)
            ->with('templateDir', $this->templateDir);
    }

    /**
     * 緊急掲示板の店舗コード
     *
     * @return string|null
     */
    private function getEmergencyBulletinShopId()
    {
        return config("{$this->hanshaCode}.general.emergency_bulletin_board_id");
    }

    /**
     * 緊急掲示板の除外
     *
     * @param object $query レコードのデータ
     * @return object
     */
    private function excludeEmergencyBulletinShop($query, $alias = null)
    {
        // 緊急掲示板の除外
        $emergencyBulletinShopCode = $this->getEmergencyBulletinShopId();
        if ($emergencyBulletinShopCode !== null) {
            if ($alias !== null) {
                $alias .= '.';
            }
            $query = $query->where($alias . 'shop', '<>', $emergencyBulletinShopCode);
        }

        return $query;
    }

    /**
     * 共通データ
     */
    private function getResultSet($alias = null)
    {
        $aliasText = '';
        if ($alias !== null) {
            $aliasText = ' AS ' . $alias;
        }
        $query = DB::table($this->tableName . $aliasText);

        // 緊急掲示板の除外
        $query = $this->excludeEmergencyBulletinShop($query, $alias);

        return $query;
    }

    /**
     * 一般なブログの画面
     * ブログ一覧画面
     */
    public function getBlog()
    {

        $req = Request::all();

        // 値が無いときはエラーを出力
        if ($this->hanshaCode === "") {
            return "<p>表示エラー</p>";
        }

        // 表示最大数の指定
        if ($this->pageNum !== "") {
            $perPage = (int)$this->pageNum;
        } else {
            // 1ページの表示件数
            $perPage = \config('original.para')[$this->hanshaCode]['page_num'] ?? (int)$this->pageNum;
        }

        // 一覧表示
        $query = $this->getResultSet('info');

        ###############################
        ## 検索処理
        ###############################

        // 拠点コード
        if ($this->shopCode !== "") {
            $query = $query->where('info.shop', $this->shopCode);
        }
        // カテゴリー
        if (isset($req['category']) && $req['category'] !== "") {
            /// カテゴリーを検索するSQL
            $category = mb_convert_encoding($req['category'], 'UTF-8', 'Shift-JIS');
            $query = $query->whereRaw(DB::Raw(" ARRAY['{$category}'] <@ regexp_split_to_array( info.category, ',' ) "));
        }
        // 絞込種類
        if (isset($this->filterType) && $this->filterType === 'has_image') {
            $query = $query->whereRaw("(info.file1 IS NOT NULL OR info.file2 IS NOT NULL "
                . "OR info.file3 IS NOT NULL OR info.file4 IS NOT NULL "
                . "OR info.file5 IS NOT NULL OR info.file6 IS NOT NULL "
                . "OR info.comment LIKE '%<img%')");
        }

        // ナンバーの検索
        if (isset($req['num']) && $req['num'] !== "") {
            $query = $query->where('number', 'data' . $req['num']);
        }

        // 表示順の条件
        $query = $this->buildOrderBy($query, 'info');

        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();

        //->where( 'shop', '=', $this->shopCode)
        $blogs = $query->where('info.published', 'ON')
            // 表示するカラム
            ->selectRaw('info.*, b.base_name')
            // 削除日時がNULLのとき
            ->whereNull('info.deleted_at')
            // 公開期間内のとき
            ->whereRaw('((info.from_date <= now() AND info.to_date >= now()) OR '
                . '(info.from_date <= now() AND info.to_date IS NULL) OR '
                . '(info.from_date IS NULL AND info.to_date >= now()) OR '
                . '(info.from_date IS NULL AND info.to_date IS NULL))')
            // 拠点テーブルとのJOIN
            ->join($baseTableName . ' AS b', function ($join) {
                $join->on('b.base_code', 'info.shop'); // 拠点コード
                $join->whereRaw("(b.show_flg = '1' OR b.show_flg IS NULL)"); // 表示機能
                $join->on('b.hansha_code', DB::raw("'{$this->hanshaCode}'")); // 販社コード
            })
            // 削除フラグ
            ->whereNull('b.deleted_at')
            // 非公開の拠点は除く
            ->where('b.base_published_flg', '<>', 2);
        // 閉店した店舗
        $shopExclusion = [];
        if (config()->has("{$this->hanshaCode}.custom.closedShopIds")) {
            $exclusionCfg = config("{$this->hanshaCode}.custom.closedShopIds");
            if (is_array($exclusionCfg)) {
                $shopExclusion = $exclusionCfg;
            }
        }
        // 拠点の除外
        if ($this->shopExclusionType == self::SHOP_EXCLUSION_FROM_URL_QUERY &&
            is_array($this->shopExclusion) &&
            count($this->shopExclusion) > 0) {
            $shopExclusion = array_merge($shopExclusion, $this->shopExclusion);
        }
        if (count($shopExclusion) > 0) {
            $blogs = $blogs->whereNotIn("info.shop", $shopExclusion);
        }

        // 複数レコードの場合
        if ($this->isMultipleRecord) {
            // ページネーション
            $blogs = $blogs
                ->paginate($perPage);
        } else { // ナンバーの指定
            $number = "data{$this->num}";
            $blog = $blogs->where('number', $number)
                ->first();

            // 値が無いときはエラーを出力
            if ($blog === null) {
                return "<p>表示エラー</p>";
            }
        }

        // ページ情報   
        if ($this->isMultipleRecord) {
            $pageInfo = [
                'total' => $blogs->total(),
                'lastPage' => $blogs->lastPage(),
                'perPage' => $blogs->perPage(),
                'currentPage' => $blogs->currentPage(),
            ];
        } else {
            $pageInfo = [
                'total' => 1,
                'lastPage' => 1,
                'perPage' => 1,
                'currentPage' => 1,
            ];
        }

        // 読者を計算
        if ( !in_array($this->shopCode, $this->shopExclusion) && ( !isset($req['page'] ) || $req['page'] == null ) ) {

            $this->dispatch(
                new BaseCountReaderCommand(
                    $this->hanshaCode,
                    $this->shopCode,
                    $pageInfo
                )
            );
        }

        // 関数をビューに渡す
        $list['isNewBlog'] = Closure::fromCallable([$this, 'isNewBlog']);
        $list['getThumbnail'] = Closure::fromCallable([$this, 'getThumbnail']);
        $list['convertEmojiToHtmlEntity'] = Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']);

        if ($this->isMultipleRecord) {
            // レコードのデータを変更
            $this->modifyResultRecord($blogs, true);
            // 複数の投稿データ
            $list['blogs'] = $blogs;
            // ビュー名
            $viewName = $this->templateDir . '.blog';
        } else {
            // レコードのデータを変更
            $this->modifyResultRecord($blog, false);
            // シングルな投稿データ
            $list['blog'] = $blog;
            $viewName = $this->templateDir . '.blogDetail';
        }

        // 設定データ
        // 販社名の設定パラメータを取得
        $list['para_list'] = config('original.para')[$this->hanshaCode] ?? [];

        // ビューデータの追加
        if (method_exists($this, 'extractViewData')) {
            $list = array_merge($list, $this->extractViewData('getBlog'));
        }
        // 表示タイプがJSONのとき
        if ($this->showType == "json") {
            return $this->renderAsJson($list, false);
        } else {
            $commentFormUrl = \App\Original\Util\CodeUtil::getV2Url('Api\CommentPostController@getIndex', $this->hanshaCode);
            $commentFormUrl .= "?hansha_code={$this->hanshaCode}&blog_data_id={ITEM_NUMBER}&style=style1";
            return view($viewName . $this->viewStyle, $list)
                ->with('hanshaCode', $this->hanshaCode)
                ->with('shopCode', $this->shopCode)
                ->with('shopExclusion', $this->shopExclusion)
                ->with('category', $this->category)
                ->with('commentFormUrl', $commentFormUrl)
                ->with('templateDir', $this->templateDir);
        }
    }

    /**
     * 添付された画像
     */
    public function getAttachedImages()
    {

        $req = Request::all();

        // 値が無いときはエラーを出力
        if ($this->hanshaCode === "") {
            return "<p>表示エラー</p>";
        }

        // 一覧表示
        $query = $this->getResultSet('info');

        ###############################
        ## 検索処理
        ###############################

        // 拠点コード
        if ($this->shopCode !== "") {
            $query = $query->where('info.shop', $this->shopCode);
        }
        // カテゴリー
        if (isset($req['category']) && $req['category'] !== "") {
            /// カテゴリーを検索するSQL
            $category = mb_convert_encoding($req['category'], 'UTF-8', 'Shift-JIS');
            $query = $query->whereRaw(DB::Raw(" ARRAY['{$category}'] <@ regexp_split_to_array( info.category, ',' ) "));
        }

        // ナンバーの検索
        if (isset($req['num']) && $req['num'] !== "") {
            $query = $query->where('number', 'data' . $req['num']);
        }

        // 表示順の条件
        $query = $this->buildOrderBy($query, 'info');

        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();

        //->where( 'shop', '=', $this->shopCode)
        $blogs = $query->where('info.published', 'ON')
            // 表示するカラム
            ->selectRaw('info.*, b.base_name')
            // 削除日時がNULLのとき
            ->whereNull('info.deleted_at')
            // 公開期間内のとき
            ->whereRaw('((info.from_date <= now() AND info.to_date >= now()) OR '
                . '(info.from_date <= now() AND info.to_date IS NULL) OR '
                . '(info.from_date IS NULL AND info.to_date >= now()) OR '
                . '(info.from_date IS NULL AND info.to_date IS NULL))')
            // 拠点テーブルとのJOIN
            ->join($baseTableName . ' AS b', function ($join) {
                $join->on('b.base_code', 'info.shop'); // 拠点コード
                $join->whereRaw("(b.show_flg = '1' OR b.show_flg IS NULL)"); // 表示機能
                $join->on('b.hansha_code', DB::raw("'{$this->hanshaCode}'")); // 販社コード
            })
            // 削除フラグ
            ->whereNull('b.deleted_at')
            // 非公開の拠点は除く
            ->where('b.base_published_flg', '<>', 2);

        $number = "data{$this->num}";
        $blog = $blogs->where('number', $number)
            ->first();

        // 値が無いときはエラーを出力
        if ($blog === null) {
            return "<p>表示エラー</p>";
        }

        // 関数をビューに渡す
        $list['isNewBlog'] = Closure::fromCallable([$this, 'isNewBlog']);
        $list['convertEmojiToHtmlEntity'] = Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']);

        // レコードのデータを変更
        $this->modifyResultRecord($blog, false);
        // シングルな投稿データ
        $list['item'] = $blog;
        // ビュー名
        $viewName = $this->templateDir . '.attachedImages';

        // 設定データ
        // 販社名の設定パラメータを取得
        $list['para_list'] = config('original.para')[$this->hanshaCode] ?? [];

        return view($viewName . $this->viewStyle, $list)
            ->with('hanshaCode', $this->hanshaCode)
            ->with('shopCode', $this->shopCode)
            ->with('shopExclusion', $this->shopExclusion)
            ->with('category', $this->category)
            ->with('templateDir', $this->templateDir);
    }

    /**
     * 最新ブログの画面
     *
     */
    public function getLatestBlog()
    {
        // 最新ブログの絞り込み
        $query = $this->getResultSet()
            // 各拠点の最新記事の絞り込み
            ->selectRaw('DISTINCT ON (shop) *');
        // 表示順の条件
        $query = $this->buildOrderBy($query->orderBy('shop'));
        // 絞り込み条件
        $query = $query->where('published', 'ON')
            ->whereRaw('deleted_at IS NULL')
            ->whereRaw('((from_date <= now() AND to_date >= now()) OR '
                . '(from_date <= now() AND to_date IS NULL) OR '
                . '(from_date IS NULL AND to_date >= now()) OR '
                . '(from_date IS NULL AND to_date IS NULL))');

        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();

        /**
         * 2段階のソート
         */
        $query2 = DB::table(DB::raw("({$query->toSql()}) AS sub"))
            ->selectRaw('main.*, b.base_name')
            /**
             * 2段階のJOIN
             */
            ->mergeBindings($query)
            ->join($this->tableName . ' AS main', 'main.id', 'sub.id')
            /**
             * 拠点テーブルとのJOIN
             */
            ->join($baseTableName . ' AS b', function ($join) {
                $join->on('b.base_code', 'main.shop'); // 拠点コード
                $join->whereRaw("(b.show_flg = '1' OR b.show_flg IS NULL)"); // 表示機能
                $join->on('b.hansha_code', DB::raw("'{$this->hanshaCode}'")); // 販社コード
            })
            // 店舗の削除フラグ
            ->whereNull('b.deleted_at')
            // 記事の削除フラグ
            ->whereNull('main.deleted_at')
            // 非公開の拠点は除く
            ->where('b.base_published_flg', '<>', 2);
        // 閉店した店舗
        $closedShopIds = [];
        if (config()->has("{$this->hanshaCode}.custom.closedShopIds")) {
            $exclusionCfg = config("{$this->hanshaCode}.custom.closedShopIds");
            if (is_array($exclusionCfg)) {
                $closedShopIds = $exclusionCfg;
            }
        }
        $query2 = $query2->whereNotIn("main.shop", $closedShopIds);

        // 表示順の条件
        $query2 = $this->buildOrderBy($query2, 'main');

        // 表示最大数の指定
        if ($this->showLimitNum !== "") {
            $query2 = $query2->limit($this->showLimitNum);
        }

        // 複数の店舗の絞込
        if ($this->shopCode !== '') {
            // 複数の店舗の絞込
            $shops = explode('|', $this->shopCode);
            $query2 = $query2->whereIn('main.shop', $shops);
        }

        // 拠点の除外
        if (is_array($this->shopExclusion) && count($this->shopExclusion) > 0) {
            $query2 = $query2->whereNotIn('main.shop', $this->shopExclusion);
        }

        $blogs = $query2->get();

        // 拠点コードによる並び順
        if (!empty($this->shopFilter)) {
            // 拠点コードごとに配列にいれる
            $temp = [];
            foreach ($blogs as $value) {
                // 拠点コードを格納
                $shopCode = $value->shop;
                $temp[$shopCode] = $value;
            }
            // 拠点コードをフィルター
            $list['blogs'] = [];
            foreach ($this->shopFilter as $shopCode) {
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
        if ($this->showType == "json") {
            return $this->renderAsJson($list);
        } else {
            // 特別なビューデータ
            if (in_array($this->hanshaCode, $this->jsonExtractHanshaCodes)) {
                $list['blogs'] = $this->renderAsJson($list, true, true);
            }

            // 絵文字変換
            $list['convertEmojiToHtmlEntity'] = Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']);

            return view($this->templateDir . '.latestBlog' . $this->viewStyle, $list)
                ->with('hanshaCode', $this->hanshaCode)
                ->with('templateDir', $this->templateDir);
        }
    }

    /**
     * ランキング画面
     *
     */
    public function getRanking()
    {
        // 販社コードが存在しないときエラー
        if ($this->hanshaCode === "") {
            return "<p>表示エラー</p>";
        }

        // 画面表示用配列の初期化
        $list = [];
        $rankingData = [];

        // 先週のログファイルを読み込む
        $path = storage_path('ranking') . '/' . $this->hanshaCode . '/infobbs/';
        $dir = realpath($path) . DIRECTORY_SEPARATOR;
        $summaryFileName = 'blog_ranking.txt';
        $path = $dir . $summaryFileName;
        //  ログファイルのパスが存在するとき
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $rankingData = $this->retrieveRankingData($content);
        }
        // ログファイルのランキングデータが空の時
        if (count($rankingData) == 0) {
            // 旧ブログシステムのランキング取得URL
            $url = 'http://cgi2-aws.hondanet.co.jp/cgi/' . $this->hanshaCode . '/blog_ranking.txt';
            // URLからのレスポンスがあるとき
            if ($content = http_get_contents($url)) {
                // ランキングデータを取得する。
                $rankingData = $this->retrieveRankingData($content);
            }
        }

        // 閉店した店舗
        $shopExclusions = [];
        if (config()->has("{$this->hanshaCode}.custom.closedShopIds")) {
            $exclusionCfg = config("{$this->hanshaCode}.custom.closedShopIds");
            if (is_array($exclusionCfg)) {
                $shopExclusions = $exclusionCfg;
            }
        }
        // 緊急掲示板の除外
        if (($exclusionId = $this->getEmergencyBulletinShopId()) !== null) {
            $shopExclusions[] = $exclusionId;
        }

        // 緊急掲示板の除外
        $temp = [];
        foreach ($rankingData as $item) {
            $temp[] = $item;
        }
        $rankingData = [];
        foreach ($temp as $item) {
            if (in_array($item['shop_code'], $shopExclusions)) {
                continue;
            }
            $rankingData[] = $item;
        }

        if ($this->showType == "json") {
            $jsonData = [];
            $ii = 0;
            foreach ($rankingData as $i => $value) {
                if ($value['blog'] === null) {
                    continue;
                }

                $key = $ii;
                $options['key'] = (int)$key;
                $data = $this->renderBlogJsonDataReturn($value['blog'], $options);
                // 拠点データ
                $shopData = $this->shopData($value['blog']->shop);
                // 拠点名
                $data[$key]['shop_name'] = $shopData->base_name;
                // 拠点名
                $data[$key]['count'] = $value['count'] ?? 0;
                // 配列をマージする
                $jsonData = array_merge($jsonData, $data);
                $ii++;
            }
            /*
             *   JSONでデータを出力する
             * json_encodeで値をJSON形式に変換して出力する
             * JSON_PRETTY_PRINT JSON出力データを見やすくする
             * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
             * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
             */
            return response()->json($jsonData, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            // ランキングデータをViewに渡す
            $list['ranking'] = $rankingData;
            $list['convertEmojiToHtmlEntity'] = Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']);

            return view($this->templateDir . '.ranking', $list)
                ->with('hanshaCode', $this->hanshaCode)
                ->with('templateDir', $this->templateDir);
        }
    }

    /**
     * ランキングデータの取り込み
     *
     * @param string $content
     * @return array
     */
    private function retrieveRankingData($content)
    {
        $match = null;
        if (!preg_match_all('/([0-9a-z]+?)\:([0-9]+)/', $content, $match)) {
            return [];
        }

        $rankingData = [];

        // 表示最大数の指定
        if ($this->showLimitNum !== "") {
            $maxRankingNum = $this->showLimitNum;
        } else {
            $maxRankingNum = self::MAX_RANKING_SHOP;
        }

        // 拠点の除外の絞り込み
        $shopList = [];
        foreach ($match[1] as $i => $shopCode) {
            if (in_array($shopCode, $this->shopExclusion)) {
                continue;
            }
            $shopList[] = [
                'shopCode' => $shopCode, // 拠点コード
                'count' => $match[2][$i] // 件数
            ];
        }

        // ランキングデータを生成するループ
        foreach ($shopList as $i => $rankingInfo) {
            if ($i >= $maxRankingNum) {
                break;
            }

            $shopCode = $rankingInfo['shopCode']; // 販社コード
            $count = $rankingInfo['count']; // 件数

            // 0を数えない
            if ($count == 0) {
                continue;
            }

            // 拠点データ
            $shopData = $this->shopData($shopCode);

            // 拠点が存在しない場合
            if ($shopData === null) {
                continue;
            }

            // 一覧表示
            $query2 = Infobbs::createNewInstance($this->hanshaCode);

            ###############################
            ## 検索処理
            ###############################

            // 拠点コード
            if ($shopCode !== "") {
                $query2 = $query2->where('shop', $shopCode);
            }

            // 表示順の条件
            $query2 = $this->buildOrderBy($query2);

            $blog = $query2->where('published', 'ON')
                ->whereRaw('((from_date <= now() AND to_date >= now()) OR '
                    . '(from_date <= now() AND to_date IS NULL) OR '
                    . '(from_date IS NULL AND to_date >= now()) OR '
                    . '(from_date IS NULL AND to_date IS NULL))')
                ->first();

            $rankingData[$i] = [
                'shop_code' => $shopCode,
                'shop_name' => $shopData->base_name,
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
    private function shopData($shopCode)
    {
        // 拠点データ
        $query1 = DB::table('base')->select('base_name')
            ->where('hansha_code', $this->hanshaCode)
            ->where('base_code', $shopCode);

        $shopData = $query1->where('deleted_at', null)
            ->where('base_published_flg', '<>', 2) // 非公開の拠点は除く
            ->whereRaw("(show_flg = '1' OR show_flg IS NULL)") // 表示機能
            ->orderBy('base_code', 'asc')->first();
        return $shopData;
    }

    /**
     * 時間を計算する関数
     *
     * @param string $number
     * @return int
     */
    private function calculateTime($number)
    {
        if ($number > 0) {
            $number = '+' . $number;
        }
        return strtotime($number . ' day', time());
    }

    /**
     * 記事のサムネール画像を取得する
     */
    private function getThumbnail($blog)
    {
        // 定形画像 3枚アップロードする画像があるとき
        $pattern = '/<img.*?src=[\"\']([^\"\']+?\.(?:[jJ][pP][eE][gG]|'
            . '[jJ][pP][gG]|'
            . '[pP][nN][gG]|'
            . '[gG][iI][fF]|'
            . '[bB][mM][pP]))[^\"\']*?[\"\']/';
        $image = asset_auto('img/no_image.gif');
        // 3枚アップロードするがぞうがあるとき
        if (!empty($blog->file1) == True) {
            // ファイルパスの情報を取得する
            $fileinfo1 = pathinfo($blog->file1);
            // PDFファイルの場合
            if (strtolower($fileinfo1['extension']) === "pdf") {
                $image = \App\Original\Util\CodeUtil::getPdfThumbnail($blog->file1);
            } else {
                $image = url_auto($blog->file1);
            }
        } else if (!empty($blog->file2) == True) {
            // ファイルパスの情報を取得する
            $fileinfo2 = pathinfo($blog->file2);
            // PDFファイルの場合
            if (strtolower($fileinfo2['extension']) === "pdf") {
                $image = \App\Original\Util\CodeUtil::getPdfThumbnail($blog->file2);
            } else {
                $image = url_auto($blog->file2);
            }
        } else if (!empty($blog->file3) == True) {
            // ファイルパスの情報を取得する
            $fileinfo3 = pathinfo($blog->file3);
            // PDFファイルの場合
            if (strtolower($fileinfo3['extension']) === "pdf") {
                $image = \App\Original\Util\CodeUtil::getPdfThumbnail($blog->file3);
            } else {
                $image = url_auto($blog->file2);
            }
            $image = url_auto($blog->file3);

            // 3枚画像が無いときは、本文の画像を参照
        } else if (preg_match($pattern, $blog->comment, $match)) {
            $image = $match[1];
        }

        // タイムスタンプ
        $image = str_replace('[NOW_TIME]', time(), $image);

        return $image;
    }

    /**
     * 最新ブログかを判定する関数
     *
     * @param string $time
     */
    private function isNewBlog($time = "")
    {
        // 時間が空でないとき
        if (!empty($time) == True) {
            // 1週間前の日付を取得する
            $tagetDay = date("Y-m-d", strtotime("-7 day"));
            // 時間の値を加工
            $day = date('Y-m-d', strtotime($time));

            // 記事の日付が、1週間前より新しいときは、true
            return strtotime($day) >= strtotime($tagetDay);
        } else {
            return false;
        }
    }

    /**
     * ブログのJSONデータ
     *
     * @param array $blogData 返す変数
     * @param object $value ブログデータ
     * @param array $options オプション
     */
    private function renderBlogJsonData(&$blogData, $value, array $options = [])
    {
        $blogData = $this->renderBlogJsonDataReturn($value, $options);
    }

    /**
     * ブログのJSONデータ
     *
     * @param array $blogData 返す変数
     * @param object $value ブログデータ
     * @param array $options オプション
     */
    private function renderBlogJsonDataReturn($value, array $options = [])
    {
        $data = [];
        // 拠点コード
        $data['shop_code'] = $value->shop;
        // 掲載番号
        $data['number'] = str_replace('data', '', $value->number);

        // 日付
        $data['time'] = date($this->timeFormat, strtotime($value->updated_at));
        // 新着フラグ
        $data['new_fig'] = $this->isNewBlog($value->updated_at);
        // 公開日時が指定されているとき
        if (!empty($value->from_date) && !in_array($this->hanshaCode, $this->fromDateEx)) {
            if ($this->hanshaCode != '1654144') { // 伊勢崎中央様以外
                $data['time'] = date($this->timeFormat, strtotime($value->from_date));
            }
            $data['new_fig'] = $this->isNewBlog($value->from_date);
        }

        // 作成日付
        $data['created_at'] = date($this->timeFormat, strtotime($value->created_at));
        // 編集日付
        $data['updated_at'] = date($this->timeFormat, strtotime($value->updated_at));
        // 開始日付
        $data['from_date'] = date($this->timeFormat, strtotime($value->from_date));
        // 終了日付
        $data['to_date'] = date($this->timeFormat, strtotime($value->to_date));

        /**
         * サムネイル画像
         */
        $contentStr = $value->comment;

        // 定形画像 3枚アップロードする画像があるとき
        $pattern = '/<img.*?src=[\"\']([^\"\']+?\.(?:[jJ][pP][eE][gG]|'
            . '[jJ][pP][gG]|'
            . '[pP][nN][gG]|'
            . '[gG][iI][fF]|'
            . '[bB][mM][pP]))[^\"\']*?[\"\']/';
        $data['image'] = asset_auto('img/no_image.gif');
        if ($this->hanshaCode === '2289009') {
            $data['image'] = asset_auto('img/no_image.jpg');
        }
        // 3枚アップロードするがぞうがあるとき
        if (!empty($value->file1) == True) {
            // ファイルパスの情報を取得する
            $fileinfo1 = pathinfo($value->file1);
            // PDFファイルの場合
            if (strtolower($fileinfo1['extension']) === "pdf") {
                $data['image'] = \App\Original\Util\CodeUtil::getPdfThumbnail($value->file1);
            } else {
                $data['image'] = url_auto($value->file1);
            }
        } else if (!empty($value->file2) == True) {
            // ファイルパスの情報を取得する
            $fileinfo2 = pathinfo($value->file2);
            // PDFファイルの場合
            if (strtolower($fileinfo2['extension']) === "pdf") {
                $data['image'] = \App\Original\Util\CodeUtil::getPdfThumbnail($value->file2);
            } else {
                $data['image'] = url_auto($value->file2);
            }
        } else if (!empty($value->file3) == True) {
            // ファイルパスの情報を取得する
            $fileinfo3 = pathinfo($value->file3);
            // PDFファイルの場合
            if (strtolower($fileinfo3['extension']) === "pdf") {
                $data['image'] = \App\Original\Util\CodeUtil::getPdfThumbnail($value->file3);
            } else {
                $data['image'] = url_auto($value->file3);
            }

            // 3枚画像が無いときは、本文の画像を参照
        } else if (preg_match($pattern, $contentStr, $match)) {
            $data['image'] = $match[1];
        }

        // タイムスタンプ
        $data['image'] = str_replace('[NOW_TIME]', time(), $data['image']);

        /**
         * タイトルの表示
         */
        $blog_title = trim($value->title);
        $blog_title = html_entity_decode($value->title);
        if (!empty($blog_title)) {
            if ($this->titleLength !== '') {
                $str_length = mb_strlen($blog_title);
                if ($str_length > $this->titleLength) {
                    if (in_array($this->hanshaCode, $this->mbStringWidthCutShops)) {
                        $blog_title = mb_strimwidth($blog_title, 0, (int)$this->titleLength, "...", 'utf-8');
                        $blog_title = trim($blog_title);
                    } else {
                        $blog_title = mb_substr($blog_title, 0, $this->titleLength, 'utf-8');
                        $blog_title = trim($blog_title) . "...";
                    }
                }
            }
        } else {
            $blog_title = 'No Title';
        }

        // タイトル
        $blog_title = $this->convertEmojiToHtmlEntity($blog_title);
        $data['title'] = $blog_title;

        /**
         * 本文の表示
         */
        // コンテンツの概要
        $content = html_entity_decode($contentStr);
        if (!empty($contentStr)) {
            if ($this->contentLength !== '') {
                $contentStr = strip_tags($contentStr);
                $contentStr = str_replace('&nbsp;', '', $contentStr);
                $contentStr = str_replace("\r\n", '', $contentStr);
                $contentStr = str_replace("\n", '', $contentStr);
                $content = $contentStr;
                // 本文から指定文字列分のみ抜き出す
                $str_length = mb_strlen($content);
                if ($str_length > $this->contentLength) {
                    if (in_array($this->hanshaCode, $this->mbStringWidthCutShops)) {
                        $content = mb_strimwidth($content, 0, (int)$this->contentLength, "...", 'utf-8');
                        $content = trim($content);
                    } else {
                        $content = mb_substr($content, 0, $this->contentLength, 'utf-8');
                        $content = trim($content) . "...";
                    }
                }
            }
        } else {
            $content = '無し';
        }
        // 本文
        $content = $this->convertEmojiToHtmlEntity($content);
        $data['content'] = $content;
        $data['pos'] = $value->pos;

        /**
         * 詳細ページ
         * アップロードの画像の追加
         */
        $data['images_upload']= $this->getImages($value);

        $blogData = [];
        if ($this->isMultipleRecord) {
            $blogData[$options['key']] = $data;
        } else {
            $blogData = $data;
        }
        return $blogData;
    }
    /**
     * ブログデータをJSONにレンダリングする
     *
     * @param array $list ブログデータ
     * @param bool $useSequentialKey 自動的なキーを使うフラグ
     * @return string
     */
    private function renderAsJson($list, $useSequentialKey = true, $useJsonReturn = false)
    {
        if ($useSequentialKey) {
            $key = "";
        } else {
            $key = 0;
        }

        // ブログデータ
        $blogData = null;
        // オプション
        $options = [
            'useSequentialKey' => $useSequentialKey,
        ];

        if ($this->isMultipleRecord && !empty($list['blogs']) == true) {

            $blogData = [];
            foreach ($list['blogs'] as $value) {
                // 拠点コードを格納
                if ($useSequentialKey) {
                    $key = $value->shop;
                }
                // キー
                $options['key'] = $key;
                // 記事ごと
                $data = $this->renderBlogJsonDataReturn($value, $options);
                // 拠点データ
                $shopData = $this->shopData($value->shop);
                // 拠点名
                $data[$key]['shop_name'] = $shopData->base_name;
                // タイトル
                $data[$key]['title'] = $this->convertEmojiToHtmlEntity($data[$key]['title']);
                $data[$key]['title'] = str_replace('<', '&lt;', $data[$key]['title']);
                $data[$key]['title'] = str_replace('>', '&gt;', $data[$key]['title']);
                // 本文
                $data[$key]['content'] = $this->convertEmojiToHtmlEntity($data[$key]['content']);
                if ($this->contentLength != '') {
                    $data[$key]['content'] = str_replace('<', '&lt;', $data[$key]['content']);
                    $data[$key]['content'] = str_replace('>', '&gt;', $data[$key]['content']);
                }
                // カテゴリー
                $data[$key]['category'] = (isset($blogData[$key]['category'])) ? $blogData[$key]['category'] : '';
                // データを付けるイベント
                if (isset($list['mergeDataRequested'])) {
                    // 現在データに新しいデータをマージする
                    $data[$key] = $list['mergeDataRequested']($data[$key], $value);
                }
                // 一部ごとにデータをマージする
                $blogData = array_merge($blogData, $data);

                if (!$useSequentialKey) {
                    $key++;
                }
            }
        } else if (!$this->isMultipleRecord && !empty($list['blog']) == true) {
            // 記事ごと
            $this->renderBlogJsonData($blogData, $list['blog'], $options);
            // 拠点データ
            $shopData = $this->shopData($list['blog']->shop);
            // 拠点名
            $blogData['shop_name'] = $shopData->base_name;
        }

        // JSON出力スタイルの判定
        $jsonData = [];
        if ($this->jsonStyle === 'data') {
            $jsonData = $blogData;
        } else if ($this->jsonStyle === 'data_paging') {
            if ($this->isMultipleRecord) {
                $jsonData = [
                    'data' => $blogData,
                    'paging' => $this->getPagingData($list['blogs']),
                ];
            } else {
                $jsonData = [
                    'data' => $blogData,
                    'paging' => $this->getPagingData($blogData['number']),
                ];
            }
        } else if ($this->jsonStyle === 'paging') {
            if ($this->isMultipleRecord) {
                $jsonData = $this->getPagingData($list['blogs']);
            } else {
                $jsonData = $this->getPagingData($blogData['number']);
            }
        }

        // JSONデータとして戻す
        if ($useJsonReturn === true) {
            return $jsonData;
        }
        /*
         *   JSONでデータを出力する
         * json_encodeで値をJSON形式に変換して出力する
         * JSON_PRETTY_PRINT JSON出力データを見やすくする
         * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
         * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
         */
        return response()->json($jsonData, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     * ページングデータ
     *
     * @param object $res 複数のデータ
     * @return array
     */
    private function getPagingData($res)
    {
        if ($this->isMultipleRecord) {
            $perPage = $res->perPage();
            $currentPage = $res->currentPage();
            $beginning = (($currentPage - 1) * $perPage) + 1;
            $ending = (($currentPage - 1) * $perPage) + $res->count();
            $totalPage = $res->total();
            $prevPage = $currentPage - 1;
            $nextPage = $currentPage + 1;
            $hasPrevPage = $currentPage > 1;
            $hasNextPage = $currentPage < $totalPage && $ending < $totalPage;

            return compact('perPage', 'currentPage', 'beginning', 'ending',
                'totalPage', 'prevPage', 'nextPage', 'hasNextPage',
                'hasPrevPage');
        } else {
            $query = $this->getResultSet();
            $current = $query->where('number', "data{$res}")
                ->first();
            // 次の記事
            $query = DB::table($this->tableName);
            $prev = $query//->select('number')
            ->where('regist', '>', $current->regist)
                ->where('published', 'ON')
                // 公開期間内のとき
                ->whereRaw('((from_date <= now() AND to_date >= now()) OR '
                    . '(from_date <= now() AND to_date IS NULL) OR '
                    . '(from_date IS NULL AND to_date >= now()) OR '
                    . '(from_date IS NULL AND to_date IS NULL))')
                // 削除日時がNULLのとき
                ->whereNull('deleted_at');
            $prev = $this->buildOrderBy($prev, '', 'asc');
            // 拠点の除外
            if (is_array($this->shopExclusion) && count($this->shopExclusion) > 0) {
                $prev = $prev->whereNotIn('shop', $this->shopExclusion);
            }
            // 拠点コード
            if ($this->shopCode !== "") {
                $prev = $prev->where('shop', $this->shopCode);
            }
            $prevs = $prev->pluck('number');

            $prevNumber = null;
            $prevCount = $prevs->count();
            if ($prevCount > 0) {
                $prevNumber = str_replace('data', '', $prevs[$prevCount - 1]);
            }

            // 前の記事
            $query = $this->getResultSet();
            $next = $query->select('number')
                ->where('regist', '<', $current->regist)
                ->where('published', 'ON')
                // 公開期間内のとき
                ->whereRaw('((from_date <= now() AND to_date >= now()) OR '
                    . '(from_date <= now() AND to_date IS NULL) OR '
                    . '(from_date IS NULL AND to_date >= now()) OR '
                    . '(from_date IS NULL AND to_date IS NULL))')
                // 削除日時がNULLのとき
                ->whereNull('deleted_at');
            $next = $this->buildOrderBy($next);
            // 拠点の除外
            if (is_array($this->shopExclusion) && count($this->shopExclusion) > 0) {
                $next = $next->whereNotIn('shop', $this->shopExclusion);
            }
            // 拠点コード
            if ($this->shopCode !== "") {
                $next = $next->where('shop', $this->shopCode);
            }
            $next = $next->first();
            $nextNumber = null;
            if ($next !== null) {
                $nextNumber = str_replace('data', '', $next->number);
            }
            return compact('prevNumber', 'nextNumber');
        }
    }

    /**
     * 店舗一覧
     *
     * @return array
     */
    public function getShopList()
    {
        // 店舗一覧
        $shops = $this->shopList($this->hanshaCode);
        // 緊急掲示板の除外
        $emergencyShopId = $this->getEmergencyBulletinShopId();
        // 拠点の除外の絞り込み
        $shopList = [];
        foreach ($shops as $shopCode => $shopName) {
            if (in_array($shopCode, $this->shopExclusion)) {
                continue;
            }
            // 緊急掲示板の除外
            if ($emergencyShopId == $shopCode) {
                continue;
            }
            $shopList[$shopCode] = $shopName;
        }
        /*
         * JSONでデータを出力する
         * json_encodeで値をJSON形式に変換して出力する
         * JSON_PRETTY_PRINT JSON出力データを見やすくする
         * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
         * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
         */
        return response()->json($shopList, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * 画像
     *
     * @param object $item レコード
     * @return array
     */
    private function getImages($item)
    {
        $outputData = [];
        $imgFiles = [];
        // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
        for ($i = 1; $i <= 3; $i++) {
            // 画像
            $file = $item->{'file' . $i};
            // PDFファイルの場合
            if( !empty( $file ) && preg_match("/\.pdf$/i", $file ) ){
                // PDFファイル
                $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $file);
                // サムネイル
                $imgFiles[$i]['thumb'] = CodeUtil::getPdfThumbnail( $file );
            }else{
                // 画像
                $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $file);
                // サムネール画像
                $imgFiles[$i]['thumb'] = $file;
            }
            $imgFiles[$i]['caption'] = $this->convertEmojiToHtmlEntity($item->{'caption' . $i});
        }

        for ($i = 1; $i <= 3; $i++) {
            if (empty($imgFiles[$i]['file']) == True) {
                continue;
            }

            $imgFiles[$i]['thumb'] = url_auto($imgFiles[$i]['thumb']);
            $imgFiles[$i]['file'] = url_auto($imgFiles[$i]['file']);
            $outputData[$i] = $imgFiles[$i];
        }

        return $outputData;
    }
}