<?php

namespace App\Http\Controllers\Api\_1382247;

use App\Http\Controllers\Api\Common\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\Api\Common\Interfaces\IInfobbsRepository;
use App\Http\Controllers\Api\Common\Repositories\InfobbsRepository;
use App\Http\Controllers\Api\Common\Repositories\InfobbsLikeRepository;
use App\Models\InfobbsComment;
use App\Original\Util\CodeUtil;
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
    
    use InfobbsLikeRepository;
    
    /**
     * ビューデータの追加
     * 
     * @param string $methodName 関数名
     * @return array
     */
    public function extractViewData($methodName) {
        if ($methodName == 'getBlog') {
            return [
                'mergeDataRequested' => function ($currentData, $recordData) {
                    // 画像
                    $images = [
                        'position' => $recordData->pos,
                        'items' => $this->getImages($recordData),
                    ];
                    // 掲載番号
                    $postNumber = $currentData['number'] ?? '';
                    // いいね数
                    $likeCount = $this->getGoodJobCountValue($postNumber);
                    // いいねを投稿するURL
                    $likePostUrl = action_auto("Api\_{$this->hanshaCode}\InfobbsController@getSubmitGoodJob");
                    $likePostUrl .= "?hansha_code={$this->hanshaCode}&num={$currentData['number']}";
                    // マージするデータ
                    $mergeData = [
                        'like_count' => $likeCount,
                        'like_post_url' => $likePostUrl,
                        'images' => $images,
                    ];
                    // 現在のデータに新しいデータをマージする
                    $currentData = array_merge($currentData, $mergeData);
                    return $currentData;
                },
            ];
        }
        return [];
    }

    /**
     * いいねを登録されたイベントを発火する
     * 
     * @param string $postNumber 掲載番号
     * @return string JSONデータ
     */
    public function onLikeAdded($postNumber) {
        // いいね数
        $likeCount = $this->getGoodJobCountValue($postNumber);
        // HTMLを出力する
        $html = "<script type=\"text/javascript\">
        //window.parent.document.getElementById('likes-count-data{$postNumber}').innerHTML = '{$likeCount}';
        //console.log(window.parent);
        </script>";
        return $html;
    }

    /**
     * いいねの登録に失敗されたイベントを発火する
     * 
     * @return mixed
     */
    public function onLikeAddFailed() {
        // HTMLを出力する
        $html = '<script type="text/javascript">
        alert(\'すでにイイねしています\');
        </script>';
        return $html;
    }

    /**
     * 画像
     * 
     * @param object $item レコード
     * @return array
     */
    private function getImages($item) {
        $outputData = [];
        $imgFiles = [];
        // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
        for( $i=1; $i<= 3; $i++ ){
            // 画像
            $thumb = $item->{'file' . $i};
            $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $thumb);
            // サムネール画像
            $imgFiles[$i]['thumb'] = $thumb;
            $imgFiles[$i]['caption'] = $this->convertEmojiToHtmlEntity($item->{'caption' . $i});
        }
        
        for( $i=1; $i<= 3; $i++ ) {
            if( empty( $imgFiles[$i]['file'] ) == True ) {
                continue;
            }

            $imgFiles[$i]['thumb'] = url_auto( $imgFiles[$i]['thumb'] );
            $imgFiles[$i]['file'] = url_auto( $imgFiles[$i]['file'] );
            $outputData[$i] = $imgFiles[$i];
        }

        return $outputData;
    }
}