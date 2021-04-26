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
        $data->title = $this->convertEmojiToHtmlEntity($data->title);
    }
    
}
