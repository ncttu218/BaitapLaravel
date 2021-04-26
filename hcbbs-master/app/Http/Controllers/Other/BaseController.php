<?php

namespace App\Http\Controllers\Other;

use App\Lib\Util\DateUtil;
use App\Original\Util\SessionUtil;
use App\Models\Base;
use App\Commands\Other\Base\ListCommand;
use App\Commands\Other\Base\CreateCommand;
use App\Commands\Other\Base\UpdateCommand;
use App\Commands\Other\Base\DeleteCommand;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\BaseRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tInitSearch;
use Request;
use Session;
use DB;

/**
 * 拠点画面用コントローラー
 *
 * @author yhatsutori
 *
 */
class BaseController  extends Controller{
    
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
        $this->displayObj->page = "base";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "Other\BaseController";
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
        $sort = [
            'hansha_code' => 'asc',
            'base_code' => 'asc'
        ];
        
        return $sort;
    }

    #######################
    ## Controller method
    #######################

    /**
     * 一覧画面のデータを表示
     * @param  [type] $search     [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function showListData( $search, $sort, $requestObj ){

        // 表示データを取得
        $showData = $this->dispatch(
            new ListCommand(
                $sort,
                $requestObj
            )
        );
        
        //　表示用に、並び替え情報を取得
        if( isset( $sort['sort'] ) == True && !empty( $sort['sort'] ) == True ){
            foreach ( $sort['sort'] as $key => $value ) {
                // 並び替え情報を格納
                $sortTypes = [
                    'sort_key' => $key,
                    "sort_by" => $value
                ];
            }
        }
        
        return view(
            $this->displayObj->tpl . '.list',
            compact(
                'search',
                'sortTypes',
                'showData'
            )
        )
        ->with( 'displayObj', $this->displayObj )
        ->with( "sortUrl", action_auto( $this->displayObj->ctl . '@getSort' ) )
        ->with( 'title', "拠点 リスト" );
    }

    #######################
    ## 追加画面
    #######################

    /**
     * 登録画面を開く時の画面
     * @return [type] [description]
     */
    public function getCreate() {
        // 拠点モデルオブジェクトを取得
        $baseMObj = new Base();

        return view(
            $this->displayObj->tpl . '.input',
            compact(
                'baseMObj'
            )
        )
        ->with( "title", "拠点／登録" )
        ->with( 'displayObj', $this->displayObj )
        ->with( "type", "create" )
        ->with( "buttonId", 'regist-button' );
    }

    /**
     * 値の登録処理
     * @param  BaseRequest $requestObj [description]
     * @return [type]                  [description]
     */
    public function putCreate( BaseRequest $requestObj ) {
        // 登録画面で入力された値を登録
        $this->dispatch(
            new CreateCommand( $requestObj )
        );
        
        return redirect( action_auto( $this->displayObj->ctl . '@getIndex' ) );
    }
    
    #######################
    ## 編集画面
    #######################

    /**
     * 編集画面を開く時の画面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getEdit( $id ){
        // 拠点モデルオブジェクトを取得
        $baseMObj = Base::findOrFail( $id );

        return view(
            $this->displayObj->tpl . '.input',
            compact(
                'baseMObj'
            )
        )
        ->with( "title", "拠点／編集" )
        ->with( 'displayObj', $this->displayObj )
        ->with( "type", "edit" )
        ->with( "buttonId", 'update-button' );
    }
    
    /**
     * 編集画面で入力された値を登録
     * @param  [type]      $id         [description]
     * @param  BaseRequest $requestObj [description]
     * @return [type]                  [description]
     */
    public function putEdit( $id, BaseRequest $requestObj ) {
        // 編集画面で入力された値を更新
        $this->dispatch(
            new UpdateCommand( $id, $requestObj )
        );

        return redirect( action_auto( $this->displayObj->ctl . '@getSearch' ) );
    }

    #######################
    ## 確認画面
    #######################

    /**
     * 編集画面を開く時の画面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getDetail( $id ){
        // 車種モデルオブジェクトを取得
        $baseMObj = Base::findOrFail( $id );

        return view(
            $this->displayObj->tpl . '.detail',
            compact(
                'baseMObj'
            )
        )
        ->with( "title", "車種／確認" )
        ->with( 'displayObj', $this->displayObj );
    }

    #######################
    ## 削除
    #######################

    /**
     * 編集画面で入力された値を登録
     * @param  [type]      $id         [description]
     * @return [type]                  [description]
     */
    public function getDelete( $id ) {
        // 編集画面で入力された値を更新
        $this->dispatch(
            new DeleteCommand( $id )
        );
        
        return redirect( action_auto( $this->displayObj->ctl . '@getSearch' ) );
    }

}
