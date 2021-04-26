<?php

namespace App\Original\Codes\Base;

use App\Original\Codes\Code;

/**
 * 拠点の表示フラグを表すコード
 *
 * @author yhatsutori
 *
 */
class BaseShowFlgCodes extends Code{
    
    private $codes = [
        '' => "すべて表示",
        '1' => "店舗ブログのみ",
        '2' => "スタッフブログのみ",
        '3' => "強化版中古車のみ"
    ];
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        parent::__construct( $this->codes );
    }

}
