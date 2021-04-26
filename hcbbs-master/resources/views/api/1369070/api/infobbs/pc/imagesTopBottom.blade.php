{{-- 定形画像が入力されていれば、画面に出力する。 --}}
@if( $containsData )
<tr>
  <td valign="top" bgcolor="#FFFFFF" colspan="3">
      <table border="0" cellspacing="0" cellpadding="1">
          <tbody>
              <tr valign="bottom">
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                  <td bgcolor="#FFFFFF">
                      <font style="font-size: 10px;">
                      @if( !empty( $imgFiles[$i]['file'] ) == True )
                        <?php
                        // ファイルパスの情報を取得する
                        $fileinfo = pathinfo( $imgFiles[$i]['file'] );
                        ?>
                        <br />
                        <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
                          {{-- PDFファイルの対応 --}}
                          @if( strtolower( $fileinfo['extension'] ) === "pdf" )
                            <img src="{{ $CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] ) }}" style="width: 160px;" border="0" f7="" />
                          @else
                            <img src="{{ url_auto( $imgFiles[$i]['thumb'] ) }}" style="width: 160px;" border="0" f7="" />
                          @endif
                        </a>
                      @endif
                      </font>
                  </td>
                @endfor
              </tr>
              <tr align="left">
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                  <td valign="top" bgcolor="#FFFFFF" class="SE-w160">
                      <font style="font-size: 10px;">
                        @if( !empty( $imgFiles[$i]['file'] ) == True )
                          <br />
                          {{-- 画像の説明文が存在するとき --}}
                          @if( !empty( $imgFiles[$i]['caption'] ) == True )
                            {!! $imgFiles[$i]['caption'] !!}
                          @endif
                        @endif
                      </font>
                  </td>
                @endfor
              </tr>
          </tbody>
      </table>
  </td>
</tr>
@endif
