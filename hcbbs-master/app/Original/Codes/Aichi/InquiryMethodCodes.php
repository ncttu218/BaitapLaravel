<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Original\Codes\Aichi;

use App\Original\Codes\Code;

/**
 * Description of InquiryMethodCodes
 *
 * @author ahmad
 */
class InquiryMethodCodes extends Code {
    
    private $codes = [
        'non' => 'なし',
        'mail' => 'メール',
        'form' => 'お問い合わせフォーム',
        'url' => 'フォームURLを入力(独自のフォームなど)',
    ];
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        parent::__construct( $this->codes );
    }
}
