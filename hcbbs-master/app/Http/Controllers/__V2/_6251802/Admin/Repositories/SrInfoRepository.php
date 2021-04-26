<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V2\_6251802\Admin\Repositories;

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
     * ログイン情報
     * 
     * @var object
     */
    protected $loginAccountObj;
    
    /**
     * 販社コード
     * 
     * @var string
     */
    protected $hanshaCode;
    
    /**
     * コントローラー名
     * 
     * @var string
     */
    protected $controller;
    
    /**
     * 店舗コード
     * 
     * @var string
     */
    protected $shopCode;
    
    /**
     * 店舗名
     * 
     * @var string
     */
    protected $shopName;
    
    /**
     * ページネーション
     * 
     * @var int
     */
    protected $page;
    
    /**
     * テーブルのタイプ
     * 
     * @var string 
     */
    protected $tableType;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();

        $this->controller = "V2\_6251802\Admin\SrInfoController";
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        $this->hanshaCode = $this->loginAccountObj->gethanshaCode(); // 販社コード
        // 販社名
        $this->hanshaName = config('original.hansha_code')[$this->hanshaCode];
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        
        $this->page = isset($req['page']) ? (int)$req['page'] : 1;
        $this->tableType = 'shop';
        
        // セッションから拠点コード
        if (empty( $this->shopCode ) && Session::has('srInfo.shop_code')) {
            $this->shopCode = Session::get('srInfo.shop_code');
        } else {
            // セッションに保持
            Session::put( 'srInfo.shop_code', $this->shopCode );
        }
        
        // 拠点名
        $shopList = SessionUtil::getShopList();
        if (isset($shopList[$this->shopCode])) {
            $this->shopName = $shopList[$this->shopCode];
        }
    }

    /**
     * インデックス
     */
    public function getIndex() {
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
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

        return view( 'api.common.admin.srinfo.responsive.list', 
                compact(
                    'srInfoObj'
                )
            )
            ->with( 'controller', $this->controller )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'shopName', $this->shopName )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'hanshaName', $this->hanshaName );
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

        return view( 'api.common.admin.srinfo.responsive.input', 
                compact( 'srInfoObj'
                )
            )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'hanshaName', $this->hanshaName )
            ->with( 'shopName', $this->shopName )
            ->with( 'urlAction', action_auto( $this->controller . '@postConfirm' )) // フォームの送信先;
            ->with( 'urlActionList', action_auto( $this->controller . '@getIndex' ) . "?shop={$this->shopCode}");
    }

    /**
     * スタッフの登録
     */
    public function postEdit() {
        // スタッフ紹介のモデルインスタンス
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );
        
        // 入力された値をセッションで取得
        $req = Request::all();
        
        // 削除選択肢が選択された？
        if (isset( $req['ListDelete'] )) {
            foreach ( $req['ListDelete'] as $key ) {
                // IDチェック
                if (!strstr($key,'data')) {
                    continue;
                }
                
                // レコード削除
                $staffInfoObj->where('number', $key)
                    ->delete();
            }
        }

        // 入力された値をセッションで取得
        $setValue = Session::get( 'srInfo.input' );
        
        // 指定したIDのモデルオブジェクトを取得
        $srInfoObj = $srInfoObj->findOrFail( $setValue['id']  );
        // 編集処理
        $srInfoObj->update( $setValue );

        $this->shopCode = null;
        if (Session::has('srInfo.shop_code')) {
            $this->shopCode = Session::get('srInfo.shop_code');
        }
        
        // 一覧画面へ戻る
        return redirect( action_auto( $this->controller . '@getThanks', ['shop' => $this->shopCode] ) );
    }

    /**
     * スタッフの確認画面
     */
    public function postConfirm( ShowroomInfoRequest $request ){

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // フォーム値
        $setValue = $request->all();
        
        // キャンセル
        if ( isset( $setValue['cancel'] ) ) {
            // 一覧画面へ戻る
            return redirect( action_auto( $this->controller . '@getIndex' ) . '?shop=' . $this->shopCode );
        }
        
        // スタッフ紹介のモデルインスタンス
        $srInfoObj = SrInfo::createNewInstance( $this->hanshaCode );

        // 画像取得
        if( isset( $setValue['file'] ) ) {
            //$fileName = ImageUtil::makeImage( 'file', 0, $this->hanshaCode, $this->tableType );
            $fileName = ImageUtil::makeImage( 'file', 0, $this->hanshaCode,
                    $this->tableType, '', 1500);
            $setValue['file'] = $fileName;
        } else if ( isset( $setValue['id'] ) ) { // IDが存在する？
            $info = $srInfoObj
                    ->select('file')
                    ->findOrFail( $setValue["id"]  );
            if (!empty( $info )) {
                $setValue['file'] = $info->file;
            }
        }

        // 入力された値をセッションで保持
        Session::put( 'srInfo.input', $setValue );

        // 入力された値をオブジェクトに格納する
        $srInfoObj = (object)$setValue;
        
        // 削除コマンド？
        $isDeletion = isset( $setValue['erase'] );
        
        // ビュー名
        $viewName = 'api.common.admin.srinfo.responsive.confirm';

        return view( 
            $viewName,
            compact( 
                'srInfoObj',
                'isDeletion'
            )
        )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'hanshaName', $this->hanshaName )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'shopName', $this->shopName )
        ->with( 'urlAction', action_auto( $this->controller . '@postEdit' )); // フォームの送信先
    }

    /**
     * スタッフの完了画面
     */
    public function getThanks() {

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        $setValue = Session::get( 'srInfo.input' );

        // 入力された値をセッションを削除する
        Session::forget( 'srInfo.input' );
        
        // 削除コマンド？
        $isDeletion = isset( $setValue['erase'] );
        
        // ビュー名
        $viewName = 'api.common.admin.srinfo.responsive.thanks';

        return view( 
            $viewName
        )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'hanshaName', $this->hanshaName )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'shopName', $this->shopName )
        ->with( 'isDeletion', $isDeletion )
        ->with( 'returnUrl', action_auto( $this->controller . '@getIndex' ) . '?shop=' . $this->shopCode );
    }
    
}
