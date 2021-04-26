<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V2\Common\Admin\Repositories\Common;

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
        $para = Config('original.para')[$this->hanshaCode];
        SessionUtil::putPageNum($para['page_num']);
        
        // 店舗リストをセッションに保存
        SessionUtil::putShopList($this->shopList($this->hanshaCode));
        // カテゴリセレクト初期設定
        SessionUtil::putCategorySelected('全て');
        // テーブルチェック、自動生成
        $this->checkTable();
    }
    
    /**
    * Index
    */
    public function getIndex() {
        $loginAccountObj = SessionUtil::getUser();
        $account_level = $loginAccountObj->getAccountLevel();
        
        // 各店情報掲示板
        $urlActionInfobbs = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/BaseListController')) {
            $urlActionInfobbs = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\BaseListController@getIndex");
        }
        
        // スタッフ日記
        $urlActionStaffbbs = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/StaffListController')) {
            $urlActionStaffbbs = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\StaffListController@getIndex");
        }
        
        // スタッフブログ
        $urlActionInfobbsStaff = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/StaffInfoController')) {
            $urlActionInfobbsStaff = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\StaffInfoController" . '@getList');
        }
        
        // ショールーム情報
        $urlActionShowroom = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/SrInfoController')) {
            $urlActionShowroom = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\SrInfoController" . '@getIndex');
        }
        
        // 掲示板の公開画面
        $urlActionViewbbs = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/ViewbbsController')) {
            $urlActionShowroom = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\ViewbbsController" . '@getIndex');
        }
        
        // 本社用管理画面
        $urlActionHobbs = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/HobbsController')) {
            $urlActionHobbs = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\HobbsController" . '@getIndex');
        }
        
        // アクセス集計
        $urlActionShopRankCount = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/BbsCountController')) {
            $urlActionShowroom = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\BbsCountController" . '@getCount')
                . '?hansha_code=' . $this->hanshaCode;
        }
        
        // 一行メッセージ
        $urlActionMessage = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/MessageController')) {
            $urlActionMessage = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\MessageController" . '@getIndex');
        }
        
        // 各店情報掲示板 店舗別集計ツール
        $urlActionAccessCounter = null;
        if (CodeUtil::isV2Has($this->hanshaCode, 'Admin/AccessCounterController')) {
            $urlActionAccessCounter = action_auto("V2\_{$this->hanshaCode}"
                . "\Admin\AccessCounterController" . '@getCount');
        }
        
        $viewName = "api.{$this->hanshaCode}.admin.top";
        if (!view()->exists($viewName)) {
            $viewName = "api.common.admin.top.top_auto";
        }
        
        return view($viewName, compact(
            'account_level',
            'urlActionInfobbs',
            'urlActionStaffbbs',
            'urlActionInfobbsStaff',
            'urlActionShowroom',
            'urlActionViewbbs',
            'urlActionHobbs',
            'urlActionShopRankCount',
            'urlActionMessage',
            'urlActionAccessCounter'
        ));
    }
    
}
