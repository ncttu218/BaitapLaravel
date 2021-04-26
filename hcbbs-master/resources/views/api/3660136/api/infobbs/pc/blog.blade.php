@if ($blogs->count() > 0)
{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
// 記事番号
$item->number = str_replace('data', '', $item->number);
?>
<a href="blog{{ $item->shop }}.{{ $item->number }}.html" class="blog__header">
    <p class="blog__title"><span>【{{ $item->base_name }}】</span>
        {{ $item->title }}</p>
    <p class="blog__date">
    <?php
        $time = strtotime($item->updated_at);
        if (!empty($item->from_date)) {
            $time = strtotime($item->from_date);
        }
    ?>
    {{ date('Y/m/d', $time) }}
    </p>
</a>
@endforeach

<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

@else
ただいま準備中です。
@endif
