<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Original\Codes\Aichi;

use App\Original\Codes\Code;

/**
 * Description of BackgroundDesignCodes
 *
 * @author ahmad
 */
class BackgroundDesignCodes extends Code {
    
    private $codes = [
        '1' => 'プレーン',
        '2' => 'コルク',
        '3' => 'クール',
        '4' => 'シーズン',
    ];
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        parent::__construct( $this->codes );
    }
}
