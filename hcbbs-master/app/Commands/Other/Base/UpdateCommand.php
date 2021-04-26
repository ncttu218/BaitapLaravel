<?php

namespace App\Commands\Other\Base;

use App\Lib\Util\DateUtil;
use App\Models\Base;
use App\Commands\Command;

/**
 * 担当者を更新するコマンド
 *
 * @author yhatsutori
 */
class UpdateCommand extends Command{

    /**
     * コンストラクタ
     * @param [type]      $id         [description]
     * @param BaseRequest $requestObj [description]
     * @param [type]      $file_name  [description]
     */
    public function __construct( $id, $requestObj ){
        $this->id = $id;
        $this->requestObj = $requestObj;
    }

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle(){
        // 指定したIDのモデルオブジェクトを取得
        $baseMObj = Base::findOrFail( $this->id );
        
        // 更新する値の配列を取得
        $setValues = $this->requestObj->all();
        
        // データの更新
        $baseMObj->update( $setValues );
                
        return $baseMObj;
    }
    
}
