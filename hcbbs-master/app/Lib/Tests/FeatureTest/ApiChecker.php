<?php

namespace Api\Lib\Tests\FeatureTest;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Checker
 *
 * @author ahmd
 */
trait ApiChecker {
    
    /**
     * ルートのデータ
     *
     * @var object
     */
    protected $response;
    
    /**
     * HTMLのデータ
     * 
     * @var object
     */
    protected $crawler;
    
    /**
     * 処理ステータスの確認
     */
    private function checkStatus() {
        $this->response->assertStatus(200);
        $this->response->assertSuccessful();
    }
}
