<?php

namespace App\Commands\Ranking;

use App\Commands\Command;
use Request;

/**
 * 拠点を新規作成するコマンド
 *
 * @author ahmad
 */
class StaffCountReaderCommand extends Command{
    
    /**
     * コンストラクタ
     * @param BaseRequest $requestObj [description]
     */
    public function __construct( $hanshaCode, $shopCode, $staffCode, $pageInfo ){
        $this->hanshaCode = $hanshaCode;
        $this->shopCode = $shopCode;
        $this->staffCode = $staffCode;
        $this->pageInfo = $pageInfo;
    }

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle()
    {
        // 販社コード・拠点コード・スタッフ番号の空チェック
        if (empty($this->shopCode) || empty($this->hanshaCode) || empty($this->staffCode)) {
            return;
        }
        
        // ページのアクセス
        if ($this->pageInfo['total'] == 0 || $this->pageInfo['currentPage'] < 1
            || $this->pageInfo['currentPage'] > $this->pageInfo['lastPage']) {
            return;
        }
        
        // ログ
        $dir = storage_path('ranking') . '/' . $this->hanshaCode . '/staffbbs';

        // AWSでは動かないので、コメントアウト
        //$dir = realpath($dir);

        if (!file_exists($dir)) {
            mkdir($dir, 0777, True);
        }
        $path = $dir . '/' . date('Ym') . '.log';
        $data = '[' . date('Y-m-d H:i:s') . '|' . $this->shopCode . '|' . $this->staffCode . '] ' . Request::header('user-agent') . "\n";
        
        // 存在
        $isExists = file_exists($path);
        // 書く
        @file_put_contents($path, $data, FILE_APPEND);
        if (!$isExists) {
            // パーミッション変更
            @chmod($path, 0777);
        }
    }

}
