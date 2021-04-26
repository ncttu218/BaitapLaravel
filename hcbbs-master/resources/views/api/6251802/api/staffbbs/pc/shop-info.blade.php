<?php
// サムネール画像
if (!empty($shopInfo->file)) {
    $imageUrl = asset_auto($shopInfo->file);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}
?>
<div class="staff-photo__img">
    <img src="{{ $imageUrl }}" alt="写真">
</div>
<div class="staff-photo__comment">
    {{ $shopInfo->comment }}
</div>
