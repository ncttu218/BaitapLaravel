<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Controllers\Parents\EmergencyBulletinCoreController;
use App\Http\Controllers\Admin\Common\Interfaces\IEmergencyBulletinRepository;
use App\Http\Controllers\Admin\Common\Repositories\EmergencyBulletinRepository;
use App\Http\Controllers\Admin\Common\Repositories\InfobbsRepository;
use App\Http\Controllers\Admin\Common\Interfaces\IInfobbsRepository;

/**
 * 一行メッセージ
 *
 * @author ahmad
 *
 */
class EmergencyBulletinController extends EmergencyBulletinCoreController
    implements IInfobbsRepository, IEmergencyBulletinRepository {
    
    use InfobbsRepository;
    
    use EmergencyBulletinRepository;

}