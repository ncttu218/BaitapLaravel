<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IBaseListRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\BaseListRepository;

/**
 * 各店情報掲示板
 *
 * @author ahmad
 *
 */
class BaseListController extends Controller implements IBaseListRepository {
    
    use BaseListRepository;
}