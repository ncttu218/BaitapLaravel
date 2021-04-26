<style>
.blog__body b,
.blog__body strong {
  font-weight: bold;
}
.blog__body h1 {
	display: block;
    font-size: 2em;
    margin-block-start: 0.67em;
    margin-block-end: 0.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
.blog__body h2 {
    display: block;
    font-size: 1.5em;
    margin-block-start: 0.83em;
    margin-block-end: 0.83em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
.blog__body h3 {
    display: block;
    font-size: 1.17em;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
.blog__body h4 {
    display: block;
    margin-block-start: 1.33em;
    margin-block-end: 1.33em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
.blog__body h5 {
    display: block;
    font-size: 0.83em;
    margin-block-start: 1.67em;
    margin-block-end: 1.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
.blog__body h6 {
    display: block;
    font-size: 0.67em;
    margin-block-start: 2.33em;
    margin-block-end: 2.33em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
.blog__body pre {
    display: block;
    font-family: monospace;
    white-space: pre;
    margin: 1em 0px;
}
</style>

{{-- 記事データが存在するとき --}}
@if (count($blogs) > 0)
@foreach ($blogs as $item)
<?php
  // タイトル
  $item->title = $convertEmojiToHtmlEntity($item->title);
  // 本文
  $item->comment = $convertEmojiToHtmlEntity($item->comment);
  // 拠点名
  $item->base_name = trim($item->base_name);
?>
<article>
    <div class="blog__header">
      <p class="blog__title">{{ $item->title }}</p>
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
      {{-- 右側(縦並び) --}}
      @if( $item->pos === "0" )
          <div style="float:left">
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
          </div>
          <div style="float:right">
              @include($templateDir . '.image_list')
          </div>
          <div style="clear:both;">
          </div>
      
      {{-- 左側(縦並び) --}}
      @elseif( $item->pos === "1" )
          <div style="float:left; min-width: 250px;">
              @include($templateDir . '.image_list')
          </div>
          <div style="float:left">
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
          </div>
          <div style="clear:both;">
          </div>

      {{-- 上側(横並び) --}}
      @elseif( $item->pos === "2" )
          <div>
              @include($templateDir . '.image_list')
          </div>
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
          </div>
          <div style="clear:both;">
          </div>
      {{-- 下側(横並び) --}}
      @else
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
          </div>
          <div>
              @include($templateDir . '.image_list')
          </div>
          <div style="clear:both;">
          </div>
      @endif
    </div>
</article>
@endforeach
@else
ただいま準備中です。
@endif
<!-- ZERO END -->
