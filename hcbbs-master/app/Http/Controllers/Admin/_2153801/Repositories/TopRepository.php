<?php

namespace App\Http\Controllers\Admin\_2153801\Repositories;

use App\Http\Controllers\tCommon;
use App\Http\Controllers\DBTrait;
use App\Models\Base;
use App\Original\Codes\Aichi\EventBlockCodes;
use App\Original\Codes\Aichi\UsedcarBlockCodes;
use App\Original\Util\CodeUtil;
use App\Original\Util\SessionUtil;
use Request;

/**
 * 管理画面のTOPページ
 * 
 * @author ahmad
 */
trait TopRepository
{
    use tCommon, DBTrait;
    use DesignRepository;

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
    }
    
    /**
     * TOPメニュー一覧
     */
    public function getIndex() {
        // テーブルチェック、自動生成
        $this->checkTable();
        // ユーザー
        $loginAccountObj = SessionUtil::getUser();
        $account_level = $loginAccountObj->getAccountLevel();
        
        // 店舗リストをセッションに保存
        SessionUtil::putShopList($this->shopList($this->hanshaCode, 1));
        // カテゴリセレクト初期設定
        SessionUtil::putCategorySelected('全て');
        // 1ページの表示数をセッションに保存
        $para = config('original.para')[$this->hanshaCode];
        SessionUtil::putPageNum($para['page_num']);
        
        // ビュー名
        $level = $account_level < 3 ? 1 : 0;
        $viewName = "api.{$this->hanshaCode}.admin.top.top{$level}";
        
        // 緊急掲示板の除外
        $emergencyBulletinShopCode = Base::getEmergencyBulletinShopId($this->hanshaCode);
        
        // コード
        $eventBlockCodes = (new EventBlockCodes())->getOptions();
        $usedcarBlockCodes = (new UsedcarBlockCodes())->getOptions();
        $shopList = $this->shopList($this->hanshaCode);
        
        ########################################################################
        # URL
        ########################################################################
        // 店舗ブログ一覧
        $urlInfobbsAdmin = CodeUtil::getV2Url('Admin\InfobbsController@getIndex', $this->hanshaCode);
        // 本社承認
        $urlInfobbsAdminConfirmation = '';
        if ($account_level < 3) {
            $urlInfobbsAdminConfirmation = CodeUtil::getV2Url('Admin\HobbsController@getIndex', $this->hanshaCode);
        }
        // プレビュー一覧
        $urlListPreview = CodeUtil::getV2Url('Admin\InfobbsController@getIndexPreview', $this->hanshaCode);
        // アクセス集計
        $urlActionAccessCounter = CodeUtil::getV2Url('Admin\AccessCounterController@getCount', $this->hanshaCode);
        // ブログ更新ログ
        $urlBlogUpdateLog = CodeUtil::getV2Url('Admin\BlogUpdateLogController@getIndex', $this->hanshaCode);
        // 背景デザイン編集
        $urlDesignEdit = CodeUtil::getV2Url('Admin\DesignController@getEdit', $this->hanshaCode);
        ########################################################################
        
        return view($viewName, compact(
            'shopList',
            'emergencyBulletinShopCode',
            'eventBlockCodes',
            'usedcarBlockCodes',
            'urlInfobbsAdmin',
            'urlInfobbsAdminConfirmation',
            'urlListPreview',
            'urlActionAccessCounter',
            'urlBlogUpdateLog',
            'urlDesignEdit'
        ));
    }
    
}
