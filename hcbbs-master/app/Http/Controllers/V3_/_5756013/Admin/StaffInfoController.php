<?php

namespace App\Http\Controllers\V3\_5756013\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IStaffInfoRepository;
//use App\Http\Controllers\V3\Common\Admin\Repositories\StaffInfoRepository;
use App\Http\Controllers\V3\_5756013\Admin\Repositories\StaffInfoRepository;
use App\Http\Controllers\V3\Common\Admin\Controllers\Parents\StaffInfoCoreController;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends StaffInfoCoreController implements IStaffInfoRepository
{
    use StaffInfoRepository;
}
