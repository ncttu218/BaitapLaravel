@if ($blogs->count() > 0)
    <script language="JavaScript" src="/common-js/opendcs.js"></script>
    <style type="text/css">
        <!--
        hakusyu{
            float:left;
            padding: 2px;
            border-width: 0px;
            border-style: solid;
            border-color: #666;
            vartical-valign: top;
        }
        font10{
            font-size: 10px;
        }
        -->
    </style>
    <a name="0"></a>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tbody>
    <tr> 
        <td valign="middle" align="left" colspan="2"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tbody>
                    <tr bgcolor="#FFFFFF"> 
                        <td valign="middle" align="left"></td>
                        <td valign="middle" align="right">
                            {{-- ページネーションの読み込み --}}
                            @include($templateDir . '.pagination')
                        </td>
                    </tr>
                </td>
            </table>
        </td>
    </tr>
{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
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
  $imgFiles[$i]['file'] = $item->{'file' . $fileNumber};
  $caption = $item->{'caption' . $fileNumber};
  $caption = $convertEmojiToHtmlEntity($caption);
  $imgFiles[$i]['caption'] = $caption;
  
  // データがあるかの確認
  if (!$containsData) {
    $containsData = !empty($imgFiles[$i]['file']) ||
            !empty($imgFiles[$i]['caption']);
  }
}

// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
// 掲載番号
$number = str_replace('data', '', $item->number);
?>
<tr> 
    <td colspan="2"> 
        <a name="{{ $number }}"></a>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr> 
                    <td> 
                        <table width="100%" border="0" cellspacing="1" cellpadding="0">
                            <tbody>
                                <tr> 
                                    <td> 
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr> 
                                                    <td align="left"> 
                                                        <table width="100%" border="0" cellspacing="1" cellpadding="2">
                                                            <tbody>
                                                                <tr> 
                                                                    <td><b>{{ $item->title }}</b> 
                                                                    </td>
                                                                    <?php
                                                                    $time = strtotime($item->updated_at);
                                                                    if (!empty($item->from_date)) {
                                                                        $time = strtotime($item->from_date);
                                                                    }
                                                                    ?>
                                                                    <td align="right" nowrap=""><font style="font-size:10px;">{{ date('Y/m/d', $time) }}【{{ $item->base_name }}】</font>&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr><td height="1" bgcolor="#dcd3d3"><img src="/img/0.gif" width="1" height="1"></td></tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr> 
                                    <td> 
                                        <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                            <tbody>
                                                @if ($item->pos == 2)
                                                    <tr>
                                                    @include($templateDir . '.image_left')
                                                    </tr>
                                                @endif
                                                <tr> 
                                                    @if ($item->pos == 1)
                                                        @include($templateDir . '.image_right')
                                                    @endif
                                                    <td valign="top" bgcolor="#FFFFFF">
                                                        <font size="2">
                                                        <?php
                                                        // 記事が改行が必要かの判定
                                                        $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
                                                        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                                                        ?>
                                                        @if ($hasNoBr)
                                                          {!! nl2br( $item->comment ) !!}
                                                        @else
                                                          {!! $item->comment !!}
                                                        @endif
                                                        @if (!empty($item->form_addr))
                                                        <br>
                                                        <a href="{{ $item->form_addr }}" target="_blank">{{ $item->inquiry_inscription }}</a>
                                                        @endif
                                                        </font>
                                                    </td>
                                                    @if ($item->pos == 0)
                                                        @include($templateDir . '.image_right')
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td align="right" colspan="2">
                                                        {{-- コメント --}}
                                                        @include($templateDir . '.comment')
                                                    </td>
                                                </tr>
                                                @if ($item->pos == 3)
                                                    <tr>
                                                    @include($templateDir . '.image_left')
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody></table>
        <img src="/img/0.gif" width="1" height="40">
    </td>
</tr>
@endforeach
<!-- ZERO END -->
<tr> 
    <td align="right" colspan="2"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tbody><tr bgcolor="#000066"> 
                    <td valign="middle" align="left" colspan="2" bgcolor="#FFFFFF"> 
                        <hr size="1" noshade="" color="#aaaaaa">
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                    <td valign="middle" align="left"></td>
                    <td valign="middle" align="right">
                        {{-- ページネーションの読み込み --}}
                        @include($templateDir . '.pagination')
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>
@else
ただいま準備中です。
@endif