{{-- 定形画像が入力されていれば、画面に出力する。 --}}
<td valign="top" align="right" bgcolor="#FFFFFF">
    <font style="font-size:10px;">
    @for( $i=1; $i<= 3; $i++ )
    <?php
    $file = $imgFiles[$i]['file'] ?? '';
    ?>
      @if( !empty( $file ) == True )
            <br>
            <a href="{{ url_auto( str_replace('thumb/thu_', '', $file) ) }}" target="_blank">
                <img src="{{ url_auto( $file ) }}" width="200" border="0" f7="">
                {{-- 画像の説明文が存在するとき --}}
                @if( !empty( $imgFiles[$i]['caption'] ) == True )
                    <br>{!! $imgFiles[$i]['caption'] !!}
                @endif
            </a>
      @endif
    @endfor
    </font>
</td>
