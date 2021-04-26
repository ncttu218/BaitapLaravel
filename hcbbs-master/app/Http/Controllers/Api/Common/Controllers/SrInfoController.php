<?php

namespace App\Http\Controllers\Api\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Repositories\SrInfoRepository;
use App\Http\Controllers\Api\Common\Interfaces\ISrInfoRepository;

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