<?php

namespace App\Http\Controllers\Other;

use App\Lib\Util\DateUtil;
use App\Original\Util\SessionUtil;
use App\Models\EmailSettings;
use App\Commands\Other\EmailSettings\ListCommand;
use App\Commands\Other\EmailSettings\CreateCommand;
use App\Commands\Other\EmailSettings\UpdateCommand;
use App\Commands\Other\EmailSettings\DeleteCommand;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\EmailSettingsRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tInitSearch;
use App\Original\Codes\MailPostTypeCodes;
use Request;
use Session;
use DB;

/**
 * 投稿アドレス画面用コントローラー
 *
 * @author yhatsutori
 *
 */
class EmailSettingsController  extends Controller{
    
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
        $this->displayObj->page = "email_settings";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "Other\EmailSettingsController";
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
            'hansha_code' => 'asc', /// 販社コード
            'shop_code' => 'asc', // 拠点コード
            'system_name' => 'asc', // システム名
            'staff_code' => 'asc' // スタッフコード
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
        
        // メール投稿の種類
        $systemName = $requestObj->system_name ?? (new MailPostTypeCodes())->getDefault();

        // 表示データを取得
        $showData = $this->dispatch(
            new ListCommand(
                $sort,
                $systemName,
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
                'showData',
                'systemName'
            )
        )
        ->with( 'displayObj', $this->displayObj )
        ->with( "sortUrl", action_auto( $this->displayObj->ctl . '@getSort' ) )
        ->with( 'title', "投稿アドレス リスト" );
    }

    #######################
    ## 追加画面
    #######################

    /**
     * 登録画面を開く時の画面
     * @return [type] [description]
     */
    public function getCreate($systemName, Request $request) {
        // 投稿アドレスモデルオブジェクトを取得
        $emailSettingsMObj = new EmailSettings();
        $emailSettingsMObj->system_name = $systemName;
        
        // メール投稿の種類
        $mailPostType = (new MailPostTypeCodes())->getValue($systemName);
        if ($mailPostType === null) {
            return 'エラー';
        }
        
        // システム名
        $systemNameText = (new MailPostTypeCodes())->getValue($systemName);

        return view(
            $this->displayObj->tpl . '.input',
            compact(
                'emailSettingsMObj',
                'mailPostType',
                'systemNameText'
            )
        )
        ->with( "title", "投稿アドレス／登録" )
        ->with( 'displayObj', $this->displayObj )
        ->with( "type", "create" )
        ->with( "buttonId", 'regist-button' );
    }

    /**
     * 値の登録処理
     * @param  EmailSettingsRequest $requestObj [description]
     * @return [type]                  [description]
     */
    public function putCreate( EmailSettingsRequest $requestObj ) {
        // 登録画面で入力された値を登録
        $this->dispatch(
            new CreateCommand( $requestObj )
        );
        
        return redirect( action_auto( $this->displayObj->ctl . '@getSearch') . '?system_name=' . $requestObj->system_name );
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
        
        $request = Request::all();
        
        // 投稿アドレスモデルオブジェクトを取得
        $emailSettingsMObj = EmailSettings::findOrFail( $id );
        
        // システム名
        $systemNameText = (new MailPostTypeCodes())->getValue($request['system_name']);

        return view(
            $this->displayObj->tpl . '.input',
            compact(
                'emailSettingsMObj',
                'systemNameText'
            )
        )
        ->with( "title", "投稿アドレス／編集" )
        ->with( 'displayObj', $this->displayObj )
        ->with( "type", "edit" )
        ->with( "buttonId", 'update-button' );
    }
    
    /**
     * 編集画面で入力された値を登録
     * @param  [type]      $id         [description]
     * @param  EmailSettingsRequest $requestObj [description]
     * @return [type]                  [description]
     */
    public function putEdit( $id, EmailSettingsRequest $requestObj ) {
        // 編集画面で入力された値を更新
        $this->dispatch(
            new UpdateCommand( $id, $requestObj )
        );

        return redirect( action_auto( $this->displayObj->ctl . '@getSearch' ) . '?system_name=' . $requestObj->system_name );
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
        $request = Request::all();
        // 車種モデルオブジェクトを取得
        $emailSettingsMObj = EmailSettings::where('system_name', $request['system_name'])
                ->findOrFail( $id );
        
        // システム名
        $systemName = (new MailPostTypeCodes())->getValue($request['system_name']);

        return view(
            $this->displayObj->tpl . '.detail',
            compact(
                'emailSettingsMObj',
                'systemName'
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
        $request = Request::all();
        
        // 編集画面で入力された値を更新
        $this->dispatch(
            new DeleteCommand( $id )
        );
        
        return redirect( action_auto( $this->displayObj->ctl . '@getSearch' ) . '?system_name=' . $request['system_name'] );
    }

}
