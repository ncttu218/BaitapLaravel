<?php
if (isset($shopInfo->file_master) && !empty($shopInfo->file_master)) {
    if (preg_match('/^[^\/]+$/', $shopInfo->file_master)) {
        $imageUrl = "https://cgi3-aws.hondanet.co.jp/cgi/{$hanshaCode}/shop/data/image/{$shopInfo->file_master}";
    } else {
        if (strstr($shopInfo->file_master, 'data/image/' . $hanshaCode)) {
            $imageUrl = asset_auto( $shopInfo->file_master );
        } else {
            $imageUrl = asset_auto( 'data/image/' . $hanshaCode . '/' . $shopInfo->file_master );
        }
    }
} else {
    $imageUrl = asset_auto('img/no_image.gif');
}
?>
<p>
    <img src="{{ $imageUrl }}" align="left" class="cgi031">
    <font color="blue" size="5">
        {!! nl2br($shopInfo->comment) !!}
    </font>
</p>

<font size="3">
    <div align="right">{{ $shopName ?? '' }} 店長<br>
        <div style="display:none;">文字化け対策</div>
        {{ $shopInfo->mastername }}
    </div>
</font>
