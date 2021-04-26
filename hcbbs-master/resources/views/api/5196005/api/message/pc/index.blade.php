@if (!empty($title))
<?php
$title = $convertEmojiToHtmlEntity($title);
?>
<a class="p-index-information-item" href="{{ $url }}" target="{{ $url_target }}">
    <div class="p-index-information-item__head">PICKUP</div>
    <div class="p-index-information-item__body">{{ $title }}</div>
</a>
@endif
