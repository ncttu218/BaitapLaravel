<?php
// サムネール画像
if (!empty($shopInfo->file)) {
    $imageUrl = asset_auto($shopInfo->file);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}
?>
<div class="p-sr-profile-info__thumb">
    <img src="{{ $imageUrl }}" alt="">
</div>
<p class="p-sr-profile-info__comment">
    {!! nl2br($shopInfo->comment) !!}
</p>
