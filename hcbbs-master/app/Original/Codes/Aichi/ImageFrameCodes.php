<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Original\Codes\Aichi;

use App\Original\Codes\Code;

/**
 * Description of ImageFrameCodes
 *
 * @author ahmad
 */
class ImageFrameCodes extends Code {
    
    private $codes = [
        '1' => 'プレーン',
        '2' => 'ピンナップ',
        '3' => 'クール',
        '4' => 'ポップ',
    ];
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        parent::__construct( $this->codes );
    }
}
