<?php

namespace App\Http\Controllers\V2\Common\Admin\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\ISrInfoRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\SrInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class SrInfoController extends Controller implements ISrInfoRepository
{
    use SrInfoRepository;
}
