<?php

namespace App\Http\Controllers\V2\_5551803\Admin;

use App\Http\Controllers\V2\Common\Admin\Controllers\MessageCoreController;
use App\Http\Controllers\V2\Common\Admin\Interfaces\IMessageRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\MessageRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class MessageController extends MessageCoreController implements IMessageRepository
{
    use MessageRepository;
}
