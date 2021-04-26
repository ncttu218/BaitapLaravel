<?php

namespace App\Http\Controllers\V3\_5551358\Api;

use App\Http\Controllers\V3\Common\Api\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\V3\Common\Api\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\InfobbsRepository;

use App\Commands\Ranking\BaseCountReaderCommand;
use App\Models\Base;
use Closure;
use Request;
use DB;

/**
 * 店舗ブログのAPI
 *
 * @author ahmad
 *
 */
class InfobbsController extends InfobbsCoreController
    implements IInfobbsRepository
{
    // 共通レポジトリー
    use InfobbsRepository;
    
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
            $query = $query->where( 'info.shop', $this->shopCode);
        }
        // カテゴリー
        if( isset( $req['category'] ) && $req['category'] !== "" ){
            /// カテゴリーを検索するSQL
            $category = mb_convert_encoding($req['category'], 'UTF-8', 'Shift-JIS');
            $query = $query->whereRaw( DB::Raw( " ARRAY['{$category}'] <@ regexp_split_to_array( info.category, ',' ) "  ) );
        }

        // ナンバーの検索
        if( isset( $req['num'] ) && $req['num'] !== "" ){
            $query = $query->where( 'number', 'data' . $req['num'] );
        }
        
        // 表示順の条件
        $query = $this->buildOrderBy( $query, 'info' );
        
        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();

        //->where( 'shop', '=', $this->shopCode)
        $blogs = $query->where( 'info.published', 'ON' )
                // 表示するカラム
                ->selectRaw('info.*, b.base_name')
                // 削除日時がNULLのとき
                ->whereNull( 'info.deleted_at' )
                // 公開期間内のとき
                ->whereRaw( '((info.from_date <= now() AND info.to_date >= now()) OR '
                    . '(info.from_date <= now() AND info.to_date IS NULL) OR '
                    . '(info.from_date IS NULL AND info.to_date >= now()) OR '
                    . '(info.from_date IS NULL AND info.to_date IS NULL))' )
                // 拠点テーブルとのJOIN
                ->join( $baseTableName . ' AS b', function ($join) {
                    $join->on('b.base_code', 'info.shop'); // 拠点コード
                    $join->on('b.hansha_code', DB::raw("'{$this->hanshaCode}'")); // 販社コード
                })
                // 削除フラグ
                ->whereNull('b.deleted_at')
                // 非公開の拠点は除く
                ->where( 'b.base_published_flg', '<>', 2 );
        
        // 拠点の除外
        if ($this->shopExclusionType == self::SHOP_EXCLUSION_FROM_URL_QUERY &&
                is_array($this->shopExclusion) &&
                count($this->shopExclusion) > 0) {
            $blogs = $blogs->whereNotIn( 'info.shop', $this->shopExclusion );
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
            if( $blog === null ){
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
        if (!in_array($this->shopCode, $this->shopExclusion)) {
            $this->dispatch(
                new BaseCountReaderCommand(
                    $this->hanshaCode,
                    $this->shopCode,
                    $pageInfo
                )
            );
        }
        
        // ビューのスタイル
        $viewStyle = $this->viewStyle == '1' ? '1' : '';
        
        // 関数をビューに渡す
        $list['isNewBlog'] = Closure::fromCallable([$this, 'isNewBlog']);
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
            // ビュー名
            $viewName = $this->templateDir . '.blogDetail';
        }
        
        // 設定データ
        // 販社名の設定パラメータを取得
        $list['para_list'] = config('original.para')[$this->hanshaCode] ?? [];
        
        echo '<meta charset="shift_jis">';
        
        // 表示タイプがJSONのとき
        if( $this->showType == "json" ){
            return $this->renderAsJson($list, false);
        }else{
            return view( $viewName . $viewStyle, $list)
                ->with( 'hanshaCode', $this->hanshaCode)
                ->with( 'shopCode', $this->shopCode)
                ->with( 'shopExclusion', $this->shopExclusion)
                ->with( 'templateDir', $this->templateDir );
        }
    }
    
    /**
     * ブログのJSONデータ
     * 
     * @param array $blogData 返す変数
     * @param object $value ブログデータ
     * @param array $options オプション
     */
    private function renderBlogJsonData(&$blogData, $value, array $options = []) {
        $data = [];
        
        // 拠点コード
        $data['shop_code'] = $value->shop;
        // 掲載番号
        $data['number'] = str_replace('data', '', $value->number);

        // 日付
        $data['time'] = date( $this->timeFormat, strtotime( $value->updated_at ) );
        // 新着フラグ
        $data['new_fig'] = $this->isNewBlog( $value->updated_at );
        // 公開日時が指定されているとき
        if( !empty( $value->from_date ) ) {
            $data['time'] = date( $this->timeFormat, strtotime( $value->from_date ) );
            $data['new_fig'] = $this->isNewBlog( $value->from_date );
        }

        /**
         * サムネイル画像
         */
        $contentStr = $value->comment;

        // 定形画像 3枚アップロードする画像があるとき
        $pattern = '/<img.*?src=[\"\']([^\"\']+?)[\"\']/';
        $data['image'] = asset_auto('img/no_image.gif');
        // 3枚アップロードするがぞうがあるとき
        if( !empty( $value->file1 ) == True ){
            $data['image'] = url_auto( $value->file1 );
        }else if( !empty( $value->file2 ) == True ){
            $data['image'] = url_auto( $value->file2 );
        }else if( !empty( $value->file3 ) == True ){
            $data['image'] = url_auto( $value->file3 );

        // 3枚画像が無いときは、本文の画像を参照
        }else if(preg_match($pattern, $contentStr, $match ) ) {
            $data['image'] = $match[1];
        }
        
        // タイムスタンプ
        $data['image'] = str_replace('[NOW_TIME]', time(), $data['image']);

        /**
         * タイトルの表示
         */
        $blog_title = trim($value->title);
        if (!empty($blog_title)) {
            if ($this->titleLength !== '') {
                $str_length = mb_strlen($blog_title);
                if ($str_length > $this->titleLength) {
                    $blog_title = mb_substr($blog_title, 0, $this->titleLength, 'utf-8');
                    $blog_title = trim($blog_title) . "...";
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
        $content = $contentStr;
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
                    $content = mb_substr($content, 0, $this->contentLength, 'utf-8');
                    $content = trim($content) . "...";
                }
            }
        } else {
            $content = '無し';
        }

        // 本文
        $content = $this->convertEmojiToHtmlEntity($content);
        $data['content'] = $content;
        
        if ($this->isMultipleRecord) {
            $blogData[$options['key']] = $data;
        } else {
            $blogData = $data;
        }
    }
    
    /**
     * レコードのデータを変更
     * 
     * @param object $data データ
     * @param bool $isMultiple 複数かのフラグ
     */
    private function modifyResultRecord(&$data, $isMultiple = true) {
    }
    
    /**
     * レコードのデータを変更
     * 
     * @param object $data レコード
     */
    private function modifyOneResultRecord(&$data) {
    }
}