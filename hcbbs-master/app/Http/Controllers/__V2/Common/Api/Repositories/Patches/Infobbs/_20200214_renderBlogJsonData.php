<?php

namespace App\Http\Controllers\V2\Common\Api\Repositories\Patches\Infobbs;

/**
 * サムネール画像の修正
 *
 * @author ahmad
 *
 */
trait _20200214_renderBlogJsonData
{   
    /**
     * ブログのJSONデータ
     * 
     * @param array $blogData 返す変数
     * @param object $value ブログデータ
     * @param array $options オプション
     */
    private function fixRenderBlogJsonData(&$blogData, $value, array $options = []) {
        $data = [];
        
        // 拠点コード
        $data['shop_code'] = $value->shop;
        // 掲載番号
        $data['number'] = str_replace('data', '', $value->number);

        // 日付
        $data['time'] = date( $this->timeFormat, strtotime( $value->updated_at ) );
        // 新着フラグ
        $data['new_fig'] = $this->isNewBlog( $value->updated_at );
        // 公開日時が指定されているとき
        if( !empty( $value->from_date ) ) {
            $data['time'] = date( $this->timeFormat, strtotime( $value->from_date ) );
            $data['new_fig'] = $this->isNewBlog( $value->from_date );
        }

        /**
         * サムネイル画像
         */
        $contentStr = $value->comment;

        // 定形画像 3枚アップロードする画像があるとき
        $pattern = '/<img.*?src=[\"\']([^\"\']+?)[\"\']/';
        $data['image'] = asset_auto('img/no_image.gif');
        // 3枚アップロードするがぞうがあるとき
        if( !empty( $value->file1 ) == True ){
            $data['image'] = url_auto( $value->file1 );
        }else if( !empty( $value->file2 ) == True ){
            $data['image'] = url_auto( $value->file2 );
        }else if( !empty( $value->file3 ) == True ){
            $data['image'] = url_auto( $value->file3 );

        // 3枚画像が無いときは、本文の画像を参照
        }else if(preg_match($pattern, $contentStr, $match ) ) {
            $data['image'] = $match[1];
        }
        
        // タイムスタンプ
        $data['image'] = str_replace('[NOW_TIME]', time(), $data['image']);

        /**
         * タイトルの表示
         */
        $blog_title = trim($value->title);
        if (!empty($blog_title)) {
            if ($this->titleLength !== '') {
                $str_length = mb_strlen($blog_title);
                if ($str_length > $this->titleLength) {
                    $blog_title = mb_substr($blog_title, 0, $this->titleLength, 'utf-8');
                    $blog_title = trim($blog_title) . "...";
                }
            }
        } else {
            $blog_title = 'No Title';
        }

        // タイトル
        $blog_title = $this->convertEmojiToHtmlEntity($blog_title);
        $data['title'] = $blog_title;

        /**
         * 本文の表示
         */
        // コンテンツの概要
        $content = $contentStr;
        if (!empty($contentStr)) {
            if ($this->contentLength !== '') {
                $contentStr = strip_tags($contentStr);
                $contentStr = str_replace('&nbsp;', '', $contentStr);
                $contentStr = str_replace("\r\n", '', $contentStr);
                $contentStr = str_replace("\n", '', $contentStr);
                $content = $contentStr;
                // 本文から指定文字列分のみ抜き出す
                $str_length = mb_strlen($content);
                if ($str_length > $this->contentLength) {
                    $content = mb_substr($content, 0, $this->contentLength, 'utf-8');
                    $content = trim($content) . "...";
                }
            }
        } else {
            $content = '無し';
        }

        // 本文
        $data['content'] = $content;
        
        if ($this->isMultipleRecord) {
            $blogData[$options['key']] = $data;
        } else {
            $blogData = $data;
        }
    }
    
}