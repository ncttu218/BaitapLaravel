<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IAccessCounterRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\AccessCounterRepository;

/**
 * 各店情報掲示板 店舗別集計ツール
 *
 * @author ahmad
 *
 */
class AccessCounterController extends Controller implements IAccessCounterRepository {
    
    use AccessCounterRepository;
}