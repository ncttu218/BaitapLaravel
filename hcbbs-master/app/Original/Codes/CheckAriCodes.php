<?php

namespace App\Original\Codes;

/**
 * 削除を表すコード
 *
 * @author yhatsutori
 *
 */
class CheckAriCodes extends Code {

    private $codes = [
        '1' => '有',
        '2' => '有以外'
    ];

    /**
     * コンストラクタ
     */
    public function __construct() {
        parent::__construct($this->codes);
    }
    
}
