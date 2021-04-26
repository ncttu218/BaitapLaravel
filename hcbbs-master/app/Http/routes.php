<?php

// 販社コード
$hanshaCode = $_GET['hansha_code'] ?? '';

/**
 * ルートを登録する
 *
 * @param string $route ルート
 * @param string $controllerOriginName コントローラー名
 */
$registerApiRouteAdv = function ($route, $controllerOriginName) use ($hanshaCode) {
    // 個人的なコントローラー
    $controllerName = "Api/_{$hanshaCode}/{$controllerOriginName}";
    $path = "Http/Controllers/{$controllerName}.php";
    $path = app_path($path);

    if (!file_exists($path)) {
        // 共通コントローラー
        $controllerName = "Api/Common/Controllers/{$controllerOriginName}";
        $path = "Http/Controllers/{$controllerName}.php";
        $path = app_path($path);
        if (!file_exists($path)) {
            return;
        }
    } else {
        $controllerCommonName = "Api/Common/Controllers/{$controllerOriginName}";
        $controllerCommonName = str_replace('/', "\\", $controllerCommonName);
        Route::controller($route . '-common', $controllerCommonName);
    }
    $controllerName = str_replace('/', "\\", $controllerName);
    Route::controller($route, $controllerName);
};

// パーマリンクのコントローラー
Route::controller('plbbs', 'Infobbs\PlinkbbsController');

// login画面に画面遷移
Route::get('/', function () {
    return redirect('auth/login');
});

// login画面に画面遷移
Route::get('/demo', function () {
    return redirect('auth/login');
});

// login画面に画面遷移
Route::get('/auth', function () {
    return redirect('auth/login');
});

Route::get('/auth/testLogin', 'Auth\AuthController@testLogin');

// 認証階層
Route::controller('auth', 'Auth\AuthController',
    [
        'postLogin' => 'post.login',
        'getLogin' => 'get.login',
        'getRegister' => 'get.register', // 使ってない・・・
        'postRegister' => 'post.register', // 使ってない・・・
        'getLogout' => 'logout'
    ]);

// パーマリンクのコントローラー
Route::controller('/preview', 'Site\SiteController');

// API部分のコントローラー
Route::group(['prefix' => 'api'], function () use ($hanshaCode, $registerApiRouteAdv) {
    if (!isset(config('original.v2_adv_para')[$hanshaCode])) {
        // コメント投稿フォーム
        Route::controller('/comment-post', 'Api\CommentPostController');
        Route::controller('/comment_post', 'Api\CommentPostController');
        // 拠点ブログAPIのコントローラー
        Route::controller('/infobbs', 'Api\InfobbsController');
        // スタッフブログAPIのコントローラー
        Route::controller('/staffbbs', 'Api\StaffbbsController');
        // 一行メッセージAPIのコントローラー
        Route::controller('/message', 'Api\MessageController');
        // ショールームAPIのコントローラー
        //Route::controller( '/showroom', 'Api\ShowroomController' );
    } else {
        // コメント投稿フォーム
        $registerApiRouteAdv('/comment-post', 'CommentPostController');
        $registerApiRouteAdv('/comment_post', 'CommentPostController');
        // スタッフ日記のコメント投稿フォーム
        $registerApiRouteAdv('/staff-comment-post', 'StaffCommentPostController');
        // 拠点ブログAPIのコントローラー
        $registerApiRouteAdv('/infobbs', 'InfobbsController');
        // スタッフブログAPIのコントローラー
        $registerApiRouteAdv('/staffbbs', 'StaffbbsController');
        // ショールーム情報APIのコントローラー
        $registerApiRouteAdv('/srinfo', 'SrInfoController');
        // 一行メッセージAPIのコントローラー
        $registerApiRouteAdv('/message', 'MessageController');
        // 緊急掲示板のコントローラー
        $registerApiRouteAdv('/emergency-bulletin', 'EmergencyBulletinController');
    }
});

// アクセス集計部分のコントローラー
Route::group(['prefix' => 'bbs_count'], function () {
    // 拠点ブログの集計
    Route::controller('base', 'BbsCount\BaseController');
    // スタッフブログの集計
    //Route::controller( 'staff', 'BbsCount\StaffController' );
});


// TODO: 適当なコメントを入れること
// ○○階層
Route::group(['middleware' => ['auth']], function () {

    // 管理画面のコントローラー
    Route::group(['prefix' => 'top'], function () {
        Route::controller('/', 'Admin\AdminController');
    });

    // 管理画面のコントローラー
    Route::group(['prefix' => 'admin'], function () {
        Route::controller('admin', 'Admin\AdminController');
    });

    // 各店情報掲示板のコントローラー
    Route::group(['prefix' => 'baselist'], function () {
        Route::controller('baselist', 'Admin\BaselistController');
    });

    // 共通アップロードのコントローラー
    Route::group(['prefix' => 'common'], function () {
        Route::controller('upload/{table_type}', 'Infobbs\CommonUploadController');
    });

    // 拠点用管理画面のコントローラー
    Route::group(['prefix' => 'infobbs'], function () {
        Route::controller('infobbs', 'Infobbs\InfobbsController');
    });

    // 各店情報掲示板のコントローラー
    Route::group(['prefix' => 'stafflist'], function () {
        Route::controller('stafflist', 'Admin\StafflistController');
    });

    // 拠点用管理画面のコントローラー
    Route::group(['prefix' => 'staffbbs'], function () {
        Route::controller('staffbbs', 'Infobbs\StaffbbsController');
    });

    // 公開画面のコントローラー
    Route::group(['prefix' => 'viewbbs'], function () {
        Route::controller('viewbbs', 'Infobbs\ViewbbsController');
    });

    // 本社用管理画面のコントローラー
    Route::group(['prefix' => 'hobbs'], function () {
        Route::controller('hobbs', 'Infobbs\HobbsController');
    });

    // 画像アップロードのコントローラー
    Route::group(['prefix' => 'image_tmp'], function () {
        Route::controller('image_tmp', 'Infobbs\ImageTmpController');
    });

    // スタッフ紹介 画面のコントローラー
    Route::controller('staffinfo', 'StaffInfo\StaffInfoController');

    // ショールーム写真・コメント入力 画面のコントローラー
    Route::controller('srinfo', 'SrInfo\SrInfoController');

    // お知らせ（1行メッセージ）画面のコントローラー
    Route::controller('message', 'Message\MessageController');

    // その他画面のコントローラー
    Route::group(['prefix' => 'other'], function () {
        Route::controller('account', 'Other\AccountController'); // アカウント
        Route::controller('base', 'Other\BaseController'); // 拠点
        Route::controller('blog_edit', 'Other\BlogEditController'); // 記事一括編集（base64取り除き
        Route::controller('email_settings', 'Other\EmailSettingsController'); // 投稿アドレス（メール投稿用）
        Route::controller('mail_register', 'Other\MailRegisterController'); // メールアドレス登録
    });
});

/**
 * Create Like API
 */
Route::get('/api/like', 'LikeController@getCount')->name('get.like');
Route::post('/api/like','LikeController@addLike')->name('add.like');