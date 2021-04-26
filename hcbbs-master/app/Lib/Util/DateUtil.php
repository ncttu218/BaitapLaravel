<?php

namespace App\Lib\Util;

/**
 * 日付関連のユーティリティー
 *
 * @author yhatsutori
 *
 */
class DateUtil {

    /**
     * 指定日付を日本表示に変換する
     *
     * @param string $value　Ymdhm, Y-m-d h:m, Y/m/d h:m
     * @return string Y年m月
     */
    public static function toJpDateYm( $value ) {
        $timestamp = strtotime( $value );
        $ym = date( 'Y年m月', $timestamp );
        return $ym;
    }

    /**
     * 指定月日を日本語表示に変換する
     *
     * @param unknown $value
     * @return n月j日
     */
    public static function toJpDateMd( $value ) {
        $timestamp = strtotime( $value );
        $ym = date( 'n月j日', $timestamp );
        return $ym;
    }

    /**
     * Timestamp型に変換する
     *
     * @param unknown $value
     * @param string $delim 区切り
     */
    public static function toTimestamp( $value, $delim='-' ) {
        $timestamp = strtotime( $value );
        $ym = date( 'Y'. $delim . 'm' . $delim . 'd' .' ' . 'H:i:s', $timestamp );
        return $ym;
    }

    /**
     * 日付型に変換する
     *
     * @param unknown $value
     * @param string $delim 区切り
     * @return string 日付型
     */
    public static function toYmd( $value, $delim='/' ) {
        $timestamp = strtotime( $value );
        $ym = date( 'Y'. $delim . 'm' . $delim . 'd', $timestamp );
        return $ym;
    }

    /**
     * 年月に変換する
     *
     * @param unknown $value
     * @param string $delim 区切り
     * @return string
     */
    public static function toYm( $value, $delim='' ) {
        $timestamp = strtotime( $value );
        $ym = date( 'Y' . $delim . 'm', $timestamp );
        return $ym;
    }

    /**
     * 指定日付を日本表示に変換する
     *
     * @param string $value　Ymdhm, Y-m-d h:m, Y/m/d h:m
     * @return string Y年m月d日(曜日) h:m
     */
    public static function toJpDate( $value ) {
        //日本語の曜日配列
        $weekjp = array(
            '日', //0
            '月', //1
            '火', //2
            '水', //3
            '木', //4
            '金', //5
            '土'  //6
        );

        $timestamp = strtotime( $value );
        $weekno = date( 'w', $timestamp );
        $ymd = date( 'Y年m月d日', $timestamp );
        $hm = date( 'H:i', $timestamp );
        return $ymd . "(" . $weekjp[$weekno] . ")" . $hm;
    }

    /**
     * システム日付を取得する
     *
     * @return string Y-m-d H:i:s
     */
    public static function now() {
        return date( 'Y-m-d H:i:s' );
    }

    /**
     * システム日付からYmを取得する
     *
     * @return string Ym
     */
    public static function currentYm( $format="Ym" ) {
        return date( $format, time() );
    }

    /**
     * 指定された日付を指定された日数分過去に遡った日付を取得する
     *
     * @param string $target
     * @param integer $day
     * @param string $format
     * @return string
     */
    public static function dayAgo( $target, $day, $format="Y/m/d" ) {
        $ago = $day * -1;
        return date( $format, strtotime( $target . $ago . " day" ) );
    }

    public static function nowMonthAgo( $month, $format="Y/m/d" ) {
        return static::monthAgo( static::now(), $month, $format );
    }

    /**
     * 指定された日付を指定された月数分過去に遡った日付を取得する
     *
     * @param string $target
     * @param integer $day
     * @param string $format
     * @return string
     */
    public static function monthAgo( $target, $month, $format="Y/m/d" ) {
        $ago = $month * -1;
        return date( $format, strtotime( $target . "+" . $ago . " month" ) );
    }

    /**
     * 指定された日付を指定された年数分過去に遡った日付を取得する
     *
     * @param string $target
     * @param integer $day
     * @param string $format
     * @return string
     */
    public static function yearAgo( $target, $year, $format="Y/m/d" ) {
        $ago = $year * -1;
        return date( $format, strtotime( $target . $ago . " year" ) );
    }

    /**
     * 指定された月の末日を取得する
     */
    public static function lastDay( $value, $format="Y/m/t" ) {
        $timestamp = strtotime( $value );
        return date( $format, $timestamp );
    }

    /**
     * 当月初日を取得する
     *
     * @param string $format
     */
    public static function currentFirstDay() {
        return date("Y-m-01");
    }

    /**
     * 当月末日を取得する
     *
     * @param string $format
     */
    public static function currentLastDay( $format="Y/m/t" ) {
        return date( $format );
    }
    
     /**
     * 当月当日を取得する
     *
     * @param string $format
     */
    public static function currentDay( $format="Y-m-d" ) {
        return date( $format );
    }

    /**
     * 指定された日付を指定された日数分未来日に進めた日付を取得する
     *
     * @param string $target
     * @param integer $day
     * @param string $format
     * @return string
     */
    public static function dayLater( $target, $day, $format="Y/m/d" ) {
        return date( $format, strtotime( $target . $day . " day" ) );
    }

    /**
     * 指定された日付を指定された月数分未来日に進めた日付を取得する
     *
     * @param string $target
     * @param integer $day
     * @param string $format
     * @return string
     */
    public static function monthLater( $target, $month, $format="Y/m/d" ) {
        return date( $format, strtotime( $target . ' +' . $month . " month" ) );
    }

    /**
     * 指定された日付を指定された年数分未来日に進めた日付を取得する
     *
     * @param string $target
     * @param integer $day
     * @param string $format
     * @return string
     */
    public static function yearLater( $target, $year, $format="Y/m/d" ) {
        return date( $format, strtotime( $target . $year . " year" ) );
    }

    /**
     * 未来日かどうかを判定する
     *
     * @param unknown $standardDay 基準となる日付
     * @param unknown $target 比較したい日付
     * @return boolean TRUE: 未来日、FALSE：未来日ではない
     */
    public static function isFuture( $standardDay, $target ) {
        return strtotime( $standardDay ) < strtotime( $target );
    }

    /**
     * 過去日かどうかを判定する
     *
     * @param unknown $standardDay 基準となる日付
     * @param unknown $target 比較したい日付
     * @return boolean TRUE: 過去日、FALSE：過去日ではない
     */
    public static function isPast( $standardDay, $target ) {
        return strtotime( $standardDay ) > strtotime( $target );
    }

    /**
     * 同一日かどうかを判定する
     *
     * @param unknown $standardDay 基準となる日付
     * @param unknown $target 比較したい日付
     * @return boolean TRUE: 同一日、FALSE：同一日ではない
     */
    public static function isSame( $standardDay, $target ) {
        return strtotime( $standardDay ) === strtotime( $target );
    }

    /**
     * 指定日付の週番号を取得する
     *
     * @param unknown $date
     */
    public static function weekNoThisMonth( $date ) {
        $year = (int)date( 'Y', strtotime( $date ) );
        $month = (int)date( 'n', strtotime( $date ) );
        $day = (int)date( 'd', strtotime( $date ) );
        $time = mktime( 0, 0, 0, $month, 1, $year );
        $wday = date( "w", $time );
        $val = (int)( ( $day + $wday - 1 ) / 7);
        return ( $val + 1 );
    }
    /**
     * 週の始まりと終わりを計算する関数
     * 
     * @return array
     */
    public static function calculateTime( $number, $time = null )
    {
        if ($time === null) {
            $time = time();
        }
        if ($number > 0) {
            $number = '+' . $number;
        }
        return strtotime($number . ' day', $time);
    }
    
    public static function getWeekInfoAtDate( $time = null ) {
        $firstTarget = 1;
        $lastTarget = 0;
        if ($time === null) {
            $time = time();
        }
        $currentDay = date('w', $time);
        
        if ($lastTarget != $currentDay) {
            // 今週の初め
            $thisWeekFirstTime = self::calculateTime(-$currentDay + 1, $time);
            // 今週の終わり
            $thisWeekLastTime = self::calculateTime(7 - $currentDay, $time);
        } else {
            // 今週の初め
            $thisWeekFirstTime = self::calculateTime(-$currentDay - 6, $time);
            // 今週の終わり
            $thisWeekLastTime = $time;
        }
        
        return [$thisWeekFirstTime, $thisWeekLastTime];
    }

    /**
     * カレンダーのような日付の配列を取得する
     *
     * @param unknown $start
     */
    public static function getRangeList( $start ) {
        $last = self::lastDay( $start, 't' );
        for( $i = 0; $i < $last; $i++ ) {
            $day = self::dayLater( $start, $i, 'Y-m-d' );
            $weekno = self::weekNoThisMonth( $day );
            $result[$weekno][] = $day;
        }

        return $result;
    }

    /**
     * 月のリストを取得する（Select用）
     */
    public static function optionMonth() {
        return $month = [
            '01' => '１月'
            , '02' => '２月'
            , '03' => '３月'
            , '04' => '４月'
            , '05' => '５月'
            , '06' => '６月'
            , '07' => '７月'
            , '08' => '８月'
            , '09' => '９月'
            , '10' => '１０月'
            , '11' => '１１月'
            , '12' => '１２月'
        ];
    }

    /**
     * 年のリストを取得する（Select用）
     *
     * @param unknown $year
     * @param number $num
     */
    public static function optionYear( $year=null, $num=5 ) {
        if( $year == null ) {
            $year = (int)date('Y');
        } else {
            $year = (int)$year;
        }

        for( $i = 0; $i < $num; $i++ ) {
            $value = $year + $i;
            $result[$value] = $value;
        }

        return $result;
    }

}