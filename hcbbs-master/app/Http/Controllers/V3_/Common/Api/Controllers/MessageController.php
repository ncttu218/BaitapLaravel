<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Api\Interfaces\IMessageRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\MessageRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class MessageController extends Controller implements IMessageRepository
{
    use MessageRepository;
}
