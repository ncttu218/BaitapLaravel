<?php

namespace App\Http\Controllers\Infobbs;

use App\Original\Util\SessionUtil;
use App\Http\Controllers\Controller;
use Request;
use App\Original\Util\ImageUtil;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class CommonUploadController extends Controller
{
    /**
     * テーブル番号
     * 
     * @var int
     */
    private $tableNo;
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        // リクエスト
        $req = Request::all();
        
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();

        // テーブル番号
        $this->tableNo = $this->loginAccountObj->gethanshaCode();
    }
    
    /**
     * マルチ画像アップロード
     * 
     * @param string $tableType テーブルのタイプ
     * @return string
     */
    public function postIndex( $tableType )
    {
        return asset_auto('') . ImageUtil::makeImage('file', 0, $this->tableNo, $tableType );
    }
}