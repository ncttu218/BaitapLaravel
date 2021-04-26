<?php

namespace App\Http\Controllers\Api\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Interfaces\IEmergencyBulletinRepository;
use App\Http\Controllers\Api\Common\Repositories\EmergencyBulletinRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class EmergencyBulletinController extends Controller implements IEmergencyBulletinRepository
{
    use EmergencyBulletinRepository;
}
