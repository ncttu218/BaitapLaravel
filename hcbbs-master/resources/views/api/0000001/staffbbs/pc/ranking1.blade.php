{{-- 記事データが存在するとき --}}
@foreach ($ranking as $i => $item)
<?php
// ランキング番号の英語文字
$suffix = 'th';
$number = $item['ranking'] . '';
$lastDigit = $number[strlen($number) - 1];
if ($lastDigit == '1' && $number != '11') {
    $suffix = 'st';
} else if ($lastDigit == '2' && $number != '12') {
    $suffix = 'nd';
} else if ($lastDigit == '3' && $number != '13') {
    $suffix = 'rd';
}

// サムネール画像
if (!empty($item['staff_photo'])) {
    $imageUrl = asset_auto($item['staff_photo']);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}

// 日付
$time = strtotime($item['blog']->updated_at);

// スタッフブログURL
$url = "home/staff.html?shop={$item['shop_code']}&staff={$item['staff_code']}";
?>
<article class="p-top-blog-article">
    <div class="p-top-blog-ranking-num"><span>{{ $item['ranking'] }}</span>{{ $suffix }}</div>
    <a href="{{ $url }}" class="p-top-blog-article__target">
        <div class="p-top-blog-article__picture">
            <div class="p-top-blog-article__image" style="background-image: url('{{ $imageUrl }}');"></div>
        </div>
        <div class="p-top-blog-article__inner">
            <h3 class="p-top-blog-article__staff">{{ $item['staff_name'] }}</h3>
            <span class="p-top-blog-article__job">{{ $item['staff_position'] }}</span>
            <h4 class="p-top-blog-article__title">{{ $item['blog'] !== null ? $item['blog']->title : '無し' }}</h4>
        </div>

        <div class="p-top-blog-article__info">
            <h4 class="p-top-blog-article__shop">{{ $item['shop_name'] }}</h4>
            <time class="p-top-blog-article__date">{{ $item['blog'] !== null ? date('Y.m.d', $time) : '無し' }}</time>
        </div>
    </a>
</article>
@endforeach