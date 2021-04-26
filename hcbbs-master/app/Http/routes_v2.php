<?php

// 販社コード
$hanshaCode = Request::segment(3);
// V2なのかのフラグ
$version = 'v2';
$isV2 = Request::segment(1) === $version;
// V2ではない場合、スキップ
if (!$isV2) {
    return;
}

/**
 * ルートを登録する
 * 
 * @param string $route ルート
 * @param string $controllerName コントローラー名
 */
$registerAdminRoute = function($route, $controllerName) use($hanshaCode) {
    // 設定ファイル確認
    if (isset(config('original.v2_adv_para')[$hanshaCode])) {
        return;
    }
    
    $controllerName = "V2/_{$hanshaCode}/Admin/{$controllerName}";
    $path = "Http/Controllers/{$controllerName}.php";
    $path = app_path($path);
    if (!file_exists($path)) {
        return;
    }
    $controllerName = str_replace('/', "\\", $controllerName);
    Route::controller( $route, $controllerName );
};

/**
 * ルートを登録する
 * 
 * @param string $route ルート
 * @param string $controllerName コントローラー名
 */
$registerApiRoute = function($route, $controllerName) use($hanshaCode) {
    // 設定ファイル確認
    if (isset(config('original.v2_adv_para')[$hanshaCode])) {
        return;
    }
    
    $controllerName = "V2/_{$hanshaCode}/Api/{$controllerName}";
    $path = "Http/Controllers/{$controllerName}.php";
    $path = app_path($path);
    if (!file_exists($path)) {
        return;
    }
    $controllerName = str_replace('/', "\\", $controllerName);
    Route::controller( $route, $controllerName );
};

// V2部分のコントローラー
Route::group( ['prefix' => $version], function()
        use($hanshaCode, $registerAdminRoute, $registerApiRoute) {
    // 公開画面(API)
    Route::group( ['prefix' => "api/{$hanshaCode}"], function()
            use($hanshaCode, $registerApiRoute) {
        // コメント投稿フォーム
        $registerApiRoute( '/comment-post', 'CommentPostController' );
        $registerApiRoute( '/comment_post', 'CommentPostController' );
        // 拠点ブログAPIのコントローラー
        $registerApiRoute( '/infobbs', 'InfobbsController' );
        // スタッフブログAPIのコントローラー
        $registerApiRoute( '/staffbbs', 'StaffbbsController' );
        // ショールーム情報APIのコントローラー
        $registerApiRoute( '/srinfo', 'SrInfoController' );
        // 一行メッセージAPIのコントローラー
        $registerApiRoute( '/message', 'MessageController' );
    });
    
    // 管理画面
    Route::group( ['prefix' => "admin/{$hanshaCode}"], function()
            use($hanshaCode, $registerAdminRoute) {
        // 管理画面のコントローラー
        $registerAdminRoute( '/top', 'AdminController' );
        // ショールーム写真・コメント入力 画面のコントローラー
        $registerAdminRoute( '/srinfo', 'SrInfoController' );
        // スタッフ紹介 画面のコントローラー
        $registerAdminRoute( '/staffinfo', 'StaffInfoController' );
        // 各店情報掲示板のコントローラー
        $registerAdminRoute( '/base-list', 'BaseListController' );
        // 各スタッフ情報掲示板のコントローラー
        $registerAdminRoute( '/staff-list', 'StaffListController' );
        // 拠点用管理画面のコントローラー
        $registerAdminRoute( '/infobbs', 'InfobbsController' );
        // 拠点用管理画面のコントローラー
        $registerAdminRoute( '/staffbbs', 'StaffbbsController' );
        // 一行メッセージAPIのコントローラー
        $registerAdminRoute( '/message', 'MessageController' );
        // 本社用管理画面コントローラー
        $registerAdminRoute( '/hobbs', 'HobbsController' );
        // 各店情報掲示板 店舗別集計ツールコントローラー
        $registerAdminRoute( '/access-counter', 'AccessCounterController' );
    });
});
