<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use App\Original\Util\CodeUtil;
use App\Original\Util\SessionUtil;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Traits\Infobbs\RecordModifier;
use App\Http\Controllers\tCommon;
use App\Models\Base;
use App\Models\Infobbs;
use Closure;
use Request;
use Session;
use DB;

/**
 * 緊急掲示板公開APIのコントローラー
 * 
 * @author ahmad
 */
trait EmergencyBulletinRepository
{
    use tCommon;
    use RecordModifier;
    
    /**
     *　販社コード
     * 
     * @var string
     */
    protected $hanshaCode;
    
    /**
     * 店舗コード
     * 
     * @var string
     */
    private $shopCode;
    
    /**
     * デバイスの種類
     * pc, lite
     * 
     * @var string
     */
    protected $deviceType;
    
    /**
     * テンプレートのフォルダー
     * 
     * @var string
     */
    protected $templateDir;
    
    /**
     * コントローラー名
     * 
     * @var string
     */
    protected $controller;
    
    /**
     * 機能を使わない販社のフラグ
     * 
     * @var bool
     */
    protected $featureUnavailable = false;

    /**
     * 複数レコードのフラグ
     * 
     * @var bool
     */
    protected $isMultipleRecord = false;
    
    /**
     * デバッグのフラグ
     * 
     * @var bool
     */
    protected $debug = false;
    
    /**
     * 日時のフォーマット
     * 
     * @var string
     */
    protected $timeFormat = null;

    /**
     * 何件のページ
     * 
     * @var int
     */
    protected $pageNum;

    /**
     * 掲載番号
     * 
     * @var string
     */
    protected $num;

    /**
     * テキストを置換する方法
     * 
     * @var string
     */
    protected $stringReplacementMethod = 'general';

    /**
     * 削除される項目
     * 
     * @var string
     */
    protected $removeFields = [];
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        // テンプレートNo
        // 販社コード
        if (isset($_GET['hansha_code'])) {
            $this->hanshaCode = $_GET['hansha_code'];
        } else {
            $this->hanshaCode = Request::segment(3);
        }
        $this->shopCode = config("{$this->hanshaCode}.general.emergency_bulletin_board_id"); // 拠点コード
        $this->showType = isset($req['show_type']) ? $req['show_type'] : ""; // 表示タイプ JSONなど
        $this->num = isset($req['num']) && !empty($req['num']) ? $req['num'] : -1; // ナンバーの指定
        // 複数レコードのフラグ
        $this->isMultipleRecord = $this->num === -1;
        
        $this->controller = "Api\EmergencyBulletinController";
        // 販社名の設定パラメータを取得
        $para_list = ( config('original.para')[$this->hanshaCode] );
        
        // 店舗が指定するフラグ
        $this->featureUnavailable = empty($this->shopCode);
        $this->pageNum = ( !empty( $req['page_num'] ) )? $req['page_num'] : ""; // ページング最大数
        
        // 日時のフォーマット
        $this->timeFormat = isset($req['time_format']) ? $req['time_format'] : null;
        // 本文の長さ
        $this->contentLength = isset($req['content_length']) &&
                !empty($req['content_length']) ? $req['content_length'] : '';
        // タイトルの長さ
        $this->titleLength = isset($req['title_length']) &&
                !empty($req['title_length']) ? $req['title_length'] : '';
        // テキストを置換する方法
        if (isset($req['string_replacement']) && !empty($req['string_replacement'])) {
            $this->stringReplacementMethod = $req['string_replacement'];
        }
        // 削除される項目
        if (isset($req['remove_fields']) && !empty($req['remove_fields'])) {
            $this->removeFields = $req['remove_fields'];
        }
        
        /**
         * テンプレートのフォルダー
         */
        // デバイスのタイプ
        $this->deviceType = isset($req['device_type']) ? $req['device_type'] : null;
        $devicePath = '';
        if ($this->deviceType === 'pc' || $this->deviceType === 'lite') {
            $devicePath = '.' . $this->deviceType;
        } else {
            $devicePath = '.pc';
        }
        $this->templateDir = 'api.' . $this->hanshaCode . '.api.emergency-bulletin' . $devicePath;
    }
    
    /**
     * 共通データ
     * 
     * @return object
     */
    private function getData() {
        return Infobbs::createNewInstance( $this->hanshaCode )
                ->where('deleted_at', null )
                ->where('published', 'ON' )
                ->orderBy('regist', 'desc')
                // 公開期間内のとき
                ->whereRaw( ' ( ( date(from_date) <= date(now()) AND date(to_date) >= date(now())) OR '
                        . ' ( date(from_date) <= date(now()) AND to_date IS NULL) OR '
                        . ' ( from_date IS NULL AND date(to_date) >= date(now())) OR '
                        . ' ( from_date IS NULL AND to_date IS NULL))' )
                ->where('shop', $this->shopCode );
    }

    /**
     * インデックス
     */
    public function getIndex() {
        // 店舗が指定するフラグ
        if ($this->featureUnavailable) {
            return '緊急掲示板の機能がついていません。';
        }
        
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 店舗のチェック
        $shopName = Base::where('hansha_code', $this->hanshaCode)
                ->where('base_code', $this->shopCode)
                ->value('base_name');

        if ($shopName === null) {
            return 'エラー：店舗が存在しません。';
        }
        
        // デフォルトの日時のフォーマット
        if ($this->timeFormat === null) {
            $this->timeFormat = 'Y/m/d';
        }
        
        // 表示最大数の指定
        if( $this->pageNum !== "" ){
            $perPage = (int)$this->pageNum;
        } else {
            // 1ページの表示件数
            $perPage = config( 'original.para' )[$this->hanshaCode] ['page_num'];
        }
        
        $showData = $this->getData()
                ->paginate($perPage);
        
        if ($showData === null) {
            return '';
        }
        
        // レコードのデータの変更
        if ($this->showType != 'json') {
            $this->modifyResultRecord($showData, true);
        }
        
        $list = compact(
            'showData',
            'shopName'
        );
        
        if ($this->showType == 'json') {
            return $this->renderAsJson($list, false);
        } else {
            return view( $this->templateDir . '.index', 
                $list
            )
            ->with( 'controller', $this->controller )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'timeFormat', $this->timeFormat )
            ->with( 'convertEmojiToHtmlEntity', Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']))
            ->with( 'templateDir', $this->templateDir );
        }
    }
    
    private function isRemoveField($fieldName) {
        // 削除する項目
        if (!empty($this->removeFields)) {
            $removeFields = explode('|', $this->removeFields);
            return in_array($fieldName, $removeFields);
        }
        return false;
    }
    
    /**
     * ブログデータをJSONにレンダリングする
     * 
     * @param array $list ブログデータ
     * @param bool $useSequentialKey 自動的なキーを使うフラグ
     * @return string
     */
    private function renderAsJson($list, $useSequentialKey = true) {
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
        
        if( !empty( $list['showData'] ) == true ){
            
            $blogData = [];
            foreach( $list['showData'] as $value ) {
                // 拠点コードを格納
                if ($useSequentialKey) {
                    $key = $value->shop;
                }
                // キー
                $options['key'] = $key;
                
                // 記事ごと
                $this->renderBlogJsonData($blogData, $value, $options);
                // 拠点データ
                $shopData = $this->shopData( $value->shop );
                // 拠点名
                $blogData[$key]['shop_name'] = $shopData->base_name;
                // タイトルのフィルター
                $blogData[$key]['title'] = str_replace('<', '&lt;', $blogData[$key]['title']);
                $blogData[$key]['title'] = str_replace('>', '&gt;', $blogData[$key]['title']);
                
                if (!isset($this->stringReplacementMethod) || 
                    $this->stringReplacementMethod === 'general') {
                    // タイトル
                    if (isset($blogData[$key]['title'])) {
                        $blogData[$key]['title'] = $this->convertEmojiToHtmlEntity($blogData[$key]['title']);
                    }
                    // 本文
                    if (isset($blogData[$key]['content'])) {
                        $blogData[$key]['content'] = $this->convertEmojiToHtmlEntity($blogData[$key]['content']);
                    }
                }
                
                if (!$useSequentialKey) {
                    $key++;
                }
            }
        } else if ( !empty( $list['showData'] ) == true ) {
            // 記事ごと
            $this->renderBlogJsonData($blogData, $list['showData'], $options);
            // 拠点データ
            $shopData = $this->shopData( $list['showData']->shop );
            // 拠点名
            $blogData['shop_name'] = $shopData->base_name;
        }
        
        // JSON出力スタイルの判定
        $jsonData = $blogData;

        /*
         *   JSONでデータを出力する
         * json_encodeで値をJSON形式に変換して出力する
         * JSON_PRETTY_PRINT JSON出力データを見やすくする
         * JSON_UNESCAPED_UNICODE 日本語が文字化けしないようにする
         * JSON_UNESCAPED_SLASHES スラッシュをエスケープしないようにする
         */
        return response()->json( $jsonData, 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

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
        // カテゴリー
        $data['category'] = $value->category;
        // 注意のフラフ
        $data['isWarning'] = $value->category === '緊急時';
        // 掲載番号
        $data['number'] = str_replace('data', '', $value->number);

        // 日付
        $data['time'] = date( $this->timeFormat, strtotime( $value->updated_at ) );

        /**
         * サムネイル画像
         */
        $contentStr = $value->comment;

        // 定形画像 3枚アップロードする画像があるとき
        $pattern = '/<img.*?src=[\"\']([^\"\']+?(?:[jJ][pP][eE][gG]|'
                . '[jJ][pP][gG]|'
                . '[pP][nN][gG]|'
                . '[gG][iI][fF]|'
                . '[bB][mM][pP])).*?[\"\']/';
        $data['image'] = asset_auto('img/no_image.gif');
        // 3枚アップロードするがぞうがあるとき
        if( !empty( $value->file1 ) == True ){
            $fileinfo = pathinfo($value->file1);
            // PDFファイルの場合
            if (strtolower($fileinfo['extension']) === "pdf") {
                $data['image'] = \App\Original\Util\CodeUtil::getPdfThumbnail($value->file1);
            } else {
                $data['image'] = url_auto($value->file1);
            }
        }else if( !empty( $value->file2 ) == True ){
            $fileinfo = pathinfo($value->file2);
            // PDFファイルの場合
            if (strtolower($fileinfo['extension']) === "pdf") {
                $data['image'] = \App\Original\Util\CodeUtil::getPdfThumbnail($value->file2);
            } else {
                $data['image'] = url_auto($value->file2);
            }
        }else if( !empty( $value->file3 ) == True ){
            $fileinfo = pathinfo($value->file3);
            // PDFファイルの場合
            if (strtolower($fileinfo['extension']) === "pdf") {
                $data['image'] = \App\Original\Util\CodeUtil::getPdfThumbnail($value->file3);
            } else {
                $data['image'] = url_auto($value->file3);
            }
        // 3枚画像が無いときは、本文の画像を参照
        }else if(preg_match($pattern, $contentStr, $match ) ) {
            $data['image'] = $match[1];
        }

        /**
         * 画像の配列の取得
         */
        $data['images']=[
            'position' => $value->pos,
            'items' => $this->getImages($value),
        ];

        /**
         * タイトルの表示
         */
        if (!$this->isRemoveField('title')) {
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
            if (isset($this->stringReplacementMethod) && 
                $this->stringReplacementMethod === 'all_unwanted_chars') {
                $blog_title = $this->replaceAllUnwantedChars($blog_title);
            }
            $data['title'] = $blog_title;
        }

        /**
         * 本文の表示
         */
        if (!$this->isRemoveField('content')) {
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
            $data['content'] = $content;
        }
        
        $blogData[$options['key']] = $data;
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

    /**
     * 詳細画面
     */
    public function getDetail() {
        // 店舗が指定するフラグ
        if ($this->featureUnavailable) {
            return '緊急掲示板の機能がついていません。';
        }
        
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 店舗のチェック
        $shopName = Base::where('hansha_code', $this->hanshaCode)
                ->where('base_code', $this->shopCode)
                ->value('base_name');

        if ($shopName === null) {
            return 'エラー：店舗が存在しません。';
        }
        
        // デフォルトの日時のフォーマット
        if ($this->timeFormat === null) {
            $this->timeFormat = 'Y.m.d';
        }
        
        // 表示最大数の指定
        if( $this->pageNum !== "" ){
            $perPage = (int)$this->pageNum;
        } else {
            // 1ページの表示件数
            $perPage = config( 'original.para' )[$this->hanshaCode] ['page_num'];
        }
        
        $showData = $this->getData();
        
        // 複数レコードの場合
        if ($this->isMultipleRecord) {
            // 1行メッセージのモデルインスタンス
            $showData = $showData->paginate($perPage);
        } else {
            $number = "data{$this->num}";
            $showData = $showData->where('number', $number)
                    ->first();
            
            // 値が無いときはエラーを出力
            if( $showData === null ){
                return "<p>表示エラー</p>";
            }
        }
        
        // レコードのデータの変更
        $this->modifyResultRecord($showData, true);
        
        return view( $this->templateDir . '.detail', 
            compact(
                'showData',
                'shopName'
            )
        )
        ->with( 'controller', $this->controller )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'convertEmojiToHtmlEntity', Closure::fromCallable([$this, 'convertEmojiToHtmlEntity']))
        ->with( 'shopCode', $this->shopCode )
        ->with( 'timeFormat', $this->timeFormat )
        ->with( 'templateDir', $this->templateDir );
    }
    
}
