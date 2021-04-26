<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Original\Util\SessionUtil;
use Request;
use DB;
use App\Http\Controllers\tCommon;

/**
 * 公開画面コントローラー
 *
 * @author M.ueki
 *
 */
class ViewbbsController extends Controller {
    use tCommon;
    /**
     * コンストラクタ
     */
    public function __construct() {
        // テンプレートNo
        $this->templateNo = '1351100';
    }

    /**
     * 一覧表示
     * @return string
     */
    public function getIndex(){
        $req = Request::all();
        // ユーザ情報
        $loginAccountObj = SessionUtil::getUser();

        // カテゴリ検索条件をセッションに保存
        if(isset($req['cat'])){
            SessionUtil::putCategorySelected($req['cat']);
        }
        // 子テンプレート設定
        $template = 'infobbs.base_' . $this->templateNo . '.search';

        // ショップリスト作成
        $shopList = ['' => '全店'];
        $shopList += $this->shopList($loginAccountObj->gethanshaCode());

        // カテゴリ
        $para = Config('original.para')[$loginAccountObj->getHanshaCode()];
        $cat_org = $para['category'];
        $category = array();
        if($cat_org){
            $cat = explode(',',explode(',', $cat_org));
            $tmp['name'] = '全て';
            $query = DB::table(SessionUtil::getTableName());
            $query = $this->makeSqlWhere($query);
            // 全ての数取得
            $tmp['num'] = $query->count();
            $category[] = $tmp;
            // カテゴリごとの数取得
            foreach ($cat as $name){
                $tmp['name'] = $name;
                $query = DB::table(SessionUtil::getTableName());
                $query = $this->makeSqlWhere($query);
                $query = $this->makeSqlCategory($query,$name);
                $tmp['num'] = $query->count();
                $category[] = $tmp;
            }
        }

        // 一覧リスト作成
        $list = $this->makeList();

        return view('infobbs.search_view',$list)
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('shopList', $shopList)                   // 店舗セレクトボックス
            ->with('shop', SessionUtil::getShopSelected())    // 店舗セレクトselected
            ->with('categorySelected', SessionUtil::getCategorySelected())    // 検索カテゴリ
            ->with('category', $category)
            ->with('urlAction',action_auto("Infobbs\ViewbbsController" . '@postSearch'));
    }

    /**
     * 一覧表示(検索ボタン)
     * @return string
     */
    public function postSearch(){
        $req = Request::all();
        SessionUtil::putShopSelected($req['shop']);
        return redirect(action_auto('Infobbs\ViewbbsController' . '@getIndex'));
    }
    
    /**
     * 表示リスト（ページネイション）
     * @return array
     */
    protected function makeList(){
        $query = DB::table(SessionUtil::getTableName());
        // 検索条件
        $query = $this->makeSqlWhere($query);
        // お店検索条件
        if(SessionUtil::getShopSelected()){
            $query->where('shop', '=', SessionUtil::getShopSelected());
        }
        // カテゴリ検索条件
        if(SessionUtil::getCategorySelected() != '全て'){
            $query = $this->makeSqlCategory($query, SessionUtil::getCategorySelected());
        }

        $list['blogs'] = $query
            ->orderBy('regist', 'desc')
            ->paginate(SessionUtil::getPageNum());

        return $list;
    }
    
    /**
     * Where条件作成
     * @return string
     */
    protected function makeSqlWhere($query){
        $date = date("Y-m-d H:i:s");
        // 掲載ON　& 掲載期間が期間内かnull のレコード検索
        $query->where('published', '=', 'ON')
            ->where(function($query) use ($date){
                $query->whereNull('from_date')
                ->orWhere('from_date', '<=', $date);
                })
            ->where(function($query) use ($date){
                $query->whereNull('to_date')
                ->orWhere('to_date', '>=', $date);
                });

        return $query;
    }

    /**
     * カテゴリのwhere条件作成
     * @return string
     */
    protected function makeSqlCategory($query,$name){
        $query->where('category','like',"%{$name}%");
        return $query;
    }
}
