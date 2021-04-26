<?php

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Commands\BlogUpdate\UpdatePopulationListCommand;
use App\Commands\BlogUpdate\LastUpdateListCommand;
use App\Commands\Csv\BlogUpdateLogCsvCommand;
use App\Http\Requests\SearchRequest;
use App\Original\Util\CodeUtil;
use App\Original\Util\SessionUtil;
use App\Original\Codes\SaitamaShopsByGroupCodes;
use App\Models\Base;
use Request;

/**
 * 各店情報掲示板 店舗別集計ツールコントローラー
 *
 *
 */
trait BlogUpdateLogRepository {

    #######################
    ## 検索・並び替え
    #######################

    /**
     * 画面固有の初期条件設定
     *
     * @return array
     */
    private function extendSearchParams(){
        $search = [];

        return $search;
    }
    
    /**
     * 
     * @param type $d1
     * @param type $d2
     * @return type
     */
    private function daysDiff($d1, $d2) {
        $datetime1 = new \DateTime($d1);
        $datetime2 = new \DateTime($d2);
        $difference = $datetime1->diff($datetime2);
        return $difference->days;
    }
    
    /**
     * 拠点別アクセス数集計表の表示
     * @return array
     */
    public function getIndex() {
        $request = Request::all();
        ########################################################################
        # 時間計算
        ########################################################################
        // 今年
        $thisYear = date('Y');
        // 今月
        $thisMonth = date('m');
        // 月
        $month = $request['month'] ?? $thisMonth;
        // 年
        $year = $request['year'] ?? $thisYear;
        // 今日
        $today = date('d');
        
        // 最終日
        $lastDay = sprintf("%02d", date('t', strtotime("{$year}-{$month}-1")));
        $dateData = [
            'prevYear' => sprintf("%04d", $month != 1 ? $year : $year - 1),
            'prevMonth' => sprintf("%02d", $month <= 1 ? 12 : $month - 1),
            'thisYear' => sprintf("%04d", $year),
            'thisMonth' => sprintf("%02d", $month),
            'nextYear' => sprintf("%04d", $month != 12 ? $year : $year + 1),
            'nextMonth' => sprintf("%02d", $month >= 12 ? 1 : $month + 1),
        ];
        ########################################################################
        
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        // 販社コード
        if (isset( $request['hansha_code'] ) && !empty( $request['hansha_code'] )) {
            $hanshaCode = $request['hansha_code'];
        } else {
            $hanshaCode = $this->loginAccountObj->getHanshaCode();
        }
        // 緊急掲示板の拠点コード
        $bulletinId = Base::getEmergencyBulletinShopId($this->hanshaCode);
        // 販社名
        $hanshaName = config('original.hansha_code')[$hanshaCode] ?? '（無名）';
        
        // 今月の更新ログ収集
        $thisMonthTotalByShopArr = [];
        if ($hanshaCode == '1351901') {
            $thisMonthLogData = $this->dispatch(
                new UpdatePopulationListCommand(
                    $this->hanshaCode,
                    $year,
                    $thisMonth
                )
            );

            foreach ($thisMonthLogData as $row) {
                // 全体合計から緊急掲示板の投稿数を抜く
                if ($bulletinId === $row->shop) {
                    continue;
                }
            
                // 各拠点の更新ログ合計
                if (!isset($thisMonthTotalByShopArr[$row->shop])) {
                    $thisMonthTotalByShopArr[$row->shop] = 0;
                }
                $thisMonthTotalByShopArr[$row->shop] += $row->count;
            }
        }

        // 選択された月の更新ログ収集
        $selectedMonthLogData = $this->dispatch(
            new UpdatePopulationListCommand(
                $this->hanshaCode,
                $year,
                $month
            )
        );
        // ログの計算
        $logArr = [];
        $totalByDayArr = [];
        $totalByShopArr = [];
        $totalAll = 0;
        
        foreach ($selectedMonthLogData as $row) {
            // 全体合計から緊急掲示板の投稿数を抜く
            if ($bulletinId === $row->shop) {
                continue;
            }
            // 更新日時
            $updated_at = (string)$row->updated_at;
            $updated_at = str_replace(' 00:00:00', '', $updated_at);
            $day = (int)preg_replace('/^[0-9]+-?[0-9]+?-([0-9]+)$/', '$1', $updated_at);
            
            // 各拠点の更新ログ合計
            $logArr[$day][$row->shop] = $row->count;
            
            // 各日の更新ログ数
            if (!isset($totalByDayArr[$day])) {
                $totalByDayArr[$day] = 0;
            }
            $totalByDayArr[$day] += $row->count;
            
            // 各拠点の更新ログ合計
            if (!isset($totalByShopArr[$row->shop])) {
                $totalByShopArr[$row->shop] = 0;
            }
            $totalByShopArr[$row->shop] += $row->count;
            
            // 全合計
            $totalAll += $row->count;
        }
        
        // 拠点一覧
        $shopList = $this->shopList($this->hanshaCode);
        unset($shopList[$bulletinId]);
        
        // 最後の更新ログ収集
        $lastDayLogData = $this->dispatch(
            new LastUpdateListCommand(
                $this->hanshaCode
            )
        );
        
        // 未更新日数
        $shopLastArr = [];
        $nowDate = date('Y-m-d');
        foreach ($lastDayLogData as $row) {
            // 更新日時
            $updated_at = (string)$row->updated_at;
            $updated_at = str_replace(' 00:00:00', '', $updated_at);
            // 未更新日数
            $dayCount = $this->daysDiff($updated_at, $nowDate);
            if ($dayCount === 0 && $updated_at != $nowDate) {
                $dayCount = $today;
            }
            $shopLastArr[$row->shop] = $dayCount;
        }
        // 空拠点をチェック
        foreach ($shopList as $shopCode => $shopName) {
            if (isset($shopLastArr[$shopCode])) {
                continue;
            }
            $shopLastArr[$shopCode] = $today;
        }
        
        // アクセス集計
        $urlActionAccessCounter = CodeUtil::getV2Url('Admin\AccessCounterController@getCount', $this->hanshaCode);
        
        // ブログ公開API
        $urlBlogIndexApi = CodeUtil::getV2Url('Api\InfobbsController@getBlog', $this->hanshaCode) . '?page_num=5';
        
        // CSVファイルをダウンロードする
        $urlDownloadCsv = action_auto($this->displayObj->ctl . '@getCsv') . 
                "?year={$year}&month={$month}";
                
        // ビュー名
        $roleName = 
        $viewName = ".index";
        $templateDir = "api.{$this->hanshaCode}.admin.infobbs.update_log";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.infobbs.update_log';
        }
        $viewName = $templateDir . $viewName;

        // 拠点一覧のグループ
        $shopGroup = (new SaitamaShopsByGroupCodes)->getOptions();
        
        return view(
            $viewName,
            compact(
                'hanshaCode',
                'shopList',
                'lastDay',
                'dateData',
                'logArr',
                'totalByDayArr',
                'totalByShopArr',
                'totalAll',
                'thisMonthTotalByShopArr',
                'shopLastArr',
                'templateDir',
                'urlActionAccessCounter',
                'urlBlogIndexApi',
                'urlDownloadCsv',
                'shopGroup'
            )
        )
        ->with( 'title', $hanshaName )
        ->with( 'updateDayLimit', 7 )
        ->with( 'displayObj', $this->displayObj );
    }
    
    /**
     * CSVダウンロード機能
     * @param  SearchRequest $requestObj [description]
     * @return [type]                 [description]
     */
    public function getCsv( SearchRequest $requestObj ){
        // 年
        $year = $requestObj->year ?? 0;
        // 月
        $month = $requestObj->month ?? 0;
        //CSVファイル名
        $filename = "更新情報確認.csv";
        // オプション
        $options = [];
        if ($this->hanshaCode == '1351901') {
            // 拠点一覧のグループ
            $groups = (new SaitamaShopsByGroupCodes)->getOptions();
            // 拠点一覧
            $options['shops'] = [];
            foreach ($groups as $name => $shops) {
                $options['shops'] = array_merge($options['shops'], $shops);
            }
        }
        
        $csv = $this->dispatch(
            new BlogUpdateLogCsvCommand(
                $this->hanshaCode,
                $year,
                $month,
                $filename,
                $options
            )
        );
        
        return $csv;
    }
}
