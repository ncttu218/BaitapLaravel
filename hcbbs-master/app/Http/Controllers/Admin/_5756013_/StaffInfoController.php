<?php

namespace App\Http\Controllers\Admin\_5756013;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\IStaffInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends Controller implements IStaffInfoRepository
{
    use Repositories\StaffInfoRepository;
}
