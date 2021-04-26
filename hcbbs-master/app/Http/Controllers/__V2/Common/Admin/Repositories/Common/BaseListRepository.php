<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V2\Common\Admin\Repositories\Common;

use App\Original\Util\SessionUtil;
use App\Http\Controllers\tCommon;

/**
 * Description of CommonBaseListRepository
 *
 * @author ahmad
 */
trait BaseListRepository {
    
    use tCommon;
    
    /**
     * 販社コード
     * 
     * @var string
     */
    protected $hanshaCode;

    /**
     * 一覧ページ
     * 
     * @return object
     */
    public function getIndex() {
        $loginAccountObj = SessionUtil::getUser();
        // 販社コード
        $this->hanshaCode = $loginAccountObj->getHanshaCode();
        // 拠点の一覧を取得 店舗ブログのみ
        $shopList = $this->shopList( $this->hanshaCode, 1 );
        
        // 掲示板の管理画面
        $urlActionInfobbs = action_auto("V2\_{$this->hanshaCode}"
            . "\Admin\InfobbsController" . '@getIndex');
        // TOPページ
        $urlActionTop = action_auto("V2\_{$this->hanshaCode}"
            . "\Admin\AdminController" . '@getIndex');
        
        return view('api.common.admin.baselist.index', compact(
            'shopList',
            'urlActionInfobbs',
            'urlActionTop'
        ));
    }
    
}
