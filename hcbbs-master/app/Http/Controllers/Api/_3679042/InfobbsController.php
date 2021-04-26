<?php

namespace App\Http\Controllers\Api\_3679042;

use App\Original\Util\CodeUtil;
use App\Http\Controllers\Api\Common\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\Api\Common\Interfaces\IInfobbsRepository;
use App\Http\Controllers\Api\Common\Repositories\InfobbsRepository;

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

    /**
     * ビューデータの追加
     *
     * @param string $methodName 関数名
     * @return array
     */
    public function extractViewData($methodName)
    {
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
                    // マージするデータ
                    $mergeData = [
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
     * 画像
     *
     * @param object $item レコード
     * @return array
     */
    private function getImages($item)
    {
        $outputData = [];
        $imgFiles = [];
        // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
        for ($i = 1; $i <= 3; $i++) {
            // 画像
            $file = $item->{'file' . $i};
            // PDFファイルの場合
            if( !empty( $file ) && preg_match("/\.pdf$/i", $file ) ){
                // PDFファイル
                $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $file);
                // サムネイル
                $imgFiles[$i]['thumb'] = CodeUtil::getPdfThumbnail( $file );
            }else{
                // 画像
                $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $file);
                // サムネール画像
                $imgFiles[$i]['thumb'] = $file;
            }
            $imgFiles[$i]['caption'] = $this->convertEmojiToHtmlEntity($item->{'caption' . $i});
        }

        for ($i = 1; $i <= 3; $i++) {
            if (empty($imgFiles[$i]['file']) == True) {
                continue;
            }

            $imgFiles[$i]['thumb'] = url_auto($imgFiles[$i]['thumb']);
            $imgFiles[$i]['file'] = url_auto($imgFiles[$i]['file']);
            $outputData[$i] = $imgFiles[$i];
        }

        return $outputData;
    }
}