<?php

namespace App\Http\Controllers\V3\_5756013\Codes;

use App\Original\Codes\Code;

/**
 * 店舗コード
 *
 * @author ahmad
 *
 */
class ShopBlogCodes extends Code {
    
    /**
     * 店舗コード
     * 
     * @var array
     */
    private $codes = [
        '00',   // さつま報
        '70',   // U-Select谷山
        'aa'    // 担当者ブログ
    ];

    /**
     * コンストラクタ
     */
    public function __construct() {
        parent::__construct( $this->codes );
    }
}
