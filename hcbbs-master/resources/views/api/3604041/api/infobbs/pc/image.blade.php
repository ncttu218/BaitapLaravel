<?php
$imgFiles = [];
// 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
for( $i=1; $i<= 3; $i++ ){
  $imgFiles[$i]['file'] = $item->{'file' . $i};
  $imgFiles[$i]['caption'] = $item->{'caption' . $i};
}
?>
{{-- 定形画像が入力されていれば、画面に出力する。 --}}
@if( !empty( $imgFiles ) == True )
  <div>
    <font> 
      {{-- 定形画像の数分繰り返す --}}
      @for( $i=1; $i<= 3; $i++ )
        @if( !empty( $imgFiles[$i]['file'] ) == True )
          <?php
          // ファイルパスの情報を取得する
          $fileinfo = pathinfo( $imgFiles[$i]['file'] );
          ?>
          <br>
          <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
              {{-- PDFファイルの対応 --}}
              @if( strtolower( $fileinfo['extension'] ) === "pdf" )
              <img src="{{ $CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
              @else
              <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
              @endif
          </a>
          {{-- 画像の説明文が存在するとき --}}
          @if( !empty( $imgFiles[$i]['caption'] ) == True )
            <p>{{ $imgFiles[$i]['caption'] }}</p>
          @endif
        @endif
      @endfor
    </font> 
  </div>
@endif