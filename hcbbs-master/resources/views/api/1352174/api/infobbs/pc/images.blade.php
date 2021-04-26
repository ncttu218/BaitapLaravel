{{-- 定形画像が入力されていれば、画面に出力する。 --}}
@if( $containsData )
@if ($item->pos == '2' || $item->pos == '3')
<tr>
@endif
  <td valign="top" bgcolor="#FFFFFF" colspan="3">
      <table border="0" cellspacing="0" cellpadding="1">
          <tbody>
              <tr valign="bottom">
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                  <td bgcolor="#FFFFFF">
                      <font style="font-size: 10px;">
                      @if( !empty( $imgFiles[$i]['file'] ) == True )
                          <br />
                          <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}" target="_blank">
                              <img src="{{ url_auto( $imgFiles[$i]['thumb'] ) }}" style="width: 150px;" border="0" f7="" />
                          </a>
                      @endif
                      </font>
                  </td>
                @endfor
              </tr>
              <tr align="left">
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                  <td valign="top" bgcolor="#FFFFFF" class="SE-w150">
                      <font style="font-size: 10px;">
                        @if( !empty( $imgFiles[$i]['file'] ) == True )
                          <br />
                          {{-- 画像の説明文が存在するとき --}}
                          @if( !empty( $imgFiles[$i]['caption'] ) == True )
                            {{ $imgFiles[$i]['caption'] }}
                          @endif
                        @endif
                      </font>
                  </td>
                @endfor
              </tr>
          </tbody>
      </table>
  </td>
@if ($item->pos == '2' || $item->pos == '3')
</tr>
@endif
@endif
