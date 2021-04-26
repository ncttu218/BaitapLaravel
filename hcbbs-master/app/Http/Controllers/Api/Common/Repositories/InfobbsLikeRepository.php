<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use App\Models\InfobbsComment;
use App\Http\Requests\SearchRequest;

/**
 * 公開画面でのコントローラー
 *
 * @author ahmad
 *
 */
trait InfobbsLikeRepository
{
    /**
     * Good Jobを送信する関数
     */
    public function getSubmitGoodJob(SearchRequest $request) {
        if (!isset($request->num) || empty($request->num)) {
            return 'エラー';
        }

        // 掲載番号
        $postNumber = $request->num;
        
        // チェック
        session_start();
        $sessionId = session_id() . '_' . $this->deviceType;
        $checkObj = InfobbsComment::createNewInstance( $this->hanshaCode );
        $date = date('Y-m-d');
        $isExists = $checkObj->whereRaw("num = '{$postNumber}' AND "
            . "date(created_at) = '{$date}' AND "
            . "ip LIKE '%- [{$sessionId}]%'")
            ->count() > 0;
        if ($isExists) {
            // データを登録されたイベント
            if (method_exists($this, 'onLikeAddFailed')) {
                // イベントを発火する
                $returnValue = $this->onLikeAddFailed($postNumber);
                // 関数のリターンがあれば、返す
                if ($returnValue !== null) {
                    // 返す値
                    return $returnValue;
                }
            }
            return;
        }
        
        // 指定したIDのモデルオブジェクトを取得
        $infobbsCommentMObj = InfobbsComment::createNewInstance( $this->hanshaCode );
        // フォームリクエストを取得
        $setValue = [];
        // ブログのIDを格納
        $setValue['num'] = $postNumber;
        // アクセス元のIPアドレスを登録
        $setValue['ip'] = $_SERVER['SERVER_ADDR'] . ' - [' . $sessionId . ']';
        // アクセス元のユーザーエージェントを登録
        $setValue['browser'] = $_SERVER['HTTP_USER_AGENT'];
        $setValue['mark'] = 'GJ';

        // 完了画面にリダイレクト
        if ($infobbsCommentMObj->create( $setValue )) {
            // データを登録されたイベント
            if (method_exists($this, 'onLikeAdded')) {
                // イベントを発火する
                $returnValue = $this->onLikeAdded($postNumber);
                // 関数のリターンがあれば、返す
                if ($returnValue !== null) {
                    // 返す値
                    return $returnValue;
                }
            }

            // 戻る
            return redirect()->back();
        }
    }
    
    /**
     * Good Jobをカウントする関数
     * 
     * @param string $number 記事番号
     * @return int
     */
    public function getGoodJobCountValue($number) {
        $count = 0;
        if (isset($number) && !empty($number)) {
            // チェック
            $count = InfobbsComment::createNewInstance( $this->hanshaCode )
                    ->where('num', $number)
                    ->count();
        }
        return $count;
    }
    
    /**
     * Good Jobをカウントする関数
     */
    public function getGoodJobCount(SearchRequest $request) {
        return response()->json([
            'count' => $this->getGoodJobCountValue($request->num),
        ]);
    }
}