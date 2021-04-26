<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers\Parents;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageCoreController
 *
 * @author ahmad
 */
class EmergencyBulletinCoreController extends InfobbsCoreController {
    
    /**
     * コンストラクター
     */
    public function __construct() {
        parent::__construct();
        
        $this->controller = "V3\Common\Admin\Controllers\EmergencyBulletinController";
        
        // カテゴリー
        $this->category = ['緊急時'];
    }
}
