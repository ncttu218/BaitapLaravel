<?php

namespace App\Http\Controllers\V2\Common\Api\Controllers\Common;

use App\Http\Controllers\V2\Common\Api\Controllers\StaffbbsCoreController;
use App\Http\Controllers\V2\Common\Api\Interfaces\IStaffbbsRepository;
use App\Http\Controllers\V2\Common\Api\Repositories\Common\StaffbbsRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class StaffbbsController extends StaffbbsCoreController implements IStaffbbsRepository
{
    use StaffbbsRepository;
}
