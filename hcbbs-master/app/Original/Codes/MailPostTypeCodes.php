<?php

namespace App\Original\Codes;

/**
 * ○/×を表すコード
 *
 * @author yhatsutori
 *
 */
class MailPostTypeCodes extends Code {

    private $codes = [
        'forwarded_infobbs' => '店舗ブログ転送メール',
        'forwarded_staff' => 'スタッフブログ転送メール',
        'infobbs' => '店舗ブログ',
        'staff' => 'スタッフブログ',
    ];

    /**
     * コンストラクタ
     */
    public function __construct() {
        parent::__construct($this->codes);
    }

    public static function getDefault() {
        return 'forwarded_infobbs';
    }
    
}
