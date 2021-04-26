<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Api\Interfaces\IEmergencyBulletinRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\EmergencyBulletinRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class EmergencyBulletinController extends Controller implements IEmergencyBulletinRepository
{
    use EmergencyBulletinRepository;
}
