<?php

namespace App\Http\Controllers\V2\_1006078\Admin;

use App\Http\Controllers\V2\Common\Admin\Controllers\MessageCoreController;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IMessageRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\MessageRepository;

/**
 * 一行メッセージ
 *
 * @author ahmad
 *
 */
class MessageController extends MessageCoreController implements IMessageRepository {
    
    use MessageRepository;

}