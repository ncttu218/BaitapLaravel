<?php

namespace App\Http\Controllers\V3\_6251802\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Admin\Interfaces\ISrInfo2ndRepository;
use App\Http\Controllers\V3\_6251802\Admin\Repositories\SrInfoRepository;
use App\Http\Controllers\V3\Common\Admin\Controllers\Parents\SrInfoCoreController;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class SrInfoController extends SrInfoCoreController implements ISrInfo2ndRepository
{
    use SrInfoRepository;
}
