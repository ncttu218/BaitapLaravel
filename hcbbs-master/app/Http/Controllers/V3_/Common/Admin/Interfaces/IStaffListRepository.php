<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\Common\Admin\Interfaces;

/**
 * Description of IInfobbsRepository
 *
 * @author ahmad
 */
interface IStaffListRepository {
    
    /**
     * 一覧ページ
     */
    public function getIndex();
    
}
