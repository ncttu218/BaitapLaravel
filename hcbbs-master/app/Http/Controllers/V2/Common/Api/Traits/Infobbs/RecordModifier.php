<?php

namespace App\Http\Controllers\V2\Common\Api\Traits\Infobbs;

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
                if (isset($data->{$propName})) {
                    $data->{$propName} = preg_replace('/img\.hondanet\.co\.jp/', 'image.hondanet.co.jp', $data->{$propName});
                }
                continue;
            }
            $data->{$propName} = null;
        }
        $data->title = $this->convertEmojiToHtmlEntity($data->title);
    }
    
}
