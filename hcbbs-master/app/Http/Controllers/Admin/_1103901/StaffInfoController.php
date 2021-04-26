<?php

namespace App\Http\Controllers\Admin\_1103901;

use App\Http\Controllers\Admin\Common\Controllers\Parents\StaffInfoCoreController;
use App\Http\Controllers\Admin\Common\Interfaces\IStaffInfoRepository;
use App\Http\Controllers\Admin\Common\Repositories\StaffInfo\ResponsiveThemeRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends StaffInfoCoreController implements IStaffInfoRepository
{
    use ResponsiveThemeRepository;
}
