<?php

namespace App\Http\Controllers;

use DB;
use App\Original\Util\SessionUtil;
use App\Http\Controllers\Api\Common\Traits\Infobbs\ConvertEmojis;

/**
 * 共通関数のトレイト
 */
trait tCommon {
    
    use ConvertEmojis;

    /**
     * 拠点リスト
     * @param char    $hansha_code 販社コード
     * @param integer $show_flg    表示フラグ 0:すべて表示 1:店舗ブログのみ 2:スタッフブログのみ
     * @return array
     */
    public function shopList( $hansha_code, $show_flg=0 ) {
        $shopList = array();
        // ログインユーザ
        $query = DB::table( 'base' )
                ->where( 'hansha_code',$hansha_code )
                ->where( 'deleted_at', null );

        // 表示フラグの絞り込み
        if( !empty( $show_flg ) == True ){
            $sql = " (
                        -- 表示フラグが指定のとき　1: 店舗ブログ  2:スタッフブログ
                        show_flg = {$show_flg} OR
                        -- 表示フラグがすべて表示のもの
                        show_flg IS NULL
                    ) ";
            $query->whereRaw( DB::Raw( $sql ) );
        }
                
        $list = $query->orderBy( 'base_code','asc' )
                    ->get();
        // 配列に格納
        foreach ($list as $val){
            $shopList[$val->base_code] = $val->base_name;
        }
        return $shopList;
    }

    /**
     * 拠点リスト
     * @param char $hansha_code
     * @return array
     */
    public function shopListStaff($hansha_code) {
        $shopList = array();
        // ログインユーザ
        $list = DB::table('base')->where('hansha_code',$hansha_code)->where('deleted_at',null)->orderBy('base_code','asc')->get();
        // 配列に格納
        foreach ($list as $val){
            $shopList[$val->base_code] = $val->base_name;
        }
        return $shopList;
    }
    
    /**
     * 全販社、拠点リスト
     * @return array
     */
    public function shopAllList() {
        $shopAllList = array();
        foreach (Config('original.hansha_code') as $hansha_code => $hansha_name){
            $shopList = array();
            $list = DB::table('base')->where('hansha_code',$hansha_code)->where('deleted_at',null)->orderBy('base_code','asc')->get();
            foreach ($list as $val){
                $shopList[$val->base_code] = $val->base_name;
            }
            $shopAllList[$hansha_code] = $shopList;
        }

        return $shopAllList;
    }
    
    /**
     * selectイベント 拠点リスト作成
     * @return array
     */
    public function postShopList( $hansha_code='' ){
        $shopList = array();
        $list = DB::table('base')->where('hansha_code',$hansha_code)->where('deleted_at',null)->orderBy('base_code','asc')->get();
        foreach ($list as $val){
            $shopList[$val->base_code] = $val->base_name;
        }
        
        return $shopList;
    }

    /**
     * 絵文字の変換
     * 
     * @param string $content
     * @return string
     */
    private function convertEmojiToHtmlEntity( $content )
    {
        return $this->convertEmoji($content);
    }
    

    
}


