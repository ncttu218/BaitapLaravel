{{-- 記事データが存在するとき --}}
@foreach ($blogs as $i => $item)
<?php
// サムネール画像
if (!empty($item->staff_photo)) {
    $imageUrl = asset_auto($item->staff_photo);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}

// スタッフ番号
$number = substr($item->staff_code, 4);
// スタッフブログURL
$url = "staff.html?shop={$item->shop}&staff={$number}";
?>
<article class="p-st-blog-list-article">
    <a href="{{ $url }}" class="p-st-blog-list-article__target">
        <div class="p-st-blog-list-article__picture">
            <div class="p-st-blog-list-article__image" style="background-image: url('{{ $imageUrl }}');"></div>
        </div>
        <div class="p-st-blog-list-article__inner">
            <h3 class="p-st-blog-list-article__staff">{{ $item->staff_name }}</h3>
            <span class="p-st-blog-list-article__job">{{ $item->staff_position }}</span>
            <h4 class="p-st-blog-list-article__title">{{ $item->title }}</h4>
        </div>

        <div class="p-st-blog-list-article__info">
            <h4 class="p-st-blog-list-article__shop">{{ $item->base_name }}</h4>
            <time class="p-st-blog-list-article__date">{{ date('Y.m.d', strtotime($item->updated_at)) }}</time>
        </div>
    </a>
</article>
@endforeach