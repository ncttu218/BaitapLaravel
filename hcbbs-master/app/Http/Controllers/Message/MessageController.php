<?php

namespace App\Http\Controllers\Message;

use App\Models\Message;
use App\Original\Util\SessionUtil;
use App\Http\Requests\MessageRequest;
use App\Http\Controllers\Controller;
use App\Models\Base;
use Request;
use Session;
use DB;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 */
class MessageController extends Controller
{
    /**
     * 拠点指定ありなしのフラグ
     * 
     * @var bool
     */
    private $shopDesignation;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $req = Request::all();

        $this->controller = "Message\MessageController";
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        $this->hanshaCode = $this->loginAccountObj->gethanshaCode(); // 販社コード
        // 販社名の設定パラメータを取得
        $this->para_list = ( Config('original.para')[$this->hanshaCode] );
        
        // 店舗が指定するフラグ
        $this->shopDesignation = $this->para_list['message'] === '2';
        
        $this->shopCode = ( !empty( $req['shop'] ) )? $req['shop'] : ""; // 拠点コード
        $this->page = isset($req['page']) ? (int)$req['page'] : 1;
        $this->tableName = 'tb_' . $this->loginAccountObj->getHanshaCode() . '_message'; // テーブル名
    }

    /**
     * インデックス
     */
    public function getIndex() {

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopDesignation && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 店舗のチェック
        $shopName = null;
        if ($this->shopDesignation) {
            $shopName = Base::where('hansha_code', $this->hanshaCode)
                    ->where('base_code', $this->shopCode)
                    ->value('base_name');

            if ($shopName === null) {
                return 'エラー：店舗が存在しません。';
            }
        }

        // 入力内容のセッションを削除
        Session::forget( 'message.input' );

        // 1行メッセージの拠点選択有の時
        if( $this->shopDesignation ){
            $urlAction = action_auto( $this->controller . '@getIndex' ) . '?shop=' . $this->shopCode ;
        }else{
            $urlAction = action_auto( $this->controller . '@getIndex' );
        }

        $req = Request::all();

        if(isset($req['action'])){
            // ボタン押下、データ並べ替え
            $this->dataSort($this->shopCode);
        }
        
        // 1行メッセージのモデルインスタンス
        $showData = Message::createNewInstance( $this->hanshaCode );
        
        $showData = $showData->where('deleted_at', null )
                ->orderBy('regist', 'desc');
        if ($this->shopDesignation) {
            $showData = $showData->where('shop', $this->shopCode );
        }
        $showData = $showData->paginate( null );

        // タイトル
        $title = "お知らせ 1行メッセージ一覧" . ($shopName !== null ? " {$shopName}" : '');

        return view( 'message.index', 
            compact(
                'title',
                'showData',
                'shopName'
            )
        )
        ->with( 'controller', $this->controller )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'shopDesignation', $this->shopDesignation )
        ->with( 'urlAction', $urlAction );
    }

    /**
     * インデックス
     */
    public function postIndex() {
        $request = Request::all(); // transactionの中に入れる

        foreach ( $request as $key => $val ){
            
            if(strstr($key,'data')){
                if(isset($val['del'])){
                    // テーブル削除
                    $db = DB::table( $this->tableName )->where('number', $key);
                    if ($this->shopDesignation) {
                        $db = $db->where('shop', $request['shop']);
                    }
                    $db->delete();
                }
            }
        };

        // 1行メッセージの拠点選択有の時
        if( $this->shopDesignation ){
            return redirect( action_auto( $this->controller . '@getIndex' ) . '?shop=' . $this->shopCode );
        }else{
            return redirect( action_auto( $this->controller . '@getIndex' ) );
        }
    }

    /**
     * 1行メッセージの登録
     */
    public function getCreate( Request $request ){
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopDesignation && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // 1行メッセージのモデルインスタンス
        $messageObj = Message::createNewInstance( $this->hanshaCode );

        // 入力された値をセッションで取得
        $setValue = Session::get( 'message.input' );
//        dd($setValue);
        if (isset($setValue['type']) && $setValue['type'] != 'create') {
            $setValue = [];
            // 入力された値をセッションを削除する
            Session::forget( 'message.input' );
        }
        // 入力のモード
        $setValue['type'] = 'create';
        // 入力された値をセッションで保持
        Session::put( 'message.input', $setValue );

        // セッションの値が空でないとき
        if( !empty( $setValue ) == True ){
            // セッションからの値をモデルオブジェクトを取得する
            foreach( $setValue as $column => $value ){
                $messageObj->{$column} = $value;
            }
        }
        
        $shopName = Base::getShopName($this->hanshaCode, $this->shopCode);

        return view( 
            'message.input',
            compact( 'messageObj', 'shopName' )
        )
        ->with( 'title', "お知らせ 1行メッセージ" )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'controller', $this->controller )
        ->with( 'para_list', $this->para_list )
        ->with( "type", "create" )
        ->with( 'urlAction',action_auto( $this->controller . '@postConfirm' )); // フォームの送信先
    }

    /**
     * スタッフの編集
     */
    public function getEdit( $id="", $shopCode = "" ){
        
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー：販社コード無しです。</p>";
        }

        // 入力された値をセッションで取得
        $setValue = Session::get( 'message.input' );
        if (isset($setValue['type']) && $setValue['type'] != 'edit') {
            $setValue = [];
            // 入力された値をセッションを削除する
            Session::forget( 'message.input' );
        }
        // 入力のモード
        $setValue['type'] = 'edit';
        // 入力された値をセッションで保持
        Session::put( 'message.input', $setValue );
        
        // 指定したIDのモデルオブジェクトを取得
        $messageObj = Message::createNewInstance( $this->hanshaCode );
        if ($this->shopDesignation) {
            // 別の店舗を変更出来ないように
            $messageObj = $messageObj->where('shop', $shopCode);
        }
        $messageObj = $messageObj->findOrFail( (int)$id );
        
        // 一行メッセージが存在しない場合
        if( $messageObj === null ){
            return "<p>表示エラー：一行メッセージが存在しません。</p>";
        }
        
        if( $this->shopCode === "" ){
            $this->shopCode = $messageObj->shop ?? Session::get( 'message.shop_cpde' );
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopDesignation && $this->shopCode === "" ){
            return "<p>表示エラー：一行メッセージの機能が付いていない販社です。</p>";
        }
        
        // idが空の時
        if( $id === "" ){ 
            // 一覧画面へ戻る
            return redirect( action_auto( $this->controller . '@getIndex' ) . '?shop=' . $this->shopCode );
        }

        // セッションの値が空でないとき
        if( isset($setValue['id']) && $id == $setValue['id'] && !empty( $setValue ) == True ) {
            // セッションからの値をモデルオブジェクトを取得する
            foreach( $setValue as $column => $value ){
                $messageObj->{$column} = $value;
            }
        }
        
        $shopName = Base::getShopName($this->hanshaCode, $shopCode);
        
        return view( 
            'message.input',
            compact( 'messageObj', 'shopName' )
        )
        ->with( 'title', "お知らせ 1行メッセージ" )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'controller', $this->controller )
        ->with( 'para_list', $this->para_list )
        ->with( 'messageId', $messageObj->id )
        ->with( "type", "edit" )
        ->with( 'urlAction',action_auto( $this->controller . '@postConfirm' )); // フォームの送信先
    }

    /**
     * 1行メッセージの確認画面
     */
    public function postConfirm( MessageRequest $request ){
        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopDesignation && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }
        
        // フォーム値
        $setValue = $request->all();
        
        // 1行メッセージのモデルインスタンス
        $messageObj = Message::createNewInstance( $this->hanshaCode );

        // 入力された値をセッションで保持
        Session::put( 'message.input', $setValue );

        // 入力された値をオブジェクトに格納する
        $messageObj = (object)$setValue;
        
        // 削除コマンド？
        $isDeletion = isset( $setValue['erase'] );
        
        // 店舗名
        $shopName = Base::getShopName($this->hanshaCode, $this->shopCode);

        return view( 
            'message.confirm',
            compact( 
                'messageObj',
                'isDeletion',
                'shopName'
            )
        )
        ->with( 'title', "お知らせ 1行メッセージ" )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'para_list', $this->para_list )
        ->with( 'urlAction', action_auto( $this->controller . '@postComp' )); // フォームの送信先
    }

    /**
     * スタッフの完了画面
     */
    public function postComp( Request $request ){

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー: 販社コード無しです。</p>";
        }

        // 入力された値をセッションで取得
        $setValue = Session::get( 'message.input' );

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopDesignation && $setValue['shop'] === "" ){
            return "<p>表示エラー：一行メッセージの機能が付いていない販社です。</p>";
        }

        // リロード等による二重送信防止
        //Session::regenerateToken();
        $req = $request::all();
        
        // 正しくフォームからアクセスされている時に追加処理
        if( isset( $setValue ) == True && $req['comp_flg'] == "True" ){
            
            // 1行メッセージのテーブル
            $messageObj = Message::createNewInstance( $this->hanshaCode, [], true );

            // idの値により、登録処理と変更処理を切り分ける
            if( !empty( $setValue["id"] ) == True ){
                // 指定したIDのモデルオブジェクトを取得
                // 別の店舗が変更出来ないように
                if ($this->shopDesignation) {
                    $messageObj = $messageObj->where('shop', $setValue['shop']);
                }
                $messageObj = $messageObj->findOrFail( $setValue["id"]  );
                // 編集処理
                $messageObj->update( $setValue );
            } else {
                // 店舗のチェック
                // 別の店舗が変更出来ないように
                if ($this->shopDesignation) {
                    $base = Base::where('hansha_code', $this->hanshaCode)
                            ->where('base_code', $setValue['shop'])
                            ->first();
                    if ($base === null) {
                        return 'エラー：店舗が存在しません。';
                    }
                }
                // 新規テーブル
                $row = $messageObj->orderBy('regist', 'DESC');
                if ($this->shopDesignation) {
                    // 別の店舗が変更出来ないように
                    $row = $row->where('shop', $setValue['shop']);
                }
                $row = $row->take(1)
                    ->get();
                // 最大番号計算
                if( count($row) == 0 ){
                    $num = 0;
                }else{
                    $num = intval($row['0']->regist);
                }
                $num++;
                $number = "data" . substr("00000" . strval($num), -6);
                
                // 番号
                $setValue['regist'] = $num;
                // 番号
                $setValue['number'] = $number;
                
                // 登録処理
                $messageObj->create( $setValue );
            }
        }

        // 1行メッセージの拠点選択有の時
        if( $this->shopDesignation ){
            // 一覧画面へ戻る
            $urlAction = action_auto( $this->controller . '@getIndex' ) . '?shop=' . $setValue['shop'] ;
        }else{
            // 一覧画面へ戻る
            $urlAction = action_auto( $this->controller . '@getIndex' );
        }

        return redirect( $urlAction );

    }

    /**
     * スタッフの完了画面
     */
    public function getThanks() {

        // 値が無いときはエラーを出力
        if( $this->hanshaCode === "" ){
            return "<p>表示エラー</p>";
        }

        // 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ）
        if( $this->shopDesignation && $this->shopCode === "" ){
            return "<p>表示エラー</p>";
        }

        // URLのアクション先設定
        if( $this->shopDesignation ){
            $returnUrl = action_auto( $this->controller . '@getIndex' ) . '?shop=' . $this->shopCode;
        }else{
            $returnUrl = action_auto( $this->controller . '@getIndex' );
        }
        
        $setValue = Session::get( 'message.input' );

        // 入力された値をセッションを削除する
        Session::forget( 'message.input' );

        return view( 
            'message.thanks'
        )
        ->with( 'title', "お知らせ 1行メッセージ" )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'shopCode', $this->shopCode )
        ->with( 'returnUrl', $returnUrl );

    }

    #######################
    ## 確認画面
    #######################

    /**
     * 編集画面を開く時の画面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getDetail( $id, $shopCode = null ){
        // 1行メッセージのモデルインスタンス
        $messageObj = Message::createNewInstance( $this->hanshaCode );
        $shopName = Base::getShopName($this->hanshaCode, $shopCode);
        
        // 1行メッセージモデルオブジェクトを取得
        if ($this->shopDesignation) {
            $messageObj = $messageObj->where('shop', $shopCode);
        }
        $messageObj = $messageObj->findOrFail( $id );
        
        return view(
            'message.detail',
            compact(
                'messageObj',
                'shopName'
            )
        )
        ->with( "title", "お知らせ 1行メッセージ" )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'para_list', $this->para_list )
        ->with( 'shopDesignation', $this->shopDesignation )
        ->with( 'controller', $this->controller );
    }

    /**
     * データ並べ替え
     * @return string
     */
    protected function dataSort($shopCode = null){
        DB::transaction(function() use($shopCode) {
            $req = Request::all();
            // 一覧リスト作成
            $list = DB::table( $this->tableName )->select('regist','number');
            if ($this->shopDesignation) {
                $list = $list->where('shop', '=', $shopCode);
            }
            $list = $list->orderBy('regist','DESC')
                ->get();
            $count = count($list);
            $flag = 0;
            
            // 一番下へ移動 または 一つ下へ移動
            if(($req['action'] == 'lowest' || $req['action'] == 'lower' ) and $count > 1){
                for ($i = 0; $i < $count-1; $i++){
                    // 下にずらすスタート位置検索
                    if($req['number'] == $list[$i]->number){
                        $targetNumber = $list[$i]->number;
                        $flag = 1;
                    }
                    if($flag == 1){
                        $number = $list[$i+1]->number;
                        $regist = $list[$i]->regist;
                        DB::table( $this->tableName )->where('number', $number)
                            ->update(['regist' => $regist]);
                        // 一つ下へ移動
                        if($req['action'] == 'lower'){
                            $i++;
                            break;
                        }
                    }
                }
                if($flag == 1){
                    $regist = $list[$i]->regist;
                    DB::table( $this->tableName )->where('number', $targetNumber)
                        ->update(['regist' => $regist]);
                }
            }
            // 一番上へ移動　または 一つ上へ移動
            if(($req['action'] == 'uppest' || $req['action'] == 'upper') and $count > 1){
                for ($i = $count-1; $i > 0; $i--){
                    // 上にずらす位置検索
                    if($req['number'] == $list[$i]->number){
                        $targetNumber = $list[$i]->number;
                        $flag = 1;
                    }
                    // 一つ上のregist
                    $targetRegist = $list[$i-1]->regist;
                    if($flag == 1){
                        // 一つ上のテーブル更新
                        $number = $list[$i-1]->number;
                        $regist = $list[$i]->regist;
                        DB::table( $this->tableName )->where('number', $number)
                            ->update(['regist' => $regist]);
                        // 一つ上へ移動
                        if($req['action'] == 'upper'){
                            $i;
                            break;
                        }
                    }
                }
                if($flag == 1){
                    // ターゲットのテーブル更新
                    $number = $list[$i]->number;
                    DB::table( $this->tableName )->where('number', $targetNumber)
                        ->update(['regist' => $targetRegist]);
                }
            }
        });
    }
}
