<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Http\Requests\ShowroomInfoRequest;
use App\Models\SrInfo;
use App\Original\Util\ImageUtil;
use App\Original\Util\SessionUtil;
use Request;
use Session;

/**
 * Description of SrInfoRepository
 *
 * @author ahmad
 */
trait SrInfoRepository {
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();

        $this->controller = "Admin\Common\Controllers\SrInfoController";
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        $this->hanshaCode = $this->loginAccountObj->gethanshaCode(); // 販社コード
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        $this->page = isset($req['page']) ? (int)$req['page'] : 1;
        $this->tableType = 'shop';
    }

    /**
     * インデックス
     */
    public function getIndex() {
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // セッションから拠点コード
        if (empty( $this->shopCode ) && Session::has('srInfo.shop_code')) {
            $this->shopCode = Session::get('srInfo.shop_code');
        } else {
            // セッションに保持
            Session::put( 'srInfo.shop_code', $this->shopCode );
        }
        
        // スタッフ紹介集合写真・拠点コメント入力のモデルインスタンス
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        $srInfoObj = $srInfoObj->where( 'shop', '=', $this->shopCode )
                ->where('deleted_at', null )
                ->get();
        // データがない場合
        if( $srInfoObj->count() == 0 ){
            return "<p>表示エラー</p>";
        }
        $srInfoObj = $srInfoObj[0];

        // セッションに保体
        $this->loadToSession($srInfoObj);
        
        // 拠点名
        $shopList = SessionUtil::getShopList();
        $shopName = '';
        if (isset($shopList[$this->shopCode])) {
            $shopName = $shopList[$this->shopCode];
        }
        
        // ビュー名
        $viewName = "api.{$this->hanshaCode}.admin.srinfo.index";
        if (!view()->exists($viewName)) {
            $viewName = 'api.common.admin.srinfo.index';
        }

        return view( $viewName, 
                compact(
                    'srInfoObj',
                    'shopName'
                )
            )
            ->with( 'controller', $this->controller )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'hanshaCode', $this->hanshaCode );
    }

    /**
     * スタッフの登録
     */
    public function getEdit( Request $request ){

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // セッションに保持
        $shopCode = Session::get( 'srInfo.shop_code');
        
        // スタッフ紹介集合写真・拠点コメント入力のモデルインスタンス
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        $srInfoObj = $srInfoObj->where( 'shop', '=', $shopCode )
                ->where('deleted_at', null )
                ->get();
        // データがない場合
        if( $srInfoObj->count() == 0 ){
            return "<p>表示エラー</p>";
        }
        $srInfoObj = $srInfoObj[0];
        
        // 拠点名
        $shopList = SessionUtil::getShopList();
        $shopName = '';
        if (isset($shopList[$shopCode])) {
            $shopName = $shopList[$shopCode];
        }

        // 動作
        $urlAction = action_auto( $this->controller . '@postEdit' );
        if ($this->hanshaCode == '1351901') { // 埼玉様のみ
            $urlAction = action_auto( $this->controller . '@postConfirm' );
        }

        // データ
        if (!Session::has( 'srInfo.data')) {
            // セッションに保体
            $this->loadToSession($srInfoObj);
        }
        // セッションからデータを読み込む
        $sessionData = Session::get( 'srInfo.data');
        $data = [
            'id' => $srInfoObj->id,
            'comment' => $sessionData['comment'] ?? '',
            'mastername' => $sessionData['mastername'] ?? '',
            'file_master' => $sessionData['file_master'],
        ];
        
        // ビュー名
        $viewName = "api.{$this->hanshaCode}.admin.srinfo.input";
        if (!view()->exists($viewName)) {
            $viewName = 'api.common.admin.srinfo.input';
        }

        return view( $viewName, 
                compact(
                    'srInfoObj',
                    'shopName',
                    'data'
                )
            )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'urlAction', $urlAction); // フォームの送信先;
    }

    /**
     * データベースからのデータをセッションに保持する
     * 
     * @param object $obj オブジェクト
     * @return void
     */
    private function loadToSession($obj) {
        $data = [
            'id' => $obj->id,
            'shop' => $obj->shop,
            'comment' => $obj->comment,
            'file' => $obj->file,
            'mastername' => $obj->mastername,
            'file_master' => $obj->file_master,
            'shop' => $obj->shop,
        ];
        // セッションに保持
        Session::put( 'srInfo.data', $data );
    }

    /**
     * スタッフの登録
     */
    public function postEdit( ShowroomInfoRequest $request ){
        // スタッフ紹介のモデルインスタンス
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        
        // 入力された値をセッションで取得
        $req = $request->all();
        
        // 画像取得
        if( isset( $req['file'] ) ){
            $fileName = ImageUtil::makeImage( 'file', 0, $this->hanshaCode, $this->tableType );
        } else if ( isset( $req['id'] ) ) { // IDが存在する？
            $info = $srInfoObj
                    ->select('file')
                    ->findOrFail( $req["id"]  );
            if (!empty( $info )) {
                $fileName = $info->file;
            }
        }
        
        $setValue = [
            'comment' => $req['comment'],
            'file' => $fileName,
        ];
        
        // 指定したIDのモデルオブジェクトを取得
        $srInfoObj = $srInfoObj->findOrFail( $req['id']  );
        // 編集処理
        $srInfoObj->update( $setValue );

        $this->shopCode = null;
        if (Session::has('srInfo.shop_code')) {
            $this->shopCode = Session::get('srInfo.shop_code');
        }
        
        // 一覧画面へ戻る
        return redirect( action_auto( $this->controller . '@getIndex', ['shop' => $this->shopCode] ) );
    }
    
    /**
     * スタッフの確認画面
     */
    public function postConfirm() {

        // リクエスト
        $req = Request::all();

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ) {
            return "<p>表示エラー</p>";
        }
        
        // セッションに保持
        $shopCode = Session::get( 'srInfo.shop_code');
        
        // スタッフ紹介集合写真・拠点コメント入力のモデルインスタンス
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        $srInfoObj = $srInfoObj->where( 'shop', '=', $shopCode )
                ->where('deleted_at', null)
                ->get();
        // データがない場合
        if( $srInfoObj->count() == 0 ){
            return "<p>表示エラー</p>";
        }
        $srInfoObj = $srInfoObj[0];
        
        // 拠点名
        $shopList = SessionUtil::getShopList();
        $shopName = '';
        if (isset($shopList[$shopCode])) {
            $shopName = $shopList[$shopCode];
        }

        // データ
        $data = [
            'comment' => $req['comment'] ?? '',
            'mastername' => $req['mastername'] ?? '',
            'shop' => $srInfoObj->shop,
            'id' => $srInfoObj->id,
        ];
        
        // 店長写真
        $fileName = '';
        if (isset($req['file_del'])) {
            $fileName = '';
        } else if (isset( $req['file_master'] ) && !empty($req['file_master'])) {
            $fileName = ImageUtil::makeImage( 'file_master', 0, $this->hanshaCode, $this->tableType );
        } else if ( isset( $req['id'] ) ) { // IDが存在する？
            $info = $srInfoObj
                    ->select('file_master')
                    ->findOrFail( $req["id"]  );
            if (!empty( $info )) {
                $fileName = $info->file_master;
            }
        }
        $data['file_master'] = $fileName;
        // セッションに保持
        Session::put( 'srInfo.data', $data );

        // 動作
        $urlAction = action_auto( $this->controller . '@postComplete' );
        
        // ビュー名
        $viewName = "api.{$this->hanshaCode}.admin.srinfo.confirm";
        if (!view()->exists($viewName)) {
            $viewName = 'api.common.admin.srinfo.confirm';
        }

        return view( $viewName, 
            compact(
                'data',
                'shopName'
            )
        )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'urlAction', $urlAction); // フォームの送信先
    }
    
    /**
     * スタッフの完了画面
     */
    public function postComplete() {

        // リクエスト
        $req = Request::all();

        // セッションに保持
        $shopCode = Session::get( 'srInfo.shop_code');
        
        // 修正する場合、リダイレクト
        if (isset($req['edit'])) {
            // セッションに保持
            Session::put( 'srInfo.data', $req );
            // リダイレクト
            return redirect(action_auto($this->controller . '@getEdit'));
        }

        if( !isset($req['id']) ){
            return "<p>表示エラー</p>";
        }

        // データ
        $setValue = [
            'comment' => $req['comment'],
            'file_master' => $req['file_master'],
            'mastername' => $req['mastername'],
        ];
        
        // スタッフ紹介集合写真・拠点コメント入力のモデルインスタンス
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        // 指定したIDのモデルオブジェクトを取得
        $srInfoObj = $srInfoObj->findOrFail( $req['id']  );
        if( $srInfoObj->count() == 0 ){
            return "<p>表示エラー</p>";
        }

        // 編集処理
        $srInfoObj->update( $setValue );

        // 動作
        $urlAction = action_auto( $this->controller . '@getIndex', ['id' => $req['id']] );
        
        // ビュー名
        /*$viewName = "api.{$this->hanshaCode}.admin.srinfo.complete";
        if (!view()->exists($viewName)) {
            $viewName = 'api.common.admin.srinfo.complete';
        }

        return view( $viewName )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'urlAction', $urlAction); // フォームの送信先*/

        return redirect($urlAction);
    }
    
}
