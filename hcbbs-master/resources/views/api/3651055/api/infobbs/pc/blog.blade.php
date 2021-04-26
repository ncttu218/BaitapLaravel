@if ($blogs->count() > 0)
<script language="JavaScript" src="/common-js/opendcs.js"></script>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
?>
<article>
    <div class="blog__header">
      <p class="blog__title">
          <span>【{{ $item->base_name }}】</span>
          {{ $item->title }}
      </p>
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
        @include($templateDir . '.attachedImages')
      @endif
      @if ($item->pos == 0 || $item->pos == 1)
        <div style="float:left;">
      @else
        <div>
      @endif
            <?php
            // 記事が改行が必要かの判定
            $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
            $hasHtml = preg_match('/<.+?>[\w\W]*?<\/.+?>/', $item->comment);
            ?>
            @if (!$hasHtml)
                {!! nl2br( $item->comment ) !!}
            @else
                <?php
                $item->comment = preg_replace('/<\/em>[\r\n]{2}<em>/', "</em>\n<em>", $item->comment);
                $item->comment = preg_replace('/<\/em>[\r\n]{2}<img/', "</em>\n<img", $item->comment);
                ?>
                {!! $item->comment !!}
            @endif
      </div>
      @if ($item->pos != 2 && $item->pos != 1)
          {{-- ページネーションの読み込み --}}
          @include($templateDir . '.attachedImages')
      @endif
      <div>
      <font style="font-size:10px;"></font> 
      </div>
      <div style="clear:both;">
      <table><tbody><tr><td align="left" valign="middle">
     <div class="hakusyu font10">
     <p></p>
     </div>
     </td></tr></tbody></table>
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