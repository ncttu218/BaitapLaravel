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
        @include('api.common.api.infobbs.image_list_default')
        
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
</article>
@endforeach
@else
ただいま準備中です。
@endif
<!-- ZERO END -->
