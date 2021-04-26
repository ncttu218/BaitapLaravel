<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\Common\Admin\Repositories;

use App\Original\Util\SessionUtil;
use App\Original\Util\CodeUtil;
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
        
        // 緊急掲示板
        $emergencyBulletinShopId = config("{$this->hanshaCode}.general.emergency_bulletin_board_id");
        
        // 掲示板の管理画面
        $urlActionInfobbs = CodeUtil::getV2Url('Admin\InfobbsController@getIndex', $this->hanshaCode);
        // 緊急掲示板の管理画面
        $urlActionEmergencyBulletin = CodeUtil::getV2Url('Admin\EmergencyBulletinController@getIndex', $this->hanshaCode);
        // TOPページ
        $urlActionTop = CodeUtil::getV2Url('Admin\AdminController@getIndex', $this->hanshaCode);
        
        return view('api.common.admin.baselist.index', compact(
            'shopList',
            'urlActionInfobbs',
            'urlActionTop',
            'emergencyBulletinShopId',
            'urlActionEmergencyBulletin'
        ));
    }
    
}
