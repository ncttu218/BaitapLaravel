<?php

namespace App\Http\Controllers\Api\_1103901;

use App\Http\Controllers\Api\Common\Controllers\Parents\StaffbbsCoreController;
use App\Http\Controllers\Api\Common\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\Api\Common\Repositories\StaffbbsRepository;

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
        $this->staffPopulationStyle = '1103901';
        
        parent::__construct();
    }
}
