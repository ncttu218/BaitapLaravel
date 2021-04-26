<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\Admin\Common\Repositories\StaffbbsRepository;
use App\Http\Controllers\Controller;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class StaffbbsController extends Controller implements IStaffbbsRepository
{
    use StaffbbsRepository;
}