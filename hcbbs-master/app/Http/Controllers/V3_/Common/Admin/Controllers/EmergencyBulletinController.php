<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\V3\Common\Admin\Controllers\Parents\EmergencyBulletinCoreController;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IEmergencyBulletinRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\EmergencyBulletinRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\InfobbsRepository;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IInfobbsRepository;

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