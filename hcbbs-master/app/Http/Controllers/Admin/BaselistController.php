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
class BaselistController extends Controller {
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
        // 拠点の一覧を取得 店舗ブログのみ
        $shopList = $this->shopList( $hansha_code, 1 );
        return view('admin.baselist',compact('shopList'))
            ->with('urlActionInfobbs',action_auto("Infobbs\InfobbsController" . '@getIndex'));  // 掲示板の管理画面
    }
}