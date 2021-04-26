<?php

namespace App\Http\Controllers\Admin\_5756013;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\IBaseListRepository;

/**
 * 各店情報掲示板
 *
 * @author ahmad
 *
 */
class BaseListController extends Controller implements IBaseListRepository {
    
    use Repositories\BaseListRepository;
}