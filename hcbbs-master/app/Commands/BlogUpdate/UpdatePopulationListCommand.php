<?php

namespace App\Commands\BlogUpdate;

use App\Commands\Command;
use App\Models\Infobbs;
use DB;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogListCommand
 *
 * @author ahmad
 */
class UpdatePopulationListCommand extends Command {
    
    /**
     * 年
     * 
     * @var string
     */
    private $year;
    
    /**
     * 月
     * 
     * @var string
     */
    private $month;
    
    /**
     * 販社コード
     * 
     * @var string
     */
    private $hanshaCode;

    /**
     * コンストラクタ
     * @param array $sort 並び順
     * @param $requestObj 検索条件
     */
    public function __construct( 
            $hanshaCode, 
            $year, 
            $month ) {
        // 販社コード
        $this->hanshaCode = $hanshaCode;
        // 年
        $this->year = $year;
        // 月
        $this->month = $month;
    }

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle() {
        // 最終日
        $day = sprintf("%02d", date('t', strtotime("{$this->year}-{$this->month}-1")));
        // 選択された月の更新ログ収集
        $startDate = "{$this->year}-{$this->month}-01";
        $endDate = "{$this->year}-{$this->month}-{$day}";
        // 更新ログ収集
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        $logData = $infoBbsInstance->selectRaw("shop, count(*) AS count, DATE(updated_at)::text AS updated_at")
                        ->where('published', 'ON')
                        // 公開期間内のとき
                        ->whereRaw( ' ( ( from_date <= now() AND to_date >= now()) OR '
                            . ' ( from_date <= now() AND to_date IS NULL) OR '
                            . ' ( from_date IS NULL AND to_date >= now()) OR '
                            . ' ( from_date IS NULL AND to_date IS NULL))' )
                        ->whereRaw("DATE(updated_at) >= '{$startDate}'")
                        ->whereRaw("DATE(updated_at) <= '{$endDate}'")
                        ->groupBy('shop');
                        
        $logData = $logData->groupBy(DB::raw('DATE(updated_at)', 'desc'));
        
        return $logData->get();
    }
    
}
