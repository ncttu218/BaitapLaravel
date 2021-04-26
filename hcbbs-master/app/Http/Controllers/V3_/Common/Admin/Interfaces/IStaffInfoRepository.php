<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\Common\Admin\Interfaces;

use App\Http\Requests\StaffInfoRequest;
use Request;

/**
 * Description of IInfobbsRepository
 *
 * @author ahmad
 */
interface IStaffInfoRepository {
    
    /**
     * コンストラクター
     */
    public function __construct();
    
    /**
     * 一覧ページ
     */
    public function getList();
    
    /**
     * 新規作成
     * 
     * @param Request $request リクエスト
     */
    public function getCreate( Request $request );
    
    /**
     * 編集画面
     * 
     * @param string $id 店舗コード
     */
    public function getEdit( $id = "" );
    
    /**
     * 確認する処理
     * 
     * @param StaffInfoRequest $request バリデーション
     */
    public function postConfirm( StaffInfoRequest $request );
    
    /**
     * 一括更新
     */
    public function postBulkAction();
    
    /**
     * 完了する処理
     * 
     * @param Request $request リクエスト
     */
    public function postComp( Request $request );
    
    /**
     * ありがとうの画面
     */
    public function getThanks();
    
}
