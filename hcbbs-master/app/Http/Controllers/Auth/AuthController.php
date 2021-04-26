<?php

namespace App\Http\Controllers\Auth;

use App\Original\Util\SessionUtil;
use App\Events\LoginedEvent;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Account\Account;
use Auth;
use Log;
use DB;
use Event;
use Hash;
use Session;

class AuthController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

        $this->middleware('guest', ['except' => ['getLogout', 'testLogin']]);
    }

    public function testLogin( SearchRequest $request)
    {
        // ユーザー情報を削除(セッション)
        SessionUtil::removeUser();
        $this->auth->logout();
        
        if (!Auth::attempt(['user_login_id' => $request->id, 'password' => $request->password])) {
            return redirect('auth/login')->with('error', 'IDまたはパスワードが間違っています');
        }
        
        Event::fire( new LoginedEvent( Auth::user() ) );
        $user = Auth::user();

        // ユーザー情報を登録(セッション)
        SessionUtil::putUser( new Account( $user ) );

        // v2があるか
        if (\App\Original\Util\CodeUtil::isV2($user->hansha_code)) {
            // v2のURLに移動
            return redirect()->intended('v2/admin/' . $user->hansha_code . '/top');
        } else {
            // 古い版のURLに移動
            return redirect()->intended('top');
        }
    }

    /**
     * ログイン画面
     */
    public function getLogin()
    {
        return view('auth/login');
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['user_login_id' => $request->id, 'password' => $request->password])) {
            Event::fire( new LoginedEvent( Auth::user() ) );
            $user = Auth::user();

            // ユーザー情報を登録(セッション)
            SessionUtil::putUser( new Account( $user ) );
            
            // v2があるか
            if (\App\Original\Util\CodeUtil::isV2($user->hansha_code)) {
                // v2のURLに移動
                return redirect()->intended('v2/admin/' . $user->hansha_code . '/top');
            } else {
                // 古い版のURLに移動
                return redirect()->intended('top');
            }
        }
        return redirect('auth/login')->with('error', 'IDまたはパスワードが間違っています');
    }

    

    public function getLogout() {
        // ユーザー情報を削除(セッション)
        SessionUtil::removeUser();

        if( session('csrf_error' ) ) {
            session('error', 'セッションが切れました。<br />セキュリティのためログアウトしました。');
        }

        $this->auth->logout();

        return redirect(
                    property_exists( $this, 'redirectAfterLogout' ) ? $this->redirectAfterLogout : '/'
                );

        //$this->getLogout();
    }
}
