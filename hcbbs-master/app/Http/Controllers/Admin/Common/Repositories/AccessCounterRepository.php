<?php

namespace App\Http\Controllers\Admin\Common\Repositories;

use App\Original\Util\SessionUtil;
use App\Original\Util\RankingUtil;
use App\Original\Util\CodeUtil;
use App\Lib\Util\DateUtil;
use Request;

/**
 * 各店情報掲示板 店舗別集計ツールコントローラー
 *
 *
 */
trait AccessCounterRepository {
    
    /**
     * 拠点別アクセス数集計表の表示
     * @return array
     */
    public function getCount() {
        $request = Request::all();
        // 販社名
        $hanshaName = config('original.hansha_code')[$this->hanshaCode] ?? '（無名）';
        
        // 拠点ランキングデータ
        $data = RankingUtil::rankByBase($this->hanshaCode, $request);
        // ブログ公開API
        $urlBlogIndexApi = CodeUtil::getV2Url('Api\InfobbsController@getBlog', $this->hanshaCode) .
                '?page_num=5';
                
        // ビュー名
        $viewName = ".count";
        $templateDir = "api.{$this->hanshaCode}.admin.bbs_count";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.bbs_count';
        }
        $viewName = $templateDir . $viewName;
        
        return view(
            $viewName,
            compact(
                'urlBlogIndexApi',
                'templateDir'
            )
        )
        ->with( 'title', $hanshaName )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'baseList', $data['baseList'] ) // 拠点リスト
        ->with( 'year', $data['year'] ) // 年
        ->with( 'month', $data['month'] ) // 月
        ->with( 'lastDay', $data['lastDay'] ) // 終了日
        ->with( 'counterData', $data['counterData'] ) // 集計データ
        ->with( 'displayObj', $this->displayObj );
    }
    
    /**
     * 拠点別アクセス数集計表の表示
     * @return array
     */
    public function getOneWeek() {
        // 販社名
        $hanshaName = config('original.hansha_code')[$this->hanshaCode] ?? '（無名）';

        // 先週の時
        $lastWeekTime = strtotime('-7 days', time());
        // 先週のデータ
        list($beginningDate, $endingDate) = DateUtil::getWeekInfoAtDate($lastWeekTime);
        $isInclude1MonthAgo = (int)date('m', $beginningDate) < (int)date('m');
        
        // 拠点ランキングデータ
        $data = RankingUtil::rankByBase($this->hanshaCode, [
            'sort' => true
        ], [
            'beginningDate' => $beginningDate,
            'endingDate' => $endingDate,
        ]);
        // ブログ公開API
        $urlBlogIndexApi = CodeUtil::getV2Url('Api\InfobbsController@getBlog', $this->hanshaCode) .
                '?page_num=5';

        // ビュー名
        $viewName = ".one_week";
        $templateDir = "api.{$this->hanshaCode}.admin.bbs_count";
        if (!view()->exists($templateDir . $viewName)) {
            $templateDir = 'api.common.admin.bbs_count';
        }
        $viewName = $templateDir . $viewName;
        
        return view(
            $viewName,
            compact(
                'urlBlogIndexApi',
                'templateDir',
                'beginningDate',
                'endingDate'
            )
        )
        ->with( 'title', $hanshaName )
        ->with( 'hanshaCode', $this->hanshaCode )
        ->with( 'baseList', $data['baseList'] ) // 拠点リスト
        ->with( 'year', $data['year'] ) // 年
        ->with( 'month', $data['month'] ) // 月
        ->with( 'lastDay', $data['lastDay'] ) // 終了日
        ->with( 'counterData', $data['counterData'] ) // 集計データ
        ->with( 'displayObj', $this->displayObj );
    }
}
