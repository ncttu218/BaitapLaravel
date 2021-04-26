<?php

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Http\Controllers\Admin\Common\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\tSendMail;
use App\Original\Util\SessionUtil;
use App\Original\Util\CodeUtil;
use App\Http\Controllers\tCommon;
use App\Models\Infobbs;
use App\Models\Base;
use Request;
use DB;

/**
 * 本社用管理画面コントローラー
 *
 * @author ahmad
 *
 */
trait HobbsRepository {
    
    use tCommon;
    use tSendMail;
    
    /**
     * 緊急掲示板の店舗コード
     * 
     * @return string|null
     */
    private function getEmergencyBulletinShopId() {
        return config("{$this->hanshaCode}.general.emergency_bulletin_board_id");
    }

    /**
     * 一覧表示
     * @return string
     */
    public function getIndex() {
        $req = Request::all();
        $hansha_code =  $this->loginAccountObj->gethanshaCode();
        $user_level = $this->loginAccountObj->getAccountLevel();

        // 一覧リスト作成
        $list = $this->makeList();
        // 子テンプレート
        $template = 'api.common.admin.hobbs.base_' . $this->templateNo . '.search';
        // 一覧表示
        $shopList = $this->shopList($hansha_code);
        
        $urlAction = CodeUtil::getV2Url('Admin\HobbsController@getIndex', $this->hanshaCode);
        $urlInfobbsAction = CodeUtil::getV2Url('Admin\InfobbsController@getIndex', $this->hanshaCode);
        $urlListPreview = CodeUtil::getV2Url('Admin\InfobbsController@getIndexPreview', $this->hanshaCode);
        
        // ビュー名
        $roleName = 
        $viewName = ".index";
        $templateDir = "api.{$this->hanshaCode}.admin.hobbs";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.hobbs';
        }
        $viewName = $templateDir . $viewName;
        
        return view($viewName, $list)
            ->with('template', $template)
            ->with('templateDir', $templateDir)
            ->with('dataType', 'object')
            ->with('shopList', $shopList)
            ->with('pageNum', SessionUtil::getPageNum())
            ->with('urlAction', $urlAction)
            ->with('urlListPreview', $urlListPreview)
            ->with('urlInfobbsAction', $urlInfobbsAction)
            ->with('hansha_code',$hansha_code)
            ->with('user_level',$user_level);
    }
    
    /**
     * 記事を削除する
     * 
     * @param string $key 記事番号
     */
    private function deletePost($key) {
        // 添付された画像を削除する
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        $infoBbsInstance = $infoBbsInstance->where('number', $key)
                ->first();
        $fileNum = 6;
        // 画像ファイルのパスをリストに入れる
        $images = [];
        for($i = 1; $i <= $fileNum; $i++) {
            $columnName = "file{$i}";
            $value = $infoBbsInstance->{$columnName} ?? '';
            if (empty($value)) {
                continue;
            }
            $images[] = $value;
        }

        // テーブル削除
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        if ($infoBbsInstance->where('number', $key)
                ->delete()) {
            // 物理的に削除する
            foreach ($images as $imageName) {
                if (!file_exists($imageName)) {
                    continue;
                }
                unlink($imageName);
            }
        }
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

            $user_level =  $this->loginAccountObj->getAccountLevel();
            $hansha_code = $this->loginAccountObj->gethanshaCode();

            foreach ($req as $key => $val){
                // 番号のフォマードが異なる場合
                if(!strstr($key,'data')) {
                    continue;
                }

                if(isset($val['del'])){
                    $this->deletePost($key);
                    continue;
                }

                $column = array();

                // 現在データ
                $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
                $row = $infoBbsInstance->selectRaw('shop, published, editflag, msg2,comment,title')
                    ->where('number', '=', $key)
                    ->whereIn('published', ['OFF', 'NG','applying'])
                    ->first();
                // レコードが存在しない場合
                if ($row === null) {
                    continue;
                }

                // 拠点コードがある場合、
                if ($shopCode !== null && $shopCode != $row->shop) {
                    continue;
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
                // 掲載
                $published_changed = false;
                if(isset($val['published'])){
                    $column['published'] = $val['published'];
                    // 掲載モード更新ステータス
                    $published_changed = $column['published'] != $row->published;
                    if ($this->hanshaCode =='3751804'){
                        /**
                         * 岡山様のみ
                         * 二段階の承認⇒本社と本社担当
                         */
                        if ($user_level === 5 && ($published_changed || $msg2_changed)){
                            $column['editflag'] = 'honsya_tantoo';
                            $column['release_confirmed_at'] = $dateTime;
                        }
                        if ($user_level === 2 && ($published_changed || $msg2_changed)){
                            $blog = DB::table(SessionUtil::getTableName())
                                ->where('number', $key)
                                ->first();
                            if ($blog->editflag == 'honsya_tantoo'){
                                $column['editflag'] = 'admin';
                            }else{
                                $column['editflag'] = 'honsya';
                            }
                            $column['release_confirmed_at'] = $dateTime;
                        }

                    }else{
                        // 掲載ステータス
                        if ($val['published'] == 'ON') {
                            $column['editflag'] = 'honsya';
                            // 公開確認日時を更新
                            $column['release_confirmed_at'] = $dateTime;
                        }
                    }
                }


                // テーブル更新
                if ($user_level === 5 && $hansha_code ==='3751804' && $val['published'] !=='NG'){
                    // 岡山について本社担当が承認すると本社にメールを送る
                    if ($published_changed || $msg2_changed) {
                        $this->sendUploadMail(
                            $row,
                            'infobbs',
                            InfobbsCoreController::NOTIFICATION_POST_HONSHA_TANTOO_CONFIRMED,
                            $row->shop
                        );
                 }
                }else{
                    if ($published_changed || $msg2_changed) {
                        // 掲載処理OKの時のメール通知
                        // 公開申請が変わる時の通知がON
                        if (in_array(InfobbsCoreController::NOTIFICATION_POST_HONSHA_CONFIRMED, $this->notificationTypes)) {
                            // メール送信
                            $this->sendUploadMail(
                                null,
                                'infobbs',
                                InfobbsCoreController::NOTIFICATION_POST_HONSHA_CONFIRMED,
                                $row->shop
                            );
                        }

                    }
                }

                $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
                $infoBbsInstance->where('number', $key)
                    ->whereIn('published', ['OFF', 'NG','applying'])
                    ->update($column);
            }
        });
        
        $urlAction = CodeUtil::getV2Url('Admin\HobbsController@getIndex', $this->hanshaCode);

        return view('api.common.admin.hobbs.complete')
            ->with('urlAction', $urlAction)
            ->with('msg','データを編集しました。');
    }
    
    /**
     * 表示リスト（ページネイション）
     * @return array
     */
    protected function makeList(){
        // 申請中 & 1週間以内更新 & (掲載OFF or 掲載NG) のものを検索
        $searchDay = date("Y/m/d",strtotime("-7 day"));
        // 販社コード
        $hanshaCode =  $this->loginAccountObj->gethanshaCode();
        $user_level = $this->loginAccountObj->getAccountLevel();
        if ($hanshaCode == '1253025'){
            $searchDay = date('Y/m/d',strtotime("-12 months"));
        }
        // テーブル名
        $infobbsTable = Infobbs::createNewInstance($this->hanshaCode)->getTable();
        $baseTable = (new Base)->getTable();
        
        $query = DB::table($infobbsTable)
            ->selectRaw("{$infobbsTable}.*, {$baseTable}.base_name");
        // C北九州様とC千葉様
        if ($this->hanshaCode == '5104199' || $this->hanshaCode == '8812391') {
            // 申請中だけの記事を表示する
            $query = $query->where('editflag', 'release');
        }


        // 岡山本社管理
        if ($this->hanshaCode =='3751804'){
            // 岡山本社管理
            if ($user_level === 2){
                $query = $query->where("{$infobbsTable}.updated_at", '>', $searchDay)
                    ->whereNull("{$infobbsTable}.deleted_at")
                    ->whereIn("{$infobbsTable}.published", ['applying','OFF'])
                    ->whereIn("{$infobbsTable}.editflag", ['release','honsya_tantoo'])
                    ->orderBy("{$infobbsTable}.updated_at", 'desc')
                    // 拠点とのJOIN
                    ->leftJoin($baseTable, function($join)
                    use($baseTable, $infobbsTable, $hanshaCode) {
                        $join->on("{$baseTable}.base_code", "{$infobbsTable}.shop");
                        $join->on("{$baseTable}.hansha_code", DB::raw("'{$hanshaCode}'"));
                    });
            }
            if ($user_level === 5){
                // 岡山本社担当
                $query = $query->where("{$infobbsTable}.updated_at", '>', $searchDay)
                    ->whereNull("{$infobbsTable}.deleted_at")
                    ->whereIn("{$infobbsTable}.published", ['OFF'])
                    ->whereIn("{$infobbsTable}.editflag", ['release'])
                    ->orderBy("{$infobbsTable}.updated_at", 'desc')
                    // 拠点とのJOIN
                    ->leftJoin($baseTable, function($join)
                    use($baseTable, $infobbsTable, $hanshaCode) {
                        $join->on("{$baseTable}.base_code", "{$infobbsTable}.shop");
                        $join->on("{$baseTable}.hansha_code", DB::raw("'{$hanshaCode}'"));
                    });
            }

        }else{
            $query = $query->where("{$infobbsTable}.updated_at", '>', $searchDay)
                ->whereNull("{$infobbsTable}.deleted_at")
                ->whereIn("{$infobbsTable}.published", ['OFF','NG'])
                ->orderBy("{$infobbsTable}.updated_at", 'desc')
                // 拠点とのJOIN
                ->leftJoin($baseTable, function($join)
                use($baseTable, $infobbsTable, $hanshaCode) {
                    $join->on("{$baseTable}.base_code", "{$infobbsTable}.shop");
                    $join->on("{$baseTable}.hansha_code", DB::raw("'{$hanshaCode}'"));
                });
        }
        // 緊急掲示板の店舗コード
        $emergencyBulletinShopId = $this->getEmergencyBulletinShopId();
        // 緊急掲示板の店舗コードがある場合
        /**
         * 西千葉様⇒緊急掲示板の承認のため
         */
        if ($emergencyBulletinShopId !== null && $hanshaCode !== '1253025') {
            // 緊急掲示板の店舗コードを除外する
            $query = $query->whereNotIn("{$infobbsTable}.shop", [$emergencyBulletinShopId]);
        }
        
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
