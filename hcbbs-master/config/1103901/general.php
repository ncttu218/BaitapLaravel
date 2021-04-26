<?php

/**
 * 埼玉南
 */
return [
    // 販社名
    'hansha_name' => 'Honda Cars 横浜',
    
    'para' => [
        // 本社認証
        'published_mode' => '0',
        // メールアドレスの登録
        'mail_register' => '0',
        // スタッフ日記
        'staff' => '1',
        // スタッフ日記のコメント投稿
        'staff_comment' => '0',
        // 店舗ブログ
        'shop' => '1',
        // 店舗ブログのコメント投稿
        'comment' => '0',
        // 一行メッセージ
        'message' => '0',
        // ページング最大数
        'page_num' => 10,
        // カテゴリー
        'category' => '',
    ],
    
    // 緊急掲示板の店舗コード
    'emergency_bulletin_board_id' => '99',
    
    // 管理画面のメニューボタン
    'admin_top_menu' => [
        ['menu_type' => 1, 'menu_name' => '拠点ブログ', 'description' => '<a href="https://cgi3-aws.hondanet.co.jp/cgi/log_count_1103901.cgi" target="_blank">更新情報確認ツール</a>'],
        ['menu_type' => 3, 'menu_name' => 'スタッフ紹介'],
        ['menu_type' => 5, 'menu_name' => 'スタッフ紹介集合写真・拠点コメント入力'],
        ['menu_type' => '', 'menu_name' => '採用情報(営業／サービス／事務スタッフ)', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=hc-yokohama/recruit&mode=admin'],
        ['menu_type' => '', 'menu_name' => '採用情報(アルバイト)', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=hc-yokohama/recruit2&mode=admin'],
        ['menu_type' => '', 'menu_name' => 'アクセス解析 ', 'menu_url' => 'https://datastudio.google.com/open/1bYuBtrhNEw7GMsCsyrlA0ki9R7Us9EdN'],
    ],
];
