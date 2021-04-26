@if ($item->pos == 2 || $item->pos == 3)
  <div>
@else
  <div style="float:left;">
@endif
    <font style="font-size:10px;"> 
      {{-- 定形画像の数分繰り返す --}}
      @for( $i=1; $i<= 3; $i++ )
        @if( !empty( $imgFiles[$i]['file'] ) && 
            !preg_match('/,file_del$/', $imgFiles[$i]['file']) )
          <br>
          <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
            <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
          </a>
          <br>
          {{-- 画像の説明文が存在するとき --}}
          @if( !empty( $imgFiles[$i]['caption'] ) == True )
            {{ $imgFiles[$i]['caption'] }}
          @endif
        @endif
      @endfor
    </font> 
</div>