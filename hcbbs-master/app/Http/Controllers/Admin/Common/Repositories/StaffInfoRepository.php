<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Http\Requests\StaffInfoRequest;
use App\Models\StaffInfo;
use App\Original\Codes\StaffDepartmentCodes;
use App\Original\Util\ImageUtil;
use App\Original\Util\SessionUtil;
use Request;
use Session;

/**
 * Description of CommonStaffInfoRepository
 *
 * @author ahmad
 */
trait StaffInfoRepository {
    
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
     * 役職のデータのスタイル
     * 
     * @var int
     */
    protected $staffPopulationStyle;


    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();
        
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        // 販社コード
        $this->hanshaCode = $this->loginAccountObj->gethanshaCode();
        $this->controller = "Admin\Common\Controllers\StaffInfoController";
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        $this->page = isset($req['page']) ? (int)$req['page'] : 1;

        // テーブルのタイプ
        $this->tableType = 'staff';
        
        // スタッフデータのスタイル
        $this->staffPopulationStyle = StaffDepartmentCodes::DEPARTMENT_POPULATION_DEFAULT;
    }

    /**
     * スタッフ一覧の表示
     */
    public function getList() {
        
        // セッションのクリア
        if (Session::has( 'staffInfo.input' )) {
            Session::forget( 'staffInfo.input' );
        }
        
        // スタッフ紹介のモデルインスタンス
        $staffInfoObj = StaffInfo::createNewInstance( $this->hanshaCode );
        
        $list = $staffInfoObj->where( 'shop', '=', $this->shopCode )
                ->where('deleted_at', null )
                ->orderBy( 'grade' )
                ->paginate(null);

        if( $this->hanshaCode === "" && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }

        // セッションに保持
        Session::put( 'staffInfo.shop_cpde', $this->shopCode );
        // 役職コード
        $code = new StaffDepartmentCodes($this->staffPopulationStyle);
        $departmentCodes = $code->getOptions();
        
        return view( 
                'api.common.admin.staffinfo.list', 
                compact( 'list', 'departmentCodes' ) 
            )
            ->with( 'controller', $this->controller )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopCode', $this->shopCode )
            ->with( 'urlAction', action_auto( $this->controller . '@postBulkAction' ) . '?shop=' . $this->shopCode ); // フォームの送信先
    }

    /**
     * スタッフの登録
     */
    public function getCreate( Request $request ){
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // スタッフ紹介のモデルインスタンス
        $staffInfoObj = StaffInfo::createNewInstance( $this->hanshaCode );

        // 入力された値をセッションで取得
        $setValue = Session::get( 'staffInfo.input' );

        // セッションの値が空でないとき
        if( !empty( $setValue ) == True ){
            // セッションからの値をモデルオブジェクトを取得する
            foreach( $setValue as $column => $value ){
                $staffInfoObj->{$column} = $value;
            }
        }
        
        // 役職のリスト
        $departmentCode = new StaffDepartmentCodes($this->staffPopulationStyle);
        $departmentList = $departmentCode->getOptions();

        return view( 
            'api.common.admin.staffinfo.input',
            compact( 'staffInfoObj', 'departmentList' )
        )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode )
        ->with( "type", "create" )
        ->with( 'urlAction',action_auto( $this->controller . '@postConfirm' )); // フォームの送信先
    }

    /**
     * スタッフの編集
     */
    public function getEdit( $id="" ){
        
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        if( $this->shopCode === "" ){
            $this->shopCode = Session::get( 'staffInfo.shop_cpde' );
        }
        
        // idが空の時
        if( $id === "" ){ 
            // 一覧画面へ戻る
            return redirect( action_auto( $this->controller . '@getList' ) . '?shop=' . $this->shopCode );
        }

        
        // 指定したIDのモデルオブジェクトを取得
        $staffInfoObj = StaffInfo::createNewInstance( $this->hanshaCode );
        $staffInfoObj = $staffInfoObj->findOrFail( (int)$id );

        // 入力された値をセッションで取得
        $setValue = Session::get( 'staffInfo.input' );

        // セッションの値が空でないとき
        if( $id == $setValue['id'] && !empty( $setValue ) == True ) {
            // セッションからの値をモデルオブジェクトを取得する
            foreach( $setValue as $column => $value ){
                $staffInfoObj->{$column} = $value;
            }
        }
        
        // 役職のリスト
        $departmentCode = new StaffDepartmentCodes($this->staffPopulationStyle);
        $departmentList = $departmentCode->getOptions();
        
        return view( 
                'api.common.admin.staffinfo.input',
                compact( 'staffInfoObj', 'departmentList' )
            )
            ->with( 'hanshaCode', $this->hanshaCode )
            ->with( 'shopCode', $this->shopCode )
            ->with( "type", "edit" )
            ->with( 'urlAction',action_auto( $this->controller . '@postConfirm' )); // フォームの送信先
    }

    /**
     * スタッフの確認画面
     */
    public function postConfirm( StaffInfoRequest $request ){

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // フォーム値
        $setValue = $request->all();
        
        // キャンセル
        if ( isset( $setValue['cancel'] ) ) {
            // 一覧画面へ戻る
            return redirect( action_auto( $this->controller . '@getList' ) . '?shop=' . $this->shopCode );
        }
        
        // スタッフ紹介のモデルインスタンス
        $staffInfoObj = StaffInfo::createNewInstance( $this->hanshaCode );

        // 画像取得
        if( isset( $setValue['photo'] ) ){
            $fileName = ImageUtil::makeImage( 'photo', 0, $this->hanshaCode, $this->tableType );
            $setValue['photo'] = $fileName;
        } else if ( isset( $setValue['id'] ) ) { // IDが存在する？
            $info = $staffInfoObj
                    ->select('photo')
                    ->findOrFail( $setValue["id"]  );
            if (!empty( $info )) {
                $setValue['photo'] = $info->photo;
            }
        }

        // 入力された値をセッションで保持
        Session::put( 'staffInfo.input', $setValue );

        // 入力された値をオブジェクトに格納する
        $staffInfoObj = (object)$setValue;
        
        // 削除コマンド？
        $isDeletion = isset( $setValue['erase'] );

        return view( 
            'api.common.admin.staffinfo.confirm',
            compact( 
                'staffInfoObj',
                'isDeletion'
            )
        )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'urlAction', action_auto( $this->controller . '@postComp' )); // フォームの送信先
    }

    /**
     * 一括更新・削除
     * 
     * @param object $request
     */
    public function postBulkAction() {
        // リクエスト
        $request = Request::all();
        
        // モデル
        $staffInfoObj = StaffInfo::createNewInstance( $this->hanshaCode );
        
        // 削除選択肢が選択された？
        if (isset( $request['ListDelete'] )) {
            foreach ( $request['ListDelete'] as $key ) {
                // IDチェック
                if (!strstr($key,'data')) {
                    continue;
                }
                
                // レコード削除
                $staffInfoObj->where('number', $key)
                    ->delete();
            }
        }
        
        // グレードを更新
        foreach ( $request['AdminEdit'] as $number => $grade ) {
            // レコード更新
            $staffInfoObj->where('number', $number)
                    ->update([ 'grade' => $grade ]);
        }
        
        // リダイレクト
        return redirect( action_auto( $this->controller . '@getList' ) . '?shop=' . $this->shopCode );
    }

    /**
     * スタッフの完了画面
     */
    public function postComp( Request $request ){

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // リロード等による二重送信防止
        //Session::regenerateToken();
        $req = $request::all();

        // 入力された値をセッションで取得
        $setValue = Session::get( 'staffInfo.input' );
        // 正しくフォームからアクセスされている時に追加処理
        if( isset( $setValue ) == True && $req['comp_flg'] == "True" ){
            
            // スタッフブログのテーブル
            $staffInfoObj = StaffInfo::createNewInstance( $this->hanshaCode, [], true );
            
            // 削除コマンド？
            if ( isset( $req['erase'] ) ) {
                // レコード削除
                $staffInfoObj->where('number', $setValue['number'])
                    ->delete();
                
                // 完了画面へリダイレクト
                return redirect( action_auto( $this->controller . '@getThanks' ) . '?shop=' . $setValue['shop'] );
            }

            // idの値により、登録処理と変更処理を切り分ける
            if( !empty( $setValue["id"] ) == True ){
                // 指定したIDのモデルオブジェクトを取得
                $staffInfoObj = $staffInfoObj->findOrFail( $setValue["id"]  );
                // 編集処理
                $staffInfoObj->update( $setValue );
            } else {
                // 新規テーブル
                $row = $staffInfoObj->orderBy('number', 'DESC')
                    ->take(1)
                    ->get();
                // 最大番号計算
                if( count($row) == 0 ){
                    $num = 0;
                }else{
                    $num = intval(substr($row['0']->number, 4));
                }
                $num++;
                $number = "data" . substr("00000" . strval($num), -6);
                
                // 番号
                $setValue['number'] = $number;
                
                // Your Eloquent query
                $staffInfoObj->create( $setValue );
            }
            
            // 完了画面へリダイレクト
            return redirect( action_auto( $this->controller . '@getThanks' ) . '?shop=' . $setValue['shop'] );
        }else{
            // 一覧画面へ戻る
            return redirect( action_auto( $this->controller . '@getList' ) . '?shop=' . $setValue['shop'] );
        }

    }

    /**
     * スタッフの完了画面
     */
    public function getThanks() {

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        $setValue = Session::get( 'staffInfo.input' );

        // 入力された値をセッションを削除する
        Session::forget( 'staffInfo.input' );
        
        // 削除コマンド？
        $isDeletion = isset( $setValue['erase'] );

        return view( 
            'api.common.admin.staffinfo.thanks'
        )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'isDeletion', $isDeletion )
        ->with( 'returnUrl', action_auto( $this->controller . '@getList' ) . '?shop=' . $this->shopCode );
    }
    
}
