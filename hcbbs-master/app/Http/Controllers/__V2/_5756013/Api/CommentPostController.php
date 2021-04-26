<?php

namespace App\Http\Controllers\V2\_5756013\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V2\Common\Api\Interfaces\ICommentPostRepository;
use App\Http\Controllers\V2\Common\Api\Repositories\Common\CommentPostRepository;

/**
 * 店舗ブログのAPI
 *
 * @author ahmad
 *
 */
class CommentPostController extends Controller
    implements ICommentPostRepository
{
    // 共通レポジトリー
    use CommentPostRepository;
}