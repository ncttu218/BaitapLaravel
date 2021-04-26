<?php

namespace App\Commands\Other\Account;

use App\Lib\Util\DateUtil;
use App\Models\UserAccount;
use App\Commands\Command;

/**
 * 担当者を削除コマンド
 *
 * @author yhatsutori
 */
class DeleteCommand extends Command{

    /**
     * コンストラクタ
     * @param [type]      $id         [description]
     * @param [type]      $file_name  [description]
     */
    public function __construct( $id ){
        $this->id = $id;
    }

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle(){
        // 指定したIDのモデルオブジェクトを取得
        $userMObj = UserAccount::findOrFail( $this->id );
        
        // ソフトデリート
        $userMObj->delete();
    }
    
}
