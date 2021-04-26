<?php

namespace App\Http\Controllers\Api\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Interfaces\ICommentPostRepository;
use App\Http\Controllers\Api\Common\Repositories\CommentPostRepository;

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