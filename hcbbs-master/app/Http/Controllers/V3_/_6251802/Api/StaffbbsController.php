<?php

namespace App\Http\Controllers\V3\_6251802\Api;

use App\Http\Controllers\V3\Common\Api\Controllers\Parents\StaffbbsCoreController;
use App\Http\Controllers\V3\Common\Api\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\StaffbbsRepository;

use App\Original\Codes\StaffDepartmentCodes;

/**
 * 本社用管理画面コントローラー
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
        $this->staffPopulationStyle = StaffDepartmentCodes::DEPARTMENT_POPULATION_STYLE1;
        
        parent::__construct();
    }
}