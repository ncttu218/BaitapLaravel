<?php

namespace App\Http\Controllers\V3\_5756013\Codes;

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
        '01' => '阿久根店',
        '02' => '谷山店',
        '03' => '指宿店',
        '04' => '南鹿児島店',
        '05' => '上川内店',
        '06' => '隈之城店',
        '07' => '宇宿店',
        '09' => '川辺店',
        '70' => 'U-Select谷山',
    ];

    /**
     * コンストラクタ
     */
    public function __construct() {
        parent::__construct( $this->codes );
    }
}
