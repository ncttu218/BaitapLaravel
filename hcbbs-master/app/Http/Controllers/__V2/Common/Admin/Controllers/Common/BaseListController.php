<?php

namespace App\Http\Controllers\V2\Common\Admin\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IBaseListRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\BaseListRepository;

/**
 * 各店情報掲示板
 *
 * @author ahmad
 *
 */
class BaseListController extends Controller implements IBaseListRepository {
    
    use BaseListRepository;
}