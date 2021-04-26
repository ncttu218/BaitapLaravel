@include($templateDir . '.pagination')

@foreach ($showData as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
// 掲載番号
$number = str_replace('data', '', $item->number);
?>
<article>
    <div class="blog__header">
        <p class="blog__title">
            <a href="?number={{ $number }}" style="color: white;text-decoration: none;">
                <span>【{{ $shopName }}】</span>
                {{ $convertEmojiToHtmlEntity($item->title) }}
            </a>
        </p>
        <p class="blog__date">
            {{ date($timeFormat, strtotime($item->created_at)) }}
        </p>
    </div>
    <div class="blog__body">
        <div>
            <?php
            // 記事が改行が必要かの判定
            $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
            $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
            ?>
            @if ($hasNoBr)
              {!! nl2br( $item->comment ) !!}
            @else
              {!! $item->comment !!}
            @endif
            
            @include('api.common.api.infobbs.image_list_default')
            <div>
                <font> 
                </font> 
            </div>
        </div>
    </div>
</article>
@endforeach

@include($templateDir . '.pagination')
