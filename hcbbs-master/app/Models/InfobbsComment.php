<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ブログコメントのモデルのモデル
 *
 * @author yhatsutori
 *
 */
class InfobbsComment extends AbstractModel implements IDynamicTableName {

    use SoftDeletes;
    use TDynamicTableName;

    // テーブル名
    protected $table = 'tb_0000001_infobbs_comment';
    
    // 変更可能なカラム
    protected $fillable = [
        'num', // ブログのID
        'mark', // マーク
        'comment', // コメント
        'ip', // アクセス元のIPアドレス
        'browser', // ブラウザ ユーザーエージェント
    ];

    /**
     * テーブル名を指定
     * @param [type] $hansha_cd [description]
     */
    public function onTableNameChanging( $hansha_cd ){
        // テーブル名
        return 'tb_' . $hansha_cd . '_infobbs_comment';
    }


}
