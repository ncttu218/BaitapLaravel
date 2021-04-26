<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api\Common\Interfaces;

/**
 * Description of ISrInfoRepository
 *
 * @author ahmad
 */
interface ISrInfoRepository {
    
    /**
     * コンストラクター
     */
    public function __construct();
    
    /**
     * 店舗のショールーム情報
     */
    public function getInfo();
    
}
