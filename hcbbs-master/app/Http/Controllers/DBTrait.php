<?php

namespace App\Http\Controllers;

use App\Original\Util\DBUtil;

/**
 * テーブル、カラム自動作成
 *
 * @author M.ueki
 *
 */
trait DBTrait {
    
    /**
    * table作成
    */
    public function checkTable() {
        
        // メール設定
        DBUtil::makeTable('tb_email_settings', config('table.emailSettingsModel'));
        
        // 販社のテーブル
        $hansha_code = config('original.hansha_code');
        foreach ($hansha_code as $code => $name){
            $para = config('original.para')[$code] ?? [];
            if (empty($para)) {
                continue;
            }
            // 情報掲示板
            DBUtil::makeTable('tb_'.$code.'_infobbs',config('table.infobbsModel'));
            // 情報掲示板コメント   
            if(isset($para['comment']) && $para['comment'] == '1'){
                DBUtil::makeTable('tb_'.$code.'_infobbs_comment',config('table.commentModel'));
            }
            // スタッフブログ&スタッフ紹介   
            if (isset($para['staff']) && $para['staff'] == '1') {
                DBUtil::makeTable('tb_' . $code . '_staff',config('table.staffModel'));
                if ($code == '2153801') {
                    DBUtil::makeTable('tb_' . $code . '_staff_draft',config('table.staffModel'));
                }
            }
            // スタッフコメント   
            if(isset($para['staff_comment']) && $para['staff_comment'] == '1'){
                DBUtil::makeTable('tb_'.$code.'_staff_comment',config('table.commentModel'));
            }
            // 店舗紹介
            if(isset($para['shop']) && $para['shop'] == '1'){
                DBUtil::makeTable('tb_'.$code.'_shop',config('table.shopModel'));
            }
            // 1行メッセージ
            if( !empty( $para['message'] ) && in_array( $para['message'], ['1', '2'] ) ){
                DBUtil::makeTable('tb_'.$code.'_message',config('table.messageModel'));
            }
            // 背景デザイン
            if (isset($para['design']) && $para['design'] == '1') {
                DBUtil::makeTable('tb_' . $code . '_true_design', config('table.designModel'));
                DBUtil::makeTable('tb_' . $code . '_draft_design', config('table.designModel'));
            }
            
        }
    }    
    
}


