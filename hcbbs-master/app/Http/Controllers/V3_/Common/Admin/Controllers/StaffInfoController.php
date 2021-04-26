<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IStaffInfoRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\StaffInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends Controller implements IStaffInfoRepository
{
    use StaffInfoRepository;
}
