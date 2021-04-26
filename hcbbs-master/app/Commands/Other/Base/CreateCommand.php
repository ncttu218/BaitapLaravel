<?php

namespace App\Commands\Other\Base;

use App\Lib\Util\DateUtil;
use App\Models\Base;
use App\Commands\Command;

/**
 * 拠点を新規作成するコマンド
 *
 * @author yhatsutori
 */
class CreateCommand extends Command{
    
    /**
     * コンストラクタ
     * @param BaseRequest $requestObj [description]
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
        $baseMObj = Base::create( $setValues );
        
        return $baseMObj;
    }

}
