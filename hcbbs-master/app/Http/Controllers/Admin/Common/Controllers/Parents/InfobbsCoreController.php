<?php

namespace App\Http\Controllers\Admin\Common\Controllers\Parents;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use App\Original\Util\SessionUtil;
use Request;

/**
 * Description of InfobbsCoreController
 *
 * @author ahmad
 */
class InfobbsCoreController extends Controller {
    
    /**
     * 販社コード
     * 
     * @var string
     */
    protected $hanshaCode;
    
    /**
     * ユーザ情報
     * 
     * @var object
     */
    protected $loginAccountObj;
    
    /**
     * テーブル番号
     * 
     * @var int
     */
    protected $tableNo;
    
    /**
     * 6件の画像アップロードかのフラグ
     * 
     * @var bool
     */
    protected $use6FileInput = false;
    
    /**
     * テンプレートNo
     * 
     * @var string 
     */
    protected $templateNo;
    
    /**
     * 公開モード
     * 
     * @var int
     */
    protected $published_mode;
    
    /**
     * コメントを使うフラグ
     * 
     * @var string
     */
    protected $comment;
    
    /**
     * カテゴリーを使うフラグ
     * 
     * @var string
     */
    protected $category;
    
    /**
     * テーブルのタイプ
     * 
     * @var string
     */
    protected $tableType;
    
    /**
     * テンプレートのフォルダー
     * 
     * @var string
     */
    protected $templateDir;
    
    /**
     * 投稿した時の通知
     */
    const NOTIFICATION_POST_REGISTERED = 0;

    /**
     * 公開申請が変わる時の通知
     */
    const NOTIFICATION_POST_EDIT_FLAG_CHANGED = 1;

    /**
     * 掲載処理OKの時の通知
     */
    const NOTIFICATION_POST_HONSHA_CONFIRMED = 2;

    /**
     * 本社担当承認
     */
    const NOTIFICATION_POST_HONSHA_TANTOO_CONFIRMED = 5;
    
    /**
     * 通知の種類
     * 
     * @var array
     */
    protected $notificationTypes = [
        self::NOTIFICATION_POST_REGISTERED,
    ];
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        // 販社コード
        $this->hanshaCode = Request::segment(3);
        
        $this->controller = "Admin\Common\Controllers\InfobbsController";
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        // テーブル名をセッションに保存(販社コードがテーブル名)
        SessionUtil::putTableName('tb_' . $this->loginAccountObj->getHanshaCode() . '_infobbs');
        // テンプレートNo
        $this->templateNo = '1351100';
        // 掲載モード
        $para = Config('original.para')[$this->loginAccountObj->getHanshaCode()] ?? [];
        $this->published_mode = $para['published_mode'] ?? 0;
        $this->comment = $para['comment'] ?? 0;
        
        // カテゴリー
        $categories = [];
        if(isset($para['category']) && $para['category']){
            foreach (explode(',', $para['category']) as $category) {
                $categories[] = trim($category);
            }
        }
        $this->category = $categories;

        // テーブル番号
        $this->tableNo = $this->loginAccountObj->gethanshaCode();

        // テーブルのタイプ
        $this->tableType = 'infobbs';

        // 設定ファイルからメール通知の種類を読み込む
        $customTypes = config("{$this->hanshaCode}.general.notification.infobbs.custom_types");
        if ($customTypes !== null && is_array($customTypes)) {
            $this->notificationTypes =$customTypes;
        }
    }
    
}
