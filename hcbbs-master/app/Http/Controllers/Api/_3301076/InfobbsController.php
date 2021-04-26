<?php

namespace App\Http\Controllers\Api\_3301076;

use App\Http\Controllers\Api\Common\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\Api\Common\Interfaces\IInfobbsRepository;
use App\Http\Controllers\Api\Common\Repositories\InfobbsRepository;
use App\Http\Controllers\Api\Common\Repositories\Patches\Infobbs\_20200214_renderBlogJsonData;
use App\Http\Controllers\Api\Common\Repositories\InfobbsLikeRepository;
use App\Models\InfobbsComment;
use Closure;

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
    
    use InfobbsLikeRepository;
    
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
    
    /**
     * ビューデータの追加
     * 
     * @param string $methodName 関数名
     * @return array
     */
    public function extractViewData($methodName) {
        if ($methodName == 'getBlog') {
            return [
                'getGoodJobCountValue' => Closure::fromCallable([$this, 'getGoodJobCountValue']),
            ];
        }
        return [];
    }
}