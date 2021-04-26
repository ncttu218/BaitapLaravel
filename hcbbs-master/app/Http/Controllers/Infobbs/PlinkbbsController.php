<?php

namespace App\Http\Controllers\Infobbs;

use App\Http\Controllers\Controller;
use Request;
use DB;

/**
 * 公開画面、単独表示機能
 * パーマリンクで個別記事表示
 *
 * @author M.ueki
 *
 */
class PlinkbbsController extends Controller {

    /**
     * コンストラクタ
     */
    public function __construct() {
    }

    /**
     * 公開画面、単独表示機能
     * @return string
     */
    public function getIndex(){
        $req = Request::all();

        // アカウント情報取得
        $account = DB::table('tb_account_hansha')
            ->where('user_login_id', '=', $req['id'])
            ->get();

        // 店舗No
        $shop = $req['shop'];
        // 店舗リスト作成
        $hansha_code = $account[0]->hansha_code;
        $list = DB::table('base')->where('hansha_code',$hansha_code)->where('deleted_at',null)->orderBy('base_code','asc')->get();
        $shopList = array();
        foreach ($list as $val){
            $shopList[$val->base_code] = $val->base_name;
        }

        // テーブル名
        $tableName ='tb_' . $account[0]->hansha_code . '_infobbs';
        // 子テンプレート
        $template = 'infobbs.base_' . '1351100' . '.search';
        // データ取得
        $data = DB::table($tableName)
            ->where('number', '=', $req['number']) // ブログNo
            ->where('shop', '=', $shop)
            ->get();
        // テンプレート取得
        return view('infobbs.search_pl')
            ->with('blogs', $data)
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('shopList', $shopList)    // 店舗セレクトボックス
            ->with('shop', $shop);    // 店舗セレクトselected
    }
}
