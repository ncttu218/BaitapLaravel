<?php

namespace App\Account;

use App\Lib\Util\DateUtil;
use App\Account\Authority;
use App\Models\UserAccount;

/**
 * ログイン時の担当者クラス
 * @author yhatsutori
 *
 */
class Account{

    private $account;
    private $role;
    private $base;
    private $authority;

    /**
     * コンストラクタ
     *
     * @param UserAccount $account
     * @param Authority $authority
     */
    public function __construct( UserAccount $account ){
        $this->account = $account;
        $this->role = $account->role;
        $this->base = $account->base;
    }

    #########################
    ## role method
    #########################
    
    /**
     * ロールのインスタンスを取得する
     * ※直接よばれてません
     * @return  class app\Models\Role
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * ロールの優先順位を取得する
     * account_levelに紐づいたidの値
     * @return  int
     */
    public function getRolePriority(){
        return $this->role->priority;
    }

    /**
     * ロール名をを取得する
     * account_levelに紐づいた名称の値
     * @return  string
     */
    public function getRoleName(){
        return $this->role->role_name;
    }

    #########################
    ## base method
    #########################
    
    /**
     * 拠点のインスタンスを取得する
     * ※直接よばれてません
     * @return class app\Models\Base
     */
    public function getBase(){
        return $this->base;
    }

    /**
     * 拠点コードを取得する
     * @return string
     */
    public function getBaseCode(){
        return $this->base->base_code;
    }

    #########################
    ## account method
    #########################

    /**
     * プライマリーキーの取得
     * @return int tb_user_accountのid
     */
    public function getPrimayKey(){
        if( !empty( $this->account ) ) {
            return $this->account->id;
        }
    }

    /**
     * 担当者コードを取得する
     * @return  string 例：999
     */
    public function getUserId(){
        if ( !empty( $this->account ) ){
            return $this->account->user_login_id;
        }
    }

    /**
     * 担当者名を取得する
     * @return  string 例：システム
     */
    public function getUserName(){
        if ( !empty( $this->account ) ){
            return $this->account->user_name;
        }
    }
    
    /**
     * 最新ログイン日時を取得する
     * @return  string 例：2016年07月15日(金)18:18
     */
    public function getLastLogined(){
        if( !empty( $this->account ) ) {
            return DateUtil::toJpDate( $this->account->last_logined );
        }
    }

    /**
     * アカウントレベルを取得する
     * @return  integer 例：5
     */
    public function getAccountLevel(){
        if ( !empty( $this->account ) ){
            return $this->account->account_level;
        }
    }

    /**
     * 1ページの表示件数を取得する
     * @return  integer 例：4
     */
    public function getPageNum(){
        if ( !empty( $this->account ) ){
            return $this->account->page_num;
        }
    }

    /**
     * メールアドレス(六三用)を取得する
     * @return  string 例：name@mut.co.jp
     */
    public function getMailMut(){
        if ( !empty( $this->account ) ){
            return $this->account->mail_mut;
        }
    }

    /**
     * メールアドレス(お客様用)を取得する
     * @return  string 例：name@mut.co.jp
     */
    public function getMailUser(){
        if ( !empty( $this->account ) ){
            return $this->account->mail_user;
        }
    }

    /**
     * 販社コードを取得する
     * @return  string
     */
    public function gethanshaCode(){
        if ( !empty( $this->account ) ){
            return $this->account->hansha_code;
        }
    }

    /**
     * テーブルNoを取得する
     * @return  string
     */
    public function getTableNo(){
        if ( !empty( $this->account ) ){
            return $this->account->table_no;
        }
    }

    /**
     * テンプレートNoを取得する
     * @return  string
     */
    public function getTemplateNo(){
        if ( !empty( $this->account ) ){
            return $this->account->template_no;
        }
    }

    /**
     * ショップリストを取得する
     * @return  string
     */
    public function getShop(){
        if ( !empty( $this->account ) ){
            return $this->account->shop;
        }
    }

    /**
     * カテゴリを取得する
     * @return  string
     */
    public function getCategory(){
        if ( !empty( $this->account ) ){
            return $this->account->category;
        }
    }

    #########################
    ## method
    #########################

    /**
     * 指定された優先度より劣っている場合、
     * ユーザーIDを返送する。そうでない場合はNUll。
     *
     * @param unknown $priority 優先度
     */
    public function getLessPriorityOrNull( $priority ){
        if( $this->role->priority >= $priority ) {
            return $this->getUserId();
        } else {
            return null;
        }
    }
    
}
