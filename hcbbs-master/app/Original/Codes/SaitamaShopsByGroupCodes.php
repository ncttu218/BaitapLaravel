<?php

namespace App\Original\Codes;

/**
 * 埼玉様の拠点一覧のグループ
 *
 * @author ahmad
 *
 */
class SaitamaShopsByGroupCodes extends Code {

    private $codes = [
        '第１営業部' => [
            '11', '17', '22', '34', '37', '40', '47', '53', '54',
        ],
        '第２営業部' => [
            '10', '14', '16', '19', '21', '26', '29', '31', '36', '41',
        ],
        '第３営業部' => [
            '04', '13', '18', '25', '27', '32', '39', '48', '50',
        ],
        '第４営業部' => [
            '01', '03', '05', '08', '15', '28', '43', '45', '46',
        ],
        '第５営業部' => [
            '06', '12', '23', '35', '38', '42', '49', '52',
        ],
        'U-Select' => [
            '71', '72', '74', '76', '77', '7A', '7B', '7C'
        ],
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
