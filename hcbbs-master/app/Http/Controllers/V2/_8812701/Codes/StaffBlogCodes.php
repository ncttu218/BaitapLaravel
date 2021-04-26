<?php

namespace App\Http\Controllers\V2\_8812701\Codes;

use App\Original\Codes\Code;

/**
 * 店舗コード
 *
 * @author ahmad
 *
 */
class StaffBlogCodes extends Code {
    
    /**
     * 店舗コード
     * 
     * @var array
     */
    private $codes = [
        '01' => '高崎貝沢店',
        '02' => '伊勢崎連取店',
        '03' => '高前バイパス店',
        '05' => '吉岡店',
        '06' => '前橋大島店',
        '07' => '上中居店',
        '70' => 'U-Select高崎西',
        '71' => 'U-Select藤岡',
    ];

    /**
     * コンストラクタ
     */
    public function __construct() {
        parent::__construct( $this->codes );
    }
}
