<?php
// タイトルの文字変換
$blog->title = $convertEmojiToHtmlEntity($blog->title);
// 本文の文字変換
$blog->comment = $convertEmojiToHtmlEntity($blog->comment);
?>
<article>
    <a name="{{ $blog->number }}"></a>
    <div class="blog__header">
        <p class="blog__title"><span>【{{ $blog->base_name }}】</span>
            {{ $blog->title }}</p>
        <p class="blog__date">
        <?php
        $time = strtotime($blog->updated_at);
        if (!empty($blog->from_date)) {
            $time = strtotime($blog->from_date);
        }
        ?>
        {{ date('Y/m/d', $time) }}
        </p>
    </div>
    <div class="blog__body">
        @if ($blog->pos == 2 || $blog->pos == 1)
          {{-- ページネーションの読み込み --}}
          @include($templateDir . '.images')
        @endif
        @if ($blog->pos == 0 || $blog->pos == 1)
          <div style="float:left;">
        @else
          <div>
        @endif
            <p class="category"></p>
            <?php
            // 記事が改行が必要かの判定
            $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $blog->comment);
            ?>
            @if ($hasNoBr)
              {!! nl2br( $blog->comment ) !!}
            @else
              {!! $blog->comment !!}
            @endif
        </div>
        @if ($blog->pos != 2 && $blog->pos != 1)
            {{-- ページネーションの読み込み --}}
            @include($templateDir . '.images')
        @endif
        <div>
            <font style="font-size:10px;">   
            </font> 
        </div>
        <div style="clear:both;">
            <table>
                <tbody>
                    @include($templateDir . '.comment')
                </tbody>
            </table>
        </div>
    </div>
</article>