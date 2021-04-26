<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Interfaces;

use App\Http\Requests\StaffRequest;

/**
 * Description of IStaffbbsRepository
 *
 * @author ahmad
 */
interface IStaffbbsRepository {
    
    /**
     * コンストラクター
     */
    public function __construct();
    
    /**
     * スタッフの一覧表示
     */
    public function getIndex();
    
    /**
     * スタッフの一覧表示(一括編集ボタン)
     */
    public function postIndex();
    
    /**
     * スタッフの編集画面
     */
    public function getEditProfile();
    
    /**
     * スタッフの編集画面（次へボタン）　使用しているか不明
     */
    public function postEditProfile( StaffRequest $req );
    
    /**
     *  スタッフの確認画面
     */
    public function getConfirm();
    
    /**
     * スタッフの登録
     */
    public function postConfirm();
    
    /**
     * スタッフ一覧表示
     */
    public function getList();
    
    /**
     * スタッフの編集画面（次へボタン）
     */
    public function postList();
    
    /**
     * スタッフ全般編集画面
     */
    public function getSingleEdit();
    
    /**
     * 編集画面（次へボタン）
     */
    public function postSingleEdit();
    
    /**
     * ブログの一覧表示
     */
    public function getBlogList();
    
    /**
     * ブログの一覧表示(一括編集ボタン)
     */
    public function postBlogList();
    
    /**
     * ブログの編集画面
     */
    public function getBlogEdit();
    
    /**
     * ブログの編集画面（次へボタン）
     */
    public function postBlogEdit();
    
    /**
     * ブログの確認画面
     */
    public function getConfirmBlog();
    
    /**
     * ブログ登録
     */
    public function postConfirmBlog();
    
    /**
     * ブログスタッフの新規入力
     */
    public function getNew();
    
    /**
     * スタッフの新規入力
     */
    public function getNewStaff();
    
    /**
     * 画像削除
     */
    public function postDeleteImage();
    
}
