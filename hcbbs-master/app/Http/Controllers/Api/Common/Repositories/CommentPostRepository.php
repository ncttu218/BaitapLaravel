<?php

namespace App\Http\Controllers\Api\Common\Repositories;

use App\Lib\Util\DateUtil;
use App\Models\InfobbsComment;
use App\Http\Requests\SearchRequest;
use App\Http\Controllers\Controller;
use Request;
use View;
use App\Original\Codes\CommentEmoticonCodes;


/**
 * 本社用管理画面コントローラー
 *
 * @author ahmad
 *
 */
trait CommentPostRepository
{
    /**
     *　販社コード
     * 
     * @var string
     */
    protected $hanshaCode;
    
    /**
     * コンストラクター
     */
    public function __construct() {
        // 販社コード
        if (isset($_GET['hansha_code'])) {
            $this->hanshaCode = $_GET['hansha_code'];
        } else {
            $this->hanshaCode = Request::segment(3);
        }
        // コントローラー名
        $this->controller = 'Api\Common\Controllers\CommentPostController';
    }
    
    /**
     * コメント投稿画面を開く
     */
    public function getIndex()
    {
        // リクエスト
        $request = Request::all();
        
        // 販社コード or 記事のID が存在しないとき エラー
        if( empty( $this->hanshaCode ) == True || empty( $request['blog_data_id'] ) == True ){
            return "<p>表示エラー</p>";
        }
        
        // スタイル
        $styleTag = 'default';
        $inputStyle = CommentEmoticonCodes::COMMENT_EMOTICON_DEFAULT;
        if (isset($request['style'])) {
            switch ($request['style']) {
                case 'style0':
                    $styleTag = 'style1';
                    $inputStyle = CommentEmoticonCodes::COMMENT_EMOTICON_NONE;
                    break;
                case 'style1':
                    $styleTag = 'style1';
                    $inputStyle = CommentEmoticonCodes::COMMENT_EMOTICON_STYLE1;
                    break;
                case 'style2':
                    $styleTag = 'style1';
                    $inputStyle = CommentEmoticonCodes::COMMENT_EMOTICON_STYLE2;
                    break;
                case 'style3':
                    $styleTag = 'style1';
                    $inputStyle = CommentEmoticonCodes::COMMENT_EMOTICON_STYLE3;
                    break;
                case 'default':
                default:
                    break;
            }
        }
        // 絵文字のリスト
        $emoticons = (new CommentEmoticonCodes($inputStyle))
                ->getOptions();

        // 販社ごとのコメントフォーム テンプレートが存在するとき
        if( View::exists( 'api.' . $this->hanshaCode . '.api.comment_post.input' ) ){
            $viewObj = view( 'api.' . $this->hanshaCode . '.api.comment_post.input' );
        }else{
            $viewObj = view( 'api.common.api.comment_post.input' );
        }
        
        // パラメーター
        $paramStr = '';
        if (isset($_GET['hansha_code'])) {
            $paramStr = "?hansha_code={$this->hanshaCode}";
        }
        $urlAction = action_auto( $this->controller . '@postCreate' ) . $paramStr;

        return $viewObj->with( 'hansha_code', $this->hanshaCode )
                    ->with( 'blog_data_id', $request['blog_data_id'] )
                    ->with( 'emoticons', $emoticons )
                    ->with( 'urlAction', $urlAction )
                    ->with( 'styleTag', $styleTag );
        
    }

    /**
     * コメント投稿処理
     */
    public function postCreate( SearchRequest $request ){

        // 販社コード or 記事のID が存在しないとき エラー
        if( empty( $this->hanshaCode ) == True || empty( $request->blog_data_id ) == True ){
            return "<p>表示エラー</p>";
        }

        // 指定したIDのモデルオブジェクトを取得
        $infobbsCommentMObj = InfobbsComment::createNewInstance( $this->hanshaCode );
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
            // パラメーター
            $paramStr = '';
            if (isset($_GET['hansha_code'])) {
                $paramStr = "?hansha_code={$this->hanshaCode}";
            }
            $urlAction = action_auto( $this->controller . '@getThanks' ) . $paramStr;
            return redirect( $urlAction );
        } else {
            return abort(500);
        }
    }

    /**
     * 投稿完了画面を開く
     */
    public function getThanks()
    {
        return view( 'api.common.api.comment_post.thanks' );
    }
    
}