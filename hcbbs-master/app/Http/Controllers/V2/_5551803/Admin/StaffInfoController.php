<?php

namespace App\Http\Controllers\V2\_5551803\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IStaffInfoRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\StaffInfoRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class StaffInfoController extends Controller implements IStaffInfoRepository
{
    use StaffInfoRepository;
}
