<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api\Common\Interfaces;

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
     * スタッフ一覧ページ
     */
    public function getStaffList();
    
    /*
     * スタッフの詳細ページ
     */
    public function getProfile();
    
    /**
     * スタッフのブログ一覧
     */
    public function getBlog();
    
    /**
     * スタッフの最新ブログ
     */
    public function getLatestBlog();
    
    /**
     * ランキング
     */
    public function getRanking();
    
}
