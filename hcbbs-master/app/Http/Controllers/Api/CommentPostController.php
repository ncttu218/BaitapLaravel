<?php

namespace App\Http\Controllers\Api;

use App\Lib\Util\DateUtil;
use App\Models\InfobbsComment;
use App\Http\Requests\SearchRequest;
use App\Http\Controllers\Controller;
use Request;
use View;


/**
 * 本社用管理画面コントローラー
 *
 * @author 江澤
 *
 */
class CommentPostController extends Controller
{
    
    /**
     * コメント投稿画面を開く
     */
    public function getIndex()
    {
        $request = Request::all();
        // 販社コード or 記事のID が存在しないとき エラー
        if( empty( $request['hansha_code'] ) == True || empty( $request['blog_data_id'] ) == True ){
            return "<p>表示エラー</p>";
        }

        // 販社ごとのコメントフォーム テンプレートが存在するとき
        if( View::exists( 'api.' . $request['hansha_code'] . '.comment_post' ) ){
            $viewObj = view( 'api.' . $request['hansha_code'] . '.comment_post' );
        }else{
            $viewObj = view( 'api.common.comment_post' );
        }

        return $viewObj->with( 'hansha_code', $request['hansha_code'] )
                    ->with( 'blog_data_id', $request['blog_data_id'] );
        
    }

    /**
     * コメント投稿処理
     */
    public function postCreate( SearchRequest $request ){

        // 販社コード or 記事のID が存在しないとき エラー
        if( empty( $request->hansha_code ) == True || empty( $request->blog_data_id ) == True ){
            return "<p>表示エラー</p>";
        }

        // 指定したIDのモデルオブジェクトを取得
        $infobbsCommentMObj = InfobbsComment::createNewInstance( $request->hansha_code );
        // フォームリクエストを取得
        $setValue = $request->all();
        // ブログのIDを格納
        $setValue['num'] = $request->blog_data_id;
        // アクセス元のIPアドレスを登録
        $setValue['ip'] = $_SERVER['SERVER_ADDR'];
        // アクセス元のユーザーエージェントを登録
        $setValue['browser'] = $_SERVER['HTTP_USER_AGENT'];

        // 完了画面にリダイレクト
        if ($infobbsCommentMObj->create( $setValue )) {
            return redirect( action_auto( 'Api\CommentPostController@getThanks' ) );
        } else {
            return abort(500);
        }
    }

    /**
     * 投稿完了画面を開く
     */
    public function getThanks()
    {
        return view( 'api.common.comment_thanks' );
        
    }
    
}