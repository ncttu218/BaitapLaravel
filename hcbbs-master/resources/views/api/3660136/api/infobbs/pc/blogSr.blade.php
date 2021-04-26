
@if ($blogs->count() > 0)
{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
?>
<article>
    <a name="{{ $item->number }}"></a>
    <div class="blog__header">
        <p class="blog__title"><span>【{{ $item->base_name }}】</span>
            {{ $item->title }}</p>
        <p class="blog__date">
        <?php
        $time = strtotime($item->updated_at);
        if (!empty($item->from_date)) {
            $time = strtotime($item->from_date);
        }
        ?>
        {{ date('Y/m/d', $time) }}
        </p>
    </div>
    <div class="blog__body">
        @if ($item->pos == 2 || $item->pos == 1)
          {{-- ページネーションの読み込み --}}
          @include($templateDir . '.imagesSr')
        @endif
        @if ($item->pos == 0 || $item->pos == 1)
          <div style="float:left;">
        @else
          <div>
        @endif
            <p class="category"></p>
            <?php
            // 記事が改行が必要かの判定
            $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
            ?>
            @if ($hasNoBr)
              {!! nl2br( $item->comment ) !!}
            @else
              {!! $item->comment !!}
            @endif
        </div>
        @if ($item->pos != 2 && $item->pos != 1)
            {{-- ページネーションの読み込み --}}
            @include($templateDir . '.imagesSr')
        @endif
        <div>
            <font style="font-size:10px;">   
            </font> 
        </div>
        <div style="clear:both;">
            <table>
                <tbody>
                    @include($templateDir . '.commentSr')
                </tbody>
            </table>
        </div>
    </div>
</article>
@endforeach

<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

@else
ただいま準備中です。
@endif