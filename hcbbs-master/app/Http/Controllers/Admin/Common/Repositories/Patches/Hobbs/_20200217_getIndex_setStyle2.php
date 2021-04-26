<?php

namespace App\Http\Controllers\Admin\Common\Repositories\Patches\Hobbs;

use App\Models\Base;
use App\Original\Util\SessionUtil;
use App\Original\Util\CodeUtil;
use DB;
use Request;

/**
 * サムネール画像の修正
 *
 * @author ahmad
 *
 */
trait _20200217_getIndex_setStyle2
{
    /**
     * 一覧表示
     * @return string
     */
    public function overrideGetIndex(){
        $req = Request::all();
        $hansha_code =  $this->loginAccountObj->gethanshaCode();

        // 一覧リスト作成
        $list = $this->makeList();
        // 子テンプレート
        $template = 'v3.common.admin.hobbs.base_' . $this->templateNo . '.search';
        // 一覧表示
        $shopList = $this->shopList($hansha_code);
        
        
        $urlAction = CodeUtil::getV2Url('Admin\HobbsController@getIndex', $this->hanshaCode);
        
        return view('v3.common.admin.hobbs.index_style2',$list)
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('shopList', $shopList)
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('urlAction', $urlAction);
    }
    
    /**
     * 表示リスト（ページネイション）
     * @return array
     */
    protected function overrideMakeList(){
        // 申請中 & 1週間以内更新 & (掲載OFF or 掲載NG) のものを検索
        $searchDay = date("Y/m/d",strtotime("-7 day"));
        
        // 販社コード
        $hanshaCode =  $this->loginAccountObj->gethanshaCode();
        
        // テーブル名
        $infobbsTable = SessionUtil::getTableName();
        $baseTable = (new Base)->getTable();
        
        $query = DB::table($infobbsTable)
            ->selectRaw("{$infobbsTable}.*, {$baseTable}.base_name")
            //->where('editflag', 'release')
            ->where("{$infobbsTable}.updated_at", '>', $searchDay)
            ->whereIn("{$infobbsTable}.published", ['OFF','NG'])
            ->orderBy("{$infobbsTable}.updated_at", 'desc')
            // 拠点とのJOIN
            ->leftJoin($baseTable, function($join)
                    use($baseTable, $infobbsTable, $hanshaCode) {
                $join->on("{$baseTable}.base_code", "{$infobbsTable}.shop");
                $join->on("{$baseTable}.hansha_code", DB::raw("'{$hanshaCode}'"));
            });
        
        // 拠点長の場合
        if ($this->loginAccountObj->getAccountLevel() == 3) {
            // 拠点長の拠点コードで絞り込む
            $query = $query->where("{$infobbsTable}.shop", $this->loginAccountObj->getShop());
        }
        
        // 記事データを取得する
        $list['blogs'] = $query->paginate(SessionUtil::getPageNum());

        return $list;
    }
    
}