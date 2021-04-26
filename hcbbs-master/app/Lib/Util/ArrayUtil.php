<?php

namespace App\Lib\Util;

/**
 * 配列関連のユーティリティー
 *
 * @author yhatsutori
 *
 */
class ArrayUtil {
	
	/**
	 * 指定された配列の中の不要なスペースを除去
	 * @param  array $array [description]
	 * @return array 不要なスペースを除去した配列
	 */
    public static function array_trim( $array ) {
    	$result = [];
    	
        foreach( $array as $value ) {
            $result[] = trim( $value );
        }
        return $result;
    }
}
