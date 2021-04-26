<?php
// 販社名の設定パラメータを取得
$para_list = ( config('original.para')[$hanshaCode] );
?>
<section class="c-section-container _both-space _bg-gray">
  <header class="c-section-header">
    <h2 class="c-section-header__title">
      <span class="en">STAFF BLOG</span>
      <span class="ja">スタッフブログ</span>
    </h2>
  </header>
  <div class="c-section-inner">
    {{-- ページネーションの読み込み --}}
    @include($templateDir . '.pagination')
    
    {{-- 記事データが存在するとき --}}
    @foreach ($blogs as $item)
      <a name="{{ $item->number }}"></a>
      <article>
        <div class="blog__header">
          <p class="blog__title">{{ $convertEmojiToHtmlEntity($item->title) }}</p>
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
            @if ($containsData)
                <div style="float:left;">
            @else
                <div>
            @endif
            <?php
            // 記事が改行が必要かの判定
            $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
            $item->comment = $convertEmojiToHtmlEntity($item->comment);
            ?>
            @if ($hasNoBr)
              {!! nl2br( $item->comment ) !!}
            @else
              {!! $item->comment !!}
            @endif
          </div>
            
          {{-- 定形画像が入力されていれば、画面に出力する。 --}}
            @if( $containsData )

              <div style="float:left;">
                <font style="font-size:10px;"> 
                  {{-- 定形画像の数分繰り返す --}}
                  @for( $i=1; $i<= 3; $i++ )
                    @if( !empty( $imgFiles[$i]['file'] ) == True )
                      <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
                        <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="180" border=0  f7>
                      </a>
                      {{-- 画像の説明文が存在するとき --}}
                      @if( !empty( $imgFiles[$i]['caption'] ) == True )
                        {{ $imgFiles[$i]['caption'] }}
                      @endif
                    @endif
                  @endfor
                </font> 
              </div>
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
      {{-- ページネーションの読み込み --}}
      @include($templateDir . '.pagination')
  </div>
</section>