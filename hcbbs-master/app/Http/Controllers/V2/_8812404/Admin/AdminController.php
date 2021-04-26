<?php

namespace App\Http\Controllers\V2\_8812404\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\ITopRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\TopRepository;

/**
 * 管理画面
 *
 * @author ahmad
 *
 */
class AdminController extends Controller implements ITopRepository {
    
    use TopRepository;
}
