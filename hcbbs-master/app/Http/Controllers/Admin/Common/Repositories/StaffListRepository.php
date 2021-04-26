<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Http\Controllers\tCommon;
use App\Original\Util\SessionUtil;
use App\Original\Util\CodeUtil;

/**
 * Description of StaffListRepository
 *
 * @author ahmad
 */
trait StaffListRepository {
    
    use tCommon;
    
    /**
     * 販社コード
     * 
     * @var string
     */
    protected $hanshaCode;

    /**
    * Index
    */
    public function getIndex() {
        $loginAccountObj = SessionUtil::getUser();
        // 販社コード
        $this->hanshaCode = $loginAccountObj->getHanshaCode();
        // 拠点の一覧を取得 スタッフブログのみ
        $shopList = $this->shopList( $this->hanshaCode, 2 );
        // TOPページ
        $urlActionTop = CodeUtil::getV2Url('Admin\AdminController@getIndex', $this->hanshaCode);
        
        $viewName = "api.{$this->hanshaCode}.admin.stafflist.index";
        if (!view()->exists($viewName)) {
            $viewName = "api.common.admin.stafflist.index";
        }
        
        return view($viewName,
            compact(
                'shopList',
                'urlActionTop'
            )
        )
        ->with('urlActionProfiles', CodeUtil::getV2Url('Admin\StaffbbsController@getIndex', $this->hanshaCode))
        ->with('urlActionList', CodeUtil::getV2Url('Admin\StaffbbsController@getList', $this->hanshaCode));  // 掲示板の管理画面
    }
}
