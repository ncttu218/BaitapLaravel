<?php
// 販社名の設定パラメータを取得
$para_list = ( config('original.para')[$hanshaCode] );
?>
<script language="JavaScript" src="/common-js/opendcs.js"></script>
{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<a name="{{ $item->number }}"></a>
<article>
   <div class="blog__header">
      <p class="blog__title"><span>【{{ $item->base_name }}】</span>
         {{ $convertEmojiToHtmlEntity($item->title) }}
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
        {{-- ページネーションの読み込み --}}
        @include('api.common.api.infobbs.image_list_default')

        {!! $convertEmojiToHtmlEntity($item->comment) !!}
      </div>
      <div>
         <font style="font-size:10px;">   
         </font> 
      </div>
      <div style="clear:both;">
         {{-- コメント --}}
         @include($templateDir . '.comment')
      </div>
   </div>
</article>
@endforeach
<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')