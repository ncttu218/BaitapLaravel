<?php

namespace App\Original\Util;

use App\Lib\Util\DateUtil;

class ViewUtil {

    // つかってない
    public static function ymFromOpt( $span ) {
        $current = DateUtil::now();
        for( $i = 0; $i < $span; $i++ ) {
            $key = DateUtil::toYm( DateUtil::monthLater( $current, $i ) );
            $value = DateUtil::toJpDateYm( $key . "01" );
            $result[$key] = $value;
        }
        return $result;
    }

    public static function defaultYmOptions() {
        $start = DateUtil::nowMonthAgo(6);
        $span = 13;
        for( $i = 0; $i < $span; $i++ ) {
            $key = DateUtil::toYm( DateUtil::monthLater( $start, $i ) );
            $value = DateUtil::toJpDateYm( $key . "01" );
            $result[$key] = $value;
        }
        return $result;
    }

    public static function ymOptions( $start, $span ) {
        for( $i = 0; $i < $span; $i++ ) {
            $key = DateUtil::toYm( DateUtil::monthLater( $start, $i ) );
            $value = DateUtil::toJpDateYm( $key . "01" );
            $result[$key] = $value;
        }
        return $result;
    }

    public static function genSelectTag( $options, $isEmptyRow=false, $default=null ) {
        $select = new VIewTagUtil();
        if( $isEmptyRow ) {
            $options = static::addEmptyRow( $options );
        }
        $select->setOptions( $options );
        $select->setEmptyRow( $isEmptyRow );
        $select->setDefaultValue( $default );

        return $select;
    }

    public static function genSelectMultiTag( $options, $isEmptyRow=false, $default=null ) {
        $select = ViewUtil::genSelectTag( $options, $isEmptyRow );
        $select->setMulti(true);
        return $select;

    }

    public static function addEmptyRow( $options ) {
        // array_unshift, array_mergeだと添え字が振り直されるので
        // 以下のように変なことをしています
        // うまく表示されないのでコメントアウト
        //$options->prepend( '----', '' );
        
        // collectionオブジェクトの時の処理
        if( is_object( $options ) ){
            // 一度値を配列に変更
            $optionsAry = $options->all();
            
            $optionsAry = array_reverse( $optionsAry, true );
            $optionsAry[null] = '----';
            $optionsAry = array_reverse( $optionsAry, true );
            
            $options = collect( $optionsAry );
        }
        
        // 配列の時の処理
        if( is_array( $options ) ){
            $options = array_reverse( $options, true );
            $options[null] = '----';
            $options = array_reverse( $options, true );

        }

        return $options;
    }
}
