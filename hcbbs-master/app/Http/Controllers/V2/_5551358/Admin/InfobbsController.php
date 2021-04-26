<?php

namespace App\Http\Controllers\V2\_5551358\Admin;

use App\Http\Controllers\V2\Common\Admin\Interfaces\IInfobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Repositories\Common\InfobbsRepository;
use App\Http\Controllers\V2\Common\Admin\Controllers\InfobbsCoreController;

use Request;
use App\Original\Util\SessionUtil;
use App\Original\Util\ImageUtil;
use DB;

/**
 * 拠点用管理画面コントローラー
 *
 * @author ahmad
 *
 */
class InfobbsController extends InfobbsCoreController implements IInfobbsRepository
{
    use InfobbsRepository;
    
    /**
     * ブログ登録
     * @return string
     */
    public function postConfirm(){
        $req = Request::all();
        $data = SessionUtil::getData();

        if(isset($req['modulate'])){
            // 変種画面へ戻る
            return redirect(action_auto($this->controller . '@getUpload'));
        }
        
        // 初期値
        $number = '';
        $column = [];
        
        // 確認画面から 登録するボタンが押されたとき
        if(isset($req['register'])){
            $dateTime = date("Y-m-d H:i:s");
            $column = $this->makeColumn();

            // 本文内にある絵文字のSJIS対応
            //if( isset( $column['comment'] ) ){
            //    // 絵文字の変換
            //    $column['comment'] = $this->convertEmojiToHtmlEntity( $column['comment'] );
            //}
            
            // 開始時間
            if (isset($column['from_date']) && !empty($column['from_date'])) {
                $column['from_date'] .= ' 00:00:00';
            }
            // 終了時間
            if (isset($column['to_date']) && !empty($column['to_date'])) {
                $column['to_date'] .= ' 23:59:59';
            }

            // 記事の編集の時
            if(SessionUtil::getMode() == 'mod'){
                $column = $this->setColumn('updated_at',$dateTime,$column);
                
                $number = $data['number'];
                // テーブル更新 
                DB::table(SessionUtil::getTableName())->where('number', $number)
                    ->update($column);
            }else{ // 記事の新規登録の時
                // 新規テーブル
                $row = DB::table(SessionUtil::getTableName())
                    ->orderBy('regist', 'DESC')
                    ->take(1)
                    ->get();
                // 最大番号計算
                if( count($row) == 0 ){
                    $num = 0;
                }else{
                    $num = intval($row['0']->regist);
                }
                $num++;
                $number = "data" . substr("00000" . strval($num),-6);

                $column = $this->setColumn('regist',$num,$column);
                $column = $this->setColumn('number',$number,$column);
                $column = $this->setColumn('created_at',$dateTime,$column);
                $column = $this->setColumn('updated_at',$dateTime,$column);
                $column = $this->setColumn('add',$_SERVER['SERVER_NAME'] . '(' . $_SERVER['SERVER_ADDR'] . ')',$column);
                $column = $this->setColumn('agent',$_SERVER['HTTP_USER_AGENT'],$column);
                $column = $this->setColumn('published','OFF',$column);
 
                // 新規テーブル作成
                DB::table(SessionUtil::getTableName())->insert($column);
                
                // メール送信
                $this->sendUploadMail();
            }
            
            // 記事の内容が空でないとき
            if ( !empty( $column['comment'] ) == true ){
                // 販社コード
                $hanshaCode = $this->loginAccountObj->gethanshaCode();
                // 画像の保存先のパス
                $dir = realpath( 'data/image');
                $dir = $dir . DIRECTORY_SEPARATOR . $hanshaCode;
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                // $replacedContentは記事の内容の変換される結果
                $replacementContent = ImageUtil::base64ToImageFromString( $column['comment'], $dir, $hanshaCode, 'infobbs', false );
                // テーブル更新 
                DB::table(SessionUtil::getTableName())->where('number', $number)
                    ->update(['comment' => $replacementContent]);
            }
            
            // セッションを削除
            SessionUtil::removeData();
            
            $urlAction = action_auto($this->controller . '@getIndex') . '?shop=' . $data['shop'];

            return view('api.common.admin.infobbs.complete', $data)->with('msg','データを登録しました。')
                ->with('urlAction', $urlAction);
        }
    }
}