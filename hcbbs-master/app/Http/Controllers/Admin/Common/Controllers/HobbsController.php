<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Controllers\Parents\HobbsCoreController;
use App\Http\Controllers\Admin\Common\Interfaces\IHobbsRepository;
use App\Http\Controllers\Admin\Common\Repositories\HobbsRepository;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class HobbsController extends HobbsCoreController implements IHobbsRepository
{
    use HobbsRepository;
}