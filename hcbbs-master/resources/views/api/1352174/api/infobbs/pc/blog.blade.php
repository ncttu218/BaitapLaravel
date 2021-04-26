<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css" />
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css" />

<a name="0"></a>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

<font style="font-size: 12px; lineheight: 12px;">
{{-- 記事データが存在するとき --}}
@if (count($blogs) > 0)
@foreach ($blogs as $item)
  <?php
  // タイトル
  $item->title = $convertEmojiToHtmlEntity($item->title);
  // 本文
  $item->comment = $convertEmojiToHtmlEntity($item->comment);
  // 拠点名
  $item->base_name = trim($item->base_name);
  ?>

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
  $thumb = $item->{'file' . $fileNumber};
  $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $thumb);
  // サムネール画像
  $imgFiles[$i]['thumb'] = $thumb;
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td nowrap="" class="infobbs_title02">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td>
                                                    <div class="font_black" align="left">[{{ $item->base_name }}]&nbsp;{{ $item->title }}</div>
                                                </td>
                                                <td>
                                                    <div class="font_black font10" align="right">
                                                        <?php
                                                        $time = strtotime($item->updated_at);
                                                        if (!empty($item->from_date)) {
                                                            $time = strtotime($item->from_date);
                                                        }
                                                        ?>
                                                        {{ date('Y/m/d', $time) }}
                                                    </div>
                                                </td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                        {{-- 上並びの画像 --}}
                        @if ($item->pos == '2')
                            @include($templateDir . '.imagesTopBottom')
                        @endif
                        <tr>
                            {{-- 左並びの画像 --}}
                            @if ($item->pos == '1')
                                @include($templateDir . '.imagesLeftRight')
                            @endif
                            <td valign="top" bgcolor="#FFFFFF" align="left" class="InfobbsArticlesText">
                                <font size="2">
                                <?php
                                // 旧システムの最後の投稿作成日
                                $lastOldSystemPostDate = '2020-09-18';
                                // 旧システムの行間を調整する
                                // 新システムの行間を調整しない
                                if (strtotime($item->created_at) < strtotime(date($lastOldSystemPostDate))) {
                                    // 行間の調整
                                    $item->comment = nl2br($item->comment);
                                    $item->comment = preg_replace('/<\/span><br \/>\n/', '</span>', $item->comment);
                                }
                                ?>
                                {!! $item->comment !!}
                                <br>
                                <div class="infobbs_inquiry"><br /></div>
                                </font>
                            </td>
                            {{-- 右並びの画像 --}}
                            @if ($item->pos == '0')
                                @include($templateDir . '.imagesLeftRight')
                            @endif
                        </tr>
                        {{-- 下並びの画像 --}}
                        @if ($item->pos == '3')
                            @include($templateDir . '.imagesTopBottom')
                        @endif
                    </table>
                </td>
            </tr>
    </table>
    @endforeach
    @else
    ただいま準備中です。
    @endif
</font>

<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
