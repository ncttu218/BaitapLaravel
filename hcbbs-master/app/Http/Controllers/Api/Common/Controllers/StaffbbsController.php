<?php

namespace App\Http\Controllers\Api\Common\Controllers;

use App\Http\Controllers\Api\Common\Controllers\Parents\StaffbbsCoreController;
use App\Http\Controllers\Api\Common\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\Api\Common\Repositories\StaffbbsRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class StaffbbsController extends StaffbbsCoreController implements IStaffbbsRepository
{
    use StaffbbsRepository;
}
