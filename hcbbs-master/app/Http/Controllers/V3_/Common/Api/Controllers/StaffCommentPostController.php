<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V3\Common\Api\Interfaces\IStaffCommentPostRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\StaffCommentPostRepository;
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