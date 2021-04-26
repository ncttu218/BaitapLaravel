<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Interfaces\IInfobbsRepository;
use App\Http\Controllers\Admin\Common\Repositories\InfobbsRepository;
use App\Http\Controllers\Admin\Common\Controllers\Parents\InfobbsCoreController;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class InfobbsController extends InfobbsCoreController implements IInfobbsRepository
{
    use InfobbsRepository;
}