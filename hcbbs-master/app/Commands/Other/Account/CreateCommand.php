<?php

namespace App\Commands\Other\Account;

use App\Lib\Util\DateUtil;
use App\Models\UserAccount;
use App\Commands\Command;
use App\Http\Requests\UserAccountRequest;

/**
 * 担当者を新規作成するコマンド
 *
 * @author yhatsutori
 */
class CreateCommand extends Command{
    
    /**
     * コンストラクタ
     * @param UserAccountRequest $requestObj [description]
     */
    public function __construct( UserAccountRequest $requestObj ){
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
        $userMObj = UserAccount::create( $setValues );
        
        return $userMObj;
    }

}
