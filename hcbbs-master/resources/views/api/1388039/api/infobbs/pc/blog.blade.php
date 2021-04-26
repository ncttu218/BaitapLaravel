<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css" />
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css" />
<a name="0"></a>

<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

{{-- 緊急掲示板以外の時 --}}
@if( empty( $shopCode ) || $shopCode !== "em" )

  {{-- 設定ファイルのカテゴリー機能NOのとき --}}
  @if( isset( $para_list['category'] ) && $para_list['category'] !== '' )
    <?php
    // カテゴリーの配列を取得
    $categoryList = explode( ",", $para_list['category'] );
    ?>

    <div align="left">
      <a href="?category=">全て({{ $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode ) }})</a>&nbsp;
      
      {{-- カテゴリー一覧を表示するループ --}}
      @foreach ( $categoryList as $category )
        <?php
        $count = $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode, $category );
        ?>
        <a href="?shop={{ $shopCode }}&category={{ $category }}" class="infoIcon">
          {{ $category }}({{  ( isset( $count ) )? $count: 0 }})
        </a>&nbsp;
      @endforeach
    </div>

  @endif

@endif
<a name="0"></a>
{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
<font style="font-size: 12px; lineheight: 12px;">
    <br clear="all" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            {{-- 記事データが存在するとき --}}
            @foreach ($blogs as $item)
            <?php
            $imgFiles = [];

            // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
            $containsData = false;
            for( $i=1; $i<= 3; $i++ ){
                $fileNumber = $i;
                if (!isset($item->{'file' . $i})) {
                    continue;
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
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
                        <tbody>
                            <tr>
                                <td nowrap="" class="infobbs_title02">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td><div class="font_black font12" align="left">[{{ $item->base_name }}]&nbsp;{{ $item->title }}</div></td>
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
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="blogInner">
                        <tbody>
                            {{-- 上並びの画像 --}}
                            @if ($item->pos == '2')
                                @include($templateDir . '.imagesTopBottom')
                            @endif
                            <tr>
                                {{-- 左並びの画像 --}}
                                @if ($item->pos == '1')
                                    @include($templateDir . '.imagesLeftRight')
                                @endif
                                <td valign="top" bgcolor="#FFFFFF" align="left">
                                    <font size="2">
                                        <?php
                                        // 記事が改行が必要かの判定
                                        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                                        ?>
                                        @if ($hasNoBr)
                                        {!! nl2br( $item->comment ) !!}
                                        @else
                                        {!! $item->comment !!}
                                        @endif
                                        <br />
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
                            <tr>
                                <td valign="top" bgcolor="#FFFFFF">
                                    <table border="0" cellspacing="0" cellpadding="1">
                                        <tbody>
                                            <tr valign="bottom">
                                                <td bgcolor="#FFFFFF"><font style="font-size: 10px;"></font></td>
                                                <td bgcolor="#FFFFFF"><font style="font-size: 10px;"> </font></td>
                                                <td bgcolor="#FFFFFF"><font style="font-size: 10px;"> </font></td>
                                            </tr>
                                            <tr align="left">
                                                <td valign="top" bgcolor="#FFFFFF"><div class="SE-w200" style="font-size: 10px;"></div></td>
                                                <td valign="top" bgcolor="#FFFFFF"><div class="SE-w200" style="font-size: 10px;"></div></td>
                                                <td valign="top" bgcolor="#FFFFFF"><div class="SE-w200" style="font-size: 10px;"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" colspan="2">
                                    {{-- 設定ファイルのコメント機能NOのとき --}}
                                    @if( $para_list['comment'] === '1' )

                                    <table>
                                    <tr>
                                        <td align="right" valign="middle">
                                            @if (!empty($item->category))
                                            <font style="font-size:8px;">カテゴリ:{{ $item->category }}</font>&nbsp;
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle">
                                            <div class="hakusyu font10">
                                                この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件
                                            </div>
                                            {{-- 感想の一覧を取得 --}}
                                            <?php
                                            $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
                                            ?>
                                            {{-- 感想の一覧にデータが存在するとき --}}
                                            @if( !$commentList->isEmpty() )
                                                @foreach ( $commentList as $commentValue )
                                                <div class="hakusyu">
                                                    <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
                                                </div>
                                                @endforeach
                                            @endif
                                            <div class="hakusyu font10">
                                                <button onclick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle"></td>
                                    </tr>
                                    </table>

                                @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            @endforeach
            <tr>
                <td>
                    {{-- ページネーションの読み込み --}}
                    @include($templateDir . '.pagination')
                </td>
            </tr>
        </tbody>
    </table>
</font>