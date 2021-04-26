<?php

namespace App\Lib\Util;

use App\Lib\Util\DateUtil;

/**
 * Queryユーティリティー
 *
 * @author yhatsutori
 *
 */
class QueryUtil {
    /**
     * From、Toの指定により
     * between条件を生成する
     *
     * @param unknown $query
     * @param unknown $column
     * @param unknown $from
     * @param unknown $to
     */
    public static function between( $query, $column, $from, $to ) {
        if( !empty( $from ) ) {
            $from = DateUtil::toYmd( $from.'01', '-' );
        }
        if( !empty( $to ) ) {
            $to = DateUtil::lastDay( $to.'01', 'Y-m-t' );
        }

        if( !empty( $from ) && !empty( $to ) ) {
            $query->whereBetween( $column, [$from, $to] );
        } else if( !empty( $from ) ) {
            $query->where ($column, '>=', $from );
        } else if( !empty( $to ) ) {
            $query->where( $column, '<=', $to );
        }
        return $query;
    }

    public static function betweenNormal( $query, $column, $from, $to ) {
        if( !empty( $from ) && !empty( $to ) ) {
            $query->whereBetween( $column, [$from, $to] );
        } else if( !empty( $from ) ) {
            $query->where( $column, '>=', $from );
        } else if( !empty( $to ) ) {
            $query->where( $column, '<=', $to );
        }
        return $query;
    }

    /**
     * 注）さすがにまずいのでは。せめてカラムを数値型にすべき
     * @param unknown $query
     * @param unknown $colum
     * @param unknown $from
     * @param unknown $to
     * @return unknown
     */
    public static function str_between( $query, $colum, $from, $to ) {
        if( !empty( $from ) ) {
            $query->where( $colum, '>=', $from );
        }
        if( !empty( $to ) ) {
            $query->where( $colum, '<=', $to );
        }
        return $query;
    }

    /**
     * 年月用の条件を設定する
     *
     * @param unknown $query
     * @param unknown $colum
     * @param unknown $yyyy
     * @param unknown $mm
     */
    public static function whereYm( $query, $colum, $yyyy, $mm ) {
        if( !empty( $yyyy ) && !empty( $mm ) ) {
            return $query->whereRaw( $colum . '=' . "'$yyyy" . sprintf( '%02d', $mm ) . "'" );
        } else if( !empty( $yyyy ) ) {
            return $query->whereRaw( $colum. ' like ' . "'{$yyyy}%'" );
        } else if( !empty( $mm ) ) {
            return $query->whereRaw( $colum. ' like ' . "'%{$mm}'" );
        }

        return $query;
    }

    /**
     * DB::Raw対策
     * サブクエリを実行するにはDB::rawで実現するしか見当たらない
     * DB::rawはクエリパラメーターが使えない（？）ので、
     * 完全なSQLを生成するためのヘルパーメソッド
     * @param unknown $value
     */
    public static function whereString( &$query, $colum, $value ) {
        if( !empty( $value ) ) {
            return $query->whereRaw( $colum . '=' . "'$value'" );
        } else {
            return $query;
        }
    }

    public static function whereLike($query, $colum, $value) {
        if( !empty( $value ) ) {
            return $query->whereRaw( $colum . ' like ' . "'%$value%'" );
        }
        return $query;
    }

    public static function inString( &$query, $colum, $values ) {
        if( count( $values ) > 0 && !empty( $values[0] ) ) {
            return $query->whereRaw( $colum . ' in (\'' . implode( "','", $values ) . '\')' );
        }
        return $query;
    }

    public static function betweenString( &$query, $colum, $from, $to ) {
        if( !empty( $from ) && !empty( $to ) ) {
            $query->whereRaw( $colum . ' between ' . "'$from'" . ' and ' .  "'$to'" );
            return $query;
        }

        if( !empty( $from ) ) {
            $query->whereRaw( $colum . '>=' . "'$from'" );
            return $query;
        }

        if( !empty( $to ) ) {
            $query->whereRaw( $colum . '<=' . "'$to'" );
            return $query;
        }
        
        return $query;
    }
}
