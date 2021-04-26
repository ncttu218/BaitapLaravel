<?php
$url = $showData->url;
$urlTarget = $showData->url_target == '0' ? ' target=_blank' : '';
$infoDate = !empty($showData->from_date) ? $showData->from_date : $showData->created_at;
$infoDate = date('Y.m.d', strtotime($infoDate));
?>
@if (!empty($url))
<a href="{{ $url }}" class="p-top-information-link"{{ $urlTarget }}>
@endif
    <div class="p-top-information__inner">
        <span class="c-icon">
            <img src="/20200512-home/img/top/icon_message.png">
        </span>
        <time class="p-top-information__date">{{ $infoDate }}</time>
        <p class="p-top-information__text">{{ $showData->title }}</p>
    </div>
@if (!empty($url))
</a>
@endif
