@foreach ($showData as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
// 掲載番号
$number = str_replace('data', '', $item->number);
?>
<a class="p-index-information-link" href="/hondacars-nagahama/home/information.html">
    <div class="p-index-information-link__head">お知らせ</div>
    <div class="p-index-information-link__date">{{ date($timeFormat, strtotime($item->created_at)) }}</div>
    <div class="p-index-information-link__body">{{ $convertEmojiToHtmlEntity($item->title) }}</div>
    <div class="p-index-information-link__more">More</div>
</a>
@endforeach
