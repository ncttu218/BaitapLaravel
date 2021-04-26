<?php

namespace App\Original\Util;

use App\Lib\Util\DateUtil;
use Exception;
use Request;
use DB;

/**
 * 画像処理のライブラリー
 */
class RankingUtil
{
    /**
     * 拠点ランキングタイプ
     * 
     * @var int
     */
    const RANKING_TYPE_BASE = 0;
    
    /**
     * スタッフランキングタイプ
     * 
     * @var int
     */
    const RANKING_TYPE_STAFF = 1;
    
    /**
     * 当週の最後の日のタイム
     * 
     * @return array
     */
    public static function getLastWeekTime()
    {
        $currentDay = date('w');
        // 今週の初め - 1日
        $time = self::calculateTime(-$currentDay + 1);
        // 先週の終わり
        $lastTime = strtotime('-1 day', $time);
        // 先週の初め
        $firstTime = self::calculateTime(-6, $lastTime);
        
        return array(
            $firstTime,
            $lastTime
        );
    }
    
    /**
     * 時間の計算
     * 
     * @param int $number
     * @param int $time
     * @return int
     */
    public static function calculateTime( $number, $time = null )
    {
        if ($number > 0) {
            $number = '+' . $number;
        }
        if ($time === null) {
            $time = time();
        }
        
        return strtotime($number . ' day', $time);
    }

    /**
     * スタッフリスト
     * 
     * @param integer $show_flg    表示フラグ 0:すべて表示 1:店舗ブログのみ 2:スタッフブログのみ
     * @return array
     */
    private static function staffList( $hanshaCode )
    {
        $staffList = array();
        // ログインユーザ
        try {
            $query = DB::table( 'tb_' . $hanshaCode . '_staff' )
                    ->whereRaw("(disp = 'ON' OR disp = 'disp')");
                    //->where('disp', 'ON');

            $list = $query->orderBy( 'shop','asc' )
                    ->orderBy( 'number','asc' )
                    ->get();
        } catch (\Exception $ex) { // テーブルが存在しない
            $list = [];
        }
        // 配列に格納
        foreach ($list as $val){
            // スタッフ番号
            $number = substr($val->number, 4);
            $staffList[] = array(
                'staffCode' => $number, // スタッフ番号
                'name' => $val->name, // 名前
                'baseCode' => $val->shop, // 拠点コード
            );
        }
        return $staffList;
    }

    /**
     * 拠点リスト
     * @param integer $show_flg    表示フラグ 0:すべて表示 1:店舗ブログのみ 2:スタッフブログのみ
     * @return array
     */
    private static function shopList( $hanshaCode, $show_flg = 0 )
    {
        $shopList = array();
        // ログインユーザ
        $query = DB::table( 'base' )
                ->where( 'hansha_code', $hanshaCode )
                ->where( 'deleted_at', null );

        // 表示フラグの絞り込み
        if( !empty( $show_flg ) == True ){
            $sql = " (
                        -- 表示フラグが指定のとき　1: 店舗ブログ  2:スタッフブログ
                        show_flg = {$show_flg} OR
                        -- 表示フラグがすべて表示のもの
                        show_flg IS NULL
                    ) ";
            $query->whereRaw( DB::Raw( $sql ) );
        }
                
        $list = $query->orderBy( 'base_code','asc' )
                    ->get();
        // 配列に格納
        foreach ($list as $val){
            $shopList[$val->base_code] = $val->base_name;
        }
        return $shopList;
    }
    
    /**
     * 拠点ブログのランキング
     */
    public static function rankByStaff( $hanshaCode, array $request = [], array $options = [] ) {
        return self::rank(
            $hanshaCode,
            self::RANKING_TYPE_STAFF,
            $request,
            $options
        );
    }
    
    /**
     * 拠点ブログのランキング
     */
    public static function rankByBase( $hanshaCode, array $request = [], array $options = [] ) {
        return self::rank( 
            $hanshaCode, 
            self::RANKING_TYPE_BASE, 
            $request,
            $options
        );
    }

    protected static function getExtractionData($hanshaCode, $rankingType, $year, $month) {
        // ログファイル
        $dirName = $rankingType === self::RANKING_TYPE_BASE ? 'infobbs' : 'staffbbs';
        $dir = storage_path('ranking') . '/' . $hanshaCode . '/' . $dirName;
        $path = $dir . '/' . $year . $month . '.log';
        $hasLog = file_exists($path);
        // 最後の日
        $lastDay = 0;
        // 2年間前
        $time2YearsAgo = strtotime('-2 years');
        $is2YearsAgo = strtotime(date('Y-m', $time2YearsAgo) . '-01') > strtotime(date("{$year}-{$month}-01"));
        // 将来
        $isFuture = strtotime(date('Y-m-d')) < strtotime(date("{$year}-{$month}-01"));
        // 最後の日
        if ($year == date('Y') && $month == date('m')) {
            $lastDay = date('d');
        } else if ($hasLog || (!$isFuture && !$is2YearsAgo)) {
            $lastDay = date('t', strtotime("{$year}-{$month}-1"));
        }

        // ログファイルの内容
        $content = '';
        if ($hasLog) {
            $content = file_get_contents($path);
        }

        return compact(
            'hasLog',
            'lastDay',
            'content'
        );
    }

    /**
     * ログファイルを読み込んで店舗ブログのランキングデータを取得する
     */
    protected static function parseInfobbsRanking($hanshaCode, $year, $month, array $baseList, $addYearInKey = false) {
        // 抽出データ
        $info = self::getExtractionData($hanshaCode, self::RANKING_TYPE_BASE, $year, $month);
        $hasLog = $info['hasLog'];
        $lastDay = $info['lastDay'];
        $content = $info['content'];
        // データ抽出パターン
        $pattern = '/\[' . $year . '-' . $month . '-([0-9]+?)\s[0-9]{2}:[0-9]{2}:[0-9]{2}\|([0-9a-zA-Z]+)\].+?\n/';
    
        if (preg_match_all($pattern, $content, $match)) {
            $rankValues = [];
            foreach ($match[1] as $i => $day) {
                $day = (int)$day;
                $baseCode = $match[2][$i];
                if (!isset($rankValues[$day][$baseCode])) {
                    $rankValues[$day][$baseCode] = 0;
                }
                $rankValues[$day][$baseCode] += 1;
            }
        }

        // ログデータ
        $logData = [];
        
        // 日付
        foreach ($baseList as $baseCode => $baseName) {
            for ($day = 1; $day <= $lastDay; $day++) {
                $timeKey = ($addYearInKey ? "{$year}-{$month}-" : '') . sprintf("%02d", $day);
                $logData[$baseCode][$timeKey] = $rankValues[$day][$baseCode] ?? 0;
            }
        }

        return compact(
            'lastDay',
            'logData'
        );
    }

    /**
     * ログファイルを読み込んでスタッフブログのランキングデータを取得する
     */
    protected static function parseStaffbbsRanking($hanshaCode, $year, $month, array $staffList, $addYearInKey = false) {
        // 抽出データ
        $info = self::getExtractionData($hanshaCode, self::RANKING_TYPE_STAFF, $year, $month);
        $hasLog = $info['hasLog'];
        $lastDay = $info['lastDay'];
        $content = $info['content'];
        // データ抽出パターン
        $pattern = '/\[' . $year . '-' . $month . '-([0-9]+?)\s[0-9]{2}:[0-9]{2}:[0-9]{2}\|([0-9a-zA-Z]+)\|([0-9]+)\].+?\n/';
            
        if (preg_match_all($pattern, $content, $match)) {
            $rankValues = [];
            foreach ($match[1] as $i => $day) {
                $day = (int)$day;
                // 拠点コード
                $baseCode = $match[2][$i];
                // スタッフ番号
                $staffCode = $match[3][$i];
                
                // 配列キー
                $key = $baseCode . '|' . $staffCode;
                
                // 件数
                if (!isset($rankValues[$day][$key])) {
                    $rankValues[$day][$key] = 0;
                }
                $rankValues[$day][$key] += 1;
            }
        }
        
        // 日付
        foreach ($staffList as $info) {
            for ($day = 1; $day <= $lastDay; $day++) {
                // 配列キー
                $key = $info['baseCode'] . '|' . $info['staffCode'];
                // 配列に登録
                $timeKey = ($addYearInKey ? "{$year}-{$month}-" : '') . sprintf("%02d", $day);
                $logData[$key][$timeKey] = $rankValues[$day][$key] ?? 0;
            }
        }

        return compact(
            'lastDay',
            'logData'
        );
    }
    
    /**
     * 共通ランキング
     * 
     * @param type $hanshaCode
     * @param type $request
     */
    private static function rank( $hanshaCode, $rankingType, array $request = [], array $options = [] ) {
        // 月
        $month = $request['month'] ?? date('m');
        // 年
        $year = $request['year'] ?? date('Y');
        
        // 拠点リスト
        $baseList = self::shopList($hanshaCode, 1);
        // 緊急掲示板の除外
        $bulletinId = \App\Models\Base::getEmergencyBulletinShopId($hanshaCode);
        unset($baseList[$bulletinId]);
        // スタッフリスト
        $staffList = [];
        if ($rankingType === self::RANKING_TYPE_STAFF) {
            $staffList = self::staffList( $hanshaCode );
        }
        
        // 終了日
        $beginningDate = $options['beginningDate'] ?? null;
        // 終了日
        $endingDate = $options['endingDate'] ?? null;
        // 先週を含むフラグ
        $isRange = $beginningDate !== null && $endingDate !== null;
        // ログのデータ
        $logData = [];
        // データ検索のパターン
        if ($rankingType === self::RANKING_TYPE_STAFF) {
            // スタッフブログのログデータ
            $logData = self::parseStaffbbsRanking($hanshaCode, $year, $month, $staffList, $isRange);
            $lastDay = $logData['lastDay'];
            $logData = $logData['logData'];
        } else {
            // 店舗ブログのログデータ
            $logData = self::parseInfobbsRanking($hanshaCode, $year, $month, $baseList, $isRange);
            $lastDay = $logData['lastDay'];
            $logData = $logData['logData'];
        }
        
        $counterData = [];
        $counterData['daily'] = [];
        $counterData['totalByBase'] = [];
        $counterData['totalByStaff'] = [];
        $counterData['totalByDay'] = [];
        $counterData['total'] = 0;
        
        // 集計
        if ($rankingType === self::RANKING_TYPE_STAFF) {
            foreach ($staffList as $info) {
                // 配列キー
                $key = $info['baseCode'] . '|' . $info['staffCode'];
                
                $totalByStaff = 0;
                if (!isset($logData[$key])) {
                    $counterData['totalByStaff'][$key] = 0;
                    continue;
                }
                for ($day = 1; $day <= $lastDay; $day++) {
                    $count = $logData[$key][$day] ?? 0;
                    $counterData['daily'][$key][$day] = $count;
                    $totalByStaff += $count;
                }
                $counterData['totalByStaff'][$key] = $totalByStaff;
                $counterData['total'] += $totalByStaff;
            }
        } else {
            // 先月のログデータ
            if ($isRange) {
                $pastYear = $month == '12' && (int)$lastDay < 7 ? (int)$year - 1 : $year;
                $pastMonth = $month == '01' ? '12' : sprintf("%02d", (int)$month - 1);
                $monthAgoLogData = self::parseInfobbsRanking($hanshaCode, $pastYear, $pastMonth, $baseList, $isRange);
            }
            foreach ($baseList as $baseCode => $baseName) {
                $totalByBase = 0;
                if (!isset($logData[$baseCode])) {
                    $counterData['totalByBase'][$baseCode] = 0;
                    continue;
                }
                if (!$isRange) {
                    for ($day = 1; $day <= $lastDay; $day++) {
                        $timeKey = sprintf("%02d", $day);
                        $count = $logData[$baseCode][$timeKey] ?? 0;
                        $counterData['daily'][$baseCode][$timeKey] = $count;
                        $totalByBase += $count;
                    }
                } else {
                    // 先月ログデータ＋今月ログデータ
                    $logData[$baseCode] = array_merge($monthAgoLogData['logData'][$baseCode], $logData[$baseCode]);
                    // 日付ごと
                    $date = $beginningDate;
                    while ($date <= $endingDate) {
                        $timeKey = date('Y-m-d', $date);
                        $count = $logData[$baseCode][$timeKey] ?? 0;
                        $counterData['daily'][$baseCode][$timeKey] = $count;
                        $totalByBase += $count;
                        $date = DateUtil::calculateTime(1, $date);
                    }
                }
                $counterData['totalByBase'][$baseCode] = $totalByBase;
                $counterData['total'] += $totalByBase;
            }
        }
        
        // 日毎のデータ
        if ($rankingType === self::RANKING_TYPE_STAFF) {
            for ($day = 1; $day <= $lastDay; $day++) {
                $day = sprintf("%02d", $day);
                $counterData['totalByDay'][$day] = 0;
                foreach ($staffList as $info) {
                    // 配列キー
                    $key = $info['baseCode'] . '|' . $info['staffCode'];
                    $count = $logData[$key][$day] ?? 0;
                    $counterData['totalByDay'][$day] += $count;
                }
            }
        } else {
            for ($day = 1; $day <= $lastDay; $day++) {
                $day = sprintf("%02d", $day);
                $counterData['totalByDay'][$day] = 0;
                foreach ($baseList as $baseCode => $baseName) {
                    $count = $logData[$baseCode][$day] ?? 0;
                    $counterData['totalByDay'][$day] += $count;
                }
            }
        }
        
        // ソートのフラグ
        $doSorting = isset($request['sort']);
        if ($doSorting) {
            $sortList = $counterData['totalByBase'];
            arsort($sortList);
            $temp = $baseList;
            $baseList = [];
            foreach (array_keys($sortList) as $baseCode) {
                $baseList[$baseCode] = $temp[$baseCode];
            }
        }
        
        return [
            'counterData' => $counterData,
            'month' => $month,
            'year' => $year,
            'lastDay' => $lastDay,
            'baseList' => $baseList,
            'staffList' => $staffList
        ];
    }
}