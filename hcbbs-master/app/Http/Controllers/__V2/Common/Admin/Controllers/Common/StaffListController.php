<?php

namespace App\Http\Controllers\V2\Common\Admin\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IStaffListRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\StaffListRepository;

/**
 * 各店情報掲示板
 *
 * @author ahmad
 *
 */
class StaffListController extends Controller implements IStaffListRepository
{
    use StaffListRepository;
}