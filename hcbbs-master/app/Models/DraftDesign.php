<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 本番背景デザインのモデル
 */
class DraftDesign extends AbstractModel implements IDynamicTableName {
    
    use SoftDeletes;
    use TDynamicTableName;

    // テーブル名
    protected $table = 'tb_0000000_draft_design';
    
    // 変更可能なカラム
    protected $fillable = [
        'shop', // 拠点コード
        'main_photo', // 写真
        'layout', // レイアウト
        'pattern', // パターン
        'edit_pwd', // パスワード
    ];
    
    /**
     * テーブル名を変更する時の対応
     * 
     * @param string $name
     * @return string
     */
    public function onTableNameChanging($name) {
        return 'tb_' . $name . '_draft_design';
    }

}