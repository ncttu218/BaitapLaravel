<?php

namespace App\Http\Controllers\V2\_6251802\Api;

use App\Http\Controllers\V2\Common\Api\Controllers\InfobbsCoreController;
use App\Http\Controllers\V2\Common\Api\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V2\Common\Api\Repositories\Common\InfobbsRepository;

/**
 * 店舗ブログのAPI
 *
 * @author ahmad
 *
 */
class InfobbsController extends InfobbsCoreController
    implements IInfobbsRepository
{
    use InfobbsRepository;
}