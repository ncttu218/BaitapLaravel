<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V2\Common\Admin\Interfaces;

use Request;
use App\Http\Requests\ShowroomInfoRequest;

/**
 * Description of IInfobbsRepository
 *
 * @author ahmad
 */
interface ISrInfoRepository {
    
    /**
     * コンストラクター
     */
    public function __construct();
    
    /**
     * 一覧ページ
     */
    public function getIndex();
    
    /**
     * 編集画面
     * 
     * @param Request $request リクエスト
     */
    public function getEdit( Request $request );
    
    /**
     * 編集する処理
     * 
     * @param ShowroomInfoRequest $request バリデーション
     */
    public function postEdit( ShowroomInfoRequest $request );
    
}
