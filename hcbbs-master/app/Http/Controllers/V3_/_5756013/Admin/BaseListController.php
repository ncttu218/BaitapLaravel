<?php

namespace App\Http\Controllers\V3\_5756013\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IBaseListRepository;
//use App\Http\Controllers\V3\Common\Admin\Repositories\BaseListRepository;
use App\Http\Controllers\V3\_5756013\Admin\Repositories\BaseListRepository;
use App\Http\Controllers\V3\Common\Admin\Controllers\Parents\BaseListCoreController;

/**
 * 各店情報掲示板
 *
 * @author ahmad
 *
 */
class BaseListController extends BaseListCoreController implements IBaseListRepository {
    
    use BaseListRepository;
}