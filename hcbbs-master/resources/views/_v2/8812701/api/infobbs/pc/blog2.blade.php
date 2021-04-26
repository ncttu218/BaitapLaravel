<?php
// 販社名の設定パラメータを取得
$para_list = ( config('original.para')[$hanshaCode] );
// 店舗除外
$categoryCounterOptions = [ 'shopExclusion' => $shopExclusion ];

$autoLinkUrls = function ($str, $popup = true) {
    if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))([\w]+[^\s\)\<]+)#i", $str, $matches)){
        $pop = ($popup == true) ? " target=\"_blank\" " : "";
        for ($i = 0; $i < count($matches['0']); $i++){
            $period = '';
            if (preg_match("|\.$|", $matches['6'][$i])){
                $period = '.';
                $matches['6'][$i] = substr($matches['6'][$i], 0, -1);
            }
            $str = str_replace($matches['0'][$i],
                    $matches['1'][$i].'<a href="http'.
                    $matches['4'][$i].'://'.
                    $matches['5'][$i].
                    $matches['6'][$i].'"'.$pop.'>http'.
                    $matches['4'][$i].'://'.
                    $matches['5'][$i].
                    $matches['6'][$i].'</a>'.
                    $period, $str);
        }
    }
    return $str;
};
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
      <?php
        $imgFiles = [];

        // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
        $containsData = false;
        for( $i=1; $i<= 3; $i++ ){
          $fileNumber = $i;
          if (!isset($item->{'file' . $i})) {
              if ($i == 1 && isset($item->file)) {
                  $fileNumber = '';
              } else {
                continue;
              }
          }
          $imgFiles[$i]['file'] = $item->{'file' . $fileNumber};
          $imgFiles[$i]['caption'] = $item->{'caption' . $fileNumber};

          // データがあるかの確認
          if (!$containsData) {
            $containsData = !empty($imgFiles[$i]['file']) ||
                    !empty($imgFiles[$i]['caption']);
          }
        }
      ?>
      @if ($item->pos == 1 || $item->pos == 2)
        {{-- ページネーションの読み込み --}}
        @include($templateDir . '.attachedImages')
      @endif
      @if ($containsData && $item->pos != 2 && $item->pos != 3)
        <div style="float:left;">
      @else
        <div>
      @endif
      
      <?php
        // 記事が改行が必要かの判定
        $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
        $item->comment = $convertEmojiToHtmlEntity($item->comment);
        $item->comment = $autoLinkUrls($item->comment);
        ?>
        @if ($hasNoBr)
          <?php
          ?>
          {!! nl2br( $item->comment ) !!}
        @else
          {!! $item->comment !!}
      @endif
        
      </div>
      @if ($item->pos == 0 || $item->pos == 3)
        {{-- ページネーションの読み込み --}}
        @include($templateDir . '.attachedImages')
      @endif
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
@include($templateDir . '.pagination2')