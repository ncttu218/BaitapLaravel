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
  // 画像
  $fileUrl = $item->{'file' . $fileNumber};
  $fileUrl = preg_replace('/\\"$/', '', $fileUrl);
  $imgFiles[$i]['file'] = $fileUrl;
  // サムネール画像
  $imgFiles[$i]['thumb'] = $fileUrl;
  // キャプション
  $caption = $item->{'caption' . $fileNumber};
  $caption = $convertEmojiToHtmlEntity($caption);
  $imgFiles[$i]['caption'] = $caption;
  
  // データがあるかの確認
  if (!$containsData) {
    $containsData = !empty($imgFiles[$i]['file']) ||
            !empty($imgFiles[$i]['caption']);
  }
}
?>

{{-- 定形画像が入力されていれば、画面に出力する。 --}}
@if( $containsData )
<tr>
<td valign="top" bgcolor="#FFFFFF" colspan="3">
    <table border="0" cellspacing="0" cellpadding="1">
        <tbody>
            <tr valign="bottom">
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                    @if( !empty( $imgFiles[$i]['file'] ) == True )
                    <td bgcolor="#FFFFFF">
                        <font style="font-size: 10px;">
                            @if ($i == 1)
                                <font style="font-size: 8px;">画像をクリックすると拡大表示できます</font><br />
                            @endif
                            <?php
                            // ファイルパスの情報を取得する
                            $fileinfo = pathinfo( $imgFiles[$i]['file'] );
                            ?>
                            <br>
                            <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
                                {{-- PDFファイルの対応 --}}
                                @if( strtolower( $fileinfo['extension'] ) === "pdf" )
                                <img src="{{ $CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] ) }}" width="200" border="0" f7="" />
                                @else
                                <img src="{{ url_auto( $imgFiles[$i]['thumb'] ) }}" width="200" border="0" f7="" />
                                @endif
                            </a>
                        </font>
                    </td>
                    @endif
                @endfor
            </tr>
            <tr align="left">
                {{-- 定形画像の数分繰り返す --}}
                @for( $i=1; $i<= 3; $i++ )
                    @if( !empty( $imgFiles[$i]['file'] ) == True )
                        {{-- 画像の説明文が存在するとき --}}
                        @if( !empty( $imgFiles[$i]['caption'] ) == True )
                        <td valign="top" bgcolor="#FFFFFF">
                            <div class="SE-w200" style="font-size: 10px;">
                                <br />
                                {{ $imgFiles[$i]['caption'] }}
                            </div>
                        </td>
                        @endif
                    @endif
                @endfor
            </tr>
        </tbody>
    </table>
</td>
</tr>
@endif
