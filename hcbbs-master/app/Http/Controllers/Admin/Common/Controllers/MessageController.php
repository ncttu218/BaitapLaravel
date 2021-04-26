<?php

namespace App\Http\Controllers\Admin\Common\Controllers;

use App\Http\Controllers\Admin\Common\Controllers\Parents\MessageCoreController;
use App\Http\Controllers\Admin\Common\Interfaces\IMessageRepository;
use App\Http\Controllers\Admin\Common\Repositories\MessageRepository;

/**
 * 一行メッセージ
 *
 * @author ahmad
 *
 */
class MessageController extends MessageCoreController implements IMessageRepository {
    
    use MessageRepository;

}