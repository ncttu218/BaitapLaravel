<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\ITopRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\TopRepository;

/**
 * 管理画面
 *
 * @author ahmad
 *
 */
class AdminController extends Controller implements ITopRepository {
    
    use TopRepository;
}
