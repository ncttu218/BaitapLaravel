<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Original\Util\SessionUtil;
use Request;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];
    
    /**
     * エラーが無効できるホスト一覧
     * 
     * @var array
     */
    private $allowedHostsForErrorIgnoring = [
        '10.0.20.24', // 検証
        '10.0.20.10', // 本番
        '10.0.20.11', // 本番
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     * ※独自改修有り
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // アクセスするクライアントがエラーが無視できるクライアントの場合、
        // エラーの時、空文字を返す
        if ($this->isAllowedErrorIgnoringClient()) {
            return '';
        }
        
        $isSessionExpired = empty(SessionUtil::getUser());
        
        if ( ($e instanceof TokenMismatchException || $isSessionExpired) &&
                !$this->isApiDebugging() ) {
            return redirect()->route('logout')
                    //->with('csrf_error', 'ページを長時間開いていた為、セッションが切れました。<br />セキュリティのためログアウトしました。');
                    ->with('csrf_error', true);
        }

        if ( $this->isHttpException( $e ) ) {
            //
            $statusCode = $e->getStatusCode();

            switch ( $statusCode ) {
                case '404':
                    //return response()->view('layouts/index', [
                    //'content' => view('errors/404')
                    //]);
                    //return response()->view('auth/login');
                    //return redirect('auth/logout');
            }

            return $this->renderHttpException( $e );
        }

       return parent::render( $request, $e );
    }
    
    /**
     * APIをデバッグするリクエストのフラグ
     * 
     * @return bool
     */
    private function isApiDebugging() {
        return Request::segment(1) === 'api' && isset($_GET['debug']);
    }
    
    /**
     * アクセスするクライアントがエラーが無視できるフラグ
     * 
     * @return bool
     */
    private function isAllowedErrorIgnoringClient() {
        return isset($_SERVER['REMOTE_ADDR']) &&
            in_array($_SERVER['REMOTE_ADDR'], $this->allowedHostsForErrorIgnoring);
    }
    
//    protected function unauthenticated($request, AuthenticationException $exception)
//    {
//        if ($request->expectsJson()) {
//            return response()->json(['error' => 'Unauthenticated.'], 401);
//        }
//        return redirect()->guest(route('logina'));
//    }

}
