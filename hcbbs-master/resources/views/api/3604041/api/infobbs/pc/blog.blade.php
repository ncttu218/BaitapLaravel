<script language="JavaScript" src="/common-js/opendcs.js"></script>

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
?>
<article>
    {{-- タイトル --}}
    <div class="blog__header">
        <p class="blog__title">
            <span>【{{ $item->base_name }}】</span>
            {{ $item->title }}
        </p>
      {{-- 掲載日時 --}}
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
    {{-- 本文 --}}
    <div class="blog__body">
        <?php
      // 記事が改行が必要かの判定
      $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
      ?>
      @if ($hasNoBr)
        {!! nl2br( $item->comment ) !!}
      @else
        {!! $item->comment !!}
      @endif
      
      {{-- 画像 --}}
      @include($templateDir . '.image')
    </div>
</article>
@endforeach

<!-- ZERO END -->
{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')