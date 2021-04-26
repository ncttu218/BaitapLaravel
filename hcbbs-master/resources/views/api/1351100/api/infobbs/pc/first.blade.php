<article>
<div class="blog__header">
  <p class="blog__title"><span>【{{ $shopName }}】</span>{{ $blog->title }}</p>
  <p class="blog__date">{{ date('Y/m/d', strtotime($blog->created_at)) }}</p>
</div>
<div class="blog__body">
    <?php
    // 記事が改行が必要かの判定
    $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $blog->comment);
    ?>
    @if ($hasNoBr)
      {!! nl2br( $blog->comment ) !!}
    @else
      {!! $blog->comment !!}
    @endif

    <?php
      $imgFiles = [];

      // 1 ?? 3 ?????? ??????????????????????
      for( $i=1; $i<= 3; $i++ ){
        $imgFiles[$i]['file'] = $blog->{'file' . $i};
        $imgFiles[$i]['caption'] = $blog->{'caption' . $i};
      }
      ?>

      {{-- ?????????????????????? --}}
      @if( !empty( $imgFiles ) == True )
        
        <div>
          <font> 
            {{-- ??????????? --}}
            @for( $i=1; $i<= 3; $i++ )
              @if( !empty( $imgFiles[$i]['file'] ) == True )
                <br>
                <a href="{{ $imgFiles[$i]['file'] }}"  target="_blank">
                  <img src="{{ $imgFiles[$i]['file'] }}" width="160" border=0  f7>
                </a>
                <p>{{ $imgFiles[$i]['caption'] }}</p>
              @endif
            @endfor
          </font> 
        </div>
      @endif
</div>
</article>
