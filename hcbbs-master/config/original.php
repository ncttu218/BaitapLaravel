<?php

return [
    'title' => 'HP情報掲示板 管理画面（ver.2）',
    'footer' => 'Copyright (c) Stadione63 All Rights Reserved.',
    'dataImage' => 'data/image/',
    /**
     * エディターの設定
     */
    'text_editor' => 'TINYMCE' // NICEDIT, TINYMCE
    , 'image_upload_target' => 'PRODUCTION' // PRODUCTION, DEVELOPMENT
    // 権限
    ,'authority' => [
        '1' => 'システム'
        ,'2' => '本社'
        ,'3' => '拠点長'
        ,'4' => 'スタッフ'
        ,'5' => '本社担当'
    ]
    // 販社コード、追加して管理画面を表示するとテーブルが自動で作成されます
    ,'hansha_code' => [
        '0000000' => '六三管理'
        ,'0000001' => 'Honda Cars 青山'
        ,'1006078' => 'Honda Cars 東京'
        ,'1011801' => 'Honda Cars 東京中央'
        ,'1103901' => 'Honda Cars 横浜'
        ,'1152053' => 'Honda Cars 神奈川北'
        ,'1351100' => 'Honda Cars 埼玉南'
        ,'1351901' => 'Honda Cars 埼玉'
        ,'1384003' => 'Honda Cars 秩父中央'
        ,'1453100' => 'Honda Cars 茨城西/福島南'
        ,'1453901' => 'Honda Cars 茨城'
        ,'1551259' => 'Honda Cars 宇都宮北'
        ,'1551801' => 'Honda Cars 栃木'
        ,'1558075' => 'Honda Cars 南栃木'
        ,'1581055' => 'Honda Cars 栃木東'
        ,'1587016' => 'Honda Cars 佐野'
        ,'1651901' => 'Honda Cars 群馬'
        ,'2153801' => 'Honda Cars 愛知'
        ,'2451901' => 'Honda Cars 岐阜'
        ,'3153074' => 'Honda Cars 長浜'
        ,'3183030' => 'Honda Cars 滋賀東'
        ,'3187901' => 'Honda Cars 滋賀北'
        ,'3207202' => 'Honda Cars 洛中'
        ,'3209155' => 'Honda Cars 南京都'
        ,'3301076' => 'Honda Cars 北大阪'
        ,'3351284' => 'Honda Cars 南海'
        ,'3353533' => 'Honda Cars 大阪'
        ,'3451253' => 'Honda Cars 奈良中央'
        ,'3487031' => 'Honda Cars 大和奈良'
        ,'3602090' => 'Honda Cars 神戸中央'
        ,'3604041' => 'Honda Cars 北神戸'
        ,'3608801' => 'Honda Cars 明舞'
        ,'3651055' => 'Honda Cars 西播'
        ,'3660136' => 'Honda Cars 加古川西'
        ,'4051009' => 'Honda Cars 島根東'
        ,'5196005' => 'Honda Cars 博多'
        ,'5551358' => 'Honda Cars 熊本東'
        ,'5551803' => 'Honda Cars 熊本'
        ,'5756013' => 'Honda Cars さつま'
        ,'6251277' => 'Honda Cars 南札幌'
        ,'6251802' => 'Honda Cars 北海道'
        ,'8812391' => 'Honda Cars 千葉'
        ,'8812404' => 'Honda Cars 埼玉西'
        ,'8812502' => 'Honda Cars 茨城南'
        ,'8812503' => 'Honda Cars 茨城北'
        ,'8812601' => 'Honda Cars 栃木中'
        ,'8812603' => 'Honda Cars 両毛'
        ,'8812701' => 'Honda Cars 高崎'

        ,'7357052' => 'Honda Cars 岩手南'
        ,'7151315' => 'Honda Cars 宮城'
        ,'7151882' => 'Honda Cars 宮城中央'
        ,'7152075' => 'Honda Cars 宮城北'
        ,'8153883' => 'Honda Cars 福島'
        ,'8190062' => 'Honda Cars 東白川'
        ,'7251883' => 'Honda Cars 山形'
        ,'7288072' => 'Honda Cars 東置賜'
        ,'1561024' => 'Honda Cars 那須'
        ,'7556029' => 'Honda Cars 十和田'
        ,'5104199' => 'Honda Cars 北九州'
        ,'1652022' => 'Honda Cars 高崎東'

        ,'1655803' => 'Honda Cars 群馬中央'
        ,'1654144' => 'Honda Cars 伊勢崎中央'
        ,'1352174' => 'Honda Cars 熊谷'
        ,'8812403' => 'Honda Cars 埼玉北'
        ,'8812702' => 'Honda Cars 前橋'
        ,'1369070' => 'Honda Cars 桶川'
        ,'1388039' => 'Honda Cars 久喜'
        ,'1382247' => 'Honda Cars 埼玉県央'
        ,'3697061' => 'Honda Cars 多可'
        ,'5852122' => 'Honda Cars 下関'
        ,'3693015' => 'Honda Cars 篠山'
        ,'2289009' => 'Honda Cars 駿河'  //駿河
        ,'6262009' => 'Honda Cars 滝川'  //滝川
        ,'3751804' => 'Honda Cars 岡山'  //岡山
        ,'3679042' => 'Honda Cars 西神戸'  //西神戸
        ,'1256015' => 'Honda Cars 木更津'  //木更津
        ,'1286034' => 'Honda Cars 市原'   //市原
        ,'1253025' => 'Honda Cars 西千葉'  //西千葉
        ,'5587043' => 'Honda Cars 宇城'
        ,'1257037' => 'Honda Cars 東葛'
        ,'1255006' => 'Honda Cars 館山'
        ,'1288165' => 'Honda Cars 北千葉'   // C北千葉様
        //,'1257014' => 'Honda Cars 松戸'  //松戸
        ,'1081179' => 'Honda Cars 東京西'   // 東京西
        ,'5656025' => 'Honda Cars 日向北'   // 日向北
        ,'8812201' => 'Honda Cars 神奈川東'   // 神奈川東
        ,'1655053' => 'Honda Cars 太田'   // 太田
        ,'1151043' => 'Honda Cars 横須賀西'   // 横須賀西

    ]
    /**
     *  カラム名        説明                      値
     *  published_mode 本社掲載確認      　        0:OFF | 1:ON
     *  mail_register  メール投稿                  0:OFF | 1:ON
     *  staff          スタッフブログ・スタッフ紹介 0:OFF | 1:ON staffテーブル作成
     *  staff_comment  スタッフブログ・コメント     0:OFF | 1:ON staff_commentテーブル作成
     *  shop           shopブログ                 0:OFF | 1:ON shopテーブル作成
     *  comment        コメント                   0:OFF | 1:ON commentテーブル作成
     *  message        1行メッセージ               0:OFF | 1:ON_店舗指定なし | 2:ON_店舗指定あり
     *  page_num       1ページ表示件数,            デフォルト:10
     *  category       カテゴリー,                カンマ区切りで追加
     */
    ,'para' => [
        '0000000' => ['published_mode' => '1', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 六三管理
        ,'0000001' => ['published_mode' => '0', 'mail_register' => '1', 'staff' => '1','staff_comment' => '1','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得']  // 青山
        ,'1006078' => ['published_mode' => '1', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '1', 'page_num' => 10, 'category' => ''] // 東京
        ,'1011801' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '1', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得'] // 東京中央
        ,'1103901' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '1', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 横浜
        ,'1152053' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得'] // 神奈川北
        ,'1351100' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 埼玉南
        ,'1351901' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '1', 'comment' => '1', 'message' => '1', 'page_num' => 10, 'category' => ''] // 埼玉
        ,'1384003' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 秩父中央
        ,'1453100' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 20, 'category' => 'お店,お得,クルマ,地域,話題'] // 茨城西/福島南
        ,'1453901' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 茨城
        ,'1551259' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' => ''] // 宇都宮北
        ,'1551801' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 栃木
        ,'1558075' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 南栃木
        ,'1581055' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => 'お店,お得,クルマ,地域,話題'] // 栃木東
        ,'1587016' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 佐野
        ,'1651901' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得'] // 群馬
        ,'2153801' => ['published_mode' => '1', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'design' => '1', 'category' => ''] // 愛知
        ,'2451901' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 岐阜
        ,'3153074' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 長浜
        ,'3183030' => ['published_mode' => '0', 'mail_register' => '1', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 滋賀東
        ,'3187901' => ['published_mode' => '0', 'mail_register' => '1', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 滋賀北
        ,'3207202' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 洛中
        ,'3209155' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 南京都
        ,'3301076' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 北大阪
        ,'3351284' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 南海
        ,'3353533' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 大阪
        ,'3451253' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 奈良中央
        ,'3487031' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 大和奈良
        ,'3602090' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''/*'shop,event'*/] // 神戸中央
        ,'3604041' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 北神戸
        ,'3608801' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' => ''] // 明舞
        ,'3651055' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 西播
        ,'3660136' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 加古川西
        ,'4051009' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' => ''] // 島根東
        ,'5196005' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '1', 'page_num' => 10, 'category' => ''] // 博多
        ,'5551358' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 熊本東
        ,'5551803' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '2', 'page_num' => 10, 'category' => ''] // 熊本
        ,'5756013' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // さつま
        ,'6251277' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '店舗紹介,スタッフ紹介,日記,キャンペーン・イベント,展示・試乗車,その他'] // 南札幌
        ,'6251802' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '1', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 北海道
        ,'8812391' => ['published_mode' => '1', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 千葉
        ,'8812404' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 20, 'category' => 'お買い得,キャンペーン,その他'] // 埼玉西
        ,'8812502' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 茨城南
        ,'8812503' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 茨城北
        ,'8812601' => ['published_mode' => '0', 'mail_register' => '1', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' => ''] // 栃木中
        ,'8812603' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' => ''] // 両毛
        ,'8812701' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '1','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 高崎
        ,'7357052' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 岩手南
        ,'7151315' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''/*'地域,お店,クルマ,話題,お得'*/] // 宮城
        ,'7151882' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' => ''] // 宮城中央
        ,'7152075' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 宮城北
        ,'8153883' => ['published_mode' => '0', 'mail_register' => '1', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 福島
        ,'8190062' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 東白川
        ,'7251883' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '1', 'page_num' => 10, 'category' => ''] // 山形
        ,'7288072' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 東置賜
        ,'1561024' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 那須
        ,'7556029' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得'] // 十和田
        ,'5104199' => ['published_mode' => '1', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 北九州
        ,'1652022' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 高崎東
        ,'1655803' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得'] // 群馬中央
        ,'1654144' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 伊勢崎中央
        ,'1352174' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 熊谷
        ,'8812403' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 埼玉北
        ,'8812702' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得'] // 前橋
        ,'1369070' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 桶川
        ,'1388039' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => '地域,お店,クルマ,話題,お得'] // 久喜
        ,'1382247' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 埼玉県央
        ,'3697061' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 多可
        ,'5852122' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 下関
        ,'3693015' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 篠山
        ,'2289009' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 駿河
        ,'6262009' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] //  滝川
        ,'3751804' => ['published_mode' => '1', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' => ''] //  岡山
        ,'3679042' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] //  西神戸
        ,'1256015' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' =>  '地域,お店,クルマ,話題,お得'] // 木更津
        ,'1286034' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 20, 'category' => ''] // 市原
        ,'1253025' => ['published_mode' => '1', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' =>  ''] //  西千葉
        ,'1257037' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' =>  ''] //  東葛
        ,'5587043' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' =>  ''] //  宇城
        ,'1255006' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' =>  ''] //  館山
        //,'1257014' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' =>  ''] //  松戸
        ,'1288165' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' =>  ''] //  C北千葉様
        ,'1081179' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '0','shop' => '1', 'comment' => '0', 'message' => '1', 'page_num' => 10, 'category' =>  ''] //  東京西
        ,'5656025' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 日向北
        ,'8812201' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '1','staff_comment' => '1','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 神奈川東
        ,'1655053' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '0', 'message' => '0', 'page_num' => 10, 'category' => ''] // 太田
        ,'1151043' => ['published_mode' => '0', 'mail_register' => '0', 'staff' => '0','staff_comment' => '0','shop' => '0', 'comment' => '1', 'message' => '0', 'page_num' => 10, 'category' => ''] // 横須賀西
    ],
    'v2_adv_para' => [
        '0000000' => true,
        '1351100' => true, // 埼玉南様
        '1651901' => true, // 群馬様
        '8812701' => true, // 高崎様
        '5551803' => true, // 熊本様
        '1453901' => true, // 茨城様
        '4051009' => true, // 島根東様
        '5196005' => true, // 博多様
        '3301076' => true, // 北大阪
        '3651055' => true, // 西播
        '3604041' => true, // 北神戸
        '3660136' => true, // 加古川西
        '1384003' => true, // 秩父中央

        '3602090' => true, // 神戸中央
        '3608801' => true, // 明舞
        '1103901' => true, // 横浜
        '2153801' => true, // 愛知

        '7357052' => true, // 岩手南
        '7151315' => true, // 宮城
        '7151882' => true, // 宮城中央
        '7152075' => true, // 宮城北
        '8153883' => true, // 福島
        '8190062' => true, // 東白川
        '7251883' => true, // 山形
        '7288072' => true, // 東置賜
        '1561024' => true, // 那須
        '7556029' => true, // 十和田
        '5104199' => true, // 北九州
        '1652022' => true, // 高崎東

        '1655803' => true, // 群馬中央
        '1654144' => true, // 伊勢崎中央
        '1352174' => true, // 熊谷
        '8812403' => true, // 埼玉北
        '8812702' => true, // 前橋
        '1369070' => true, // 桶川
        '1351901' => true, // 埼玉
        '1388039' => true, // 久喜
        '1382247' => true, // 埼玉県央
        '3153074' => true, // 長浜

        '3697061' => true, // 多可
        '5852122' => true, // 下関
        '3693015' => true, // 篠山
        '2289009' => true, // 駿河
        '6262009' => true, // 滝川
        '3751804' => true, // 岡山
        '3679042' => true, // 西神戸
        '1256015' => true, // 木更津
        '8812391' => true, // 千葉
        '1253025' => true, // 西千葉
        //'1257014' => true, // 松戸
        '1453100' => true, // 茨城西/福島南
        '1286034' => true, // 市原
        '5587043' => true, // 宇城
        '1257037' => true, // 東葛
        '1255006' => true, // 館山
        '1288165' => true, // 北千葉
        '1081179' => true, // 東京西
        '5656025' => true, // 日向北
        '8812201' => true, // 神奈川東
        '1655053' => true, // 太田
        '1151043' => true, // 横須賀西

        //'1551801' => true, // 栃木
        //'3183030' => true, // 滋賀東
        //'3207202' => true, // 洛中
        //'6251277' => true, // 南札幌
        //'5551358' => true, // 熊本東

        //'1006078' => true, // 東京
        //'1581055' => true, // 栃木東
        //'5756013' => true, // さつま
        //'6251802' => true, // 北海道
    ]

    /**
     * 管理画面のトップのパラメータ
     * カラム名     説明                値
     * menu_type   メニューの表示タイプ  1（店舗ブログ）, 2(スタッフブログ) , 3（スタッフ紹介）,  4（拠点選択フォーム）, 5 （ショールーム情報入力）
     *                                  6（店舗ブログ）, 7（一行メッセージ）, 8（本社承認店舗ブログ）、9（アクセスカウンターリンク）、10（拠点選択フォーム カスタム）
     * menu_name   メニュー名
     * menu_url　　メニューのリンク先URL
     * menu_url_auto 自動的に置換されるURL　→　文字列を置換するフォーマット
     * description 説明文
     */
    ,'admin_menu_para' => [
        '1006078' => [ // 東京
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板(拠点別)'],
            ['menu_type' => 4, 'menu_name' => 'Honda Cars 東京 中古車在庫情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1006078/usedcar&mode=admin']
        ],
        '1011801' => [ // 東京中央
            ['menu_type' => 3, 'menu_name' => 'スタッフ紹介'],
            ['menu_type' => 5, 'menu_name' => 'スタッフ紹介集合写真・拠点コメント入力']
        ],
        '1103901' => [ // 横浜
            ['menu_type' => 1, 'menu_name' => '拠点ブログ', 'description' => '<a href="{BLOG_UPDATE_LOG_URL}" target="_blank">更新情報確認ツール</a>'],
            ['menu_type' => 3, 'menu_name' => 'スタッフ紹介'],
            ['menu_type' => 5, 'menu_name' => 'スタッフ紹介集合写真・拠点コメント入力'],
            ['menu_type' => '', 'menu_name' => '採用情報(営業／サービス／事務スタッフ)', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=hc-yokohama/recruit&mode=admin'],
            ['menu_type' => '', 'menu_name' => '採用情報(アルバイト)', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=hc-yokohama/recruit2&mode=admin'],
            ['menu_type' => '', 'menu_name' => 'アクセス解析 ', 'menu_url' => 'https://datastudio.google.com/open/1bYuBtrhNEw7GMsCsyrlA0ki9R7Us9EdN'],
        ],
        '1152053' => [ // 神奈川北
            ['menu_type' => 2, 'menu_name' => 'スタッフサイト(編集)', 'description' => '初期パスワードは「<font color=red>ck001122</font>」<br>もしくは「<font color=red>1152053</font>」(2018年3月登録以降)です。'],
            ['menu_type' => 1, 'menu_name' => '店舗ニュース'],
            ['menu_type' => '', 'menu_name' => 'カナキタと遊ぶ', 'menu_url' => 'http://play.hondacars-kanagawakita.co.jp/utils/wp-login.php', 'description' => 'ID default_user<br>PW wFW1td1x'],
            ['menu_type' => '', 'menu_name' => 'ボイスコレクター', 'menu_url' => 'https://secure.hondanet.co.jp/dealer_admin/form_admin.cgi?id=1152053'],
            ['menu_type' => '', 'menu_name' => 'データスタジオ', 'menu_url' => 'https://datastudio.google.com/u/0/reporting/1eLUmn9H9gzg3nAMwrNHZexiIvOtiYOO1/page/6I3B']

        ],
        '1351100' => [ // 埼玉南
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板']
        ],
        '1351901' => [ // 埼玉
            ['menu_type' => '', 'menu_name' => 'ネットオーダーシステム', 'menu_url' => 'http://cgi1.hondanet.co.jp/cgi/clio-saitama/NetOrder/index.html'],
            ['menu_type' => 1, 'menu_name' => 'ショールームだより'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫検索(新車拠点＆オートテラス店＆中古車センター用)', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1351901/usedcar&mode=admin', 'use_selector' => true],
            ['menu_type' => 5, 'menu_name' => 'ショールーム'],
            ['menu_type' => '', 'menu_name' => 'アウトレット／ショッピング', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=hc-saitama/partsinfo&mode=admin'],
            //['menu_type' => 3, 'menu_name' => 'スタッフパーソナルサイト(個人データ編集)'],
        ],
        '1453100' => [ // 茨城西/福島南
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板']
        ],
        '1453901' => [ // 茨城
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1453901/usedcar&mode=admin']
        ],
        '1551259' => [ // 宇都宮北
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => '', 'menu_name' => 'トップページ一行メッセージ', 'menu_url_auto' => 'routes.message', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/hcBbs/message/index?hansha_code=1551259']
        ],
        '1551801' => [ // 栃木
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板']
        ],
        '1558075' => [ // 南栃木
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板']
        ],
        '1581055' => [ // 栃木東
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板＋クラブ・サークル活動'],
            //['menu_type' => 2, 'menu_name' => 'スタッフ日記', 'description' => '<font color="#ff0000">編集用パスワードの初期値は「1581055」です。<br>適宜変更してください。</font>'],
            ['menu_type' => '', 'menu_name' => '会社説明会情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1581055/recruit_topics&mode=admin']
        ],
        '1651901' => [ // 群馬
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '2153801' => [ // 愛知
            ['menu_type' => '', 'menu_name' => '@ichi.com 試乗キャンペーン管理画面', 'menu_url' => 'https://secure.hondanet.co.jp/cgi/admin/shijo_admin.cgi'],
            ['menu_type' => '', 'menu_name' => '@ichi.com 車検キャンペーン管理画面', 'menu_url' => 'https://secure.hondanet.co.jp/cgi/admin/syaken_admin.cgi'],
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '拠店ページ ビジュアル改廃', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/2153801/sr_edit.php?id=2153801/infobbs&mode=admin'],
            ['menu_type' => 4, 'menu_name' => '来場イベント引換券印刷システム', 'menu_url' => 'http://cgi3.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/coupon&mode=admin'],
            ['menu_type' => '', 'menu_name' => 'アクセス集計', 'menu_url' => 'https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count_aichi.cgi?id=2153801/infobbs'],
            ['menu_type' => '', 'menu_name' => 'お礼メール', 'menu_url' => 'https://secure.hondanet.co.jp/cgi/admin/mail_sender.cgi?id=hc-aichi'],
            ['menu_type' => '', 'menu_name' => '情報掲示板　更新情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/log_count.cgi'],
            ['menu_type' => 4, 'menu_name' => '社内用中古車情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/usedcar&mode=admin'],
            ['menu_type' => 4, 'menu_name' => '@ichi.com イベント掲示板', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/ladysday&mode=admin'],
        ],
        '2451901' => [ // 岐阜
            ['menu_type' => 1, 'menu_name' => '情報掲示板']
        ],
        '3183030' => [ // 滋賀東
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板(拠点別)'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=3183030/usedcar&mode=admin'],
            ['menu_type' => 9, 'menu_name' => 'アクセス集計', 'menu_url' => 'https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count.cgi?id=hc-shigahigashi/infobbs',
                'description' => '<a target="_blank" href="https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count.cgi?id=hc-shigahigashi/infobbs">情報掲示板のアクセス集計（旧）</a>']
        ],
        '3207202' => [ // 洛中
            ['menu_type' => 1, 'menu_name' => '情報掲示板']
        ],
        '3209155' => [ // 南京都
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板']
        ],
        '3301076' => [ // 北大阪
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => '', 'menu_name' => '会社説明会情報', 'menu_url' => 'https://cgi3.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=3301076/testdrive&mode=admin']
        ],
        '3351284' => [ // 南海
            ['menu_type' => 1, 'menu_name' => '情報掲示板']
        ],
        '3353533' => [ // 大阪
            ['menu_type' => 4, 'menu_name' => '中古車情報', 'method' => 'get', 'menu_url' => ''],
        ],
        '3602090' => [ // 神戸中央
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '強化版中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=3602090/usedcar&mode=admin']
        ],
        '3604041' => [ // 北神戸
            ['menu_type' => 1, 'menu_name' => '拠点ブログ'],
            ['menu_type' => '', 'menu_name' => 'お客様限定情報掲示板', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=3604041/pasbbs&mode=admin']
        ],
        '3608801' => [ // 明舞
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 7, 'menu_name' => 'Honda Cars 明舞からのお知らせ', 'menu_url_auto' => 'routes.message', 'description' => '', 'role_check' => false],
        ],
        '3651055' => [ // 西播
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板']
        ],
        '3660136' => [ // 加古川西
            ['menu_type' => 1, 'menu_name' => '店舗ブログ']
        ],
        '1384003' => [ // 秩父中央
            ['menu_type' => 1, 'menu_name' => '店舗ブログ']
        ],
        '4051009' => [ // 島根東
            ['menu_type' => 1, 'menu_name' => '店舗掲示板'],
            ['menu_type' => '', 'menu_name' => '中古車在庫', 'menu_url' => 'http://cgi3.hondanet.co.jp/cgi/shimane_usedcar/', 'description' => '中古車の掲載については【島根県Honda Cars 中古車サイト】の管理画面から改廃下さい。'],
            ['menu_type' => 7, 'menu_name' => 'トップページ一行メッセージ', 'menu_url_auto' => 'routes.message', 'description' => ''],
        ],
        '5196005' => [ // 博多
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 7, 'menu_name' => 'TOPページ1行メッセージ', 'menu_url_auto' => 'routes.message', 'description' => '', 'role_check' => false],
        ],
        '5551358' => [ // 熊本東
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板']
        ],
        '5551803' => [ // 熊本
            ['menu_type' => 4, 'menu_name' => '中古車情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=5551803/usedcar&mode=admin'],
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 7, 'menu_name' => '一行メッセージ', 'method' => 'get', 'use_selector' => true],
            ['menu_type' => 3, 'menu_name' => 'スタッフ紹介']
        ],
        '5756013' => [ // さつま
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=5756013/usedcar&mode=admin'],
            ['menu_type' => 3, 'menu_name' => 'スタッフ紹介']
        ],
        '6251802' => [ // 北海道
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 3, 'menu_name' => 'スタッフ紹介', 'use_selector' => true],
            ['menu_type' => 5, 'menu_name' => 'スタッフ紹介集合写真・拠点コメント入力', 'use_selector' => true]
        ],
        '6251277' => [ // 南札幌
            ['menu_type' => 1, 'menu_name' => '拠点ブログ']
        ],
        '8812391' => [ // 千葉
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板', 'description' => '<a href="https://cgi3-aws.hondanet.co.jp/hcBbs/v2/admin/8812391/access-counter/count" target="_blank">情報掲示板店舗別集計ツール</a><br/><a href="https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count.cgi?id=8812391/infobbs" target="_blank">情報掲示板店舗別集計ツール（旧）</a>'],
            ['menu_type' => '', 'menu_name' => 'お買い得車', 'menu_url' => 'http://cgi3.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812391/pasbbs&mode=admin'],
            ['menu_type' => '', 'menu_name' => '用品・パーツ情報', 'menu_url' => 'http://cgi3.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812391/partsinfo&mode=admin'],
            ['menu_type' => '', 'menu_name' => 'イベント・キャンペーン', 'menu_url' => 'http://cgi3.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812391/pasbbs2&mode=admin'],
            ['menu_type' => '', 'menu_name' => 'ボイスコレクター', 'menu_url' => 'https://secure.hondanet.co.jp/dealer_admin/form_admin.cgi?id=8812391'],
            ['menu_type' => '', 'menu_name' => '法人課・特販課お問い合わせフォーム', 'menu_url' => 'https://secure.hondanet.co.jp/cgi/admin/csv.cgi?id=8812391&mode=csvdsp&code=hojin1'],
            ['menu_type' => '', 'menu_name' => '初めてご利用の方へフォーム', 'menu_url' => 'https://secure.hondanet.co.jp/cgi/admin/csv.cgi?id=8812391&mode=csvdsp&code=beginners-form'],
        ],
        '8812404' => [ // 埼玉西
            ['menu_type' => 1, 'menu_name' => '拠点ブログ'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫管理', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812404/usedcar&mode=admin']
        ],
        '8812502' => [ // 茨城南
            ['menu_type' => 1, 'menu_name' => '情報掲示板', 'description' => '<a href="//cgi3-aws.hondanet.co.jp/hcBbs/bbs_count/base/count?hansha_code=8812502" target="_blank">情報掲示板のアクセス集計</a><br><a href="https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count.cgi?id=8812502/infobbs" target="_blank">情報掲示板のアクセス集計（旧）</a>'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫管理', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812502/usedcar&mode=admin']
        ],
        '8812503' => [ // 茨城北
            ['menu_type' => 4, 'menu_name' => '中古車在庫情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812503/usedcar&mode=admin']
        ],
        '8812601' => [ // 栃木中
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812601/usedcar&mode=admin']
        ],
        '8812603' => [ // 両毛
            ['menu_type' => 4, 'menu_name' => '中古車情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812603/usedcar&mode=admin'],
            ['menu_type' => '', 'menu_name' => 'お知らせ', 'menu_url_auto' => 'routes.message', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/hcBbs/message/index?hansha_code=8812603']
        ],
        '8812701' => [ // 高崎
            ['menu_type' => 4, 'menu_name' => '中古車在庫検索', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812701/usedcar&mode=admin'],
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板'],
            ['menu_type' => 2, 'menu_name' => 'スタッフ日記', 'description' => '<font color="#ff0000">編集用パスワードの初期値は「8812701」(半角小文字)です。<br>適宜変更してください。</font>'],
            ['menu_type' => '', 'menu_name' => '在庫車管理システム', 'menu_url' => 'https://cms.hondanet.co.jp/cms/', 'description' => '管理者用ID/PWは「Honda 販売会社ホームページ管理システム」と同じです。<br>営業スタッフ用ID/PWは管理者ログイン後「ID・パスワード管理」から確認・編集できます。']
        ],
        '7357052' => [ // 岩手南
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=7357052/usedcar&mode=admin', 'use_selector' => true],
        ],
        '7151315' => [ // 宮城
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
        ],
        '7151882' => [ // 宮城中央
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '強化版中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=7151882/usedcar&mode=admin'],
            ['menu_type' => 7, 'menu_name' => 'トップページ一行メッセージ', 'menu_url_auto' => 'routes.message', 'description' => '', 'role_check' => false],
        ],
        '7152075' => [ // 宮城北
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '強化版中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=7152075/usedcar&mode=admin'],
        ],
        '8153883' => [ // 福島
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
        ],
        '8190062' => [ // 東白川
            ['menu_type' => 1, 'menu_name' => '拠点ブログ'],
        ],
        '7251883' => [ // 山形
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
            ['menu_type' => 7, 'menu_name' => 'トップページ一行メッセージ', 'menu_url_auto' => 'routes.message', 'description' => '', 'role_check' => false],
        ],
        '7288072' => [ // 東置賜
            ['menu_type' => 1, 'menu_name' => '店舗ブログ'],
        ],
        '1561024' => [ // 那須
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1561024/usedcar&mode=admin', 'use_selector' => true],
        ],
        '7556029' => [ // 十和田
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '強化版中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=7556029/usedcar&mode=admin', 'use_selector' => true],
        ],
        '5104199' => [ // 北九州
            // ['menu_type' => 4, 'menu_name' => '試乗車・展示車情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=5104199/democar&mode=admin', 'use_selector' => true],
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
            // ['menu_type' => 10, 'menu_name' => 'スタッフ紹介', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=toku/staff&mode=admin', 'use_selector' => true],
        ],
        '1652022' => [ // 高崎東
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
            ['menu_type' => '', 'menu_name' => '用品・パーツ情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=hc-takasakihigashi/partsinfo&mode=admin'],
        ],
        '1655803' => [ // 群馬中央
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板'],
        ],
        '1654144' => [ // 伊勢崎中央
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
        ],
        '1352174' => [ // 熊谷
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
            ['menu_type' => 4, 'menu_name' => 'LP用中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1352174/usedcar&mode=admin', 'use_selector' => true],
        ],
        '8812403' => [ // 埼玉北
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '強化版中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812403/usedcar&mode=admin', 'use_selector' => true],
        ],
        '8812702' => [ // 前橋
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
        ],
        '1369070' => [ // 桶川
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車情報', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1369070/usedcar&mode=admin', 'use_selector' => true],
        ],
        '1388039' => [ // 久喜
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
        ],
        '1382247' => [ // 埼玉県央
            ['menu_type' => 1, 'menu_name' => '各店情報掲示板'],
        ],
        '3153074' => [ // 長浜
            ['menu_type' => 1, 'menu_name' => '店舗ブログ'],
        ],
        '3697061' => [ // 多可
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '5852122' => [ // 下関
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '3693015' => [ // 篠山
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '2289009' => [ // 駿河
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '6262009' => [ // 滝川
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '3751804' => [ // 岡山
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '3679042' => [ // 西神戸
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '1256015' => [ // 木更津
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
        ],
        '1286034' => [ // 市原
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板']
       ],
        '1253025' => [ // 西千葉
            ['menu_type' => 1, 'menu_name' => 'Honda Cars 西千葉 拠点情報掲示板']
        ],
        '5587043' => [ // 宇城
            ['menu_type' => 1, 'menu_name' => '緊急掲示板']
        ],
        '1257037' => [ // 東葛
            ['menu_type' => 1, 'menu_name' => 'ブログ'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1257037/usedcar&mode=admin'],
        ],
        '1255006' => [ // 館山
            ['menu_type' => 1, 'menu_name' => '店舗ブログ']
        ],
//        '1257014' => [ // 松戸
//            ['menu_type' => 1, 'menu_name' => '店舗ﾌﾞﾛｸﾞ']
//        ],
        '1288165' => [ // 北千葉
            ['menu_type' => 1, 'menu_name' => '情報掲示板']
        ],
        '1081179' => [ // 東京西
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1081179/usedcar&mode=admin'],
            ['menu_type' => 3, 'menu_name' => 'スタッフ紹介', 'use_selector' => true],
            ['menu_type' => 5, 'menu_name' => 'スタッフ紹介タイトル写真', 'use_selector' => true]
        ],
        '5656025' => [ // 日向北
            ['menu_type' => 1, 'menu_name' => '情報掲示板']
        ],
        '8812201' => [ // 東
            ['menu_type' => 4, 'menu_name' => '中古車', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=8812201/usedcar&mode=admin'],
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板'],
            ['menu_type' => 2, 'menu_name' => 'スタッフサイト(編集)','description'=>'<p class="p-index-button__description">初期パスワードは「<font color="red">8812201</font>」です。</p>'],
            ['menu_type' => '', 'menu_name' => 'プロぐアクセスランキング ', 'menu_url' => 'https://datastudio.google.com/u/0/reporting/1ZAVC0I4iWR0X_NQmYJLuP-Wcu7Ae0xDF/page/tzCV']
        ],
        '1655053' => [ // 太田
            ['menu_type' => 1, 'menu_name' => '情報掲示板']
        ],
        '1151043' => [ // 横須賀西
            ['menu_type' => 1, 'menu_name' => '各店舗情報掲示板'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫検索', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1151043/usedcar&mode=admin']
        ],
    ],

    /**
     * ショールームページへのリンク用パラメータ
     */
    'sr_link_para' => [
        '1453100' => [ // 茨城西/福島南
            'pc' => [ // 茨城西/福島南
                '01' => 'tsuchiuraomachi', // 土浦大町店
                '03' => 'shimodatenikinari', // 下館二木成店
                '04' => 'hitachinoushiku', // ひたち野うしく店
                '05' => 'moriyakinunodai.', // 守谷絹の台店
                '06' => 'hitachiogitsu', // 日立小木津店
                '07' => 'kamisuhoriwari', // 神栖堀割店
                '08' => 'kogaono', // 古河大野店
                '09' => 'shimodatekamiwake', // 下館神分店
                '11' => 'tsukubakenkyugakuen', // つくば研究学園店
                '14' => 'onahama', // 小名浜店
                '15' => 'sukagawa', // 須賀川店
                '16' => 'nakoso', // 勿来店
                '17' => 'koriyamaasahi', // 郡山朝日店
                '18' => 'iwakikabeya', // いわき神谷店
                '19' => 'chikuseiyokoshima', // 筑西横島店
                '20' => 'yuki', // 結城店
                '21' => 'kogaoyama', // 古河大山店
                '23' => 'chikuseiyokotsuka', // 筑西横塚店
                '24' => 'mitominami', // 水戸南店
                '25' => 'tsukubamiraidaira', // つくばみらい平店
                '70' => 'us_shimodate', // U-Select下館
                '90' => 'honsya' // 本社
            ]
        ]
    ],

    /**
     * 文字列を置換するフォーマット
     */
    'formatters' => [
        'routes' => [
            // 一行メッセージ
            'message' => 'Message\MessageController@getIndex',
        ]
    ],

    /**
     * 管理画面のトップのパラメータ
     * カラム名     説明                値
     * menu_type   メニューの表示タイプ  1（店舗ブログ）, 2(スタッフブログ) , 3（スタッフ紹介）,  4（拠点選択フォーム）, 5 （ショールーム情報入力）
     *      6（店舗ブログ）, 7（一行メッセージ）, 8（本社承認店舗ブログ）、9（アクセスカウンターリンク）、10（拠点選択フォーム カスタム）
     * menu_name   メニュー名
     * menu_url　　メニューのリンク先URL
     * description 説明文
     */
    'admin_honsya_menu_para' => [
        '1006078' => [ // 東京
            ['menu_type' => 8, 'menu_name' => '拠点情報掲示板(承認待ち一覧)'],
            ['menu_type' => 1, 'menu_name' => '拠点情報掲示板(拠点別)'],
            ['menu_type' => 7, 'menu_name' => 'TOPページ1行メッセージ'],
            ['menu_type' => '', 'menu_name' => 'ボイスコレクター', 'menu_url' => 'https://secure.hondanet.co.jp/dealer_admin/form_admin.cgi?id=1006078'],
            ['menu_type' => '', 'menu_name' => 'DMデータアップロードツール', 'menu_url' => 'https://secure.hondanet.co.jp/cgi/grbbs3.cgi?id=hc-tokyo/upload',
                'description' => 'PW:hct_dm'],
        ],
        '8812391' => [ // 千葉
            ['menu_type' => 8, 'menu_name' => '拠点情報掲示板　新規掲載一覧', 'description' => '<a href="https://cgi3-aws.hondanet.co.jp/hcBbs/v2/admin/8812391/access-counter/count" target="_blank">情報掲示板店舗別集計ツール</a><br/><a href="https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count.cgi?id=8812391/infobbs" target="_blank">情報掲示板店舗別集計ツール（旧）</a>']
        ],
        '5104199' => [ // 北九州
            ['menu_type' => 8, 'menu_name' => '拠点情報掲示板　新規掲載一覧'],
            ['menu_type' => 1, 'menu_name' => '情報掲示板'],
        ],
        '1351901' => [ // 埼玉
            ['menu_type' => '', 'menu_name' => 'ネットオーダーシステム', 'menu_url' => 'http://cgi1.hondanet.co.jp/cgi/clio-saitama/NetOrder/admin/'],
            ['menu_type' => 1, 'menu_name' => 'ショールームだより', 'description' => '<a href="{BLOG_UPDATE_LOG_URL}" target="_blank">ショールームだより 更新状況表示</a>
                <a href="https://cgi3-aws.hondanet.co.jp/cgi/log_count_1351901i.cgi" target="_blank">ショールームだより 更新状況表示（旧）</a>
                <a href="{ACCESS_COUNTER_ONE_WEEK_URL}" target="_blank">アクセスランキング</a>
                <a href="http://cgi2.hondanet.co.jp/cgi/1351901/ranking/ranking.html" target="_blank">アクセスランキング（旧）</a>'],
            // ['menu_type' => 1, 'menu_name' => 'ショールームだより', 'description' => '<a href="https://cgi3-aws.hondanet.co.jp/cgi/log_count_1351901i.cgi" target="_blank">ショールームだより 更新状況表示</a><br><a href="http://cgi2.hondanet.co.jp/cgi/1351901/ranking/ranking.html" target="_blank">アクセスランキング</a>'],
            ['menu_type' => 4, 'menu_name' => '中古車在庫検索(新車拠点＆オートテラス店＆中古車センター用)', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1351901/usedcar&mode=admin', 'use_selector' => true],
            ['menu_type' => 5, 'menu_name' => 'ショールーム'],
            //['menu_type' => '', 'menu_name' => 'アウトレット／ショッピング', 'menu_url' => 'https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=hc-saitama/partsinfo&mode=admin'],
            ['menu_type' => 7, 'menu_name' => 'トップページお知らせ', 'use_selector' => false, 'role_check' => false]
            //['menu_type' => 3, 'menu_name' => 'スタッフパーソナルサイト(個人データ編集)'],
        ],
        '3751804' => [ // 岡山
            ['menu_type' => 8, 'menu_name' => '拠点情報掲示板(承認待ち一覧)'],
            ['menu_type' => 7, 'menu_name' => 'トップページ一行メッセージ', 'menu_url_auto' => 'routes.message', 'description' => '', 'role_check' => false]
        ],
        '1253025' => [ // 西千葉
            ['menu_type' => 8, 'menu_name' => 'Honda Cars 西千葉・拠点情報掲示板(承認待ち一覧)'],
            ['menu_type' => 1, 'menu_name' => 'Honda Cars 西千葉・拠点情報掲示板(拠点別)'],
            ['menu_type' => 7, 'menu_name' => 'Honda Cars 西千葉・トップページ一行メッセージ', 'menu_url_auto' => 'routes.message', 'description' => '', 'role_check' => false]
        ],
        '1081179' => [ // 東京西
            ['menu_type' => 7, 'menu_name' => 'トップページNEWS', 'menu_url_auto' => 'routes.message', 'description' => '', 'role_check' => false],
            ['menu_type' => '', 'menu_name' => 'ボイスコレクター', 'menu_url' => 'https://secure.hondanet.co.jp/dealer_admin/form_admin.cgi?id=1081179'],
        ],
    ],

    /**
     * APIのパラメータ
     * カラム名         説明        フォーマット
     * shop_exclusion  拠点の除外
     * post_url        掲載URL      {shop} -> 拠点コードに変換
     */
    'api_para' => [
        '8812502' => [ // 茨城南
            'shop_exclusion' => ['99', 'a1', 'nr', '15pre'], // 除外される店舗
            'post_url' => 'https://www.hondacars-ibarakiminami.co.jp/home/sr{shop}.html'
        ],
        '2153801' => [ // 愛知
            'post_url' => 'https://www.hondanet.co.jp/hondacars-aichi/home/sr{shop}.html',
        ],
        '8812391' => [ // 千葉
            'post_url' => 'https://www.hondacars-chiba.com/home/sr{shop}.html',
        ],
    ],

    /**
     * 記事データの自動削除用のパラメータ 毎日0:05にバッチを実行
     * カラム名      説明               値
     * table_name   削除するテーブル名  [販社コード]
     * key_column   キーになる日付      created_at( 作成日 ),  updated_at（ 最終更新日 )
     * timespan     削除するまでの期間  ○month, ○year
     * erace_method 削除方法           delete ( 削除データ用テーブルに移動 ), timelimit ( 掲載期間設定 )
     * 旧システムは grbbs. dataerace_master に保持している
     */
    'dataerase_para' => [
        ['table_name' => '1006078_infobbs', 'key_column' => 'updated_at', 'timespan' => '1year', 'erace_method' => 'delete'], // 東京
        ['table_name' => '1011801_infobbs', 'key_column' => 'updated_at', 'timespan' => '3month', 'erace_method' => 'delete'], // 東京中央
        ['table_name' => '1103901_infobbs', 'key_column' => 'updated_at', 'timespan' => '6month', 'erace_method' => 'delete'], // 横浜
        ['table_name' => '1453901_infobbs', 'key_column' => 'updated_at', 'timespan' => '2month', 'erace_method' => 'timelimit'], // 茨城
        ['table_name' => '1551801_infobbs', 'key_column' => 'updated_at', 'timespan' => '2month', 'erace_method' => 'timelimit'], // 栃木
        // ['table_name' => '1954117_infobbs', 'key_column' => 'updated_at', 'timespan' => '12month', 'erace_method' => 'delete'], // 新潟県央
        ['table_name' => '2153801_infobbs', 'key_column' => 'updated_at', 'timespan' => '3month', 'erace_method' => 'delete'], // 愛知
        // ['table_name' => '5151810_infobbs', 'key_column' => 'updated_at', 'timespan' => '3month', 'erace_method' => 'delete'], // 福岡/大分
        // ['table_name' => '5151810_staff', 'key_column' => 'updated_at', 'timespan' => '6month', 'erace_method' => 'delete'], // 福岡/大分
        ['table_name' => '8153883_infobbs', 'key_column' => 'updated_at', 'timespan' => '12month', 'erace_method' => 'delete'], // 福島
        ['table_name' => '8812391_infobbs', 'key_column' => 'updated_at', 'timespan' => '6month', 'erace_method' => 'timelimit'], // 千葉
        ['table_name' => '1655803_infobbs', 'key_column' => 'updated_at', 'timespan' => '1month', 'erace_method' => 'timelimit'], // 群馬中央
        // ['table_name' => '1785801_infobbs', 'key_column' => 'updated_at', 'timespan' => '1month', 'erace_method' => 'timelimit'], // 山梨/松本中央
        // ['table_name' => '1952803_infobbs', 'key_column' => 'updated_at', 'timespan' => '1month', 'erace_method' => 'timelimit'], // 新潟
        ['table_name' => '1351901_infobbs', 'key_column' => 'updated_at', 'timespan' => '5month', 'erace_method' => 'delete'], // 埼玉
        // ['table_name' => '5451801_infobbs', 'key_column' => 'updated_at', 'timespan' => '6month', 'erace_method' => 'timelimit'], // 長崎
        // ['table_name' => '5451801_staff', 'key_column' => 'updated_at', 'timespan' => '6month', 'erace_method' => 'timelimit'], // 長崎
    ],

];