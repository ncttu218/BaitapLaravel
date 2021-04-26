<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\Common\Admin\Interfaces;

/**
 * 各店情報掲示板 店舗別集計ツール
 *
 * @author ahmad
 */
interface IAccessCounterRepository {
    
    /**
     * コンストラクター
     */
    public function __construct();
    
    /**
     * 各店情報掲示板 店舗別集計ツール
     */
    public function getCount();
}
