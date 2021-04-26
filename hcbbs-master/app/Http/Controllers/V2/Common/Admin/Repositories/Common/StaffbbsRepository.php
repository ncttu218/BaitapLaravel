<?php

namespace App\Http\Controllers\V2\Common\Admin\Repositories\Common;

use App\Lib\Util\DateUtil;
use App\Models\Base;
use App\Models\Staffbbs;
use App\Original\Util\ImageUtil;
use App\Original\Util\SessionUtil;
use App\Http\Requests\StaffRequest;
use App\Http\Controllers\tCommon;
use App\Http\Controllers\tSendMail;
use Request;
use Session;
use DB;
use Image;
use Validator;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
trait StaffbbsRepository
{
    
    use tCommon, tSendMail;
    
    /**
     * テーブル番号
     * 
     * @var int
     */
    private $tableNo;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        // 販社コード
        $this->hanshaCode = $this->loginAccountObj->getHanshaCode();
        // セッションのシステム名
        SessionUtil::setSystemName( '_staffbbs' );
        // テーブル名をセッションに保存(販社コードがテーブル名)
        SessionUtil::putTableName('tb_' . $this->hanshaCode . '_staff');
        
        // 1ページの表示数をセッションに保存
        $para = Config('original.para')[$this->loginAccountObj->getHanshaCode()];
        SessionUtil::putPageNum($para['page_num']);
        // 店舗リストをセッションに保存
        SessionUtil::putShopList($this->shopList($this->loginAccountObj->gethanshaCode()));
        
        $this->controller = "V2\_{$this->hanshaCode}\Admin\StaffbbsController";
        // テンプレートNo
        $this->templateNo = '1351100';
        // カテゴリー
        $para = Config('original.para')[$this->loginAccountObj->getHanshaCode()];
        $categories = [];
        if($para['category']){
            foreach (explode(',', $para['category']) as $category) {
                $categories[] = trim($category);
            }
        }
        $this->category = $categories;
        // テーブル番号
        $this->tableNo = $this->loginAccountObj->gethanshaCode();

        // テーブルのタイプ
        $this->tableType = 'staff';
    }

    #############################
    ## スタッフ一覧・編集画面
    #############################

    /**
     * 一覧表示
     * @return string
     */
    public function getIndex()
    {
        $req = Request::all();

        if(isset($req) && isset($req['shop'])){
            // 初期表示
            SessionUtil::putShop($req['shop']); // 店舗No
            
            // 店舗名取得
            $hansha_code =  $this->loginAccountObj->gethanshaCode();
            $shopList = $this->shopList($hansha_code);
            foreach ($shopList as $shop => $name){
                if($shop == SessionUtil::getShop()){
                    SessionUtil::putName($name); // 店舗名
                    break;
                }
            }
        }
        if(isset($req) && isset($req['action'])){
            // ボタン、リンク
            if($req['action'] == 'edit'){
                $this->initData( 'blog' );

                $number = $req['number'];
                $row = DB::table(SessionUtil::getTableName())
                    ->where('number', '=', $number)->get();
                // セッションに保存
                SessionUtil::putNumber($number);
 
                $data = array();
                // 更新画面項目（DBから全項目取得）
                $data['number'] = $row[0]->number;
                $data['title'] = $row[0]->title;
                $data['comment'] = $row[0]->comment;
                $data['file'] = $row[0]->file;
                $data['file2'] = $row[0]->file2;
                $data['file3'] = $row[0]->file3;
                $data['caption'] = $row[0]->caption;
                $data['caption2'] = $row[0]->caption2;
                $data['caption3'] = $row[0]->caption3;
                $data['category'] = $row[0]->category;
                $data['inquiry_method'] = $row[0]->inquiry_method;
                $data['pos'] = $row[0]->pos;
                $data['mail_addr'] = $row[0]->mail_addr;
                $data['form_addr'] = $row[0]->form_addr;
                $data['inquiry_inscription'] = $row[0]->inquiry_inscription;
                $data['published'] = $row[0]->published;
                $data['shop'] = $req['shop'];

                SessionUtil::putData($data);
                SessionUtil::putMode('mod');    // 編集モード
                SessionUtil::putUpflag('on');   // 更新フラグon
                // 編集画面
                return redirect(action_auto($this->controller . '@getUpload'));
            }
            // ボタン押下、データ並べ替え
            $this->dataSort();
        }

        // 一覧表示
        $staffInstance = Staffbbs::createNewInstance( $this->hanshaCode );
        $list['blogs'] = $staffInstance->where('shop', '=', SessionUtil::getShop())
            ->whereNull('treepath')
            ->orderByRaw('listing_order::INT ASC') // 並び順
            ->get();
        
        // 子テンプレート設定
        $template = 'infobbs.base_' . $this->templateNo . '.search';

        // 拠点コード
        $data = SessionUtil::getData();
        $shopCode = isset($data['shop']) && !empty($data['shop']) ? $data['shop'] : '';
        $shopCode = isset($req['shop']) && !empty($req['shop']) ? $req['shop'] : $shopCode;
        // 拠点名
        $shopList = SessionUtil::getShopList();
        $shopName = '';
        if (isset($shopList[$shopCode])) {
            $shopName = $shopList[$shopCode];
        }
        // 登録画面へのURL
        $urlNew = action_auto($this->controller . '@getNew');
        if (!empty($shopCode)) {
            $urlNew .= '?shop=' . $shopCode;
        }
        $urlNewStaff = action_auto($this->controller . '@getNewStaff');
        if (!empty($shopCode)) {
            $urlNewStaff .= '?shop=' . $shopCode;
        }

        return view('api.common.admin.infobbs.staff.admin', $list) // 掲載設定機能で親テンプレート切り替え
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('shopList', $shopList) // 店舗セレクトボックス
            ->with('shopName', $shopName) // 店舗セレクトselected
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('category', $this->category)                   // カテゴリチェックボックス
            ->with('urlAction', action_auto($this->controller . '@getIndex'))
            ->with('urlNew', $urlNew)
            ->with('urlNewStaff', $urlNewStaff);
    }

    /**
     * 一覧表示(一括編集ボタン)
     * @return string
     */
    public function postIndex(){
        DB::transaction(function() {
            $req = Request::all();// transactionの中に入れる
            $dateTime = date("Y-m-d H:i:s");

            $staffs = $req['staff'] ?? [];
            foreach ($staffs as $key => $val){
                if (isset($val['del'])) {
                    // テーブル削除
                    $staffInstance = Staffbbs::createNewInstance( $this->hanshaCode );
                    $staffInstance->where('number', $val['number'])
                            ->delete();
                } else{
                    // テーブル更新
                    $column = array();
                    // 掲載
                    $column['disp'] = 'OFF';
                    if(isset($val['disp'])){
                        $column['disp'] = $val['disp'];
                    }
                    // 公開時の並び順
                    if(isset($val['listing_order'])){
                        $column['listing_order'] = $val['listing_order'];
                    }
                    // 更新時間
                    $column = $this->setColumn('updated_at',$dateTime,$column);

                    DB::table(SessionUtil::getTableName())->where('number', $val['number'])
                        ->update($column);
                }
            }
        });
        
        // ホーム名
        SessionUtil::putHomeName('INDEX');
        $data = SessionUtil::getData();
        SessionUtil::putData($data);
        
        $shopCode = SessionUtil::getShop();
        
        return view('infobbs.complete')
            ->with('urlAction', action_auto($this->controller . '@getIndex') . '?shop=' . $shopCode)
            ->with('msg','データを編集しました。');
    }

    /**
     * 編集画面
     * @return string
     */
    public function getEditProfile(){
        $data = SessionUtil::getData('profile');
        
        // IDが違うなら、リセット
        if (isset($data['number']) && $data['number'] != SessionUtil::getNumber()) {
            SessionUtil::removeData('profile');
            $data = SessionUtil::getData('profile');
        }
        
        // 子テンプレート
        $template = 'infobbs.base_' . $this->templateNo . '.upload';
        $mode = SessionUtil::getMode();
        
        if ($mode == 'mod' && empty($data)) {
            $number = SessionUtil::getNumber();
            $row = DB::table(SessionUtil::getTableName())
                ->where('number', '=', $number)->get();

            $data['number'] = $row[0]->number;
            $data['name_furi'] = $row[0]->name_furi;
            $data['name'] = $row[0]->name;
            $data['msg'] = $row[0]->msg;
            $data['hobby'] = $row[0]->hobby;
            $data['ext_field1'] = $row[0]->ext_field1;
            $data['ext_value1'] = $row[0]->ext_value1;
            $data['ext_field2'] = $row[0]->ext_field2;
            $data['ext_value2'] = $row[0]->ext_value2;
            $data['ext_field3'] = $row[0]->ext_field3;
            $data['ext_value3'] = $row[0]->ext_value3;
            $data['ext_field4'] = $row[0]->ext_field4;
            $data['ext_value4'] = $row[0]->ext_value4;
            $data['ext_field5'] = $row[0]->ext_field5;
            $data['ext_value5'] = $row[0]->ext_value5;
            $data['editpass'] = $row[0]->editpass;
            $data['disp'] = $row[0]->disp;
            $data['position'] = $row[0]->position;
            $data['shop'] = $row[0]->shop;
            $data['photo'] = $row[0]->photo;
            $data['photo2'] = $row[0]->photo2;
            $data['editpass'] = $row[0]->editpass;
            $data['lisence'] = $row[0]->qualification;
            $data['comp_check'] = '';
            
            // セッションを更新
            SessionUtil::putData( $data, 'profile' );
        }
        
        $shopList = SessionUtil::getShopList();

        return view('api.common.admin.infobbs.staff.profile_edit')->with('data', $data)
            ->with('template', $template)
            ->with('dataType', 'array')
            ->with('mode', SessionUtil::getMode())          // 新規 or 編集
            ->with('upflag', SessionUtil::getUpflag())      // 更新フラグ
            ->with('shopList', $shopList)  // 店舗セレクトボックス
//            ->with('urlImageTmp',action_auto($this->controller . '@getIndex')) // // 画像アップロード機能（本文）
            ->with('urlAction',action_auto($this->controller . '@getEditProfile'));
    }

    /**
     * 編集画面（次へボタン）　使用しているか不明
     * @return string
     */
    public function postEditProfile( StaffRequest $req ){
        //　ボタンが押されたらON
        SessionUtil::putUpflag('on');

        if(isset($req['del'])){
            return redirect(action_auto($this->controller . '@getDelete'));
       }

        // 初期化（フォームから項目を取得）
        $data = array();
        // 共通項目
        $data['name_furi'] = $req['name_furi'];
        $data['name'] = $req['name'];
        $data['pos'] = $req['pos'];
        $data['position'] = $req['position'];
        $data['shop'] = $req['shop'];
        $data['msg'] = $req['msg'];
        $data['lisence'] = $req['lisence'];
        $data['hobby'] = $req['hobby'];
        $data['ext_field1'] = $req['ext_field1'];
        $data['ext_value1'] = $req['ext_value1'];
        $data['ext_field2'] = $req['ext_field2'];
        $data['ext_value2'] = $req['ext_value2'];
        $data['ext_field3'] = $req['ext_field3'];
        $data['ext_value3'] = $req['ext_value3'];
        $data['ext_field4'] = $req['ext_field4'];
        $data['ext_value4'] = $req['ext_value4'];
        $data['ext_field5'] = $req['ext_field5'];
        $data['ext_value5'] = $req['ext_value5'];
        // 編集パスワード
        $data['editpass'] = !empty($req['editpass']) ? $req['editpass'] : $this->loginAccountObj->gethanshaCode();
        $data['disp'] = '';
        if (isset($req['disp'])) {
            $data['disp'] = $req['disp'];
        }
        if (isset($req['comp_check'])) {
            $data['comp_check'] = $req['comp_check'];
        }
        // セッションから取得
        $data['number'] = SessionUtil::getNumber();
        // 画像登録済みの場合セッションから取得
        $sessionData = SessionUtil::getData('profile');
        
        // 画像アップ
        if(isset($req['photo'])){
            // フォームから入力あり
            $data['photo'] = $req['photo'];
        }else{
            $data['photo'] = '';
            // セッションから取得
            if(isset($sessionData['photo']) && substr($sessionData['photo'], 0,4) != 'err/'){
                $data['photo'] = $sessionData['photo'];
            }
        }
        if(isset($req['photo2'])){
            $data['photo2'] = $req['photo2'];
        }else{
            $data['photo2'] = '';
            // セッションから取得
            if(isset($sessionData['photo2']) && substr($sessionData['photo2'], 0,4) != 'err/'){
                $data['photo2'] = $sessionData['photo2'];
            }
        }
        
        // 表示位置
        $data['pos'] = 0;
        if(isset($req['pos'])){
            $data['pos'] = $req['pos'];
        }
        // お問い合わせ方法
        if(isset($req['inquiry_method'])){
            $data['inquiry_method'] = $req['inquiry_method'];
        }
        
        // 画像取得
        if(isset($req['photo'])){
            // 古いファイル名
            $oldName = $sessionData['photo'] ?? '';
            $oldName = basename($oldName);
            $fileName = ImageUtil::makeImage('photo', 1, $this->tableNo, $this->tableType, $oldName );
            $data['photo'] = $fileName;
        }
        if(isset($req['photo2'])){
            // 古いファイル名
            $oldName = $sessionData['photo2'] ?? '';
            $oldName = basename($oldName);
            $fileName = ImageUtil::makeImage('photo2', 2, $this->tableNo, $this->tableType, $oldName );
            $data['photo2'] = $fileName;
        }
        
        // 画像を削除
        if (isset($req['photo1_del'])) {
            $data['photo'] = '';
            $data['photo1_del'] = $req['photo1_del'];
        }
        if (isset($req['photo2_del'])) {
            $data['photo2'] = '';
            $data['photo2_del'] = $req['photo2_del'];
        }
        
        // セッションに保存
        $data['continue'] = 'ok';
        
        SessionUtil::putData($data, 'profile');
        
        return redirect(action_auto($this->controller . '@getConfirm'));
    }

    /**
     * 確認画面
     * @return string
     */
    public function getConfirm(){
        $data = SessionUtil::getData( 'profile' );
        
        // 子テンプレート
        $template = 'infobbs.base_' . $this->templateNo . '.search';
        $shopList = SessionUtil::getShopList();
        $shopName = $shopList[$data['shop']];

        return view('api.common.admin.infobbs.staff.profile_edit_confirm')->with('data', $data)
            ->with('template', $template)
            ->with('dataType', 'array')
            ->with('shopList', $shopList)  // 店舗セレクトボックス
            ->with('shopName', $shopName)
            ->with('urlAction',action_auto($this->controller . '@postConfirm'));
    }

    /**
     * ブログ登録
     * @return string
     */
    public function postConfirm()
    {
        $req = Request::all();
        $data = SessionUtil::getData( 'profile' );

        if(isset($req['modulate'])){
            // 変種画面へ戻る
            return redirect(action_auto($this->controller . '@getEditProfile'));
        }
        if(isset($req['register'])){
            $dateTime = date("Y-m-d H:i:s");
            $column = $this->makeColumn();

            if(SessionUtil::getMode() == 'mod'){
                $column = $this->setColumn('updated_at',$dateTime,$column);
                $column = $this->setColumn('photo', $data['photo'], $column);
                $column = $this->setColumn('photo2', $data['photo2'], $column);
                $column = $this->setColumn('editpass', $data['editpass'], $column);
                
                // テーブル更新 
                DB::table(SessionUtil::getTableName())
                    // スタッフ番号
                    ->where('number',  $data['number'])
                    // 拠点コード
                    //->where('shop',  $data['shop'])
                    ->update($column);
            }else{
                // 新規テーブル
                $row = DB::table(SessionUtil::getTableName())
                    ->orderBy('regist', 'DESC')
                    ->take(1)
                    ->get();
                // 最大番号計算
                if( count($row) == 0 ){
                    $num = 0;
                }else{
                    $num = intval($row['0']->regist);
                }
                $num++;
                $number = "data" . substr("00000" . strval($num),-6);

                $column = $this->setColumn('regist',$num,$column);
                $column = $this->setColumn('number',$number,$column);
                $column = $this->setColumn('editpass', $data['editpass'], $column);
                $column = $this->setColumn('photo', $data['photo'], $column);
                $column = $this->setColumn('photo2', $data['photo2'], $column);
                $column = $this->setColumn('created_at',$dateTime,$column);
                $column = $this->setColumn('updated_at',$dateTime,$column);
                $column = $this->setColumn('add',$_SERVER['SERVER_NAME'] . '(' . $_SERVER['SERVER_ADDR'] . ')',$column);
                $column = $this->setColumn('agent',$_SERVER['HTTP_USER_AGENT'],$column);
 
                // 新規テーブル作成
                DB::table(SessionUtil::getTableName())->insert($column);
            }
            
            $shopCode = SessionUtil::getShop();
            $urlAction = action_auto($this->controller . '@getIndex') . '?shop=' . $shopCode;
            if (SessionUtil::getHomeName() == 'LIST') {
                $urlAction = action_auto($this->controller . '@getList');
            }
            
            // セッションを削除
            foreach ($data as $key => $value) {
                $data[$key] = '';
            }
            SessionUtil::putData($data, 'profile');

            return view('api.common.admin.infobbs.staff.complete', $data)->with('msg','データを登録しました。')
                ->with('urlAction', $urlAction);
        }
        return redirect(action_auto($this->controller . '@getConfirm'));
    }

    #############################
    ## スタッフ選択・全般編集画面
    #############################

    /**
     * スタッフ一覧表示
     * @return string
     */
    public function getList()
    {
        $req = Request::all();

        if(isset($req) && isset($req['shop'])){
            // 初期表示
            SessionUtil::putShop($req['shop']); // 店舗No
            
            // 店舗名取得
            $hansha_code =  $this->loginAccountObj->gethanshaCode();
            $shopList = $this->shopList($hansha_code);
            foreach ($shopList as $shop => $name){
                if($shop == SessionUtil::getShop()){
                    SessionUtil::putName($name); // 店舗名
                    break;
                }
            }
        }
        if(isset($req) && isset($req['action'])){
            // ボタン、リンク
        }

        // 一覧表示
        $list['blogs'] = DB::table(SessionUtil::getTableName())
            ->where('shop', '=', SessionUtil::getShop())
            ->whereNull('treepath')
            ->orderByRaw('listing_order::INT ASC') // 並び順
            ->get();
        
        // 子テンプレート設定
        $template = 'infobbs.base_' . $this->templateNo . '.search';

        // 拠点コード
        $data = SessionUtil::getData();
        $shopCode = isset($data['shop']) && !empty($data['shop']) ? $data['shop'] : '';
        $shopCode = isset($req['shop']) && !empty($req['shop']) ? $req['shop'] : $shopCode;
        // 拠点名
        $shopList = SessionUtil::getShopList();
        $shopName = '';
        if (isset($shopList[$shopCode])) {
            $shopName = $shopList[$shopCode];
        }
        // 登録画面へのURL
        $urlNew = action_auto($this->controller . '@getNew');
        if (!empty($shopCode)) {
            $urlNew .= '?shop=' . $shopCode;
        }
        $urlNewStaff = action_auto($this->controller . '@getNewStaff');
        if (!empty($shopCode)) {
            $urlNewStaff .= '?shop=' . $shopCode;
        }

        return view('api.common.admin.infobbs.staff.list', $list) // 掲載設定機能で親テンプレート切り替え
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('shopList', $shopList) // 店舗セレクトボックス
            ->with('shopName', $shopName) // 店舗セレクトselected
            ->with('shopCode', $shopCode)
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('category', $this->category)                   // カテゴリチェックボックス
            ->with('urlAction', action_auto($this->controller . '@getSingleEdit'));
    }

    /**
     * 編集画面（次へボタン）
     * @return string
     */
    public function postList()
    {
        $req = Request::all();
        $data = SessionUtil::getData();
        // ホーム名
        SessionUtil::putHomeName('LIST');
        // 暗証番号を確認
        $data['editable'] = false;
        $row = DB::table(SessionUtil::getTableName())
            ->where('number', '=', $req['number'])->get();
        // 認証OK
        if ($row->count() > 0 && $req['editpass'] == $row[0]->editpass) {
            $data['editable'] = true;
        }
        SessionUtil::putData( $data, 'staff-list' );
        
        SessionUtil::putNumber($req['number']);
        SessionUtil::putShop($req['shop']);
        SessionUtil::putMode('mod');
        
        return redirect(action_auto($this->controller . '@getSingleEdit'));
    }

    /**
     * スタッフ全般編集画面
     * @return string
     */
    public function getSingleEdit(){
        // データ
        $data = SessionUtil::getData( 'staff-list' );
        // スタッフ番号
        $number = SessionUtil::getNumber();
        
        $staffName = DB::table( SessionUtil::getTableName() )
            ->where('number', '=', $number)
            ->first()->name;
        // 拠点コード
        $shopCode = SessionUtil::getShop();
        // メールアドレス登録のステータス
        $mailReg = config('original.para')[$this->tableNo]['mail_register'] ?? '0';
        // メールアドレス登録画面のURL
        $mailFormUrl = action_auto('Other\MailRegisterController@getRegister')
                . '?shop=' . $shopCode . '&system_name=staff&staff_code=' . $number;
        

        return view('api.common.admin.infobbs.staff.single_edit')->with('data', $data)
            ->with('dataType', 'array')
            ->with('mailReg', $mailReg)
            ->with('mailFormUrl', $mailFormUrl)
            ->with('staffName', $staffName)
            ->with('editable', (bool)$data['editable'])
            ->with('urlActionEditProfile', action_auto($this->controller . '@getEditProfile'))
            ->with('urlActionBlogList', action_auto($this->controller . '@getBlogList'));
    }

    /**
     * 編集画面（次へボタン）
     * @return string
     */
    public function postSingleEdit(){
        $req = Request::all();

/*
 * エラーチェックなし
        //バリデーションをインスタンス化
        $validation = Validator::make(
            $req,
            $this->validateRules,
            $this->validateMessages
        );
*/
        //　ボタンが押されたらON
        SessionUtil::putUpflag('on');

        if(isset($req['del'])){
            return redirect(action_auto($this->controller . '@getDelete'));
       }

        // 初期化（フォームから項目を取得）
        $data = array();
        
        // 共通項目
        $data['title'] = $req['title'];
        $data['comment'] = $req['comment'];
        $data['caption'] = $req['caption'];
        $data['caption2'] = $req['caption2'];
        $data['caption3'] = $req['caption3'];
        $data['shop'] = $req['shop'];
        // セッションから取得
        $data['number'] = SessionUtil::getNumber();
        // 画像登録済みの場合セッションから取得
        $sessionData = SessionUtil::getData();
        if(isset($req['file'])){
            // フォームから入力あり
            $data['file'] = $req['file'];
        }else{
            // セッションから取得
            if(substr($sessionData['file'], 0,4) == 'err/'){
                // エラーの場合クリア
                $data['file'] = '';
            }else{
                $data['file'] = $sessionData['file'];
            }
        }
        if(isset($req['file2'])){
            $data['file2'] = $req['file2'];
        }else{
            // セッションから取得
            if(substr($sessionData['file2'], 0,4) == 'err/'){
                // エラーの場合クリア
                $data['file2'] = '';
            }else{
                $data['file2'] = $sessionData['file2'];
            }
        }
        if(isset($req['file3'])){
            $data['file3'] = $req['file3'];
        }else{
            // セッションから取得
            if(substr($sessionData['file3'], 0,4) == 'err/'){
                // エラーの場合クリア
                $data['file3'] = '';
            }else{
                $data['file3'] = $sessionData['file3'];
            }
        }
        // 表示位置
        $data['pos'] = 0;
        if(isset($req['pos'])){
            $data['pos'] = $req['pos'];
        }
        // お問い合わせ方法
        if(isset($req['inquiry_method'])){
            $data['inquiry_method'] = $req['inquiry_method'];
        }

        // カテゴリ
        $category = '';
        if(isset($req['category'])){
            foreach ($req['category'] as $val){
                if($category){
                    $category .= ',';
                }
                $category .= $val;
            }
        }
        $data['category'] = $category;
        // 画像取得
        if(isset($req['file'])){
            $fileName = ImageUtil::makeImage('file',1, $this->tableNo, $this->tableType );
            $data['file'] = $fileName;
        }
        if(isset($req['file2'])){
            $fileName = ImageUtil::makeImage('file2',2, $this->tableNo, $this->tableType );
            $data['file2'] = $fileName;
        }
        if(isset($req['file3'])){
            $fileName = ImageUtil::makeImage('file3',3, $this->tableNo, $this->tableType );
            $data['file3'] = $fileName;
        }
        // 画像削除
        if(isset($req['delete1'])){
            $data['file'] = '';
        }
        if(isset($req['delete2'])){
            $data['file2'] = '';
        }
        if(isset($req['delete3'])){
            $data['file3'] = '';
        }
        // セッションに保存
        SessionUtil::putData($data);

        // エラーチェック
        /*
        if($validation->fails()){
            $msg = $validation->errors()->all();
            return redirect(action_auto($this->controller . '@getUpload'))
                ->withErrors($validation)
                ->withInput();
        }
        */
        
        // 画像エラーチェック
        if(substr($data['file'],0,4) == 'err/' ||
           substr($data['file2'],0,4) == 'err/' ||
           substr($data['file3'],0,4) == 'err/'
        ){
            return redirect(action_auto($this->controller . '@getUpload'));
        }
        return redirect(action_auto($this->controller . '@getConfirmBlog'));
    }

    #############################
    ## スタッフブログの一覧
    #############################
    
    /**
     * 一覧表示
     * @return string
     */
    public function getBlogList(){
        $req = Request::all();

        // 一覧表示
        $list['blogs'] = DB::table(SessionUtil::getTableName())
            // ->where('shop', '=', SessionUtil::getShop())
            ->where('treepath', '=', SessionUtil::getNumber())
            ->orderBy('regist', 'desc')
            ->paginate(SessionUtil::getPageNum());
        
        // 子テンプレート設定
        $template = 'infobbs.base_' . $this->templateNo . '.search';
        
        // 拠点コード
        $data = SessionUtil::getData();
        $shopCode = SessionUtil::getShop();
        // 拠点名
        $shopList = SessionUtil::getShopList();
        $shopName = '';
        if (isset($shopList[$shopCode])) {
            $shopName = $shopList[$shopCode];
        }
        // 登録画面へのURL
        $urlNew = action_auto($this->controller . '@getNew');
        if (!empty($shopCode)) {
            $urlNew .= '?shop=' . $shopCode;
        }
        
        // スタッフ番号
        $number = SessionUtil::getNumber();
        
        $staffName = DB::table( SessionUtil::getTableName() )
            ->where('number', '=', $number)
            ->first()->name;

        return view('api.common.admin.infobbs.staff.blog_list', $list) // 掲載設定機能で親テンプレート切り替え
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('shopList', $shopList) // 店舗セレクトボックス
            ->with('shopName', $shopName) // 店舗セレクトselected
            ->with('staffName', $staffName)
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('urlAction', action_auto($this->controller . '@getBlogEdit'))
            ->with('urlActionNew', $urlNew);
    }

    /**
     * 一覧表示(一括編集ボタン)
     * @return string
     */
    public function postBlogList(){
        DB::transaction(function() {
            $req = Request::all();// transactionの中に入れる
            $dateTime = date("Y-m-d H:i:s");

            foreach ($req as $key => $val){
                if(strstr($key,'data')){
                    if(isset($val['del'])){
                        // テーブル削除
                        $staffInstance = Staffbbs::createNewInstance( $this->hanshaCode );
                        $staffInstance->where('number', $key)
                                ->delete();
                    } /*else {
                        // テーブル更新
                        $column = array();
                        // 掲載
                        if(isset($val['published'])){
                            $column['published'] = $val['published'];
                        }
                        // 公開申請
                        if(isset($val['editflag'])){
                            $column['editflag'] = $val['editflag'];
                        }
                        // お店から
                        if(isset($val['msg1'])){
                            $column['msg1'] = $val['msg1'];
                        }
                        
                        // カテゴリ
                        // 本社申請機能のときのみカテゴリーセット
                        $category = '';
                        $column['category'] = '';// チェックがない場合全部消す
                        if(isset($val['category'])){
                            foreach ($val['category'] as $catVal){
                                if($category){
                                    $category .= ',';
                                }
                                $category .= $catVal;
                            }
                            $column['category'] = $category;
                        }
                        
                        // 更新時間
                        $column = $this->setColumn('updated_at',$dateTime,$column);

                        DB::table(SessionUtil::getTableName())->where('number', $key)
                            ->update($column);
                    }*/
                }
            }
        });
        
        $data = SessionUtil::getData();
        
        return view('api.common.admin.infobbs.staff.complete')
            ->with('urlAction', action_auto($this->controller . '@getBlogList') . '?shop=' . $data['shop'])
            ->with('msg','データを編集しました。');
    }

    /**
     * 編集画面
     * @return string
     */
    public function getBlogEdit()
    {
        $data = SessionUtil::getData( 'blog' );

        // お問い合わせ方法初期化
        if(!isset($data['inquiry_method'])){
            $data['inquiry_method'] = '';
        }
        // 子テンプレート
        $template = 'infobbs.base_' . $this->templateNo . '.upload';
        
        $req = Request::all();
        $number = $req['number'] ?? '';
        
        if(isset($req) && isset($req['action'])){
            // ボタン、リンク
            if($req['action'] == 'edit'){
                $this->initData( 'blog' );
                
                $row = DB::table(SessionUtil::getTableName())
                    ->where('number', '=', $number)->get();
                
                // セッションに保存
                SessionUtil::putNumber($row[0]->treepath);
 
                $data = array();
                // 更新画面項目（DBから全項目取得）
                $data['number'] = $row[0]->number;
                $data['treepath'] = $row[0]->treepath;
                $data['title'] = $row[0]->title;
                $data['comment'] = $row[0]->comment;
                $data['file'] = $row[0]->file;
                $data['file2'] = $row[0]->file2;
                $data['file3'] = $row[0]->file3;
                $data['caption'] = $row[0]->caption;
                $data['caption2'] = $row[0]->caption2;
                $data['caption3'] = $row[0]->caption3;
                $data['category'] = $row[0]->category;
                $data['pos'] = $row[0]->pos;
                $data['published'] = $row[0]->published;
                $data['shop'] = $req['shop'];
                
                SessionUtil::putData($data, 'blog');
                SessionUtil::putMode('mod');    // 編集モード
                SessionUtil::putUpflag('on');   // 更新フラグon
            }
        }
        
        $result = $this->modifyImageForDropZone($data['comment']);
        $data['comment'] = $result['content'];
        $data['existing_images'] = $result['existing_images'];
        
        $shopList = SessionUtil::getShopList();
        $shopName = $shopList[$data['shop']] ?? '';
        
        // スタッフの名前
        $staffName = '';
        // スタッフ番号
        $staffCode = SessionUtil::getNumber();
        $staffData = DB::table( SessionUtil::getTableName() )
            ->where('number', '=', $staffCode)
            ->first();
        if ($staffData !== null) {
            $staffName = $staffData->name;
        }

        return view('api.common.admin.infobbs.staff.blog_edit')->with('data', $data)
            ->with('template', $template)
            ->with('dataType', 'array')
            ->with('tableType', $this->tableType)
            ->with('mode', SessionUtil::getMode())          // 新規 or 編集
            ->with('upflag', SessionUtil::getUpflag())      // 更新フラグ
            ->with('shopList', $shopList)  // 店舗セレクトボックス
            ->with('shopName', $shopName)          // 店舗セレクトselected
            ->with('staffName', $staffName) // スタッフの名前
            ->with('urlImageTmp',action_auto($this->controller . '@getIndex')) // // 画像アップロード機能（本文）
            ->with('urlAction',action_auto($this->controller . '@postBlogEdit'));
    }

    /**
     * 編集画面（次へボタン）
     * @return string
     */
    public function postBlogEdit()
    {
        $req = Request::all();

/*
 * エラーチェックなし
        //バリデーションをインスタンス化
        $validation = Validator::make(
            $req,
            $this->validateRules,
            $this->validateMessages
        );
*/
        //　ボタンが押されたらON
        SessionUtil::putUpflag('on');

        if(isset($req['del'])){
            return redirect(action_auto($this->controller . '@getDelete'));
       }

        // 初期化（フォームから項目を取得）
        $data = array();
        
        // 共通項目
        $data['title'] = $req['title'];
        $data['comment'] = $req['comment'];
        $data['caption'] = $req['caption'];
        $data['caption2'] = $req['caption2'];
        $data['caption3'] = $req['caption3'];
        $data['shop'] = $req['shop'];
        // 画像登録済みの場合セッションから取得
        $sessionData = SessionUtil::getData( 'blog' );
        // セッションから取得
        if (SessionUtil::getMode() == 'mod') {
            $data['number'] = $sessionData['number'];
        }
        $data['treepath'] = $sessionData['treepath'];
        
        if(isset($req['file'])){
            // フォームから入力あり
            $data['file'] = $req['file'];
        }else{
            // セッションから取得
            if(substr($sessionData['file'], 0,4) == 'err/'){
                // エラーの場合クリア
                $data['file'] = '';
            }else{
                $data['file'] = $sessionData['file'];
            }
        }
        if(isset($req['file2'])){
            $data['file2'] = $req['file2'];
        }else{
            // セッションから取得
            if(substr($sessionData['file2'], 0,4) == 'err/'){
                // エラーの場合クリア
                $data['file2'] = '';
            }else{
                $data['file2'] = $sessionData['file2'];
            }
        }
        if(isset($req['file3'])){
            $data['file3'] = $req['file3'];
        }else{
            // セッションから取得
            if(substr($sessionData['file3'], 0,4) == 'err/'){
                // エラーの場合クリア
                $data['file3'] = '';
            }else{
                $data['file3'] = $sessionData['file3'];
            }
        }
        // 表示位置
        $data['pos'] = 0;
        if(isset($req['pos'])){
            $data['pos'] = $req['pos'];
        }
        // お問い合わせ方法
        if(isset($req['inquiry_method'])){
            $data['inquiry_method'] = $req['inquiry_method'];
        }

        // 画像取得
        if(isset($req['file'])){
            // 古いファイル名
            $oldName = $sessionData['file'] ?? '';
            $oldName = basename($oldName);
            $fileName = ImageUtil::makeImage('file',1, $this->tableNo, $this->tableType, $oldName );
            $data['file'] = $fileName;
        }
        if(isset($req['file2'])){
            // 古いファイル名
            $oldName = $sessionData['file2'] ?? '';
            $oldName = basename($oldName);
            $fileName = ImageUtil::makeImage('file2',2, $this->tableNo, $this->tableType, $oldName );
            $data['file2'] = $fileName;
        }
        if(isset($req['file3'])){
            // 古いファイル名
            $oldName = $sessionData['file3'] ?? '';
            $oldName = basename($oldName);
            $fileName = ImageUtil::makeImage('file3',3, $this->tableNo, $this->tableType, $oldName );
            $data['file3'] = $fileName;
        }
        // 画像削除
        if(isset($req['file_del'])){
            $data['file'] = '';
        }
        if(isset($req['file2_del'])){
            $data['file2'] = '';
        }
        if(isset($req['file3_del'])){
            $data['file3'] = '';
        }
        // セッションに保存
        SessionUtil::putData($data, 'blog');

        // エラーチェック
        /*
        if($validation->fails()){
            $msg = $validation->errors()->all();
            return redirect(action_auto($this->controller . '@getUpload'))
                ->withErrors($validation)
                ->withInput();
        }
        */
        
        // 画像エラーチェック
        if(substr($data['file'],0,4) == 'err/' ||
           substr($data['file2'],0,4) == 'err/' ||
           substr($data['file3'],0,4) == 'err/'
        ){
            return redirect(action_auto($this->controller . '@getUpload'));
        }
        return redirect(action_auto($this->controller . '@getConfirmBlog'));
    }
    
    /**
     * 確認画面
     * @return string
     */
    public function getConfirmBlog(){
        $data = SessionUtil::getData( 'blog' );
        
        // 子テンプレート
        $template = 'infobbs.base_' . $this->templateNo . '.search';
        $shopList = SessionUtil::getShopList();
        $shopName = $shopList[$data['shop']] ?? null;

        return view('api.common.admin.infobbs.staff.blog_edit_confirm')->with('data', $data)
            ->with('template', $template)
            ->with('dataType', 'array')
            ->with('shopList', $shopList)  // 店舗セレクトボックス
            ->with('shopName', $shopName)
            ->with('urlActionConfirm', action_auto($this->controller . '@postConfirmBlog'));
    }
    
    /**
     * ブログ登録
     * @return string
     */
    public function postConfirmBlog(){
        $req = Request::all();
        $column = [];
        $number = '';
        $mode = SessionUtil::getMode();

        if(isset($req['modulate'])){
            // 変種画面へ戻る
            return redirect(action_auto($this->controller . '@getBlogEdit'));
        }
        
        if(isset($req['register'])){
            $dateTime = date("Y-m-d H:i:s");
            $column = $this->makeColumnBlog($mode == 'new');

            // 本文内にある絵文字のSJIS対応
            if( isset( $column['comment'] ) ){
                // 絵文字の変換
                $column['comment'] = $this->convertEmojiToHtmlEntity( $column['comment'] );
            }

            if($mode == 'mod'){
                $column = $this->setColumn('updated_at', $dateTime, $column);
                $number = $column['number'];
                // テーブル更新 
                DB::table(SessionUtil::getTableName())->where('number', $number)
                    ->update($column);
            }else{
                // 新規テーブル
                $row = DB::table(SessionUtil::getTableName())
                    ->orderBy('regist', 'DESC')
                    ->take(1)
                    ->get();
                // 最大番号計算
                if( count($row) == 0 ){
                    $num = 0;
                }else{
                    $num = intval($row['0']->regist);
                }
                $num++;
                $number = "data" . substr("00000" . strval($num),-6);

                $column = $this->setColumn('regist',$num,$column);
                $column = $this->setColumn('number',$number,$column);
                $column = $this->setColumn('created_at',$dateTime,$column);
                $column = $this->setColumn('updated_at',$dateTime,$column);
                $column = $this->setColumn('add',$_SERVER['SERVER_NAME'] . '(' . $_SERVER['SERVER_ADDR'] . ')',$column);
                $column = $this->setColumn('agent',$_SERVER['HTTP_USER_AGENT'],$column);
                $column = $this->setColumn('published', 'ON', $column);
 
                // 新規テーブル作成
                DB::table(SessionUtil::getTableName())->insert($column);
                
                // メール送信
                $this->sendUploadMail( null, 'staffbbs' );
            }
            
            // 記事の内容が空でないとき
            if( !empty( $column['comment'] ) == true ){
                // 画像の保存先のパス
                $dir = realpath( 'data/image');
                $dir = $dir . DIRECTORY_SEPARATOR . $this->tableNo;
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                // $replacedContentは記事の内容の変換される結果
                $replacementContent = ImageUtil::base64ToImageFromString( $column['comment'], $dir, $this->tableNo, 'staff', false );
                // テーブル更新 
                DB::table(SessionUtil::getTableName())->where('number', $number)
                    ->update(['comment' => $replacementContent]);
            }
            
            $urlAction = action_auto($this->controller . '@getBlogList');

            return view('infobbs.complete', $column)->with('msg','データを登録しました。')
                ->with('urlAction', $urlAction);
        }
    }

    #############################
    ## その他
    #############################
    
    /**
     * データ並べ替え
     * @return string
     */
    protected function dataSort(){
        DB::transaction(function() {
            $req = Request::all();
            // 一覧リスト作成
            $list = DB::table(SessionUtil::getTableName())->select('regist','number')
                ->where('shop', '=', SessionUtil::getShop())
                ->orderBy('regist','DESC')
                ->get();
            $count = count($list);
            $flag = 0;
            // 一番下へ移動 または 一つ下へ移動
            if(($req['action'] == 'lower' or $req['action'] == 'down' ) and $count > 1){
                for ($i = 0; $i < $count-1; $i++){
                    // 下にずらすスタート位置検索
                    if($req['number'] == $list[$i]->number){
                        $targetNumber = $list[$i]->number;
                        $flag = 1;
                    }
                    if($flag == 1){
                        $number = $list[$i+1]->number;
                        $regist = $list[$i]->regist;
                        DB::table(SessionUtil::getTableName())->where('number', $number)
                            ->update(['regist' => $regist]);
                        // 一つ下へ移動
                        if($req['action'] == 'down'){
                            $i++;
                            break;
                        }
                    }
                }
                if($flag == 1){
                    $regist = $list[$i]->regist;
                    DB::table(SessionUtil::getTableName())->where('number', $targetNumber)
                        ->update(['regist' => $regist]);
                }
            }
            // 一番上へ移動　または 一つ上へ移動
            if(($req['action'] == 'upper' or $req['action'] == 'up') and $count > 1){
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
                        DB::table(SessionUtil::getTableName())->where('number', $number)
                            ->update(['regist' => $regist]);
                        // 一つ上へ移動
                        if($req['action'] == 'up'){
                            $i;
                            break;
                        }
                    }
                }
                if($flag == 1){
                    // ターゲットのテーブル更新
                    $number = $list[$i]->number;
                    DB::table(SessionUtil::getTableName())->where('number', $targetNumber)
                        ->update(['regist' => $targetRegist]);
                }
            }
        });
    }

    /**
     * 新規入力
     * @return string
     */
    public function getNew(){
        $this->initData( 'blog' );
        SessionUtil::putMode('new');    // 新規追加モード
        SessionUtil::putUpflag('');     // 更新フラグOFF
        return redirect(action_auto($this->controller . '@getBlogEdit'));
    }

    /**
     * セッションdata初期化
     * @param string $keyName セッションのキー
     */
    protected function initData( $keyName = '' ) {
        $data = array();
        
        $data['title'] = '';
        $data['comment'] = '';
        $data['file'] = '';
        $data['file2'] = '';
        $data['file3'] = '';
        $data['caption'] = '';
        $data['caption2'] = '';
        $data['caption3'] = '';
        $data['category'] = '';
        $data['inquiry_method'] = '';
        $data['pos'] = '';
        $data['mail_addr'] = '';
        $data['form_addr'] = '';
        $data['number'] = '';
        $data['inquiry_inscription'] = 'お問い合わせはこちら';
        
        $req = Request::all();
        $data['shop'] = SessionUtil::getShop();
        $data['treepath'] = SessionUtil::getNumber();

        SessionUtil::putData($data, $keyName);
    }

    /**
     * 新規入力
     * @return string
     */
    public function getNewStaff(){
        $req = Request::all();
        $shopCode = "";
        // 拠点コードが空でないとき
        if( isset( $req['shop'] ) ){
            $shopCode = $req['shop'];
        }

        $this->initDataStaff();
        SessionUtil::putMode('new');    // 新規追加モード
        SessionUtil::putUpflag('');     // 更新フラグOFF
        return redirect(action_auto($this->controller . '@getEditProfile') . '?shop=' . $shopCode);
    }

    /**
     * セッションdata初期化
     */
    protected function initDataStaff(){
        $data = array();
        
        $data['name_furi'] = '';
        $data['name'] = '';
        $data['position'] = '';
        $data['shop'] = '';
        $data['photo'] = '';
        $data['photo1_del'] = '';
        $data['photo2'] = '';
        $data['photo2_del'] = '';
        $data['msg'] = '';
        $data['lisence'] = '';
        $data['hobby'] = '';
        $data['ext_field1'] = '';
        $data['ext_value1'] = '';
        $data['ext_field2'] = '';
        $data['ext_value2'] = '';
        $data['ext_field3'] = '';
        $data['ext_value3'] = '';
        $data['ext_field4'] = '';
        $data['ext_value4'] = '';
        $data['ext_field5'] = '';
        $data['ext_value5'] = '';
        $data['editpass'] = '';
        $data['disp'] = '';
        $data['comp_check'] = '';
        $data['continue'] = '';
        
        $req = Request::all();
        $data['shop'] = $req['shop'];
        SessionUtil::putNumber($req['shop']);

        SessionUtil::putData($data);
    }
    
    /**
     * マルチアップロードのために画像処理
     */
    private function modifyImageForDropZone($content)
    {
        $existingImages = [];
        
        $path = Config('original.dataImage') . $this->templateNo;
        $pattern = '(<img\s)(.+?)(' . $path . '.+?)(["\'])';
        $pattern = str_replace('/', '\\/', $pattern);
        
        $content = preg_replace_callback('/' . $pattern . '/', function($match) use(&$existingImages) {
            $name = preg_replace('/^.+?\/([^\/]+\..+?)$/', '$1', $match[3]);
            $filesize = 0;
            if (file_exists($match[3])) {
                $filesize = filesize($match[3]);
            }
            $existingImages[] = [
                'name' => $name,
                'dataUrl' => asset_auto('') . $match[3],
                'size' => $filesize,
            ];
            $rel = '';
            $namePtrn = str_replace('.', '\\.', $name);
            if (!preg_match('/rel=[\'"]' . $namePtrn . '[\'"]/', $match[2])) {
                $rel = 'rel="' . $name . '" ';
            }
            return $match[1] . $rel . $match[2] . $match[3] . $match[4];
        }, $content);

        return [
            'content' => $content,
            'existing_images' => $existingImages,
        ];
    }

    /*
     * 編集画面
     */
    // バリデーションのルール
    public $validateRules = [
        'title'=>'required',
    ];
    // バリデーションのエラーメッセージ
    public $validateMessages = [
        "required" => ":attributeは必須項目です。",
    ];
    
    /**
     * マルチ画像アップロード
     * 
     * @return string
     */
    public function postDeleteImage()
    {
        $req = Request::all();
        // ディレクトリパス
        $tableNo = $this->loginAccountObj->gethanshaCode();
        $req['path'] = config('original.dataImage') . $tableNo . '/' . $req['name'];
        @unlink($req['path']);
        return $req;
    }

    

    /**
     * カラム作成
     * @return string
     */
    protected function makeColumn()
    {
        $data = SessionUtil::getData( 'profile' );
        
        $column = [];
        
        $column['name_furi'] = $data['name_furi'] ?? ''; // ふりがな
        $column['name'] = $data['name'] ?? ''; // 氏名
        $column['msg'] = $data['msg'] ?? ''; // スタッフから一言
        $column['qualification'] = $data['lisence'] ?? ''; // 役職
        $column['position'] = $data['position'] ?? ''; // 資格
        $column['hobby'] = $data['hobby'] ?? ''; // 趣味
        $column['ext_field1'] = $data['ext_field1'] ?? ''; // 自由入力_フィールド名1
        $column['ext_value1'] = $data['ext_value1'] ?? ''; // 自由入力_内容1
        $column['ext_field2'] = $data['ext_field2'] ?? ''; // 自由入力_フィールド名2
        $column['ext_value2'] = $data['ext_value2'] ?? ''; // 自由入力_内容2
        $column['ext_field3'] = $data['ext_field3'] ?? ''; // 自由入力_フィールド名3
        $column['ext_value3'] = $data['ext_value3'] ?? ''; // 自由入力_内容3
        $column['ext_field4'] = $data['ext_field4'] ?? ''; // 自由入力_フィールド名3
        $column['ext_value4'] = $data['ext_value4'] ?? ''; // 自由入力_内容3
        $column['ext_field5'] = $data['ext_field5'] ?? ''; // 自由入力_フィールド名4
        $column['ext_value5'] = $data['ext_value5'] ?? ''; // 自由入力_内容4
        $column['disp'] = empty($data['disp']) ? 'OFF' : $data['disp']; // 公開フラグ
        $column['shop'] = $data['shop'] ?? null; // 店舗
        
        return $column;
    }

    /**
     * カラム作成
     * @param bool $isNew
     * @param string $keyName
     * @return string
     */
    protected function makeColumnBlog( $isNew = true )
    {
        $data = SessionUtil::getData( 'blog' );
        
        $column = [];

        foreach ($data as $key => $val){
            if($val != ""){
                $column[$key] = $val;
            }else{
                $column[$key] = null;
            }
        }

        return $column;
    }

    /**
     * カラムセット
     * @return string
     */
    protected function setColumn($col,$val,$column){
        if($val != ''){
            $column[$col] = $val;
        }else{
            $column[$col] = null;
        }
        return $column;
    }

}