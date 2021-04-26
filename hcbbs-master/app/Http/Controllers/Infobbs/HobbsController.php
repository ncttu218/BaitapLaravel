<?php

namespace App\Http\Controllers\Infobbs;

use App\Http\Controllers\Controller;
use App\Original\Util\SessionUtil;
use Request;
use DB;
use App\Http\Controllers\tCommon;

/**
 * 本社用管理画面コントローラー
 *
 * @author M.ueki
 *
 */
class HobbsController extends Controller {
    use tCommon;
    /**
     * コンストラクタ
     */
    public function __construct() {
        // テンプレートNo
        $this->templateNo = '1351100';
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
    }

    /**
     * 一覧表示
     * @return string
     */
    public function getIndex(){
        $req = Request::all();

        // 一覧リスト作成
        $list = $this->makeList();
        // 子テンプレート
        $template = 'infobbs.base_' . $this->templateNo . '.search';
        // 一覧表示
        $hansha_code =  $this->loginAccountObj->gethanshaCode();
        $shopList = $this->shopList($hansha_code);
        return view('infobbs.search_ho',$list)
            ->with('template', $template)
            ->with('dataType', 'object')
            ->with('shopList', $shopList)
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('urlAction',action_auto("Infobbs\HobbsController" . '@postIndex'));
    }

    /**
     * 一括編集ボタン
     * @return string
     */
    public function postIndex(){

        DB::transaction(function() {
            $req = Request::all();// transactionの中に入れる
            $dateTime = date("Y-m-d H:i:s");
            
            // 拠点コード
            $shopCode = null;
            // 拠点長の場合
            if ($this->loginAccountObj->getAccountLevel() == 3) {
                $shopCode = $this->loginAccountObj->getShop();
            }

            foreach ($req as $key => $val){
                
                // 番号のフォマードが異なる場合
                if(!strstr($key,'data')) {
                    continue;
                }
                
                $column = array();

                // 現在データ
                $row = DB::table(SessionUtil::getTableName())
                    ->selectRaw('shop, published, editflag, msg2')
                    ->where('number', '=', $key)->get();
                $row = $row[0];

                // 拠点コードがある場合、
                if ($shopCode !== null && $shopCode != $row->shop) {
                    continue;
                }

                // 掲載
                $published_changed = false;
                if(isset($val['published'])){
                    $column['published'] = $val['published'];

                    // 掲載ステータス
                    if ($val['published'] == 'ON') {
                        $column['editflag'] = 'honsya';
                        // 公開確認日時を更新
                        $column['release_confirmed_at'] = $dateTime;
                    }
                    // 掲載モード更新ステータス
                    $published_changed = $column['published'] != $row->published;
                }

                // 本社から
                $msg2_changed = false;
                if(isset($val['msg2'])){
                    $column['msg2'] = $val['msg2'];
                    // 本社から更新ステータス
                    $msg2_changed = $column['msg2'] != $row->msg2;
                } else if (!empty($row->msg2)) {
                    $msg2_changed = true;
                    $column['msg2'] = null;
                }

                // 更新時間
                // $column['updated_at'] = $dateTime;

                // テーブル更新
                if ($published_changed || $msg2_changed) {
                    DB::table(SessionUtil::getTableName())->where('number', $key)
                        ->update($column);
                }
            }
        });

        return view('infobbs.complete')
            ->with('urlAction',action_auto("Infobbs\HobbsController" . '@getIndex'))
            ->with('msg','データを編集しました。');
    }
    
    /**
     * 表示リスト（ページネイション）
     * @return array
     */
    protected function makeList(){
        // 申請中 & 1週間以内更新 & (掲載OFF or 掲載NG) のものを検索
        $searchDay = date("Y/m/d",strtotime("-7 day"));
        
        // 記事データ
        $query = DB::table(SessionUtil::getTableName())
            ->where('editflag', 'release')
            ->where('updated_at', '>', $searchDay)
            ->whereIn('published', ['OFF','NG'])
            ->orderBy('updated_at', 'desc');
        
        // 拠点長の場合
        if ($this->loginAccountObj->getAccountLevel() == 3) {
            // 拠点長の拠点コードで絞り込む
            $query = $query->where('shop', $this->loginAccountObj->getShop());
        }
        
        // 記事データを取得する
        $list['blogs'] = $query->paginate(SessionUtil::getPageNum());

        return $list;
    }
}
