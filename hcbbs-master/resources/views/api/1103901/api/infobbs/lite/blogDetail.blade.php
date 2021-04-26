<?php
// タイトルの文字変換
$blog->title = $convertEmojiToHtmlEntity($blog->title);
// 本文の文字変換
$blog->comment = $convertEmojiToHtmlEntity($blog->comment);
// 掲載番号
$number = str_replace('data', '', $blog->number);
?>
<article>
    <div class="blog__header">
        <p class="blog__title">
            <span>【{{ $blog->base_name }}】</span>
            {{ $blog->title }}
        </p>
        <p class="blog__date">
            {{ date('Y/m/d', strtotime($blog->updated_at)) }}
        </p>
    </div>
    <div class="blog__body">
        <div>
            <?php
            // 記事が改行が必要かの判定
            $blog->comment = str_replace('[NOW_TIME]', time(), $blog->comment);
            $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $blog->comment);
            ?>
            @if ($hasNoBr)
              {!! nl2br( $blog->comment ) !!}
            @else
              {!! $blog->comment !!}
            @endif
            
            @include('api.common.api.infobbs.image_list_default', ['item' => $blog])
            <div>
                <font> 
                </font> 
            </div>
        </div>
    </div>
    @include($templateDir . '.shareboxDetail')
</article>
