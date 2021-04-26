<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 投稿アドレスのモデル
 *
 * @author yhatsutori
 *
 */
class EmailSettings extends AbstractModel {

    use SoftDeletes;

    // テーブル名
    protected $table = 'tb_email_settings';
    
    // 変更可能なカラム
    protected $fillable = [
        'email',       // メールアドレス
        'forward_email',// 転送メール
        'staff_code',  // スタッフコード
        'shop_code',   // 拠点コード
        'hansha_code', // 販社コード
        'system_name'  // システム名 infobbs OR staff
    ];

    /**
     * 検索条件を指定するメソッド
     * @param  [type] $query      [description]
     * @param  [type] $requestObj [description]
     * @return [type]             [description]
     */
    public function scopeWhereRequest( $query, $requestObj ){
        // 検索条件を指定
        $query
            // 販社コード
            ->whereMatch( 'hansha_code', $requestObj->hansha_code )
            // 拠点コード
            ->whereLike( 'shop_code', $requestObj->shop_code )
            // スタッフコード
            ->whereLike( 'staff_code', $requestObj->staff_code )
            // システム名
            ->whereLike( 'system_name', $requestObj->system_name )
            // メールアドレス
            ->whereLike( 'email', $requestObj->email );
        
        // 転送メールアドレス
        if (!empty($requestObj->forward_email)) {
            $query = $query->whereLike( 'forward_email', $requestObj->forward_email );
        }

        return $query;
    }

}
