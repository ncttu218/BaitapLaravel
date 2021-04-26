<?php

namespace App\Http\Controllers\V3\Common\Api\Controllers;

use App\Http\Controllers\V3\Common\Api\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\V3\Common\Api\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\InfobbsRepository;
use App\Http\Controllers\V3\Common\Api\Repositories\Patches\Infobbs\_20200214_renderBlogJsonData;

/**
 * 店舗ブログのAPI
 *
 * @author ahmad
 *
 */
class InfobbsController extends InfobbsCoreController implements IInfobbsRepository
{
    // 共通レポジトリー
    use InfobbsRepository;
    
    // サムネール画像を間違った修正
    use _20200214_renderBlogJsonData;
    
    /**
     * サムネール画像の修正
     * 
     * @param array $blogData 返す変数
     * @param object $value ブログデータ
     * @param array $options オプション
     */
    private function renderBlogJsonData(&$blogData, $value, array $options = []) {
        $this->fixRenderBlogJsonData($blogData, $value, $options);
    }
}