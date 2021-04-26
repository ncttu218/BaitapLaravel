<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Api\Repositories\SrInfoRepository;
use App\Http\Controllers\V3\Common\Api\Interfaces\ISrInfoRepository;

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