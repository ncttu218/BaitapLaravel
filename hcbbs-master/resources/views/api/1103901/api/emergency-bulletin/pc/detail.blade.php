<?php
// タイトルの文字変換
$showData->title = $convertEmojiToHtmlEntity($showData->title);
// 本文の文字変換
$showData->comment = $convertEmojiToHtmlEntity($showData->comment);
?>
<article>
    <div class="blog__header">
        <p class="blog__title">
            <span>【{{ $shopName }}】</span>
            {{ $convertEmojiToHtmlEntity($showData->title) }}
        </p>
        <p class="blog__date">
            {{ date($timeFormat, strtotime($showData->created_at)) }}
        </p>
    </div>
    <div class="blog__body">
        <div>
            <?php
            // 記事が改行が必要かの判定
            $showData->comment = str_replace('[NOW_TIME]', time(), $showData->comment);
            $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $showData->comment);
            ?>
            @if ($hasNoBr)
              {!! nl2br( $showData->comment ) !!}
            @else
              {!! $showData->comment !!}
            @endif
            
            @include('api.common.api.infobbs.image_list_default')
            <div>
                <font> 
                </font> 
            </div>
        </div>
    </div>
</article>
