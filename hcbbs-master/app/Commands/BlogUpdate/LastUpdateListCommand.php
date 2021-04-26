<?php

namespace App\Commands\BlogUpdate;

use App\Commands\Command;
use App\Models\Infobbs;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LastUpdateListCommand
 *
 * @author ahmad
 */
class LastUpdateListCommand extends Command {
    
    /**
     * 販社コード
     * 
     * @var string
     */
    private $hanshaCode;

    /**
     * コンストラクタ
     * @param array $sort 並び順
     * @param $requestObj 検索条件
     */
    public function __construct( $hanshaCode ) {
        // 販社コード
        $this->hanshaCode = $hanshaCode;
    }

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle() {
        // 更新ログ収集
        $infoBbsInstance = Infobbs::createNewInstance( $this->hanshaCode );
        $logData = $infoBbsInstance->selectRaw('shop, max(date(updated_at)) as updated_at')
                ->where('published', 'ON')
                ->whereRaw('updated_at <= now()')
                // 公開期間内のとき
                ->whereRaw( ' ( ( from_date <= now() AND to_date >= now()) OR '
                    . ' ( from_date <= now() AND to_date IS NULL) OR '
                    . ' ( from_date IS NULL AND to_date >= now()) OR '
                    . ' ( from_date IS NULL AND to_date IS NULL))' )
                ->groupBy('shop')
                ->orderBy('shop')
                ->orderBy('updated_at', 'desc')
                ->get();
        return $logData;
    }
    
}
