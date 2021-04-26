<?php

namespace App\Http\Controllers\Api\Common\Traits\Infobbs;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecordModifier
 *
 * @author ahmad
 */
trait RecordModifier {
    
    //use ConvertEmojis;
    
    /**
     * レコードのデータを変更
     * 
     * @param object $data データ
     * @param bool $isMultiple 複数かのフラグ
     */
    private function modifyResultRecord(&$data, $isMultiple = true) {
        if ($isMultiple) {
            foreach ($data as $i => $item) {
                $this->modifyOneResultRecord($item);
            }
        } else {
            $this->modifyOneResultRecord($data);
        }
    }
    
    /**
     * レコードのデータを変更
     * 
     * @param object $data レコード
     */
    private function modifyOneResultRecord(&$data) {
        // 削除マークが入っている画像ファイル名を削除する
        for ($i = 1; $i <= 6; $i++) {
            $propName = 'file' . $i;
            if (!isset($data->{$propName}) || 
                !preg_match('/,?file_del$/', $data->{$propName}))
            {
                // 画像URLを置換
                if (isset($data->{$propName}) && !empty($data->{$propName})) {
                    $data->{$propName} = $this->replaceOldSystemImage($data->{$propName});
                }
                continue;
            }
            $data->{$propName} = null;
        }
        //$data->title = $this->convertEmojiToHtmlEntity($data->title);
        
        // 余計な文字を削除する
        /*if (isset($this->stringReplacementMethod) && 
                $this->stringReplacementMethod === 'all_unwanted_chars') {*/
            if (is_object($data)) {
                // タイトル
                $data->title = $this->replaceAllUnwantedChars($data->title);
                // 画像URLを置換
                $data->comment = $this->replaceOldSystemImage($data->comment);
                // 本文
                $data->comment = $this->replaceAllUnwantedChars($data->comment);
            } else if (is_array($data)) {
                // タイトル
                if (isset($data['title'])) {
                    $data['title'] = $this->replaceAllUnwantedChars($data['title']);
                }
                // 本文
                if (isset($data['content'])) {
                    // 画像URLを置換
                    $data['content'] = $this->replaceOldSystemImage($data['content']);
                    $data['content'] = $this->replaceAllUnwantedChars($data['content']);
                }
            }
        //}
    }

    /**
     * 旧システムからの画像URLを置換する
     * 
     * @param string $str テキスト
     * @return string
     */
    private function replaceOldSystemImage($str) {
        $str = preg_replace('/img\.hondanet\.co\.jp/', 'image.hondanet.co.jp', $str);
        $str = preg_replace_callback('/(\/cgi\/)(.+?)(\/infobbs\/data\/image\/)(.+?)(\..+)/', function ($match) {
            if ($match[2] == substr($match[4], 0, 7)) {
                return "$match[1]$match[2]$match[3]$match[4]$match[5]";
            }
            return "$match[1]{$this->hanshaCode}$match[3]$match[4]$match[5]";
        }, $str);
        return $str;
    }
    
    /**
     * 余計な文字を削除する
     * 
     * @param string $str テキスト
     * @return string
     */
    private function replaceAllUnwantedChars($str) {
        // 絵文字を置換
        $str = $this->convertEmoji($str);
        return $str;
    }
    
}
