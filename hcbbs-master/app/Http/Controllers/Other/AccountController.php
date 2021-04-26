<?php

namespace App\Http\Controllers\Other;

use App\Lib\Util\DateUtil;
use App\Original\Util\SessionUtil;
use App\Commands\Other\Account\ListCommand;
use App\Commands\Other\Account\CreateCommand;
use App\Commands\Other\Account\UpdateCommand;
use App\Commands\Other\Account\DeleteCommand;
use App\Models\UserAccount;
use App\Http\Requests\UserAccountRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tInitSearch;
use App\Http\Requests\SearchRequest;
use Session;
use DB;
use App\Http\Controllers\tCommon;

/**
 * アカウント画面用コントローラー
 *
 * @author yhatsutori
 *
 */
class AccountController extends Controller{
    
    use tInitSearch,tCommon;
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        // 表示部分で使うオブジェクトを作成
        $this->initDisplayObj();

        // 引き継ぎの検索項目は消去
        SessionUtil::removeSearch();
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
        $this->displayObj->page = "account";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "Other\AccountController";
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
        $userId= '';
        $search['user_id'] = $userId;
        return $search;
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
        // オブジェクトを再構築
        $requestObj = SearchRequest::getInstance( $search );
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
        // 全店舗リスト
        $shopAllList = $this->shopAllList();

        return view(
            $this->displayObj->tpl . '.list',
            compact(
                'search',
                'sortTypes',
                'shopAllList',
                'showData'
            )
        )
        ->with( 'displayObj', $this->displayObj )
        ->with( "sortUrl", action_auto( $this->displayObj->ctl . '@getSort' ) )
        ->with( 'title', "アカウント リスト" );
    }
    
    #######################
    ## 追加画面
    #######################

    /**
     * 登録画面を開く時の画面
     * @return [type] [description]
     */
    public function getCreate() {
        $loginAccountObj = SessionUtil::getUser();
        // アカウントモデルオブジェクトを取得
        $userMObj = new UserAccount();
        $shopAllList = $this->shopAllList();
        $shopList = $shopAllList[$loginAccountObj->gethanshaCode()];
        // ログインユーザーレベル
        $loginAccountObj = SessionUtil::getUser();
        $accountLevel =  $loginAccountObj->getAccountLevel();

        return view(
            $this->displayObj->tpl . '.input',
            compact(
                'userMObj',
                'shopList',
                'accountLevel'
            )
        )
        ->with( "title", "アカウント／登録" )
        ->with( 'displayObj', $this->displayObj )
        ->with( "type", "create" )
        ->with( "buttonId", 'regist-button' );
    }

    /**
     * 値の登録処理
     * @param  UserAccountRequest $requestObj [description]
     * @return [type]                  [description]
     */
    public function putCreate( UserAccountRequest $requestObj ) {
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
        // アカウントモデルオブジェクトを取得
        $userMObj = UserAccount::findOrFail( $id );
        $shopList = $this->shopList($userMObj->hansha_code);
        // ログインユーザーレベル
        $loginAccountObj = SessionUtil::getUser();
        $accountLevel =  $loginAccountObj->getAccountLevel();
        return view(
            $this->displayObj->tpl . '.input',
            compact(
                'userMObj','shopList','accountLevel'
            )
        )
        ->with( "title", "アカウント／編集" )
        ->with( 'displayObj', $this->displayObj )
        ->with( "type", "edit" )
        ->with( "buttonId", 'update-button' );
    }
    
    /**
     * 編集画面で入力された値を登録
     * @param  [type]      $id         [description]
     * @param  UserAccountRequest $requestObj [description]
     * @return [type]                  [description]
     */
    public function putEdit( $id, UserAccountRequest $requestObj ) {
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
        // アカウントモデルオブジェクトを取得
        $userMObj = UserAccount::findOrFail( $id );
        $shopList = $this->shopList($userMObj->hansha_code);
        $shop_name = $shopList[$userMObj->shop];
        
        return view(
            $this->displayObj->tpl . '.detail',
            compact(
                'userMObj'
                ,'shop_name'
            )
        )
        ->with( "title", "アカウント／確認" )
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
