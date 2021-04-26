<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Api\Interfaces\ICommentPostRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\CommentPostRepository;

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