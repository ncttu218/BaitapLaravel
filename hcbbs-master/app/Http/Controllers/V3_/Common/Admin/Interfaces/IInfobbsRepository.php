<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V3\Common\Admin\Interfaces;

/**
 * Description of IInfobbsRepository
 *
 * @author ahmad
 */
interface IInfobbsRepository {
    
    /**
     * コンストラクター
     */
    public function __construct();
    
    /**
     * 一覧ページ
     */
    public function getIndex();
    
    /**
     * ルールページ
     */
    public function getRule();
    
    /**
     * 一覧ページでサブミットされるページ
     */
    public function postIndex();
    
    /**
     * 新規作成
     */
    public function getNew();
    
    /**
     * フォームを表示するページ
     */
    public function getUpload();
    
    /**
     * 画像を削除する処理
     */
    public function postDeleteImage();
    
    /**
     * フォームをサブミットする処理
     */
    public function postUpload();
    
    /**
     * 確認画面
     */
    public function getConfirm();
    
    /**
     * 確認する処理
     */
    public function postConfirm();
    
}
