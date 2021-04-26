<?php

namespace App\Original\Codes;

/**
 * 表示/非表示を表すコード
 *
 * @author yhatsutori
 *
 */
class StaffDepartmentCodes extends Code {
    
    /**
     * デフォルトスタイル
     * 
     * 東京中央様
     */
    const DEPARTMENT_POPULATION_DEFAULT = 0;
    
    /**
     * スタイル１
     * 
     * 北海道様
     */
    const DEPARTMENT_POPULATION_STYLE1 = 1;
    
    /**
     * スタイル１
     * 
     * さつま様
     */
    const DEPARTMENT_POPULATION_STYLE2 = 2;
    
    /**
     * コード
     * 
     * @var array
     */
    private $codes = [
        
        self::DEPARTMENT_POPULATION_DEFAULT => [
            'staff10' => '店長',
            'staff20' => '工場長',
            'staff29' => '店長代行',
            'staff30' => '営業',
            'staff40' => 'サービスフロント',
            'staff50' => 'サービス',
            'staff60' => 'ストアマネージャー',
            'staff70' => '事務',
        ],
        
        self::DEPARTMENT_POPULATION_STYLE1 => [
            "staff10" => '店長',
            "staff20" => '営業',
            "staff30" => '工場長',
            "staff40" => 'サービススタッフ',
            "staff31" => 'サービスフロント',
            "staff60" => '業務スタッフ',
        ],
        
        self::DEPARTMENT_POPULATION_STYLE2 => [
            'staff10' => '店長',
            'staff15' => '副店長',
            'staff20' => '工場長',
            'staff29' => '店長代行',
            'staff30' => '営業',
            'staff40' => 'サービスフロント',
            'staff50' => 'サービス',
            'staff60' => 'ストアマネージャー',
            'staff70' => '事務',
        ],
        
        '5551803' => [
            '営業' => '営業', 
            '工場長' => '工場長', 
            '中古車営業' => '中古車営業', 
            '営業主任' => '営業主任', 
            '店長代理' => '店長代理',
            'サービスフロント' => 'サービスフロント', 
            'サービス' => 'サービス', 
            '店長' => '店長',
        ],
        
        '1103901' => [
            'staff10' => '店長',
            'staff11' => '副店長',
            'staff12' => '店長代行',
            'staff13' => '店長代理',
            'staff20' => '工場長',
            'staff21' => '工場長代理',
            'staff30' => '営業スタッフ',
            'staff40' => 'サービスフロント',
            'staff50' => 'サービススタッフ',
            'staff60' => 'ストアマネージャー',
            'staff61' => 'シニアマネージャー',
            'staff70' => 'CA',
        ],
    ];

    /**
     * コンストラクタ
     */
    public function __construct( $key = self::DEPARTMENT_POPULATION_DEFAULT ) {
        parent::__construct( $this->codes[$key] ?? [] );
    }

    public function getValueOrNull($code, $default = '非表示') {
        $value = $this->getValue($code);
        if(empty($value)) {
            $value = $default;
        }
        return $value;
    }
}
