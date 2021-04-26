<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\V3\Common\Admin\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\StaffbbsRepository;
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