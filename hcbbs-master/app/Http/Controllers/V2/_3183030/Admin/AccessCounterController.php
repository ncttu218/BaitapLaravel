<?php

namespace App\Http\Controllers\V2\_3183030\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IAccessCounterRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\AccessCounterRepository;

/**
 * 各店情報掲示板 店舗別集計ツール
 *
 * @author ahmad
 *
 */
class AccessCounterController extends Controller implements IAccessCounterRepository {
    
    use AccessCounterRepository;
}