<?php

namespace App\Http\Controllers\Admin\_2153801;

use App\Http\Controllers\Admin\Common\Controllers\Parents\AdminCoreController;
use App\Http\Controllers\Admin\Common\Repositories\SrInfo\ResponsiveThemeRepository;
use App\Http\Controllers\V2\Common\Admin\Interfaces\ITopRepository;

/**
 * 管理画面のTOPページ
 * 
 * @author ahmad
 */
class AdminController extends AdminCoreController implements ITopRepository
{
    use Repositories\TopRepository;

}
