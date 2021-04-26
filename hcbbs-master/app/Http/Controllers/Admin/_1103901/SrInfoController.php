<?php

namespace App\Http\Controllers\Admin\_1103901;

use App\Http\Controllers\Admin\Common\Controllers\Parents\SrInfoCoreController;
use App\Http\Controllers\Admin\Common\Interfaces\ISrInfo2ndRepository;
use App\Http\Controllers\Admin\Common\Repositories\SrInfo\ResponsiveThemeRepository;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class SrInfoController extends SrInfoCoreController implements ISrInfo2ndRepository
{
    use ResponsiveThemeRepository;
}
