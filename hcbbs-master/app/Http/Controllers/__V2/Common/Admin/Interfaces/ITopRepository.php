<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V2\Common\Admin\Interfaces;

/**
 * Description of ITopRepository
 *
 * @author ahmad
 */
interface ITopRepository {
    
    /**
     * コンストラクター
     */
    public function __construct();
    
    /**
     * 一覧ページ
     */
    public function getIndex();
    
}
