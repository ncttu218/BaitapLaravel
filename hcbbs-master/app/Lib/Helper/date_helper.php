<?php

use App\Lib\Util\DateUtil;

/**
 * 主にテンプレートの用の関数
 */

/**
 * 指定日付を日本表示に変換する
 *
 * @param string $value　Ymdhm, Y-m-d h:m, Y/m/d h:m
 * @return string Y年m月d日(曜日) h:m
 */
function jp_date($value) {
    return DateUtil::toJpDate( $value );
}

/**
 * システム日付を取得する
 *
 * @return string Y-m-d H:i:s
 */
function db_now() {
    return DateUtil::now();
}

/**
 * 指定日付を日本表示に変換する
 *
 * @param string $value　Ymdhm, Y-m-d h:m, Y/m/d h:m
 * @return string Y年m月
 */
function jp_current_ym() {
    return DateUtil::toJpDateYm( DateUtil::now() );
}

/**
 * 指定された日付を指定された月数分未来日に進めた日付を取得する
 *
 * @param string $target
 * @param integer $day
 * @param string $format
 * @return string
 */
function jp_aftger_ym($month) {
    return DateUtil::monthLater( DateUtil::now(), $month, 'Y年m月' );
}

/**
 * カレンダーのような日付の配列を取得する
 *
 * @param unknown $start
 */
function last_day($format='Y-m-t') {
    return DateUtil::lastDay( null );
}

/**
 * 当月末日を取得する
 *
 * @param string $format
 */
function current_last_day($format='Y-m-t') {
    return DateUtil::currentLastDay( $format );
}

/**
 * 
 * @param  string $value 例：201703
 * @return string 例：2017年03月
 */
function toJpDateYm($value)
{
    if (empty($value)) return false;

    $year = substr($value, 0, 4);
    $month = substr($value, 4);
    $timestamp = strtotime($year.'-'.$month);
    $ym = date('Y年m月', $timestamp);

    return $ym;
}

/**
 * Timestamp型に変換する
 *
 * @param unknown $value
 * @param string $delim 区切り
 */
function toTimestamp( $value, $delim='-' ){
    return DateUtil::toTimestamp( $value, $delim );
}
