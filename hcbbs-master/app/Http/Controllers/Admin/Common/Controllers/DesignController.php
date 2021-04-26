<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Interfaces\IDesignRepository;
use App\Http\Controllers\Admin\Common\Repositories\DesignRepository;
use App\Http\Controllers\Admin\Common\Controllers\Parents\DesignCoreController;

/**
 * ショールーム情報編集のコントローラー
 * 
 * @author ahmad
 */
class DesignController extends DesignCoreController implements IDesignRepository
{
    use DesignRepository;
}
