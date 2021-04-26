<?php

namespace App\Commands\Other\EmailSettings;

use App\Models\EmailSettings;
use App\Commands\Command;

/**
 * 取り込みデータの実績一覧を取得するコマンド
 *
 * @author yhatsutori
 */
class ListCommand extends Command{

    /**
     * コンストラクタ
     * @param array $sort 並び順
     * @param $requestObj 検索条件
     */
    public function __construct( $sort, $mailPostType, $requestObj ){
        $this->sort = $sort;
        $this->requestObj = $requestObj;
        $this->mailPostType = $mailPostType;

        // カラムとヘッダーの値を取得
        $csvParams = $this->getCsvParams();
        // カラムを取得
        $this->columns = array_keys( $csvParams );
        // ヘッダーを取得
        $this->headers = array_values( $csvParams );
    }

    /**
     * カラムとヘッダーの値を取得
     * @return array
     */
    private function getCsvParams(){
        return [
            'id' => '',
            'email' => '', // メールアドレス
            'forward_email' => '', // 転送メール
            'staff_code' => '', // スタッフコード
            'shop_code' => '', // 拠点コード
            'hansha_code' => '', // 販社コード
            'system_name' => '', // システム名
        ];
    }

    /**
     * メインの処理
     * @return [type] [description]
     */
    public function handle(){
        // 表示も問題で一度変数に格納
        $requestObj = $this->requestObj;

        // 検索条件を指定
        $builderObj = EmailSettings::whereRequest( $this->requestObj );

        // 並び替えの処理
        $builderObj = $builderObj->orderBys( $this->sort['sort'] );
        
        // システム名
        $builderObj = $builderObj->where('system_name', $this->mailPostType);

        // ペジネートの処理
        $data = $builderObj
            ->paginate( $this->requestObj->row_num, $this->columns )
            // 表示URLをpagerに指定
            ->setPath('pager');
 
        return $data;
    }

}
