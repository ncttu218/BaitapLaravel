<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 店舗ブログのモデル
 */
class Infobbs extends AbstractModel implements IDynamicTableName {
    
    use SoftDeletes;
    use TDynamicTableName;

    // テーブル名
    protected $table = 'tb_0000000_infobbs';
    
    // 変更可能なカラム
    protected $fillable = [
        'number',
        'add',
        'agent',
        'comment',
        'shop',
        'file',
    ];
    
    /**
     * テーブル名を変更する時の対応
     * 
     * @param string $name
     * @return string
     */
    public function onTableNameChanging($name) {
        return 'tb_' . $name . '_infobbs';
    }

}