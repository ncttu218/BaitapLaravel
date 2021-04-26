<?php

namespace App\Original\Codes\Aichi;

use App\Original\Codes\Code;

/**
 * 拠点の表示フラグを表すコード
 *
 * @author ahmad
 *
 */
class UsedcarBlockCodes extends Code{
    
    private $codes = [
        '' => '全ブロック',
        '01' => '第1ブロック',
        '02' => '第2ブロック',
        '03' => '第3ブロック',
        '04' => '第4ブロック',
        '05' => '第5ブロック',
        '06' => '第6ブロック',
        '07' => '第7ブロック',
        '08' => '第8ブロック',
    ];
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        parent::__construct( $this->codes );
    }

}
