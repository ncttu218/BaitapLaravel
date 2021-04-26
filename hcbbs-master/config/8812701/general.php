<?php

/**
 * 埼玉南
 */
return [
    // 販社名
    'hansha_name' => 'Honda Cars 高崎',
    
    'para' => [
        // 本社認証
        'published_mode' => '0',
        // メールアドレスの登録
        'mail_register' => '0',
        // スタッフ日記
        'staff' => '1',
        // スタッフ日記のコメント投稿
        'staff_comment' => '1',
        // 店舗ブログ
        'shop' => '0',
        // 店舗ブログのコメント投稿
        'comment' => '1',
        // 一行メッセージ
        'message' => '0',
        // ページング最大数
        'page_num' => 10,
        // カテゴリー
        'category' => '',
    ],
    
    // 緊急掲示板の店舗コード
    'emergency_bulletin_board_id' => 'em',
    
    // 管理画面のメニューボタン
    'admin_top_menu' => [
        ['menu_type' => 4, 'menu_name' => '中古車在庫検索', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812701/usedcar&mode=admin'],
        ['menu_type' => 1, 'menu_name' => '拠点情報掲示板'],
        ['menu_type' => 2, 'menu_name' => 'スタッフ日記', 'description' => '<font color="#ff0000">編集用パスワードの初期値は「8812701」(半角小文字)です。<br>適宜変更してください。</font>'],
        ['menu_type' => '', 'menu_name' => '在庫車管理システム', 'menu_url' => 'https://cms.hondanet.co.jp/cms/', 'description' => '管理者用ID/PWは「Honda 販売会社ホームページ管理システム」と同じです。<br>営業スタッフ用ID/PWは管理者ログイン後「ID・パスワード管理」から確認・編集できます。'],
    ],
];
