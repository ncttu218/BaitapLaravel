<?php

namespace Api\Lib\Tests\FeatureTest;

use Symfony\Component\DomCrawler\Crawler;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InfobbsChecker
 *
 * @author ahmad
 */
trait V2InfobbsApiChecker {
    
    use V2ApiChecker;
    
    /**
     * ページングの数
     * 
     * @var int
     */
    protected $pageNum = 10;
    
    protected $blogRecordStructure = [
            'shop_code',
            'shop_name',
            'time',
            'new_fig', 
            'image', 
            'title', 
            'content', 
            'number',
        ];
    
    /**
     * ルートをHTMLとしてロードされる
     * 
     * @param string $route ルート
     * @param string $method メソッド名
     */
    protected function loadPageHtml($page, $params = '') {
        $method = 'GET';
        if ($params !== '') {
            $params = "&{$params}";
        }
        $route = "/v2/api/{$this->hanshaCode}/infobbs/{$page}?"
            . "page_num={$this->pageNum}"
            . "{$params}";
        $this->response = $this->call($method, $route);
        // HTMLのデータ
        $html = $this->response->getContent();
        $this->crawler = new Crawler($html);
    }
    
    /**
     * ルートをJSONとしてロードされる
     * 
     * @param string $route ルート
     * @param string $method メソッド名
     */
    protected function loadPageJson($page, $params = '') {
        $method = 'GET';
        if ($params !== '') {
            $params = "&{$params}";
        }
        $route = "/v2/api/{$this->hanshaCode}/infobbs/{$page}?show_type=json&"
            . "page_num={$this->pageNum}"
            . "{$params}";
        $this->response = $this->call($method, $route);
        return $route;
    }
    
    /**
     * 記事の表示の確認
     */
    private function checkBody() {
        $nodes = $this->crawler->filter('body > font > table');
        $this->assertEquals($this->pageNum, $nodes->count());
    }
    
    private function assertHtmlEquals($text, $selector) {
        $result = $this->crawler->filter($selector)->text();
        $this->assertEquals($text, $result);
    }
    
    private function getNodesObject($selector) {
        return $this->crawler->filter($selector)->each(function (Crawler $node) {
            return $node;
        });
    }
    
    private function callNodesObject($selector, $callback) {
        $nodes = $this->crawler->filter($selector)->each(function (Crawler $node) {
            return $node;
        });
        $callback($nodes);
    }
    
    private function assertHtmlMatches($pattern, $selector, $callback = null) {
        $result = $this->crawler->filter($selector)->last()->text();
        if ($callback !== null) {
            $callback($result);
        }
        $this->assertEquals((bool)preg_match($pattern, $result), true);
    }
    
    private function assertMatchesPattern($pattern, $text) {
        $this->assertEquals((bool)preg_match($pattern, $text), true);
    }
    
    /**
     * カテゴリーの確認
     */
    private function checkCategory() {
        $this->callNodesObject('body > div[align=left] a', function($nodes) {
            $this->assertEquals(6, count($nodes));
            $this->assertMatchesPattern('/全て/', $nodes[0]->text());
            $this->assertMatchesPattern('/お店/', $nodes[1]->text());
            $this->assertMatchesPattern('/お得/', $nodes[2]->text());
            $this->assertMatchesPattern('/クルマ/', $nodes[3]->text());
            $this->assertMatchesPattern('/地域/', $nodes[4]->text());
            $this->assertMatchesPattern('/話題/', $nodes[5]->text());
        });
    }
    
    /**
     * ページングの確認
     */
    private function checkPaging() {
        $this->assertHtmlMatches('/[0-9]+?件中/', '.infobbs_page');
        $this->callNodesObject('.infobbs_page font', function($nodes) {
            $this->assertMatchesPattern("/{$this->pageNum}件目/", $nodes[0]->text());
            $this->assertMatchesPattern("/次の{$this->pageNum}件/", $nodes[1]->text());
            $this->assertMatchesPattern("/{$this->pageNum}件目/", $nodes[2]->text());
            $this->assertMatchesPattern("/次の{$this->pageNum}件/", $nodes[3]->text());
        });
    }
    
    /**
     * 感想の確認
     */
    private function checkImpression() {
        $this->assertHtmlMatches('/この記事の感想：[0-9]+?件/',
                'table td > div.hakusyu.font10:nth-child(1)');
        $this->assertHtmlMatches('/感想を送る/',
                'table td > div.hakusyu.font10:nth-child(2)');
    }
}
