<?php

namespace App\Commands\Other\EmailSettings;

use App\Lib\Util\DateUtil;
use App\Models\EmailSettings;
use App\Commands\Command;

/**
 * 投稿アドレスを新規作成するコマンド
 *
 * @author yhatsutori
 */
class CreateCommand extends Command{
    
    /**
     * コンストラクタ
     * @param EmailSettingsRequest $requestObj [description]
     */
    public function __construct( $requestObj ){
        $this->requestObj = $requestObj;
    }

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle(){
        // 追加する値の配列を取得
        $setValues = $this->requestObj->all();
        
        // 登録されたデータを持つモデルオブジェクトを取得
        $baseMObj = EmailSettings::create( $setValues );
        
        return $baseMObj;
    }

}
