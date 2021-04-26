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
{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// タイトル
$item->title = $convertEmojiToHtmlEntity($item->title);
// 店舗ID
$alias = $shopInfo[$item->shop]['alias'] ?? '';
// サムネール画像
$thumbImage = $getThumbnail($item);
?>
<article class="wow slideInRight" style="visibility: visible; animation-name: slideInRight;">
    <a href="/site/164_info_{{ $alias }}.html?:{{ str_replace('data', '', $item->number) }}">
        <figure><img src="{{ $thumbImage }}" /></figure>
        <div class="blog_detail">
            <p class="blog_ttl">
                <i><img src="img/icon_blog.png" /></i>{{ $convertEmojiToHtmlEntity($item->title) }}
            </p>
        </div>
    </a>
</article>
@endforeach
{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
