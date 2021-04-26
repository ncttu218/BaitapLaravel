<?php

namespace App\Http\Controllers\V3\Common\Admin\Controllers;

use App\Http\Controllers\V3\Common\Admin\Controllers\Parents\MessageCoreController;
use App\Http\Controllers\V3\Common\Admin\Interfaces\IMessageRepository;
use App\Http\Controllers\V3\Common\Admin\Repositories\MessageRepository;

/**
 * 一行メッセージ
 *
 * @author ahmad
 *
 */
class MessageController extends MessageCoreController implements IMessageRepository {
    
    use MessageRepository;

}