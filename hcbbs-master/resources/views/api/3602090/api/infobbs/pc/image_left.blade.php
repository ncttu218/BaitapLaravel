{{-- 定形画像が入力されていれば、画面に出力する。 --}}
<td valign="top" bgcolor="#FFFFFF"> 
    <table border="0" cellspacing="0" cellpadding="1">
        <tbody>
            <tr valign="bottom"> 
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                <?php
                $file = $imgFiles[$i]['file'] ?? '';
                ?>
                  @if( !empty( $file ) == True )
                    <td bgcolor="#FFFFFF">
                        <font style="font-size:10px;">
                        <br>
                        <a href="{{ url_auto( str_replace('thumb/thu_', '', $file) ) }}" target="_blank">
                            <img src="{{ url_auto( $file ) }}" width="200" border="0" f7="">
                        </a>
                        </font>
                    </td>
                  @else
                    <td bgcolor="#FFFFFF">
                        <font style="font-size:10px;"></font>
                    </td>
                  @endif
                @endfor
                </td>
            </tr>
            <tr>
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                    {{-- 画像の説明文が存在するとき --}}
                    @if( !empty( $imgFiles[$i]['caption'] ) == True )
                        <td valign="top" bgcolor="#FFFFFF">
                            <font style="font-size:10px;"> 
                            <br>{!! $imgFiles[$i]['caption'] !!}</font>
                        </td>
                    @else
                        <td valign="top" bgcolor="#FFFFFF">
                            <font style="font-size:10px;"></font>
                        </td>
                    @endif
                @endfor
            </tr>
        </tbody>
    </table>
</td>
