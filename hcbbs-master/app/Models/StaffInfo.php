<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * スタッフ紹介のモデル
 */
class StaffInfo extends AbstractModel implements IDynamicTableName {
    
    use SoftDeletes;
    use TDynamicTableName;

    // テーブル名
    protected $table = 'tb_0000001_staff';
    
    // 変更可能なカラム
    protected $fillable = [
        'regist', // 登録位置
        'number', // 
        'add', // 
        'agent', // 
        'single', // 
        'editpass', // 
        'treepath', // 
        'dis_date', // 
        'disp', // 
        'shop', // 
        'name', // 
        'name_furi', // 
        'name_roma', // 
        'degree', // 肩書き
        'qualification', // 
        'position', // 
        'phone_number', // 
        'birtday', // 
        'hobby', // 
        'photo', // 
        'photo2', // 
        'title', // 
        'file', // 
        'file2', // 
        'file3', // 
        'caption', // 
        'caption2', // 
        'caption3', // 
        'comment', // 
        'comment2', // 
        'msg', // 
        'published', // 
        'pos', // 

        #####################
        ##
        #####################

        'ext_field1', // 
        'ext_value1', // 
        'ext_field2', // 
        'ext_value2', // 
        'ext_field3', // 
        'ext_value3', // 
        'ext_value3_2', // 
        'ext_value3_3', // 
        'ext_value3_4', // 
        'ext_value3_5', // 
        'ext_value3_6', // 
        'ext_field4', // 
        'ext_value4', // 
        'ext_value4_2', // 
        'ext_value4_3', // 
        'ext_value4_4', // 
        'ext_value4_5', // 
        'ext_value4_6', // 
        'ext_field5', // 
        'ext_value5', // 
        'ext_value6', // 
        'category', // 
        'listing_order', // 
        'grade', // 
        'department', // 
    ];
    
    /**
     * テーブル名を変更する時の対応
     * 
     * @param string $name
     * @return string
     */
    public function onTableNameChanging( $name ) {
        return 'tb_' . $name . '_staff';
    }
}
