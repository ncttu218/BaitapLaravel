<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api\Common\Interfaces;

/**
 * Description of IDesignRepository
 *
 * @author ahmad
 */
interface IDesignRepository {
    
    /**
     * 一覧ページ
     */
    public function getIndex();
    
}
