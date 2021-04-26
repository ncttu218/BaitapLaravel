<?php

namespace App\Http\Controllers\Admin\_5551803;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\IStaffInfoRepository;
use App\Http\Controllers\Admin\_5551803\Repositories\StaffInfoRepository;
use App\Http\Controllers\Admin\Common\Controllers\Parents\StaffInfoCoreController;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends StaffInfoCoreController implements IStaffInfoRepository
{
    use StaffInfoRepository;
}
