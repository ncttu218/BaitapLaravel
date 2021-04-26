<?php

namespace App\Http\Controllers\V2\Common\Api\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Api\Repositories\Common\SrInfoRepository;
use App\Http\Controllers\V2\Common\Api\Interfaces\ISrInfoRepository;

/**
 * 本社用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class SrInfoController extends Controller implements ISrInfoRepository
{
    use SrInfoRepository;
}