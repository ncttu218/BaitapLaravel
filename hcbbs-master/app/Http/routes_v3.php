<?php
// Add cors for call API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');

// 販社コード
$hanshaCode = Request::segment(3);
// V3なのかのフラグ
$version = 'v2';
$isV2 = Request::segment(1) === $version;
// V3ではない場合、スキップ
if (!$isV2) {
    return;
}

/**
 * ルートを登録する
 * 
 * @param string $route ルート
 * @param string $controllerOriginName コントローラー名
 */
$registerAdminRoute = function($route, $controllerOriginName) use($hanshaCode) {
    // 設定ファイル確認
    if (!isset(config('original.v2_adv_para')[$hanshaCode])) {
        return;
    }
    
    $controllerName = "Admin/_{$hanshaCode}/{$controllerOriginName}";
    $path = "Http/Controllers/{$controllerName}.php";
    $path = app_path($path);
    if (!file_exists($path)) {
        // 共通コントローラー
        $controllerName = "Admin/Common/Controllers/{$controllerOriginName}";
        $path = "Http/Controllers/{$controllerName}.php";
        $path = app_path($path);
        if (!file_exists($path)) {
            return;
        }
    } else {
        $controllerCommonName = "Admin/Common/Controllers/{$controllerOriginName}";
        $controllerCommonName = str_replace('/', "\\", $controllerCommonName);
        Route::controller( $route . '-common', $controllerCommonName );
    }
    $controllerName = str_replace('/', "\\", $controllerName);
    Route::controller( $route, $controllerName );
};

/**
 * ルートを登録する
 * 
 * @param string $route ルート
 * @param string $controllerOriginName コントローラー名
 */
$registerApiRoute = function($route, $controllerOriginName) use($hanshaCode) {
    // 設定ファイル確認
    if (!isset(config('original.v2_adv_para')[$hanshaCode])) {
        return;
    }
    
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
        Route::controller( $route . '-common', $controllerCommonName );
    }
    $controllerName = str_replace('/', "\\", $controllerName);
    Route::controller( $route, $controllerName );
};

// V3部分のコントローラー
Route::group( ['prefix' => $version], function()
        use($hanshaCode, $registerAdminRoute, $registerApiRoute) {
    // 公開画面(API)
    Route::group( ['prefix' => "api/{$hanshaCode}"], function()
            use($hanshaCode, $registerApiRoute) {
        // コメント投稿フォーム
        $registerApiRoute( '/comment-post', 'CommentPostController' );
        $registerApiRoute( '/comment_post', 'CommentPostController' );
        // スタッフ日記のコメント投稿フォーム
        $registerApiRoute( '/staff-comment-post', 'StaffCommentPostController' );
        // 拠点ブログAPIのコントローラー
        $registerApiRoute( '/infobbs', 'InfobbsController' );
        // スタッフブログAPIのコントローラー
        $registerApiRoute( '/staffbbs', 'StaffbbsController' );
        // ショールーム情報APIのコントローラー
        $registerApiRoute( '/srinfo', 'SrInfoController' );
        // 一行メッセージAPIのコントローラー
        $registerApiRoute( '/message', 'MessageController' );
        // 緊急掲示板のコントローラー
        $registerApiRoute( '/emergency-bulletin', 'EmergencyBulletinController' );
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
        // 公開画面のコントローラー
        //$registerAdminRoute( '/viewbbs', 'ViewbbsController' );
        // 一行メッセージのコントローラー
        $registerAdminRoute( '/message', 'MessageController' );
        // 本社用管理画面コントローラー
        $registerAdminRoute( '/hobbs', 'HobbsController' );
        // 各店情報掲示板 店舗別集計ツールコントローラー
        $registerAdminRoute( '/access-counter', 'AccessCounterController' );
        // 更新情報確認ツールコントローラー
        $registerAdminRoute( '/blog-update-log', 'BlogUpdateLogController' );
        // 緊急掲示板のコントローラー
        $registerAdminRoute( '/emergency-bulletin', 'EmergencyBulletinController' );
    });
});
