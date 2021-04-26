<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Controllers\Parents\BlogUpdateLogCoreController;
use App\Http\Controllers\Admin\Common\Interfaces\IBlogUpdateLogRepository;
use App\Http\Controllers\Admin\Common\Repositories\BlogUpdateLogRepository;

/**
 * 各店情報掲示板 店舗別集計ツール
 *
 * @author ahmad
 *
 */
class BlogUpdateLogController extends BlogUpdateLogCoreController implements IBlogUpdateLogRepository {
    
    use BlogUpdateLogRepository;
}
