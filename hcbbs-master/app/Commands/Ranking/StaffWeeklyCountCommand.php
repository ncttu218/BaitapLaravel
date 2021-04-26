<?php

namespace App\Commands\Ranking;

use App\Commands\Command;
use Request;
use DB;
use App\Original\Util\RankingUtil;
use App\Lib\Util\DateUtil;

/**
 * 全拠点の毎週ランキングを記録するコマンド
 *
 * @author ahmad
 */
class StaffWeeklyCountCommand extends Command
{
    /**
     * コンストラクタ
     * 
     * @param string $hanshaCode 販社コード
     */
    public function __construct( $hanshaCode )
    {
        // 販社コード
        $this->hanshaCode = $hanshaCode;
    }
    
    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle()
    {
        // ログローテート
        $this->rotateLogFiles();
        
        // ランキングログのまとめ
        $this->summarizeRanking();
    }
    
    /**
     * ログファイルのローテート（削除）
     */
    private function rotateLogFiles() {
        // 2年前
        $time = strtotime('-2 years');
        // 2年前の先週
        $lastWeekTime = strtotime('-7 days', $time);
        list($firstTime, $lastTime) = DateUtil::getWeekInfoAtDate($lastWeekTime);
        
        // ログファイル
        $path = storage_path('ranking') . DIRECTORY_SEPARATOR . $this->hanshaCode
                . DIRECTORY_SEPARATOR . 'infobbs' . DIRECTORY_SEPARATOR;
        $files = [];
        if (date('Ym', $firstTime) == date('Ym', $lastTime)) {
            $lastMonth = strtotime(date('Y-m', $firstTime) . '-01');
            $lastMonth = strtotime('+1 month', $lastMonth);
            $files[] = $path . date('Ym', $lastMonth) . '.log';
        } else {
            $lastMonth = strtotime(date('Y-m', $firstTime) . '-01');
            $lastMonth = strtotime('-1 month', $lastMonth);
            $files[] = $path . date('Ym', $lastMonth) . '.log';
            
            $lastMonth = strtotime(date('Y-m', $lastTime) . '-01');
            $lastMonth = strtotime('-1 month', $lastMonth);
            $files[] = $path . date('Ym', $lastMonth) . '.log';
        }
        
        // ログファイルを削除
        foreach ($files as $file) {
            if (!file_exists($file)) {
                continue;
            }
            @unlink($file);
        }
    }
    
    /**
     * 当週のランキングの取り込み
     * 
     * @param int $inputTime
     * @return array
     */
    private function countWeekly( $inputTime ) {
        $day = date('d', $inputTime);
        $month = date('m', $inputTime);
        $year = date('Y', $inputTime);
        // 今月のランキングのデータ
        $data = RankingUtil::rankByStaff( $this->hanshaCode, [
            'month' => $month,
            'year' => $year,
        ]);
        // 先週の時
        $date = $year . '-' . $month . '-' . $day;
        $time = strtotime($date);
        $lastWeekTime = strtotime('-7 days', $time);
        // 先週のデータ
        list($firstTime, $lastTime) = DateUtil::getWeekInfoAtDate($lastWeekTime);
        
        $weeklyCount = [];
        foreach($data['counterData']['daily'] as $baseCode => $daily) {
            $total = 0;
            foreach ($daily as $currentDay => $number) {
                $dataDate = $data['year'] . '-' . $data['month'] . '-' . $currentDay;
                $dataTime = strtotime($dataDate);
                if ($dataTime < $firstTime || $dataTime > $lastTime) {
                    continue;
                }
                $total += $number;
            }
            $weeklyCount[$baseCode] = $total;
        }
        arsort($weeklyCount);
        return $weeklyCount;
    }
    
    /**
     * ランキングログのまとめ
     */
    private function summarizeRanking() {
        
        // 先月の確認
        $lastWeek = strtotime('-7 days');
        $isThisMonth = date('m', $lastWeek) == date('m');
        $data = [];
        if (!$isThisMonth) {
            $data[] = $this->countWeekly($lastWeek);
        }
        // 今月
        $data[] = $this->countWeekly(time());
        
        // 月データのマージ
        $total = [];
        foreach ($data as $weeklyCount) {
            foreach ($weeklyCount as $baseCode => $number) {
                if (!isset($total[$baseCode])) {
                    $total[$baseCode] = 0;
                }
                $total[$baseCode] += $number;
            }
        }
        
        // ソート
        arsort($total);
        // テキスト内容
        $content = '';
        foreach ($total as $baseCode => $number) {
            $content .= $baseCode . ':' . $number . "\n";
        }
        
        // ファイルに保存
        $path = storage_path('ranking') . DIRECTORY_SEPARATOR . $this->hanshaCode
                . DIRECTORY_SEPARATOR . 'staffbbs';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filename = 'staff_ranking.txt';
        $path .= DIRECTORY_SEPARATOR . $filename;
        
        // 存在
        $isExists = file_exists($path);
        // 書く
        file_put_contents($path, $content);
        if (!$isExists) {
            // パーミッション変更
            @chmod($path, 0777);
        }
    }
}