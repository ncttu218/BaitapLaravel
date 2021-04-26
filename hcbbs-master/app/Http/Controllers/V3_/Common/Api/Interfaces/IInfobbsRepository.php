<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\Common\Api\Interfaces;

/**
 * Description of IInfobbsRepository
 *
 * @author ahmad
 */
interface IInfobbsRepository {
    
    /**
     * 1件最新ブログ
     */
    public function getFirst();
    
    /**
     * 店舗ブログ一覧
     */
    public function getBlog();
    
    /**
     * 最新ブログ一覧
     */
    public function getLatestBlog();
    
    /**
     * ランキング
     */
    public function getRanking();
    
}
