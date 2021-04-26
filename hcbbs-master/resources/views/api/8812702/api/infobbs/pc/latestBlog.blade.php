<?php
// 店舗ID一覧
$shopInfo = [
    '01' => [
        'alias' => 'amakawaohshima',
        'image' => 'site/img/top_s01.png',
    ],
    '02' => [
        'alias' => 'aramaki',
        'image' => 'site/img/top_s02.png',
    ],
    '03' => [
        'alias' => 'kiryuhirosawa',
        'image' => 'site/img/top_s03.png',
    ],
    '04' => [
        'alias' => 'ohtanishiyajima',
        'image' => 'site/img/top_s04.png',
    ],
    '70' => [
        'alias' => 'uselect',
        'image' => 'site/img/top_s05.png',
    ],
    'aa' => [
        'alias' => 'maebashibodycenter',
        'image' => 'site/img/top_s07.png',
    ],
    '90' => [
        'alias' => 'honsha',
        'image' => 'site/img/top_s06.png',
    ],
];
?>
<div id="top_message">
    <!-- アイコン：キャンペーン home/img/top_info_mr1.png　 -->
    <!-- アイコン：新車 home/img/top_info_mr2.png　 -->
    <!-- アイコン：おしらせ、インフォメーション home/img/top_info_mr3.png　 -->
    @foreach ($blogs as $item)
    <?php
    // 店舗ID
    $shopId = $shopInfo[$item->shop]['alias'] ?? '';
    // 画像
    $image = $shopInfo[$item->shop]['image'] ?? '';
    // 新しい記事のフラグ
    $isNew = $isNewBlog( $item->updated_at );
    // 本文
    $maxLength = 25;
    $content = $item->comment;
    $content = strip_tags($content);
    $content = trim($content);
    $content = str_replace('&nbsp;', ' ', $content);
    $content = html_entity_decode($content);
    if (strlen($content) > $maxLength) {
        $content = mb_substr($content, 0, $maxLength, 'utf-8') . '...';
    }
    $content = $convertEmojiToHtmlEntity($content);
    ?>
    <!-- 天川大島中央店ここから -->
    <dl class="top_message1">
        <dt class="top_message2">
            <?php
                $time = strtotime($item->updated_at);
                if (!empty($item->from_date)) {
                    $time = strtotime($item->from_date);
                }
            ?>
            {{ date('Y.m.d', $time) }}
        </dt>
        <dd>
            <p class="top_message3"><img src="{{ $image }}" /></p>
            <p class="top_message4">
                <a href="site/164_info_{{ $shopId }}.html">{{ $content }}</a>
            </p>
            <p class="top_message5">
                @if ($isNew)
                <img src="site/img/top_new.gif" width="27" height="27">
                @endif
            </p>
        </dd>
    </dl>
    <p class="clear"></p>
    <!--  //天川大島中央店ここまで -->
    @endforeach
</div>
