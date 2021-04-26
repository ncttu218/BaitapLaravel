<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\Common\Admin\Interfaces;

use Request;
use App\Http\Requests\ShowroomInfoRequest;

/**
 * Description of ISrInfoNewRepository
 *
 * @author ahmad
 */
interface ISrInfo2ndRepository {
    
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
     */
    public function postEdit();
    
    /**
     * 確認する処理
     * 
     * @param ShowroomInfoRequest $request バリデーション
     */
    public function postConfirm( ShowroomInfoRequest $request );
    
    /**
     * 成功するメッセージを表示するページ
     */
    public function getThanks();
    
}
