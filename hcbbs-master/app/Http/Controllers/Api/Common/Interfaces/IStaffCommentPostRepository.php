<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api\Common\Interfaces;

use App\Http\Requests\SearchRequest;

/**
 * Description of ICommentPostRepository
 *
 * @author ahmad
 */
interface IStaffCommentPostRepository {
    
    /**
     * 一覧ページ
     */
    public function getIndex();
    
    /**
     * 新規作成の処理
     * 
     * @param SearchRequest $request リクエスト
     */
    public function postCreate( SearchRequest $request );
    
    /**
     * ありがとうの画面
     */
    public function getThanks();
    
}
