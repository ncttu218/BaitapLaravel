<?php

namespace App\Http\Controllers\V2\Common\Admin\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IStaffInfoRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\StaffInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends Controller implements IStaffInfoRepository
{
    use StaffInfoRepository;
}
