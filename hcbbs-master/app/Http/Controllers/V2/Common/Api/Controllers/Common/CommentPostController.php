<?php

namespace App\Http\Controllers\V2\Common\Api\Controllers\Common;

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