<?php

namespace App\Original\Codes;

/**
 * ○/×を表すコード
 *
 * @author yhatsutori
 *
 */
class UrlTargetCodes extends Code {

    private $codes = [
        '0' => '別ウィンドウ',
        '1' => '同ウィンドウ',
    ];

    /**
     * コンストラクタ
     */
    public function __construct() {
        parent::__construct($this->codes);
    }

    public static function getDefault() {
        return '0';
    }
    
}
