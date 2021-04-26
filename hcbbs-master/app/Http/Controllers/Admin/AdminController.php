<?php

namespace App\Http\Controllers\Admin;

use App\Original\Util\SessionUtil;
use App\Http\Controllers\Controller;
use Request;
use Session;
use DB;
use App\Http\Controllers\tCommon;
use App\Http\Controllers\DBTrait;

/**
 * 管理画面
 *
 * @author M.ueki
 *
 */
class AdminController extends Controller {
    use tCommon,DBTrait;
    /**
     * コンストラクタ
     */
    public function __construct() {
        // ログインユーザ
        $loginAccountObj = SessionUtil::getUser();
        // テーブル名をセッションに保存(販社コードがテーブル名)
        SessionUtil::putTableName('tb_' . $loginAccountObj->getHanshaCode() . '_infobbs');
        // 1ページの表示数をセッションに保存
        $para = Config('original.para')[$loginAccountObj->getHanshaCode()];
        SessionUtil::putPageNum($para['page_num']);
        
        // 店舗リストをセッションに保存
        SessionUtil::putShopList($this->shopList($loginAccountObj->gethanshaCode()));
        // カテゴリセレクト初期設定
        SessionUtil::putCategorySelected('全て');
        // テーブルチェック、自動生成
        $this->checkTable();
    }
    
    /**
    * Index
    */
    public function getIndex() {
        // 販社コード
        $loginAccountObj = SessionUtil::getUser();
        $account_level = $loginAccountObj->getAccountLevel();
        $hanshaCode = $loginAccountObj->getHanshaCode();
        
        // v2があるか
        if (\App\Original\Util\CodeUtil::isV2($hanshaCode)) {
            // v2のURLに移動
            return redirect()->intended('v2/admin/' . $hanshaCode . '/top');
        }
        
        return view('admin.top',compact('account_level','hanshaCode'))
            ->with('urlActionInfobbs',action_auto("Admin\BaselistController" . '@getIndex'))  // 各店情報掲示板
            ->with('urlActionInfobbsStaff',action_auto("Admin\StafflistController" . '@getIndex'))  // スタッフブログ
            ->with('urlActionViewbbs',action_auto("Infobbs\ViewbbsController" . '@getIndex'))  // 掲示板の公開画面
            ->with('urlActionHobbs',action_auto("Infobbs\HobbsController" . '@getIndex'))     // 本社用管理画面
            ->with( 'urlActionShopRankCount', action_auto("BbsCount\BaseController" . '@getCount') . '?hansha_code=' . $hanshaCode ); // アクセス集計
    }
}
