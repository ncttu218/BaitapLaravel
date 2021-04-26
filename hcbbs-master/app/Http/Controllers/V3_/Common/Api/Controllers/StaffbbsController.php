<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers;

use App\Http\Controllers\V3\Common\Api\Controllers\Parents\StaffbbsCoreController;
use App\Http\Controllers\V3\Common\Api\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\StaffbbsRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class StaffbbsController extends StaffbbsCoreController implements IStaffbbsRepository
{
    use StaffbbsRepository;
}
