<?php

namespace App\Http\Controllers\Other;

use App\Lib\Util\DateUtil;
use App\Original\Util\SessionUtil;
use App\Original\Util\ImageUtil;
use App\Http\Requests\SearchRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tInitSearch;
use Session;
use DB;

/**
 * 拠点画面用コントローラー
 *
 * @author yhatsutori
 *
 */
class BlogEditController  extends Controller{
    
    use tInitSearch;
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        // 表示部分で使うオブジェクトを作成
        $this->initDisplayObj();

        // 引き継ぎの検索項目は消去
        // SessionUtil::removeSearch();
    }

    #######################
    ## initalize
    #######################

    /**
     * 表示部分で使うオブジェクトを作成
     * @return [type] [description]
     */
    public function initDisplayObj(){
        // 表示部分で使うオブジェクトを作成
        $this->displayObj = app('stdClass');
        // カテゴリー名
        $this->displayObj->category = "other";
        // 画面名
        $this->displayObj->page = "blog_edit";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "Other\BlogEditController";
    }

    #######################
    ## 検索・並び替え
    #######################

    /**
     * 画面固有の初期条件設定
     *
     * @return array
     */
    public function extendSearchParams(){
        $search = [];

        return $search;
    }

    /**
     * 並び順のデフォルト値を指定
     * ※継承先で主に定義
     * @return [type] [description]
     */
    public function extendSortParams() {
        // 複数テーブルにあるidが重複するため明示的にエイリアス指定
        $sort = [];
        
        return $sort;
    }

    #######################
    ## インデックス表示
    #######################

    /**
     * インデックス画面を表示
     * @param  [type] $search     [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function getIndex(){

        return view(
            $this->displayObj->tpl . '.index',
            compact(
                'search',
                'sortTypes'
            )
        )
        ->with( 'displayObj', $this->displayObj )
        ->with( "sortUrl", action_auto( $this->displayObj->ctl . '@getSort' ) )
        ->with( 'title', "記事データ 一括編集 画面" );

    }

    #######################
    ## 一括編集
    #######################

    /**
     * 記事データの一括編集（base64画像の置換）
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function postUpdate( SearchRequest $request ){
        $contents = [];
        // 画像の保存先のパス
        $dir = realpath( 'data/image');
        $dir = $dir . DIRECTORY_SEPARATOR . $request->hansha_code;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        // 販社コードが空でないとき
        if( !empty( $request->hansha_code ) == True ){
            // ブログテーブルのID取得用のSQL
            $selectIdSql = " select id from tb_{$request->hansha_code}_infobbs WHERE comment LIKE '%;base64,%' LIMIT 20";
            // テーブル内のIDの配列 SQLより取得
            $idList = DB::select( $selectIdSql );
            
            // IDの配列が空でないとき
            if( !empty( $idList ) == True ){
                // 記事内容から BASE64 を置換するループ
                foreach( $idList as $key => $value ){
                    // ブログデータ取得用のSQL
                    $selectBlogSql = " select comment from tb_{$request->hansha_code}_infobbs where id = {$value->id} ";
                    // 記事の内容 SQLより取得
                    $content = DB::select( $selectBlogSql );

                    // 記事の内容が空でないとき
                    if( !empty( $content[0]->comment ) == True ){
                        // $replacedContentは記事の内容の変換される結果
                        $replacementData = ImageUtil::base64ToImageFromString( $content[0]->comment, $dir, $request->hansha_code, 'infobbs', true );
                        $contents[$value->id] = [
                            'id' => $value->id,
                            'content' => $content[0]->comment,
                            'replacement' => $replacementData,
                        ];
                    }
                }
            }
        }
        // 元の画面に遷移する
        if (isset($request->doConversion)) {
            foreach ($request->doConversion as $id) {
                $blogItem = $contents[$id];
                $oldContent = $blogItem['content'];
                $replacedContent = ImageUtil::base64ToImageFromString( $oldContent, $dir, $request->hansha_code, 'infobbs', false );
                // 記事内容を update するSQL
                $updateBlogSql = " update tb_{$request->hansha_code}_infobbs set comment = ? where id = ? ";
                // 記事の内容 SQLより取得
                DB::update( $updateBlogSql, [$replacedContent, $id] );
            }
            return redirect( action_auto( $this->displayObj->ctl . '@getIndex' ) );
        }
        
        return view(
            $this->displayObj->tpl . '.index',
            compact(
                'search',
                'sortTypes',
                'contents',
                'dataPreview'
            )
        )
        ->with( 'displayObj', $this->displayObj )
        ->with( "sortUrl", action_auto( $this->displayObj->ctl . '@getSort' ) )
        ->with( 'title', "記事データ 一括編集 画面" );
    }

}
