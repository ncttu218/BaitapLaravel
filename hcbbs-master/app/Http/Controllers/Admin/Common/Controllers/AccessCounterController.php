<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Controllers\Parents\AccessCounterCoreController;
use App\Http\Controllers\Admin\Common\Interfaces\IAccessCounterRepository;
use App\Http\Controllers\Admin\Common\Repositories\AccessCounterRepository;

/**
 * 各店情報掲示板 店舗別集計ツール
 *
 * @author ahmad
 *
 */
class AccessCounterController extends AccessCounterCoreController implements IAccessCounterRepository {
    
    use AccessCounterRepository;
}