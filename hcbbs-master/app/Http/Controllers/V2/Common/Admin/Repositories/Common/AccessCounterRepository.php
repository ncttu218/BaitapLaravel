<?php

namespace App\Http\Controllers\V2\Common\Admin\Repositories\Common;

use App\Original\Util\SessionUtil;
use App\Original\Util\RankingUtil;
use App\Http\Controllers\tInitSearch;
use Request;

/**
 * 各店情報掲示板 店舗別集計ツールコントローラー
 *
 *
 */
trait AccessCounterRepository {

    use tInitSearch;
    
    /**
     * 表示のデータ
     * 
     * @var object
     */
    private $displayObj;
    
    /**
     * ログイン情報
     * 
     * @var object
     */
    private $loginAccountObj;
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        // 表示部分で使うオブジェクトを作成
        $this->initDisplayObj();

        // 引き継ぎの検索項目は消去
        // SessionUtil::removeSearch();
    }

    #######################
    ## initalize
    #######################

    /**
     * 表示部分で使うオブジェクトを作成
     * @return [type] [description]
     */
    private function initDisplayObj() {
        // 表示部分で使うオブジェクトを作成
        $this->displayObj = app('stdClass');
        // カテゴリー名
        $this->displayObj->category = "bbs_count";
        // 画面名
        $this->displayObj->page = "base";
        // 基本のテンプレート
        $this->displayObj->tpl = $this->displayObj->category . "." . $this->displayObj->page;
        // コントローラー名
        $this->displayObj->ctl = "BbsCount\BaseController";
    }

    #######################
    ## 検索・並び替え
    #######################

    /**
     * 画面固有の初期条件設定
     *
     * @return array
     */
    private function extendSearchParams(){
        $search = [];

        return $search;
    }
    
    /**
     * 拠点別アクセス数集計表の表示
     * @return array
     */
    public function getCount() {
        $request = Request::all();
        // ユーザ情報
        $this->loginAccountObj = SessionUtil::getUser();
        // 販社コード
        if (isset( $request['hansha_code'] ) && !empty( $request['hansha_code'] )) {
            $hanshaCode = $request['hansha_code'];
        } else {
            $hanshaCode = $this->loginAccountObj->getHanshaCode();
        }
        // 販社名
        $hanshaName = config('original.hansha_code')[$hanshaCode] ?? '（無名）';
        
        // 拠点ランキングデータ
        $data = RankingUtil::rankByBase($hanshaCode, $request);
        
        return view(
            $this->displayObj->tpl . '.count',
            compact(
                'hanshaCode'
            )
        )
        ->with( 'title', $hanshaName )
        ->with( 'baseList', $data['baseList'] ) // 拠点リスト
        ->with( 'year', $data['year'] ) // 年
        ->with( 'month', $data['month'] ) // 月
        ->with( 'lastDay', $data['lastDay'] ) // 終了日
        ->with( 'counterData', $data['counterData'] ) // 集計データ
        ->with( 'displayObj', $this->displayObj );
    }
}
