<?php

namespace App\Http\Controllers;

use App\Lib\Util\DateUtil;
use App\Original\Codes\RowNumCodes;
use App\Original\Util\SessionUtil;
use App\Http\Requests\SearchRequest;
use App\Models\UserAccount;
use Request;
use Session;

/**
 * 検索画面用初期化処理トレイト
 * 検索処理の関数(検索・ソート)
 *
 * 【概要】
 * getSearchParamsやgetSortParamsを呼ぶと共通となっている
 * 初期化処理を行います。
 * またextendSearchParamsやextendSortParamsをオーバーライドすることで
 * 画面内固有の初期化処理を行うことができます。
 *
 * 【使用方法】
 * useしたクラス内でextendSearchParamsやextendSortParamsを実装してください。
 *
 * 【注意事項】
 * extendSearchParamsでは追加されていきますが、
 * extendSortParamsは名前通り上書きます。
 *
 * 【例】
 *  public function extendSearchParams() {
 *      return ['account_level' => 3, 'base_code' => '01'];
 *  }
 *
 *  public function extendSortParams() {
 *      return ['account_level' => 'asc'];
 *  }
 *
 */
trait tInitSearch {

    protected $search;
    protected $sort;

    #######################
    ## 検索部分のメソッド
    #######################

    /**
     * 検索部分のデフォルト値を指定
     * ※継承先で主に定義
     * @return [type] [description]
     */
    public function extendSearchParams() {
        return array();
    }

    /**
     * 検索部分の値を格納した配列を取得
     */
    public function getSearchParams() {
        // 検索部分の値を格納する配列
        // ※継承先で定義された検索値を取得
        $this->search = $this->extendSearchParams();

        // デフォルトの表示件数を指定
        $this->search['row_num'] = RowNumCodes::getDefault();

        return $this->search;
    }

    #######################
    ## 並び順のメソッド
    #######################

    /**
     * 並び順のデフォルト値を指定
     * ※継承先で主に定義
     * @return [type] [description]
     */
    public function extendSortParams() {
        return array();
    }

    /**
     * @return unknown[]
     */
    public function getSortParams() {
        // 並び順の値を格納する配列
        // ※継承先で定義された検索値を取得
        $customSortLink = $this->extendSortParams();

        // 継承先の並び順を取得
        if( !empty( $customSortLink ) == True ) {
            $this->sort['sort'] = $customSortLink;

        }else{
            // デフォルトの並び順を取得
            $this->sort = $this->initSortValue();
        }

        return $this->sort;
    }

    #######################
    ## 検索用のメソッド
    #######################

    /**
     * カレント日付のYM値をデフォルト選択値とする
     *
     * @return string
     */
    public function selectedYm() {
        return DateUtil::currentYm();
    }

	/**
     * カレント日付をデフォルト選択値とする
     *
     * @return string
     */
    public function selectedYmd() {
        return DateUtil::currentDay();
    }
    
    /**
     *
     */
    public function selectedUserId() {
        // ユーザー情報を取得(セッション)
        $loginAccountObj = SessionUtil::getUser();

        return $loginAccountObj->defaultSelectedUserId();
    }

    /**
     *
     */
    public function selectedBaseCode() {
        // ユーザー情報を取得(セッション)
        $loginAccountObj = SessionUtil::getUser();

        return $loginAccountObj->defaultSelectedBaseCode();
    }

    #######################
    ## 並び替え用のメソッド
    #######################

    /**
     * デフォルトの並び順を取得
     * @param  array  $sortValues [description]
     * @return [type]           [description]
     */
    public function initSortValue( $sortValues = array() ){
        // 並び順を削除(セッション)
        SessionUtil::removeSort();

        // 並び替えのデフォルト値を取得
        if( empty( $sortValues ) == True ){
            $sortValues = ['id' => 'asc'];
        }

        // 並び替え情報を取得
        $sort = ['sort' => $sortValues];

        return $sort;
    }

    /**
     * 並び順を取得(セッション)
     * @return [type] [description]
     */
    public function getSortValue() {
        // 並び順を取得(セッション)
        $sort = SessionUtil::getSort();

        return $sort;
    }

    /**
     * 並び替え情報を登録して取得(セッション)
     * @return [type] [description]
     */
    public static function setSortValue() {
        //
        $sort = array();

        // 検索条件を取得
        $query = Request::query();

        // 並び順のキーと値を指定
        if( isset( $query['sort_key'] ) == True && isset( $query['sort_by'] ) == True ) {
            $sort['sort'][$query['sort_key']] = $query['sort_by'];

        }else{
            // 並び順を取得(セッション)
            $sort = SessionUtil::getSort();

        }

        // 並び順を登録(セッション)
        SessionUtil::putSort( $sort );

        return $sort;
    }

    #######################
    ## Controller method
    #######################

    #######################
    ## indexの処理
    #######################

    /**
    * Index
    * @return デフォルト画面に画面遷移
    */
    public function getIndex() {
        // 検索情報と並び替え情報を削除
        SessionUtil::removeSession();

        // search画面に画面遷移
        return redirect( action_auto( $this->displayObj->ctl . '@getSearch' ) );
    }

    #######################
    ## 一覧画面
    #######################

    /**
     * 一覧画面のデータを表示
     * @param  array $search      [description]
     * @param  array $sort        [description]
     * @param  object $requestObj [description]
     * @return [type]             [description]
     */
    public function showListData( $search, $sort, $requestObj ){
        echo "None output page.";
    }

    /**
     * 検索部分を操作時の処理
     * @param  SearchRequest $requestObj [description]
     * @return [type]                    [description]
     */
    public function getSearch( SearchRequest $requestObj ){
        // 並び順が格納されている配列を取得
        $sort = $this->getSortParams();

        // 検索の値を取得
        $search = $requestObj->all();

        // 検索の値が空の時
        if( empty( $search ) == True ){
            // 検索部分の値を格納した配列を取得
            $search = $this->getSearchParams();

            // リクエストオブジェクトを取得
            $requestObj = SearchRequest::getInstance( $search );

        }

        // 検索値を登録(セッション)
        SessionUtil::putSearch( $search );

        // 並び順を登録(セッション)
        SessionUtil::putSort( $sort );
        // 一覧画面のデータを表示
        return $this->showListData( $search, $sort, $requestObj );
    }

    /**
     * ペジネートの処理
     * @return [type] [description]
     */
    public function getPager() {
        // 検索値を取得(セッション)
        $search = SessionUtil::getSearch();

        // 並び順を取得(セッション)
        $sort = $this->getSortValue();

        // リクエストオブジェクトを取得
        $requestObj = SearchRequest::getInstance( $search );

        // 一覧画面のデータを表示
        return $this->showListData( $search, $sort, $requestObj );
    }

    /**
     * ソートの処理
     * @return [type] [description]
     */
    public function getSort() {
        // 検索値を取得(セッション)
        $search = SessionUtil::getSearch();

        // 並び替え情報を登録して取得(セッション)
        $sort = $this->setSortValue();

        // リクエストオブジェクトを取得
        $requestObj = SearchRequest::getInstance( $search );

        // 一覧画面のデータを表示
        return $this->showListData( $search, $sort, $requestObj );
    }

}
