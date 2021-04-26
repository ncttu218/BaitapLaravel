@foreach ( $staffs as $row )
<?php
// サムネール画像
if (!empty($row->photo)) {
    $imageUrl = asset_auto($row->photo);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}

// スタッフ番号
$number = substr($row->number, 4);
// スタッフブログURL
$url = "staff.html?shop={$shopCode}&staff={$number}";
?>
<article class="p-st-blog-list-article">
    <a href="{{ $url }}" class="p-st-blog-list-article__target">
        <div class="p-st-blog-list-article__picture">
            <div class="p-st-blog-list-article__image" style="background-image: url('{{ $imageUrl }}');"></div>
        </div>
        <div class="p-st-blog-list-article__inner">
            <h3 class="p-st-blog-list-article__staff">
                {{ $row->name }}
            </h3>
            <span class="p-st-blog-list-article__job">{{ $row->pos }}</span>
        </div>
    </a>
</article>
@endforeach