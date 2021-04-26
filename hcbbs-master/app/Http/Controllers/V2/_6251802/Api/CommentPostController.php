<?php

namespace App\Http\Controllers\V2\_6251802\Api;

use App\Http\Controllers\V2\Common\Api\Interfaces\ICommentPostRepository;
use App\Http\Controllers\V2\Common\Api\Repositories\Common\CommentPostRepository;
use Illuminate\Routing\Controller;

/**
 * 本社用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class CommentPostController extends Controller implements ICommentPostRepository
{
    use CommentPostRepository;
}