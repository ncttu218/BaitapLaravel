<?php

namespace App\Http\Controllers\V2\_6251802\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Api\Interfaces\IMessageRepository;
use App\Http\Controllers\V2\Common\Api\Repositories\Common\MessageRepository;

/**
 * お知らせ（1行メッセージ） 編集のコントローラー
 * 
 * @author ahmad
 */
class MessageController extends Controller implements IMessageRepository
{
    use MessageRepository;
}
