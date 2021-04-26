<?php

namespace App\Http\Controllers\Admin;

use App\Original\Util\SessionUtil;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tCommon;

/**
 * 各店情報掲示板
 *
 * @author M.ueki
 *
 */
class StafflistController extends Controller {
    use tCommon;
    
    /**
     * コンストラクタ
     */
    public function __construct() {
    }

    /**
    * Index
    */
    public function getIndex() {
        $loginAccountObj = SessionUtil::getUser();
        $hansha_code =  $loginAccountObj->gethanshaCode();
        // 拠点の一覧を取得 スタッフブログのみ
        $shopList = $this->shopList( $hansha_code, 2 );
        return view('admin.stafflist',compact('shopList'))
            ->with('urlActionProfiles',action_auto("Infobbs\StaffbbsController" . '@getIndex'))
            ->with('urlActionList',action_auto("Infobbs\StaffbbsController" . '@getList'));  // 掲示板の管理画面
    }
}