<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories\Infobbs;

use App\Http\Controllers\Infobbs\TAdminConfirmation;
use App\Http\Controllers\tCommon;
use App\Http\Controllers\tSendMail;
use App\Original\Util\ImageUtil;
use App\Original\Util\SessionUtil;
use App\Models\Infobbs;
use DB;
use Request;

/**
 * Description of BlogConfirmationListRepository
 *
 * @author ahmad
 */
trait BlogConfirmationListRepository {
    
    /**
     * 一覧表示
     * @return string
     */
    public function overrideGetIndex(){
        $req = Request::all();
        // 販社コード
        $loginAccountObj = SessionUtil::getUser();
        $hansha_code =  $loginAccountObj->gethanshaCode();

        if(isset($req) && isset($req['shop'])){
            // 初期表示
            SessionUtil::putShop($req['shop']); // 店舗No
            
            // 店舗名取得
            $shopList = $this->shopList($hansha_code);
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
                // 編集画面
                return redirect(action_auto($this->controller . '@getUpload'));
            }
            // ボタン押下、データ並べ替え
            $this->dataSort();
        }

        // 一覧表示
        $infoBbsInstance = Infobbs::createNewInstance( $hansha_code );
        $list['blogs'] = $infoBbsInstance->where('shop', '=', SessionUtil::getShop())
            ->orderBy('regist', 'desc')
            ->paginate(SessionUtil::getPageNum());
        
        // 子テンプレート設定
        $template = 'api.common.admin.infobbs.base_' . $this->templateNo . '.search';

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
        // コメント取得
        $comment = array();
        if($this->comment == '1'){
            $comment = $this->makeComment($list['blogs']);
        }
        // メールアドレス登録
        $mailReg = config('original.para')[$hansha_code]['mail_register'] ?? '0';
        // メール登録のURL
        $urlMailRegister = action_auto('Other\MailRegisterController@getRegister')
                . '?shop=' . $shopCode . '&system_name=infobbs';

        return view('api.common.admin.infobbs.search_' . $this->published_mode . '_style2', $list) // 掲載設定機能で親テンプレート切り替え
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('mailReg', $mailReg) // メールアドレス登録
            ->with('shopList', $shopList) // 店舗セレクトボックス
            ->with('shopCode', $shopCode) // 店舗コード
            ->with('shopName', $shopName) // 店舗セレクトselected
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('urlAction', action_auto($this->controller . '@getIndex'))
            ->with('urlNew', $urlNew)
            ->with('urlMailRegister', $urlMailRegister)
            ->with('comment', $comment)
            ->with('category', $this->category); // カテゴリチェックボックス
    }
    
}
