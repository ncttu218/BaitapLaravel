<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\_5756013\Admin\Repositories;

use App\Original\Util\SessionUtil;
use App\Original\Util\CodeUtil;
use App\Http\Controllers\tCommon;
use App\Http\Controllers\V3\_5756013\Codes\ShopBlogCodes;
use DB;

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
        $shopList = $this->getShopList( $this->hanshaCode );
        
        // 掲示板の管理画面
        $urlActionInfobbs = CodeUtil::getV2Url('Admin\InfobbsController@getIndex', $this->hanshaCode);
        // TOPページ
        $urlActionTop = CodeUtil::getV2Url('Admin\AdminController@getIndex', $this->hanshaCode);
        
        return view('v3.common.admin.baselist.index', compact(
            'shopList',
            'urlActionInfobbs',
            'urlActionTop'
        ));
    }
    
    /**
     * 拠点リスト
     * @param char    $hansha_code 販社コード
     * @return array
     */
    private function getShopList() {
        // 店舗コード
        $shopBlogCodes = (new ShopBlogCodes)->getOptions();
        
        $shopList = array();
        // ログインユーザ
        $query = DB::table( 'base' )
                ->where( 'hansha_code', $this->hanshaCode )
                ->where( 'deleted_at', null );

        // 表示フラグの絞り込み
        $sql = " (
                    -- 表示フラグが指定のとき　1: 店舗ブログ  2:スタッフブログ
                    show_flg = 1 OR
                    -- 表示フラグがすべて表示のもの
                    show_flg IS NULL
                ) ";
        $query->whereRaw( DB::Raw( $sql ) );
                
        $list = $query->orderBy( 'base_code','asc' )
                    ->get();
        // 配列に格納
        foreach ($list as $val) {
            if (!in_array($val->base_code, $shopBlogCodes)) {
                continue;
            }
            $shopList[$val->base_code] = $val->base_name;
        }
        return $shopList;
    }
    
}
