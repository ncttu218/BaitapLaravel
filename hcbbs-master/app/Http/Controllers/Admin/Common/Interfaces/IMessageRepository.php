<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin\Common\Interfaces;

use Request;
use App\Http\Requests\MessageRequest;

/**
 * Description of IMessageRepository
 *
 * @author ahmad
 */
interface IMessageRepository {
    
    /**
     * 一覧画面
     */
    public function getIndex();
    
    /**
     * 一括更新
     */
    public function postIndex();
    
    /**
     * 新規作成
     * 
     * @param Request $request リクエスト
     */
    public function getCreate( Request $request );
    
    /**
     * 編集画面
     * 
     * @param string $id ID
     * @param string $shopCode 店舗コード
     */
    public function getEdit( $id = "", $shopCode = "" );
    
    /**
     * 1行メッセージの確認画面
     * 
     * @param MessageRequest $request リクエスト
     */
    public function postConfirm( MessageRequest $request );
    
    /**
     * スタッフの完了画面
     * 
     * @param object $request リクエスト
     */
    public function postComp( Request $request );
    
    /**
     * スタッフの完了画面
     */
    public function getThanks();
    
    /**
     * 編集画面を開く時の画面
     * 
     * @param  string $id ID
     * @return string $shopCode 店舗コード
     */
    public function getDetail( $id, $shopCode = null );
    
}
