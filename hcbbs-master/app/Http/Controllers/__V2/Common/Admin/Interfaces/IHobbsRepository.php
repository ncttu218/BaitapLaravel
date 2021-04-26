<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V2\Common\Admin\Interfaces;

/**
 * Description of IHobbsRepository
 *
 * @author ahmad
 */
interface IHobbsRepository {
    
    /**
     * 一覧画面
     */
    public function getIndex();
    
    /**
     * 一括更新
     */
    public function postIndex();
    
}
