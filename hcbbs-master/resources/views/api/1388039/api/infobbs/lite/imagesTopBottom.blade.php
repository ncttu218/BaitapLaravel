{{-- 定形画像が入力されていれば、画面に出力する。 --}}
@if( $containsData )
<tr>
  <td valign="top" bgcolor="#FFFFFF">
      <table border="0" cellspacing="0" cellpadding="1">
          <tbody>
              <tr valign="bottom">
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                @if( !isset( $imgFiles[$i]['file'] ) )
                  @continue
                @endif
                  <td bgcolor="#FFFFFF">
                      <font style="font-size: 10px;">
                      @if( !empty( $imgFiles[$i]['file'] ) == True )
                          @if ($i === 1)
                            <font style="font-size:8px;">画像をクリックすると拡大表示できます</font>
                          @endif
                          <?php
                          // ファイルパスの情報を取得する
                          $fileinfo = pathinfo( $imgFiles[$i]['file'] );
                          ?>
                          <br />
                          <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
                            {{-- PDFファイルの対応 --}}
                            @if( strtolower( $fileinfo['extension'] ) === "pdf" )
                              <img src="{{ $CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] ) }}" style="width: 200px;" border="0" f7="" />
                            @else
                              <img src="{{ url_auto( $imgFiles[$i]['thumb'] ) }}" style="width: 200px;" border="0" f7="" />
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
                @if( !isset( $imgFiles[$i]['file'] ) )
                  @continue
                @endif
                  <td valign="top" bgcolor="#FFFFFF">
                      <font style="font-size: 10px;">
                        <div class="SE-w200" style="font-size: 10px;">
                        @if( !empty( $imgFiles[$i]['file'] ) == True )
                          {{-- 画像の説明文が存在するとき --}}
                          @if( !empty( $imgFiles[$i]['caption'] ) == True )
                            <br>
                            {{ $imgFiles[$i]['caption'] }}
                          @endif
                        @endif
                        </div>
                      </font>
                  </td>
                @endfor
              </tr>
          </tbody>
      </table>
  </td>
</tr>
@endif
