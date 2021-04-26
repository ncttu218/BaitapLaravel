<?php

namespace App\Http\Controllers\V2\_6251802\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\ISrInfo2ndRepository;
use App\Http\Controllers\V2\_6251802\Admin\Repositories\SrInfoRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class SrInfoController extends Controller implements ISrInfo2ndRepository
{
    use SrInfoRepository;
}
