<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\IBaseListRepository;
use App\Http\Controllers\Admin\Common\Repositories\BaseListRepository;

/**
 * 各店情報掲示板
 *
 * @author ahmad
 *
 */
class BaseListController extends Controller implements IBaseListRepository {
    
    use BaseListRepository;
}