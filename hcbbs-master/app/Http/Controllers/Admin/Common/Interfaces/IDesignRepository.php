<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Interfaces;

/**
 * Description of IDesignRepository
 *
 * @author ahmad
 */
interface IDesignRepository {
    
    /**
     * 背景デザインを編集する画面
     */
    public function getEdit();

    /**
     * 背景デザインを確認する画面
     */
    public function postConfirm();
    
    /**
     * 背景デザインを保存する
     */
    public function postSave();

}
