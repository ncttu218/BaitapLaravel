<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\Interfaces\ISrInfoRepository;
use App\Http\Controllers\Admin\Common\Repositories\SrInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class SrInfoController extends Controller implements ISrInfoRepository
{
    use SrInfoRepository;
}
