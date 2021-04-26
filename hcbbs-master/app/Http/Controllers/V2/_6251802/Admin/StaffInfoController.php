<?php

namespace App\Http\Controllers\V2\_6251802\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IStaffInfoRepository;
//use App\Http\Controllers\V2\Common\Admin\Repositories\Common\StaffInfoRepository;
use App\Http\Controllers\V2\_6251802\Admin\Repositories\StaffInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends Controller implements IStaffInfoRepository
{
    use StaffInfoRepository;
}
