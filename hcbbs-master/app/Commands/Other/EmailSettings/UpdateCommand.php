<?php

namespace App\Commands\Other\EmailSettings;

use App\Lib\Util\DateUtil;
use App\Models\EmailSettings;
use App\Commands\Command;

/**
 * 投稿アドレスを更新するコマンド
 *
 * @author yhatsutori
 */
class UpdateCommand extends Command{

    /**
     * コンストラクタ
     * @param [type]      $id         [description]
     * @param EmailSettingsRequest $requestObj [description]
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
        $baseMObj = EmailSettings::findOrFail( $this->id );
        
        // 更新する値の配列を取得
        $setValues = $this->requestObj->all();
        
        // データの更新
        $baseMObj->update( $setValues );
                
        return $baseMObj;
    }
    
}
