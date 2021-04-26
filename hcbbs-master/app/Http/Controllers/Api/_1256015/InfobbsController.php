<?php

namespace App\Http\Controllers\Api\_1256015;

use App\Http\Controllers\Api\Common\Controllers\Parents\InfobbsCoreController;
use App\Http\Controllers\Api\Common\Interfaces\IInfobbsRepository;
use App\Http\Controllers\Api\Common\Repositories\InfobbsRepository;
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

                    /**
                     * カテゴリー
                     */
                    // 販社名の設定パラメータを取得
                    $para_list = ( config('original.para')[$this->hanshaCode] );
                    // 店舗除外
                    $categoryCounterOptions = [ 'shopExclusion' => $this->shopExclusion ];
                    
                    $categoryList = [];
                    // 設定ファイルのカテゴリー機能NOのとき
                    if( isset( $para_list['category'] ) && $para_list['category'] !== '' ){
                        // カテゴリーの配列を取得
                        $categoryParaList = explode( ",", $para_list['category'] );
                        sort($categoryParaList);
                        $i = 0;
                        foreach( $categoryParaList as $categoryName ){
                            $categoryList[$i]['category_name'] = $categoryName;
                            $categoryList[$i]['category_count'] = CodeUtil::getBlogTotalSum( $this->hanshaCode, $this->shopCode, $categoryName, $categoryCounterOptions );
                            $i++;
                        }
                    }

                     /**
                     * コメント投稿
                     */
                    

                    // コメントの配列
                    $commentList = CodeUtil::getBlogCommentCountList( $this->hanshaCode, $postNumber );
                    // コメントを投稿するURL
                    $commentPostUrl = url_auto('/api/comment_post');
                    $commentPostUrl .= "?hansha_code={$this->hanshaCode}&blog_data_id={$postNumber}";
                    // マージするデータ
                    $mergeData = [
                        'category_list' => $categoryList,
                        'comment_list' => $commentList,
                        'comment_post_url' => $commentPostUrl,
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
            // ファイルパスの情報を取得する
            $fileinfo = pathinfo( $imgFiles[$i]['file'] );
            // PDFファイルの対応
            if( strtolower( $fileinfo['extension'] ) === "pdf" ){
                $imgFiles[$i]['thumb'] = CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] );
            }else{
                $imgFiles[$i]['thumb'] = url_auto( $imgFiles[$i]['thumb'] );
            }
            
            $imgFiles[$i]['file'] = url_auto( $imgFiles[$i]['file'] );
            $outputData[$i] = $imgFiles[$i];
        }

        return $outputData;
    }
}