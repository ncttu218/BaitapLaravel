{{-- 定形画像が入力されていれば、画面に出力する。 --}}
@if( $containsData )
  <td valign="top" align="right" bgcolor="#FFFFFF" nowrap="">
    {{-- 定形画像の数分繰り返す --}}
    @for( $i=1; $i<= 3; $i++ )
    @if( !isset( $imgFiles[$i]['file'] ) )
      @continue
    @endif
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
            <br />
            {{-- 画像の説明文が存在するとき --}}
            @if( !empty( $imgFiles[$i]['caption'] ) == True )
              {{ $imgFiles[$i]['caption'] }}
              <br>
            @endif
        @endif
        </font>
    @endfor
  </td>
@endif
