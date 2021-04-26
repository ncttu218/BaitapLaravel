<?php

namespace App\Http\Controllers\V2\_1581055\Admin;

use App\Http\Controllers\V2\Common\Admin\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\StaffbbsRepository;
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