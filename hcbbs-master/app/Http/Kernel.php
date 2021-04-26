<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,

        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,

        \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\TrimStrings::class,
        \App\Http\Middleware\TrustProxies::class,

        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\Cors::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // \Illuminate\Session\Middleware\StartSession::class, <-- フォーム検証エラーメッセージが共有出来なくなった原因
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth.basic' =>     \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => 	\Illuminate\Routing\Middleware\SubstituteBindings::class,

        'auth' =>           \App\Http\Middleware\Authenticate::class,
        'guest' =>          \App\Http\Middleware\RedirectIfAuthenticated::class,
        'viewFinder' =>     \App\Http\Middleware\ViewFinder::class,
        'can' => 		\Illuminate\Auth\Middleware\Authorize::class,
        'throttle' => 	\Illuminate\Routing\Middleware\ThrottleRequests::class,

        'RoleAdmin' =>      \App\Http\Middleware\Role\RoleAdmin::class,
        'RoleManager' =>    \App\Http\Middleware\Role\RoleManager::class,
        'RoleHonsya' =>     \App\Http\Middleware\Role\RoleHonsya::class,
        'RoleTentyou' =>    \App\Http\Middleware\Role\RoleTentyou::class,
        'cors'        =>  \App\Http\Middleware\Cors::class,

    ];

}
