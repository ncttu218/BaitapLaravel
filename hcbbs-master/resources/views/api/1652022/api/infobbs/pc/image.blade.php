<?php
$images = [];
// 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
for( $i=1; $i<= 3; $i++ ){
  $file = $item->{'file' . $i};
  $caption = $convertEmojiToHtmlEntity($item->{'caption' . $i});
  if (!empty($file)) {
    $images[] = [
      'url' => url_auto( $file ),
      'thumb' => url_auto( str_replace('thumb/thu_', '', $file) ),
      'caption' => $caption,
    ];
  }
}
?>

<table width="590" cellspacing="1" cellpadding="1">
  <tbody>
      <tr>
          @for ($i=0;$i<3;$i++)
          <?php $imageItem = $images[$i] ?? []; ?>
          @if ($i < 2)
          <td width="181">
          @else
          <td width="192">
          @endif
            @if (count($imageItem) > 0)
              <br />
              <a href="{{ $imageItem['thumb'] }}" target="_blank">
                  <img src="{{ $imageItem['url'] }}" width="200" border="0" f7="" />
              </a>
            @endif
          </td>
          <td width="8">&nbsp;</td>
          @endfor
      </tr>
      <tr>
        @foreach ($images as $imageItem)
        <td style="padding: 4px 0 0 0;">
            <br />
            {{ $imageItem['caption'] }}
        </td>
        <td>&nbsp;</td>
        @endforeach
      </tr>
  </tbody>
</table>
