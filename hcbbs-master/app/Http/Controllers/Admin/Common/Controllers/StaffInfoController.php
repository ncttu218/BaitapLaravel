<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\IStaffInfoRepository;
use App\Http\Controllers\Admin\Common\Repositories\StaffInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends Controller implements IStaffInfoRepository
{
    use StaffInfoRepository;
}
