<?php

namespace App\Commands\Other\Base;

use App\Lib\Util\DateUtil;
use App\Models\Base;
use App\Commands\Command;

/**
 * 拠点を削除コマンド
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
        $baseMObj = Base::findOrFail( $this->id );
        
        // ソフトデリート
        $baseMObj->delete();
    }
    
}
