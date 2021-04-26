<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\V3\Common\Admin\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\InfobbsRepository;
use App\Http\Controllers\V3\Common\Admin\Controllers\Parents\InfobbsCoreController;

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