<?php

namespace App\Original\Util;

use Session;

class SessionUtil {
    
    const DEFAULT_SYSTEM_NAME = '_infobbs';

    /**
     * システム名
     * 
     * @var string
     */
    private static $systemName = self::DEFAULT_SYSTEM_NAME;
    
    /**
     * システム名を変更する
     * 
     * @param string $systemName
     */
    public static function setSystemName( $systemName ) {
        self::$systemName = $systemName;
    }
    
    /**
     * システム名を取得する
     * 
     * @return string
     */
    public static function getSystemName() {
        return self::$systemName;
    }

    ######################
    ## user_info
    ######################
    
    /**
     * ユーザー情報を登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putUser( $value ) {
        Session::put('user_info' . self::DEFAULT_SYSTEM_NAME, $value);
    }

    /**
     * ユーザー情報を取得(セッション)
     * @return [type] [description]
     */
    public static function getUser() {
        return Session::get('user_info' . self::DEFAULT_SYSTEM_NAME);
    }

    /**
     * ユーザー情報を削除(セッション)
     * @return [type] [description]
     */
    public static function removeUser() {
        Session::forget('user_info' . self::DEFAULT_SYSTEM_NAME);
    }

    ######################
    ## sort
    ######################

    /**
     * 並び順を登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putSort( $value ) {
        Session::put('sort' . self::$systemName, $value);
    }
    
    /**
     * 並び順を取得(セッション)
     * @return [type] [description]
     */
    public static function getSort() {
        return Session::get('sort' . self::$systemName);
    }

    /**
     * 並び順を削除(セッション)
     * @return [type] [description]
     */
    public static function removeSort() {
        Session::forget('sort' . self::$systemName);
    }

    ######################
    ## search
    ######################
    
    /**
     * 検索値を登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putSearch( $array ) {
        Session::put('search' . self::$systemName, $array);
    }

    /**
     * 検索値を取得(セッション)
     * @return [type] [description]
     */
    public static function getSearch() {
        return Session::get('search' . self::$systemName);
    }

    /**
     * 検索値を削除(セッション)
     * @return [type] [description]
     */
    public static function removeSearch() {
        Session::forget('search' . self::$systemName);
    }

    /**
     * 検索値のセッションを保持するかを調べる
     * @return boolean [description]
     */
    public static function hasSearch(){
        if ( Session::has('search' . self::$systemName) ) {
            return true;
        } else {
            return false;
        }
    }
    
    ######################
    ## remove
    ######################
    
    /**
     * 検索情報と並び替え情報を削除
     * @return [type] [description]
     */
    public static function removeSession() {
        // 検索情報を初期化
        Session::forget('search' . self::$systemName);
        // 並び替え情報を初期化
        Session::forget('sort' . self::$systemName);
    }

    ######################
    ## １ページの数
    ######################
    
    /**
     * １ページの数を登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putPageNum( $value ) {
        Session::put('pageNum' . self::$systemName, $value);
    }

    /**
     * １ページの数を取得(セッション)
     * @return [type] [description]
     */
    public static function getPageNum() {
        return Session::get('pageNum' . self::$systemName);
    }

    ######################
    ## 店舗リスト
    ######################
    
    /**
     * 店舗リストを登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putShopList( $value ) {
        Session::put('shopList' . self::$systemName, $value);
    }

    /**
     * 店舗リストを取得(セッション)
     * @return [type] [description]
     */
    public static function getShopList() {
        return Session::get('shopList' . self::$systemName) ?? [];
    }

    ######################
    ## テーブル名
    ######################
    
    /**
     * テーブル名を登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putTableName( $value ) {
        Session::put('tableName' . self::$systemName, $value);
    }

    /**
     * テーブル名を取得(セッション)
     * @return [type] [description]
     */
    public static function getTableName() {
        return Session::get('tableName' . self::$systemName);
    }

    ######################
    ## 店舗No
    #######################
    
    /**
     * 店舗Noを登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putShop( $value ) {
        Session::put('shop' . self::$systemName, $value);
    }

    /**
     * 店舗Noを取得(セッション)
     * @return [type] [description]
     */
    public static function getShop() {
        return Session::get('shop' . self::$systemName);
    }

    ######################
    ## 店舗名
    #######################
    
    /**
     * 店舗名を登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putName( $value ) {
        Session::put('nsme' . self::$systemName, $value);
    }

    /**
     * 店舗名を取得(セッション)
     * @return [type] [description]
     */
    public static function getName() {
        return Session::get('nsme' . self::$systemName);
    }

    ######################
    ## blogデータ
    #######################
    
    /**
     * blogデータを登録(セッション)
     * @param mixed $value 値
     * @param string $keyName セッションのキー
     * @return void
     */
    public static function putData( $value, $keyName = '' ) {
        // セッションのキー
        $keyName = $keyName !== '' ? '_' . $keyName : '';
        Session::put('data' . self::$systemName . $keyName, $value);
    }

    /**
     * blogデータを取得(セッション)
     * @param string $keyName セッションのキー
     * @return mixed
     */
    public static function getData( $keyName = '' ) {
        // セッションのキー
        $keyName = $keyName !== '' ? '_' . $keyName : '';
        return Session::get('data' . self::$systemName . $keyName);
    }

    /**
     * blogデータを取得(セッション)
     * @param string $keyName セッションのキー
     * @return mixed
     */
    public static function removeData( $keyName = '' ) {
        // データ情報を初期化
        $keyName = $keyName !== '' ? '_' . $keyName : '';
        Session::forget('data' . self::$systemName . $keyName);
    }

    ######################
    ## upflag
    #######################
    
    /**
     * upflagを登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putUpflag( $value ) {
        Session::put('upflag' . self::$systemName, $value);
    }

    /**
     * upflag取得(セッション)
     * @return [type] [description]
     */
    public static function getUpflag() {
        return Session::get('upflag' . self::$systemName);
    }

    ######################
    ## upflag
    #######################
    
    /**
     * isconfirmationを登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putIsConfirmation( $value ) {
        Session::put('isconfirmation' . self::$systemName, $value);
    }

    /**
     * isconfirmation取得(セッション)
     * @return [type] [description]
     */
    public static function getIsConfirmation() {
        return Session::get('isconfirmation' . self::$systemName);
    }

    ######################
    ## numberモード
    #######################
    
    /**
     * numberモードを登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putNumber( $value ) {
        Session::put('number' . self::$systemName, $value);
    }

    /**
     * numberモードを取得(セッション)
     * @return [type] [description]
     */
    public static function getNumber() {
        return Session::get('number' . self::$systemName);
    }

    ######################
    ## modeモード
    #######################
    
    /**
     * editモードを登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putMode( $value ) {
        Session::put('mode' . self::$systemName, $value);
    }

    /**
     * editモードを取得(セッション)
     * @return [type] [description]
     */
    public static function getMode() {
        return Session::get('mode' . self::$systemName);
    }

    ######################
    ## shopSelectedモード
    #######################
    
    /**
     * editモードを登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putShopSelected( $value ) {
        Session::put('shopSelected' . self::$systemName, $value);
    }

    /**
     * editモードを取得(セッション)
     * @return [type] [description]
     */
    public static function getShopSelected() {
        return Session::get('shopSelected' . self::$systemName);
    }

    ######################
    ## カテゴリ検索
    ######################
    
    /**
     * カテゴリ検索を登録(セッション)
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function putCategorySelected( $value ) {
        Session::put('categorySelected' . self::$systemName, $value);
    }

    /**
     * カテゴリ検索を取得(セッション)
     * @return [type] [description]
     */
    public static function getCategorySelected() {
        return Session::get('categorySelected' . self::$systemName);
    }
    
    /**
     * メーム名検索を登録(セッション)
     * 
     * @param  string $value 値
     * @return void
     */
    public static function putHomeName( $value ) {
        Session::put('homeName' . self::$systemName, $value);
    }

    /**
     * ホーム検索を取得(セッション)
     * 
     * @return string ホーム名
     */
    public static function getHomeName() {
        return Session::get('homeName' . self::$systemName);
    }

}
