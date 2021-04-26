<?php

namespace App\Http\Controllers\V2\_5551803\Admin;

use App\Http\Controllers\V2\Common\Admin\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\InfobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Controllers\InfobbsCoreController;

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