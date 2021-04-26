<?php

/**
 * 北九州
 */
return [

    // 緊急掲示板の店舗コード
    'emergency_bulletin_board_id' => '99',

    // 本社の管理画面
    'admin_honsya_config' => [
        // カスタムな店舗一覧
        'base_list' => ['99'],
    ],

    // メール通知
    'notification' => [
        // 記事の投稿後
        'infobbs' => [
            'subject' => '拠点ブログに新規投稿がありました',
            'sender_name' => 'Honda Cars 北九州 拠点ブログ管理システム',
        ],
    ],
];
