<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories;

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

        // 掲載モード
        $publishedMode = config("original.para.{$this->hanshaCode}.published_mode") ?? 0;
        
        // 緊急掲示板
        $emergencyBulletinShopId = config("{$this->hanshaCode}.general.emergency_bulletin_board_id");

        // 拠点の一覧を取得 店舗ブログのみ
        $shopList = $this->shopList( $this->hanshaCode, 1 );
        // カスタムな店舗一覧
        $customShopList = config("{$this->hanshaCode}.general.admin_honsya_config.base_list");
        // カスタムな店舗一覧があるフラグ
        $hasCustomShopList = is_array($customShopList);

        // ユーザー権限
        $userLevel = $loginAccountObj->getAccountLevel();
        
        // カスタムな店舗一覧があって
        // 本社承認機能があって
        // 本社権限の場合
        if ($hasCustomShopList && $publishedMode == 1 && $userLevel <= 2) {
            $temp = [];
            // 配列にある店舗一覧を読み込む
            foreach ($customShopList as $shopCode) {
                if (!isset($shopList[$shopCode])) {
                    continue;
                }
                $temp[$shopCode] = $shopList[$shopCode];
            }
            $shopList = $temp;
        } else if ($emergencyBulletinShopId !== null) {
            // 緊急掲示板を一番したにする
            $temp = [];
            // 配列にある店舗一覧を読み込む
            $bulletinShopData = [];
            foreach ($shopList as $shopCode => $shopName) {
                if ($shopCode == $emergencyBulletinShopId) {
                    $bulletinShopData[$shopCode] = $shopName;
                    continue;
                }
                if (!isset($shopList[$shopCode])) {
                    continue;
                }
                $temp[$shopCode] = $shopList[$shopCode];
            }
            $shopList = $temp;
            // キーがうまく取れないため、ループデータを入れる
            foreach ($bulletinShopData as $shopCode => $shopName) {
            	$shopList[$shopCode] = $shopName;
            }
        }

        
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
