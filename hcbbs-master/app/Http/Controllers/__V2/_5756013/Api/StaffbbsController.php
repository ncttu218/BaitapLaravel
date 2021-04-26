<?php

namespace App\Http\Controllers\V2\_5756013\Api;

use App\Http\Controllers\V2\Common\Api\Controllers\StaffbbsCoreController;
use App\Http\Controllers\V2\Common\Api\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\V2\Common\Api\Repositories\Common\StaffbbsRepository;

use App\Original\Codes\StaffDepartmentCodes;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class StaffbbsController extends StaffbbsCoreController implements IStaffbbsRepository
{
    use StaffbbsRepository;
    
    /**
     * 役職のデータのスタイル
     * 
     * @var int
     */
    protected $staffPopulationStyle;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // スタッフデータのスタイル
        $this->staffPopulationStyle = StaffDepartmentCodes::DEPARTMENT_POPULATION_STYLE2;
        
        parent::__construct();
    }
}
