<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\ISrInfoRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\SrInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class SrInfoController extends Controller implements ISrInfoRepository
{
    use SrInfoRepository;
}
