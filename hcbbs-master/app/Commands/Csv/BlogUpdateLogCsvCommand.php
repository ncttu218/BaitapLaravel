<?php

namespace App\Commands\Csv;

use App\Commands\BlogUpdate\UpdatePopulationListCommand;
use App\Commands\BlogUpdate\LastUpdateListCommand;
use App\Commands\Command;
use App\Lib\Csv\Csv;
use App\Original\Util\SessionUtil;
use App\Models\Base;
use Illuminate\Foundation\Bus\DispatchesJobs;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlogUpdateLogCsvCommand
 *
 * @author ahmad
 */
class BlogUpdateLogCsvCommand extends Command {
    
    use DispatchesJobs;
    
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
     * ファイル名
     * 
     * @var string
     */
    private $filename;
    
    /**
     * 拠点一覧
     * 
     * @var array
     */
    private $shops = [];
    
    /**
     * コンストラクタ
     * @param BaseRequest $requestObj [description]
     */
    public function __construct( $hanshaCode, $year, $month, $filename = "blogUpdateLog.csv", array $options = [] ){
        // 販社コード
        $this->hanshaCode = $hanshaCode;
        // 年
        $this->year = $year;
        // 月
        $this->month = $month;
        // ファイル名
        $this->filename = $filename;
        // 拠点一覧
        $this->shops = isset($options['shops']) ? $options['shops'] : [];

        // カラムとヘッダーの値を取得
        $csvParams = $this->getCsvParams();
        // カラムを取得
        $this->columns = array_keys( $csvParams );
        // ヘッダーを取得
        $this->headers = array_values( $csvParams );
    }

    /**
     * カラムとヘッダーの値を取得
     * @return array
     */
    private function getCsvParams(){
        return [
            '拠点名',
            (int)$this->month . '月更新数',
            '未更新日数',
        ];
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
     * メインの処理
     * @return [type] [description]
     */
    public function handle()
    {
        // 緊急掲示板の拠点コード
        $bulletinId = Base::getEmergencyBulletinShopId($this->hanshaCode);
        // 選択された月の更新ログ収集
        $selectedMonthLogData = $this->dispatch(
            new UpdatePopulationListCommand(
                $this->hanshaCode,
                $this->year,
                $this->month
            )
        );
        
        // 今年
        $thisYear = date('Y');
        // 今月
        $thisMonth = date('m');
        // 今日
        $today = date('d');
        
        // 最後の更新ログ収集
        $lastDayLogData = $this->dispatch(
            new LastUpdateListCommand(
                $this->hanshaCode
            )
        );
        
        // 拠点一覧
        $shopList = SessionUtil::getShopList();
        if (count($this->shops) === 0) {
            $this->shops = $shopList;
        } else {
            $shops = [];
            foreach ($this->shops as $shopCode) {
                $shops[$shopCode] = $shopList[$shopCode];
            }
            $this->shops = $shops;
        }
        unset($this->shops[$bulletinId]);
        
        if ( empty( $selectedMonthLogData ) ) {
            throw new \Exception('データが見つかりません');
        }

        // 検索結果をCSV出力ように変換
        $export = $this->convert( $this->shops, $lastDayLogData, $selectedMonthLogData );
        
        return Csv::download( $export, $this->headers, $this->filename );
    }

    /**
     * 出力形式に変換
     * @param $data
     * @return
     */
    private function convert( $shops, $thisMonthData, $selectedMonthData ){
        //変換格納用変数と列番号変数の初期化
        $export = null;
        // 今日
        $today = date('d');
        // 未更新日数
        $shopLastArr = [];
        $nowDate = date('Y-m-d');
        foreach ($thisMonthData as $row) {
            // 更新日時
            $updated_at = (string)$row->updated_at;
            $updated_at = str_replace(' 00:00:00', '', $updated_at);
            // 未更新日数
            $shopLastArr[$row->shop] = $this->daysDiff($updated_at, $nowDate);
        }
        
        $temp = [];
        foreach ($selectedMonthData as $row) {
            if (!isset($temp[$row->shop])) {
                $temp[$row->shop] = 0;
            }
            $temp[$row->shop] += $row->count;
        }
        // 空拠点をチェック
        foreach ($shops as $shopCode => $shopName) {
            if (isset($temp[$shopCode])) {
                continue;
            }
            $temp[$shopCode] = $today;
        }
        $selectedMonthData = $temp;

        //１件ごとにデータを整形
        foreach( $shops as $shopCode => $shopName ){
            // 拠点名
            $export[$shopCode][] = $shopName;
            // 更新数
            $export[$shopCode][] = $selectedMonthData[$shopCode] ?? 0;
            // 未更新日数
            $export[$shopCode][] = $shopLastArr[$shopCode] ?? 0;
        }

        return $export;
    }
    
}
