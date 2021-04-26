<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends AbstractModel implements IDynamicTableName {

    use SoftDeletes;
    use TDynamicTableName;

    // テーブル名
    protected $table = 'tb_0000001_message';
    
    // 変更可能なカラム
    protected $fillable = [
        'regist',
        'number',
        'add',
        'agent',
        'single',
        'editpass',
        'treepath',
        'dis_date',
        'title', // タイトル
        'shop', // 店舗
        'url', // URL
        'url_target', // URL.target
        'from_date',
        'to_date',
    ];
    
    /**
     * テーブル名を変更する時の対応
     * 
     * @param string $name
     * @return string
     */
    public function onTableNameChanging($name) {
        return 'tb_' . $name . '_message';
    }
}
