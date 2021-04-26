<?php

namespace App\Http\Controllers\Api\Common\Controllers;

use App\Http\Controllers\Api\Common\Controllers\Parents\DesignCoreController;
use App\Http\Controllers\Api\Common\Interfaces\IDesignRepository;
use App\Http\Controllers\Api\Common\Repositories\DesignRepository;

/**
 * 背景デザインのコントローラー
 * 
 * @author ahmad
 */
class DesignController extends DesignCoreController implements IDesignRepository
{
    use DesignRepository;
}
