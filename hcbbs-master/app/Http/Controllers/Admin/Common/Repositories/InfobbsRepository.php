<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Http\Controllers\Admin\Common\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\Infobbs\TAdminConfirmation;
use App\Http\Controllers\tCommon;
use App\Http\Controllers\tSendMail;
use App\Original\Util\ImageUtil;
use App\Original\Util\SessionUtil;
use App\Original\Util\CodeUtil;
use App\Original\Codes\Aichi\InquiryMethodCodes;
use App\Models\Base;
//use App\Http\Controllers\Api\Common\Traits\Infobbs\ConvertEmojis;
use App\Http\Controllers\Api\Common\Traits\Infobbs\RecordModifier;
use App\Http\Requests\InfobbsRequest;
use App\Models\Infobbs;
use DB;
use Request;

/**
 * Description of CommonInfobbsRepository
 *
 * @author ahmad
 */
trait InfobbsRepository {
    
    use tCommon, tSendMail, TAdminConfirmation;
    //use ConvertEmojis;
    use RecordModifier;
    
    /**
     * 緊急掲示板の店舗コード
     * 
     * @return string|null
     */
    private function getEmergencyBulletinShopId() {
        return config("{$this->hanshaCode}.general.emergency_bulletin_board_id");
    }

    /**
     * 一覧表示
     * @return string
     */
    public function getIndex(){
        $req = Request::all();
        $loginAccountObj = SessionUtil::getUser();

        if(isset($req) && isset($req['shop'])){
            // 初期表示
            SessionUtil::putShop($req['shop']); // 店舗No
            
            // 店舗名取得
            $shopList = $this->shopList($this->hanshaCode);
            foreach ($shopList as $shop => $name){
                if($shop == SessionUtil::getShop()){
                    SessionUtil::putName($name); // 店舗名
                    break;
                }
            }
        }
        if(isset($req['action'])){
            // ボタン、リンク
            if($req['action'] == 'edit'){
                $this->initData();

                $number = $req['number'];
                $row = DB::table(SessionUtil::getTableName())
                    ->where('shop', $req['shop'])
                    ->where('number', '=', $number)->get();
                // セッションに保存
                SessionUtil::putNumber($number);
 
                $data = array();
                // 更新画面項目（DBから全項目取得）
                $data['number'] = $row[0]->number;
                $data['title'] = $row[0]->title;
                $data['comment'] = $row[0]->comment;
                $data['file1'] = $row[0]->file1;
                $data['file2'] = $row[0]->file2;
                $data['file3'] = $row[0]->file3;
                if ($this->use6FileInput) {
                    $data['file4'] = $row[0]->file4;
                    $data['file5'] = $row[0]->file5;
                    $data['file6'] = $row[0]->file6;
                }
                $data['caption1'] = $row[0]->caption1;
                $data['caption2'] = $row[0]->caption2;
                $data['caption3'] = $row[0]->caption3;
                if ($this->use6FileInput) {
                    $data['caption4'] = $row[0]->caption4;
                    $data['caption5'] = $row[0]->caption5;
                    $data['caption6'] = $row[0]->caption6;
                }
                $data['category'] = $row[0]->category;
                if (isset($row[0]->inquiry_method)) {
                    $data['inquiry_method'] = $row[0]->inquiry_method;
                }
                $data['pos'] = $row[0]->pos;
                if (isset($row[0]->mail_addr)) {
                    $data['mail_addr'] = $row[0]->mail_addr;
                }
                if (isset($row[0]->form_addr)) {
                    $data['form_addr'] = $row[0]->form_addr;
                }
                if (isset($row[0]->inquiry_inscription)) {
                    $data['inquiry_inscription'] = $row[0]->inquiry_inscription;
                }
                $data['from_date'] = $row[0]->from_date;
                $data['to_date'] = $row[0]->to_date;
                $data['published'] = $row[0]->published;
                $data['shop'] = $req['shop'];

                SessionUtil::putData($data);
                SessionUtil::putMode('mod');    // 編集モード
                SessionUtil::putUpflag('on');   // 更新フラグon
                $isConfirmation = isset($_GET['confirmation']) && $_GET['confirmation'] == 1;
                SessionUtil::putIsConfirmation($isConfirmation); // 本社確認フラグon
                // 編集画面
                return redirect(action_auto($this->controller . '@getUpload'));
            }
            // ボタン押下、データ並べ替え
            if (($redirection = $this->dataSort()) !== null) {
                return $redirection;
            }
        }

        // 一覧表示
        $_shopCode = SessionUtil::getShop();
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        $list['blogs'] = $infoBbsInstance->where('shop', '=', $_shopCode)
            ->orderBy('regist', 'desc')
            ->paginate(SessionUtil::getPageNum());

        // レコードを置換
        foreach ($list['blogs'] as $blogData) {
            //$blogData->comment = $this->replaceOldSystemImage($blogData->comment);
            $this->modifyOneResultRecord($blogData);
        }
        
        // 子テンプレート設定
        $template = 'api.common.admin.infobbs.base_' . $this->templateNo . '.search';

        // 拠点コード
        $data = SessionUtil::getData();
        $shopCode = !empty($_shopCode) ? $_shopCode : '';
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
        // コメント取得
        $comment = array();
        if($this->comment == '1'){
            $comment = $this->makeComment($list['blogs']);
        }
        // メールアドレス登録
        $mailReg = config('original.para')[$this->loginAccountObj->gethanshaCode()]['mail_register'] ?? '0';
        // メール登録のURL
        $urlMailRegister = action_auto('Other\MailRegisterController@getRegister')
                . '?shop=' . $shopCode . '&system_name=infobbs';
        // プレビュー一覧のURL
        $urlListPreview = action_auto($this->controller . '@getIndexPreview')
                . '?shop=' . $shopCode;
        
        // 緊急掲示板の店舗コード
        $emergencyBulletinShopId = $this->getEmergencyBulletinShopId();
        // 緊急掲示板の店舗のフラグ
        $isEmergencyBulletin = isset($emergencyBulletinShopId) && $emergencyBulletinShopId == $shopCode;
        
        // ビュー名
        // 緊急掲示板の店舗かを確認する
        if (!$isEmergencyBulletin) {
            // 緊急掲示板の店舗じゃない場合、本社承認機能があるかによって切り替える
            $viewName = ".search_{$this->published_mode}";
        } else {
            // 緊急掲示板の店舗の場合、本社承認機能があっても、
            // 本社承認機能がない一覧画面を表示する
            $viewName = ".search_0";
        }
        $templateDir = "api.{$this->hanshaCode}.admin.infobbs";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.infobbs';
        }
        $viewName = $templateDir . $viewName;

        $hansha_code =  $this->loginAccountObj->gethanshaCode();
        return view($viewName, $list) // 掲載設定機能で親テンプレート切り替え
            ->with('template', $template)
            ->with('templateDir', $templateDir)
            ->with('dataType', 'object')
            ->with('mailReg', $mailReg) // メールアドレス登録
            ->with('shopList', $shopList) // 店舗セレクトボックス
            ->with('shopCode', $shopCode) // 店舗コード
            ->with('shopName', $shopName) // 店舗セレクトselected
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('urlAction', action_auto($this->controller . '@getIndex'))
            ->with('urlNew', $urlNew)
            ->with('urlMailRegister', $urlMailRegister)
            ->with('urlListPreview', $urlListPreview)
            ->with('comment', $comment)
            ->with('category', $this->category)
            ->with('hanshaCode', $hansha_code)
            ->with('isEmergencyBulletin', $isEmergencyBulletin); // カテゴリチェックボックス
    }
    
    /**
     * 共通データ
     */
    private function getResultSet($alias = null) {
        $aliasText = '';
        if ($alias !== null) {
            $aliasText = ' AS ' . $alias;
        }
        // 一覧表示
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        $tableName = $infoBbsInstance->getTable();
        $query = DB::table( $tableName . $aliasText );
        
        // 緊急掲示板の除外
        $query = $this->excludeEmergencyBulletinShop($query, $alias);
        
        return $query;
    }
    
    /**
     * 緊急掲示板の除外
     * 
     * @param object $query レコードのデータ
     * @return object
     */
    private function excludeEmergencyBulletinShop($query, $alias = null) {
        // 緊急掲示板の除外
        $emergencyBulletinShopCode = $this->getEmergencyBulletinShopId();
        if ($emergencyBulletinShopCode !== null) {
            if ($alias !== null) {
                $alias .= '.';
            }
            $query = $query->where( $alias . 'shop', '<>', $emergencyBulletinShopCode );
        }
        
        return $query;
    }
    
    /**
     * 表示順の条件
     * 
     * @param object $query
     * @return object
     */
    private function buildOrderBy( $query, $prefix = '', $dir = 'desc' ) {
        // 公開日時があれば公開日時を、無ければ、更新日時のソート順にする
        if ($prefix !== '') {
            $prefix .= '.';
        }
        return $query->orderByRaw( "{$prefix}regist desc" )
            ->orderBy( $prefix . 'to_date', $dir )
            ->orderBy( $prefix . 'title', 'DESC' );
    }
    
    /**
     * 一覧表示
     * @return string
     */
    public function getIndexPreview() {
        $req = Request::all();
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
        
        // 緊急掲示板の店舗コード
        $emergencyBulletinShopId = $this->getEmergencyBulletinShopId();
        $isEmergencyBulletin = isset($emergencyBulletinShopId) && $emergencyBulletinShopId == $shopCode;
        
        // 一覧表示
        // 1ページの表示件数
        $perPage = \Config( 'original.para' )[$this->hanshaCode] ['page_num'];
        
        // 一覧表示
        $query = $this->getResultSet('info');

        ###############################
        ## 検索処理
        ###############################

        // 拠点コード
        if( $shopCode !== "" ){
            $query = $query->where( 'info.shop', $shopCode);
        }
        // カテゴリー
        if( isset( $req['category'] ) && $req['category'] !== "" ){
            /// カテゴリーを検索するSQL
            $category = mb_convert_encoding($req['category'], 'UTF-8', 'Shift-JIS');
            $query = $query->whereRaw( DB::Raw( " ARRAY['{$category}'] <@ regexp_split_to_array( info.category, ',' ) "  ) );
        }
        // 絞込種類
        if (isset($this->filterType) && $this->filterType === 'has_image') {
            $query = $query->whereRaw("(info.file1 IS NOT NULL OR info.file2 IS NOT NULL "
                    . "OR info.file3 IS NOT NULL OR info.file4 IS NOT NULL "
                    . "OR info.file5 IS NOT NULL OR info.file6 IS NOT NULL "
                    . "OR info.comment LIKE '%<img%')");
        }

        // ナンバーの検索
        if( isset( $req['num'] ) && $req['num'] !== "" ){
            $query = $query->where( 'number', 'data' . $req['num'] );
        }
        
        // 表示順の条件
        $query = $this->buildOrderBy( $query, 'info' );
        
        // 拠点のテーブル名
        $baseTableName = (new Base)->getTable();

        //->where( 'shop', '=', $this->shopCode)
        $blogs = $query->where( 'info.published', 'ON' )
                // 表示するカラム
                ->selectRaw('info.*, b.base_name')
                // 削除日時がNULLのとき
                ->whereNull( 'info.deleted_at' )
                // 公開期間内のとき
                ->whereRaw( '((info.from_date <= now() AND info.to_date >= now()) OR '
                    . '(info.from_date <= now() AND info.to_date IS NULL) OR '
                    . '(info.from_date IS NULL AND info.to_date >= now()) OR '
                    . '(info.from_date IS NULL AND info.to_date IS NULL))' )
                // 拠点テーブルとのJOIN
                ->join( $baseTableName . ' AS b', function ($join) {
                    $join->on('b.base_code', 'info.shop'); // 拠点コード
                    $join->whereRaw("(b.show_flg = '1' OR b.show_flg IS NULL)"); // 表示機能
                    $join->on('b.hansha_code', DB::raw("'{$this->hanshaCode}'")); // 販社コード
                })
                // 削除フラグ
                ->whereNull('b.deleted_at')
                // 非公開の拠点は除く
                ->where( 'b.base_published_flg', '<>', 2 );
        
        // ページネーション
        $list['blogs'] = $blogs
                ->paginate($perPage);
        
        // 子テンプレート設定
        $template = 'api.common.admin.infobbs.base_' . $this->templateNo . '.search';
        // ビュー名
        $viewName = ".index_preview";
        $templateDir = "api.{$this->hanshaCode}.admin.infobbs";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.infobbs';
        }
        $viewName = $templateDir . $viewName;

        return view($viewName, $list) // 掲載設定機能で親テンプレート切り替え
            ->with('template', $template)
            ->with('templateDir', $templateDir)
            ->with('dataType', 'object')
            ->with('shopList', $shopList) // 店舗セレクトボックス
            ->with('shopCode', $shopCode) // 店舗コード
            ->with('shopName', $shopName) // 店舗セレクトselected
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('urlAction', action_auto($this->controller . '@getIndex'))
            ->with('isEmergencyBulletin', $isEmergencyBulletin); // カテゴリチェックボックス
    }
    
    public function getRule()
    {
        return view('api.common.admin.infobbs.rule');
    }

    /**
     * データ並べ替え
     * @return string
     */
    protected function dataSort(){
        return DB::transaction(function() {
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
                    return $this->getRedirectToIndexUrl();
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
                    return $this->getRedirectToIndexUrl();
                }
            }
        });
    }

    /**
     * 一覧画面への移動するURL
     */
    private function getRedirectToIndexUrl() {
        // URLのパラメーター
        $params = [];
        $paramStr = '';
        if (isset($_GET['shop']) && !empty($_GET['shop'])) {
            $params['shop'] = $_GET['shop'];
        }
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $params['page'] = $_GET['page'];
        }
        $count = count($params);
        if ($count > 0) {
            $paramStr .= '?';
            $i = 0;
            foreach ($params as $key => $value) {
                $paramStr .= "{$key}={$value}";
                if ($i < $count - 1) {
                    $paramStr .= '&';
                }
            }
        }
        return redirect(action_auto($this->controller . '@getIndex') . $paramStr);
    }
    
    /**
     * 記事を削除する
     * 
     * @param string $key 記事番号
     */
    private function deletePost($key) {
        // 添付された画像を削除する
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        $infoBbsInstance = $infoBbsInstance->where('number', $key)
                ->first();
        $fileNum = 6;
        // 画像ファイルのパスをリストに入れる
        $images = [];
        for($i = 1; $i <= $fileNum; $i++) {
            $columnName = "file{$i}";
            $value = $infoBbsInstance->{$columnName} ?? '';
            if (empty($value)) {
                continue;
            }
            $images[] = $value;
        }

        // テーブル削除
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        if ($infoBbsInstance->where('number', $key)
                ->delete()) {
            // 物理的に削除する
            foreach ($images as $imageName) {
                if (!file_exists($imageName)) {
                    continue;
                }
                unlink($imageName);
            }
        }
    }

    /**
     * 削除
     */
    public function getCompleteDelete() {
        DB::transaction(function() {
            $req = Request::all();
            $key = $req['number'] ?? '';
            if (empty($key)) {
                return;
            }
            
            $this->deletePost($key);
        });
    }

    /**
     * 削除
     */
    public function postConfirmDelete() {
        $req = Request::all();
        $number = $req['number'] ?? '';
        $shopCode = $req['shop'] ?? '';
        
        DB::transaction(function() use($number) {
            if (empty($number)) {
                return;
            }
            
            $this->deletePost($number);
        });
        
        // ビュー名
        $viewName = ".complete";
        $templateDir = "api.{$this->hanshaCode}.admin.infobbs";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.infobbs';
        }
        $viewName = $templateDir . $viewName;
        
        return view($viewName)
            ->with('urlAction', action_auto($this->controller . '@getIndex') . '?shop=' . $shopCode)
            ->with('msg','このデータを削除しました。');
    }

    /**
     * 一覧表示(一括編集ボタン)
     * @return string
     */
    public function postIndex(){
        DB::transaction(function() {
            $req = Request::all();// transactionの中に入れる

            foreach ($req as $key => $val){
                if(!strstr($key,'data')){
                    continue;
                }
                if(isset($val['del'])){
                    $this->deletePost($key);
                }else{
                    if ($this->published_mode == '1') {
                        // 現在データ
                        $row = DB::table(SessionUtil::getTableName())
                            ->selectRaw('title, published, editflag, category, msg1, comment')
                            ->where('number', '=', $key)
                            ->first();
                        // 店舗が存在しない場合、スキップ
                        if ($row === null) {
                            continue;
                        }
                        // 本社認証あり
                        $this->adminConfirmationOnBulkUpdate($key, $val, $row);
                    } else {
                        // 本社認証無し
                        $this->adminConfirmationOffBulkUpdate($key, $val);
                    }
                }
            }
        });
        
        $shop = SessionUtil::getShop();
        
        return view('api.common.admin.infobbs.complete')
            ->with('urlAction', action_auto($this->controller . '@getIndex') . '?shop=' . $shop)
            ->with('msg','データを編集しました。');
    }

    /**
     * 新規入力
     * @return string
     */
    public function getNew(){
        $this->initData();
        SessionUtil::putMode('new');    // 新規追加モード
        SessionUtil::putUpflag('');     // 更新フラグOFF
        return redirect(action_auto($this->controller . '@getUpload'));
    }

    /**
     * セッションdata初期化
     */
    protected function initData(){
        $data = array();
        
        $data['title'] = '';
        $data['comment'] = '';
        $data['file1'] = '';
        $data['file2'] = '';
        $data['file3'] = '';
        if ($this->use6FileInput) {
            $data['file4'] = '';
            $data['file5'] = '';
            $data['file6'] = '';
        }
        $data['caption1'] = '';
        $data['caption2'] = '';
        $data['caption3'] = '';
        if ($this->use6FileInput) {
            $data['caption4'] = '';
            $data['caption5'] = '';
            $data['caption6'] = '';
        }
        
        $data['category'] = '';
        $data['inquiry_method'] = '';
        $data['pos'] = '';
        $data['mail_addr'] = '';
        $data['form_addr'] = '';
        $data['inquiry_inscription'] = 'お問い合わせはこちら';
        $data['from_date'] = '';
        $data['to_date'] = '';
        
        $req = Request::all();
        $data['shop'] = $req['shop'];

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

    /**
     * 編集画面
     * @return string
     */
    public function getUpload(){
        $data = SessionUtil::getData();
        
        // セッションに残るデータを削除
        if (!$this->use6FileInput) {
            unset($data['file4']);
            unset($data['file5']);
            unset($data['file6']);
        }
        
        $data['from_date'] = !empty($data['from_date']) ? date('Y-m-d', strtotime($data['from_date'])) : '';
        $data['to_date'] = !empty($data['to_date']) ? date('Y-m-d', strtotime($data['to_date'])) : '';

        // お問い合わせ方法初期化
        if(!isset($data['inquiry_method'])){
            $data['inquiry_method'] = '';
        }
        // 子テンプレート
        $template = 'api.common.admin.infobbs.base_' . $this->templateNo . '.upload';
        
        $result = $this->modifyImageForDropZone($data['comment']);
        $data['comment'] = $result['content'];
        $data['existing_images'] = $result['existing_images'];
        
        $shopList = SessionUtil::getShopList();
        $shopName = $shopList[$data['shop']] ?? '';
        
        // コード
        $inquiryMethodCodes = [];
        if ($this->hanshaCode === '2153801') {
            $inquiryMethodCodes = (new InquiryMethodCodes())->getOptions();
        }
        
        // ビュー名
        $viewName = "api.{$this->hanshaCode}.admin.infobbs.upload";
        if (!view()->exists($viewName)) {
            $viewName = 'api.common.admin.infobbs.upload';
        }

        return view($viewName)->with('data', $data)
            ->with('inquiryMethodCodes', $inquiryMethodCodes)
            ->with('template', $template)
            ->with('dataType', 'array')
            ->with('tableType', $this->tableType)
            ->with('mode', SessionUtil::getMode()) // 新規 or 編集
            ->with('upflag', SessionUtil::getUpflag()) // 更新フラグ
            ->with('shopList', $shopList) // 店舗セレクトボックス
            ->with('shopName', $shopName) // 店舗セレクトselected
            ->with('hanshaCode', $this->hanshaCode) // 販社コード
            ->with('urlImageTmp', action_auto("Infobbs\ImageTmpController" . '@getIndex')) // 画像アップロード機能（本文）
            ->with('urlAction', action_auto($this->controller . '@postUpload'))
            ->with('urlDeleteConfirm', action_auto($this->controller . '@getConfirmDelete'));
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
     * 編集画面（次へボタン）
     * @return string
     */
    public function postUpload(InfobbsRequest $request){
        $req = $request->all();
        $this->loginAccountObj = SessionUtil::getUser();

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

        // 初期化（フォームから項目を取得）
        $data = array();
        // 掲載設定機能ONのみ
        $hanshaCode = $this->loginAccountObj->getHanshaCode();
        if($this->published_mode == '1'){
            $data['editflag'] = 'draft';
            if ($hanshaCode == '3751804' || $hanshaCode ='1253025'){
                $data['published'] = 'OFF';
            }
        }
        // 共通項目
        $data['title'] = $req['title'] ?? '';
        $data['comment'] = $req['comment'] ?? '';
        $data['caption1'] = $req['caption1'] ?? '';
        $data['caption2'] = $req['caption2'] ?? '';
        $data['caption3'] = $req['caption3'] ?? '';
        $data['shop'] = $req['shop'] ?? '';
        $data['from_date'] = $req['from_date'] ?? '';
        $data['to_date'] = $req['to_date'] ?? '';
        $data['inquiry_inscription'] = $req['inquiry_inscription'] ?? '';
        $data['form_addr'] = $req['form_addr'] ?? '';
        $data['mail_addr'] = $req['mail_addr'] ?? '';
        // セッションから取得
        $data['number'] = SessionUtil::getNumber();
        // 画像登録済みの場合セッションから取得
        $sessionData = SessionUtil::getData();
        if(isset($req['file1'])){
            // フォームから入力あり
            $data['file1'] = $req['file1'];
        }else{
            // セッションから取得
            if(substr($sessionData['file1'], 0,4) == 'err/'){
                // エラーの場合クリア
                $data['file1'] = '';
            }else{
                $data['file1'] = $sessionData['file1'];
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
        if(isset($req['file4'])){
            $data['file4'] = $req['file4'];
        }else{
            $data['file4'] = '';
            // セッションから取得
            if(isset($sessionData['file4']) && substr($sessionData['file4'], 0,4) != 'err/'){
                $data['file4'] = $sessionData['file4'];
            }
        }
        if(isset($req['file5'])){
            $data['file5'] = $req['file5'];
        }else{
            $data['file5'] = '';
            // セッションから取得
            if(isset($sessionData['file5']) && substr($sessionData['file5'], 0,4) != 'err/'){
                $data['file5'] = $sessionData['file5'];
            }
        }
        if(isset($req['file6'])){
            $data['file6'] = $req['file6'];
        }else{
            $data['file6'] = '';
            // セッションから取得
            if(isset($sessionData['file6']) && substr($sessionData['file6'], 0,4) != 'err/'){
                $data['file6'] = $sessionData['file6'];
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
        // 項目チェック（フォームにより項目が違う）
        if(isset($req['caption4'])){
            $data['caption4'] = $req['caption4'];
        }
        if(isset($req['caption5'])){
            $data['caption5'] = $req['caption5'];
        }
        if(isset($req['caption6'])){
            $data['caption6'] = $req['caption6'];
        }

        // 画像取得
        if(isset($req['file1'])){
            $fileName = ImageUtil::makeImage('file1',1, $this->tableNo, $this->tableType );
            $data['file1'] = $fileName;
        }
        if(isset($req['file2'])){
            $fileName = ImageUtil::makeImage('file2',2, $this->tableNo, $this->tableType );
            $data['file2'] = $fileName;
        }
        if(isset($req['file3'])){
            $fileName = ImageUtil::makeImage('file3',3, $this->tableNo, $this->tableType );
            $data['file3'] = $fileName;
        }
        if(isset($req['file4'])){
            $fileName = ImageUtil::makeImage('file4',4, $this->tableNo, $this->tableType );
            $data['file4'] = $fileName;
        }
        if(isset($req['file5'])){
            $fileName = ImageUtil::makeImage('file5',5, $this->tableNo, $this->tableType );
            $data['file5'] = $fileName;
        }
        if(isset($req['file6'])){
            $fileName = ImageUtil::makeImage('file6',6, $this->tableNo, $this->tableType );
            $data['file6'] = $fileName;
        }
        // 画像削除
        if(isset($req['file1_del'])){
            $data['file1'] = '';
        }
        if(isset($req['file2_del'])){
            $data['file2'] = '';
        }
        if(isset($req['file3_del'])){
            $data['file3'] = '';
        }
        if(isset($req['file4_del'])){
            $data['file4'] = '';
        }
        if(isset($req['file5_del'])){
            $data['file5'] = '';
        }
        if(isset($req['file6_del'])){
            $data['file6'] = '';
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
        if(substr($data['file1'],0,4) == 'err/' ||
           substr($data['file2'],0,4) == 'err/' ||
           substr($data['file3'],0,4) == 'err/' ||
           substr($data['file4'],0,4) == 'err/' ||
           substr($data['file5'],0,4) == 'err/' ||
           substr($data['file6'],0,4) == 'err/'
        ){
            return redirect(action_auto($this->controller . '@getUpload'));
        }
        return redirect(action_auto($this->controller . '@getConfirm'));
    }
    
    /**
     * 確認画面
     * @return string
     */
    public function getConfirm(){
        $data = SessionUtil::getData();
        // 子テンプレート
        $template = 'api.common.admin.infobbs.base_' . $this->templateNo . '.search';
        $shopList = SessionUtil::getShopList();
        $shopName = $shopList[$data['shop']] ?? [];
        
        // ビュー名
        $viewName = ".confirm";
        $templateDir = "api.{$this->hanshaCode}.admin.infobbs";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.infobbs';
        }
        $viewName = $templateDir . $viewName;

        return view($viewName)->with('data', $data)
            ->with('templateDir', $templateDir)
            ->with('template', $template)
            ->with('dataType', 'array')
            ->with('shopList', $shopList)  // 店舗セレクトボックス
            ->with('shopName', $shopName)
            ->with('urlAction',action_auto($this->controller . '@postConfirm'));
    }
    
    /**
     * 削除確認画面
     * @return string
     */
    public function getConfirmDelete(){
        $data = SessionUtil::getData();
        $shopList = SessionUtil::getShopList();
        $shopCode = $data['shop'] ?? '';
        $shopName = $shopList[$shopCode] ?? [];
        $number = $data['number'] ?? '';
        
        // 現在データ
        $row = DB::table(SessionUtil::getTableName())
                ->selectRaw('created_at')
                ->where('number', '=', $number)
                ->first();
        $createdAt = '';
        if ($row !== null) {
            $createdAt = $row->created_at;
        }
        
        // ビュー名
        $viewName = ".confirm_delete";
        $templateDir = "api.{$this->hanshaCode}.admin.infobbs";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.infobbs';
        }
        $viewName = $templateDir . $viewName;
        
        // URL
        $urlAction = action_auto($this->controller . '@postConfirmDelete') .
                "?number={$number}&shop={$shopCode}";

        return view($viewName)->with('data', $data)
            ->with('templateDir', $templateDir)
            ->with('dataType', 'array')
            ->with('shopList', $shopList)  // 店舗セレクトボックス
            ->with('shopName', $shopName)
            ->with('createdAt', $createdAt)
            ->with('urlAction', $urlAction);
    }

    /**
     * ブログ登録
     * @return string
     */
    public function postConfirm(){
        $req = Request::all();
        $data = SessionUtil::getData();

        if(isset($req['modulate'])){
            // 変種画面へ戻る
            return redirect(action_auto($this->controller . '@getUpload'));
        }
        
        // 初期値
        $number = '';
        $column = [];
        
        // 確認画面から 登録するボタンが押されたとき
        if(isset($req['register'])){
            $dateTime = date("Y-m-d H:i:s");
            $column = $this->makeColumn();

            /** 正常にテキストが切れないので、コメントアウト **/
            // 本文内にある絵文字のSJIS対応
            /*if( isset( $column['comment'] ) ){
                // 絵文字の変換
                $column['comment'] = $this->convertEmoji( $column['comment'] );
            }*/

            // タイトル内にある絵文字のSJIS対応
            /*if( isset( $column['title'] ) ){
                // 絵文字の変換
                $column['title'] = $this->convertEmoji( $column['title'] );
            }*/
            
            // 開始時間
            if (isset($column['from_date']) && !empty($column['from_date'])) {
                $column['from_date'] .= ' 00:00:00';
            }
            // 終了時間
            if (isset($column['to_date']) && !empty($column['to_date'])) {
                $column['to_date'] .= ' 23:59:59';
            }

            // 記事の編集の時
            if(SessionUtil::getMode() == 'mod'){
                $column = $this->setColumn('updated_at',$dateTime,$column);
                
                $number = $data['number'];

                /**
                * C千葉様のみ
                * 記事の編集するときもともとの[status]がそのままのため
                */
                if ($this->loginAccountObj->gethanshaCode() == '8812391'){
                    $row = DB::table(SessionUtil::getTableName())
                        ->where('number', $number)
                        ->first();
                    $column['published'] = $row->published;
                }
                // テーブル更新 
                DB::table(SessionUtil::getTableName())->where('number', $number)
                    ->update($column);
            }else{ // 記事の新規登録の時
                // 新規テーブル
                // 掲載番号で掲載番号を生成する
                $row = DB::table(SessionUtil::getTableName())
                    ->select(['number'])
                    ->whereNotNull('number')
                    ->orderBy('number', 'DESC')
                    ->first();
                $maxNumber = 0;
                if ($row !== null) {
                    $maxNumber = (int)str_replace('data', '', $row->number);
                }
                // 登録番号で掲載番号を生成する
                $row = DB::table(SessionUtil::getTableName())
                    ->select(['regist'])
                    ->whereNotNull('regist')
                    ->orderBy('regist', 'DESC')
                    ->first();
                $maxRegist = 0;
                if ($row !== null) {
                    $maxRegist = $row->regist;
                }
                // 掲載番号と登録番号を比較して最大数を掲載番号にする
                $num = 0;
                if ($maxNumber > $maxRegist) {
                    $num = $maxNumber;
                } else {
                    $num = $maxRegist;
                }
                // 掲載番号を作成する
                $num++;
                $number = "data" . substr("00000" . strval($num),-6);
                
                $column = $this->setColumn('regist',$num,$column);
                $column = $this->setColumn('number',$number,$column);
                $column = $this->setColumn('created_at',$dateTime,$column);
                $column = $this->setColumn('updated_at',$dateTime,$column);
                $column = $this->setColumn('add',$_SERVER['SERVER_NAME'] . '(' . $_SERVER['SERVER_ADDR'] . ')',$column);
                $column = $this->setColumn('agent',$_SERVER['HTTP_USER_AGENT'],$column);
                $column = $this->setColumn('published','OFF',$column);
 
                // 新規テーブル作成
                DB::table(SessionUtil::getTableName())->insert($column);
                
                /**
                 * メール通知を送信
                 */
                // 緊急掲示板の店舗コード
                $emergencyBulletinShopId = $this->getEmergencyBulletinShopId();
                // 緊急掲示板の店舗を除外する
                if (($emergencyBulletinShopId === null || $emergencyBulletinShopId !== $data['shop'])
                    // 記事を登録した通知がON
                    && in_array(InfobbsCoreController::NOTIFICATION_POST_REGISTERED, $this->notificationTypes)
                ) {
                    // メール通知を送信
                    $this->sendUploadMail(null, 'infobbs', InfobbsCoreController::NOTIFICATION_POST_REGISTERED);
                }
            }
            
            // 記事の内容が空でないとき
            if ( !empty( $column['comment'] ) == true ){
                // 販社コード
                $hanshaCode = $this->loginAccountObj->gethanshaCode();
                // 画像の保存先のパス
                $dir = realpath( 'data/image');
                $dir = $dir . DIRECTORY_SEPARATOR . $hanshaCode;
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                // $replacedContentは記事の内容の変換される結果
                $replacementContent = ImageUtil::base64ToImageFromString( $column['comment'], $dir, $hanshaCode, 'infobbs', false );
                // テーブル更新 
                DB::table(SessionUtil::getTableName())->where('number', $number)
                    ->update(['comment' => $replacementContent]);
            }
            
            // セッションを削除
            SessionUtil::removeData();
            
            if (SessionUtil::getIsConfirmation()) {
                $urlAction = CodeUtil::getV2Url('Admin\HobbsController@getIndex', $this->hanshaCode);
            } else {
                $urlAction = action_auto($this->controller . '@getIndex') . '?shop=' . $data['shop'];
            }
        
            // ビュー名
            $viewName = ".complete";
            $templateDir = "api.{$this->hanshaCode}.admin.infobbs";
            if (!view()->exists($templateDir . $viewName)) {
                $templateDir = 'api.common.admin.infobbs';
            }
            $viewName = $templateDir . $viewName;

            return view($viewName, $data)->with('msg','データを登録しました。')
                ->with('urlAction', $urlAction);
        }
    }

    /**
     * カラム作成
     * @return string
     */
    protected function makeColumn(){
        $data = SessionUtil::getData();

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
    
    /**
     * コメントデータ作成
     * array $blog ブログリスト
     * @return array
     */
    protected function makeComment($blog){
        
        $table_name = 'tb_'.$this->tableNo.'_infobbs_comment';
                
        $list = array();
        foreach ($blog as $row){
            $comment = DB::table($table_name)
                ->where('num', '=', $row->number)->where('deleted_at',null)->orderBy('created_at','DESC')->get();
            $data = array();
            foreach ($comment as $com){
                $tmp = array();
                $tmp['date'] = $com->created_at;
                
                if(!empty($com->mark)) {
                    $tmp['mark'] = "img/hakusyu/".$com->mark.".png";
                    if($this->tableNo == '1011801'){
                        // 東京中央のみ
                        $tmp['mark'] = "img/hakusyu/1011801/".$com->mark.".png";
                    } else if ($com->mark == 'GJ') {
                        // Good Job -> 北大阪のみ
                        $tmp['mark'] = "img/hakusyu/".$com->mark.".gif";
                    }
                }else{
                    $tmp['mark'] = '';
                }

                // コメントの内容
                $comment = $com->comment;
                $comment = str_replace('<', '&lt;', $comment);
                $comment = str_replace('>', '&gt;', $comment);
                $comment = $this->convertEmojiToHtmlEntity($comment);
                $tmp['comment'] = $comment;
                
                $data[] = $tmp;
            }
            $list[$row->number] = $data;
        }
        
        return $list;
    }
    
}
