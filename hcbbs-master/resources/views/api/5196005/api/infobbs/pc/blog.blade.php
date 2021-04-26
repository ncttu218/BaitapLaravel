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
   <div class="blog__header">
      <p class="blog__title"><span>【{{ $item->base_name }}】</span>
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
      <div>
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
      <div>
         <font style="font-size:10px;">   
         </font> 
      </div>
      <div style="clear:both;">
         @include($templateDir . '.comment')
      </div>
   </div>
</article>

@endforeach
<!-- ZERO END -->

{{-- ページネーション --}}
@include($templateDir . '.pagination')
