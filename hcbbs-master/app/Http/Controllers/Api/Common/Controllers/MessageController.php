<?php

namespace App\Http\Controllers\Api\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Interfaces\IMessageRepository;
use App\Http\Controllers\Api\Common\Repositories\MessageRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class MessageController extends Controller implements IMessageRepository
{
    use MessageRepository;
}
