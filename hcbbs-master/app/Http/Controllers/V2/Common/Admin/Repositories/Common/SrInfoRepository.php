<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V2\Common\Admin\Repositories\Common;

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

        $this->controller = "V2\_6251802\Admin\SrInfoController";
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
        
        // 拠点名
        $shopList = SessionUtil::getShopList();
        $shopName = '';
        if (isset($shopList[$this->shopCode])) {
            $shopName = $shopList[$this->shopCode];
        }

        return view( 'api.common.admin.srinfo.index', 
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

        return view( 'api.common.admin.srinfo.input', 
                compact( 'srInfoObj',
                    'shopName'
                )
            )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'urlAction',action_auto( $this->controller . '@postEdit' )); // フォームの送信先;
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
    
}
