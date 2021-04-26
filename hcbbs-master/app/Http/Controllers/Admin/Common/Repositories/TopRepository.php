<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Original\Util\SessionUtil;
use App\Original\Util\CodeUtil;
use App\Http\Controllers\DBTrait;
use App\Http\Controllers\tCommon;

/**
 * Description of CommonTopRepository
 *
 * @author ahmad
 */
trait TopRepository {
    
    use tCommon, DBTrait;
    
    /**
     * 販社コード
     * 
     * @var string
     */
    protected $hanshaCode;

    /**
     * コンストラクタ
     */
    public function __construct() {
        // ログインユーザ
        $loginAccountObj = SessionUtil::getUser();
        // 販社コード
        $this->hanshaCode = $loginAccountObj->getHanshaCode();
        // テーブル名をセッションに保存(販社コードがテーブル名)
        SessionUtil::putTableName('tb_' . $this->hanshaCode . '_infobbs');
        // 1ページの表示数をセッションに保存
        $para = config('original.para')[$this->hanshaCode] ?? [];
        SessionUtil::putPageNum($para['page_num'] ?? 10);
        
        // 店舗リストをセッションに保存
        SessionUtil::putShopList($this->shopList($this->hanshaCode, 1));
        // カテゴリセレクト初期設定
        SessionUtil::putCategorySelected('全て');
        // テーブルチェック、自動生成
        $this->checkTable();
    }
    
    /**
     * 緊急掲示板の店舗コード
     * 
     * @return string|null
     */
    private function getEmergencyBulletinShopId() {
        return config("{$this->hanshaCode}.general.emergency_bulletin_board_id");
    }
    
    /**
    * Index
    */
    public function getIndex() {
        $loginAccountObj = SessionUtil::getUser();
        $account_level = $loginAccountObj->getAccountLevel();
        
        // 各店情報掲示板
        $urlActionInfobbs = CodeUtil::getV2Url('Admin\BaseListController@getIndex', $this->hanshaCode);
        
        // スタッフ日記
        $urlActionStaffbbs = CodeUtil::getV2Url('Admin\StaffListController@getIndex', $this->hanshaCode);
        
        // スタッフブログ
        $urlActionInfobbsStaff = CodeUtil::getV2Url('Admin\StaffInfoController@getList', $this->hanshaCode);
        
        // ショールーム情報
        $urlActionShowroom = CodeUtil::getV2Url('Admin\SrInfoController@getIndex', $this->hanshaCode);
        
        // 掲示板の公開画面
        //$urlActionViewbbs = CodeUtil::getV2Url('Admin\ViewbbsController@getIndex', $this->hanshaCode);
        
        // 本社用管理画面
        $urlActionHobbs = CodeUtil::getV2Url('Admin\HobbsController@getIndex', $this->hanshaCode);
        
        // 一行メッセージ
        $urlActionMessage = CodeUtil::getV2Url('Admin\MessageController@getIndex', $this->hanshaCode);
        
        // アクセス集計
        $urlActionAccessCounter = CodeUtil::getV2Url('Admin\AccessCounterController@getCount', $this->hanshaCode);
        // 一週間ごとのアクセス集計
        $urlAccessCounterOneWeek = CodeUtil::getV2Url('Admin\AccessCounterController@getOneWeek', $this->hanshaCode);
        
        // ブログ更新ログ
        $urlBlogUpdateLog = CodeUtil::getV2Url('Admin\BlogUpdateLogController@getIndex', $this->hanshaCode);
        
        $viewName = "api.{$this->hanshaCode}.admin.top";
        if (!view()->exists($viewName)) {
            $viewName = "api.common.admin.top.top_auto";
        }
        
        // 緊急掲示板の除外
        $emergencyBulletinShopCode = $this->getEmergencyBulletinShopId();
        
        return view($viewName, compact(
            'account_level',
            'urlActionInfobbs',
            'urlActionStaffbbs',
            'urlActionInfobbsStaff',
            'urlActionShowroom',
            //'urlActionViewbbs',
            'urlActionHobbs',
            'urlActionShopRankCount',
            'urlActionMessage',
            'urlActionAccessCounter',
            'urlAccessCounterOneWeek',
            'urlBlogUpdateLog',
            'emergencyBulletinShopCode'
        ));
    }
    
}
