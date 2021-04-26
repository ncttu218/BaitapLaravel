<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\IStaffListRepository;
use App\Http\Controllers\Admin\Common\Repositories\StaffListRepository;

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