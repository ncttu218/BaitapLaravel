<?php

namespace App\Http\Controllers\Api\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\Interfaces\IStaffCommentPostRepository;
use App\Http\Controllers\Api\Common\Repositories\StaffCommentPostRepository;
use Request;

/**
 * 店舗ブログのAPI
 *
 * @author ahmad
 *
 */
class StaffCommentPostController extends Controller
    implements IStaffCommentPostRepository
{
    // 共通レポジトリー
    use StaffCommentPostRepository;
}