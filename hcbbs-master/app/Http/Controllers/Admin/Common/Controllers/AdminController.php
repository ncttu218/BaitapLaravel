<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\ITopRepository;
use App\Http\Controllers\Admin\Common\Repositories\TopRepository;

/**
 * 管理画面
 *
 * @author ahmad
 *
 */
class AdminController extends Controller implements ITopRepository {
    
    use TopRepository;
}
