<?php

namespace app\Lib\Csv;

interface iParser
{
    /**
     * 行単位のバリデーションを行う
     *
     * @param array $row
     * @return true: invalid, false: normal
     */
    public function validate($row);
    public function store($row);
    public function getColumns();
    
    /**
     * CSVファイル外（プログラム呼び出し側）から値を受け取り設定する
     *
     */
    public function inject($storeData, $value);
    public function getItemNum();

}