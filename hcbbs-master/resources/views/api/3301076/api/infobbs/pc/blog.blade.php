@if ($blogs->count() > 0)
<script language="JavaScript" src="/common-js/opendcs.js">
</script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<style type="text/css">#blogLoad img{height: auto;}</style>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

<font style="font-size :12px; lineheight :12px;">

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
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
                <tr>
                    <td valign="top" bgcolor="#FFFFFF" align="left" class="InfobbsArticlesText">
                        <font size="2">
                            @include('api.common.api.infobbs.image_list_default')
                            
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
                        </font>
                    </td>
                </tr>
                <tr>
                    <td valign="top" bgcolor="#FFFFFF">
                        <table border="0" cellspacing="0" cellpadding="1">
                            <tr valign="bottom">
                                <td bgcolor="#FFFFFF">
                                    <font style="font-size:10px;"></font>
                                </td>
                                <td bgcolor="#FFFFFF">
                                    <font style="font-size:10px;"></font>
                                </td>
                                <td bgcolor="#FFFFFF">
                                    <font style="font-size:10px;"></font>
                                </td>
                            </tr>
                            <tr align="left">
                                <td valign="top" bgcolor="#FFFFFF" class="SE-w175">
                                    <font style="font-size:10px;"></font>
                                </td>
                                <td valign="top" bgcolor="#FFFFFF" class="SE-w175">
                                    <font style="font-size:10px;"></font>
                                </td>
                                <td valign="top" bgcolor="#FFFFFF" class="SE-w175">
                                    <font style="font-size:10px;"></font>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                    <td>
                        <div class="goodjob_image">
                            <?php
                            // 記事番号
                            $number = str_replace('data', '', $item->number);
                            // Good Jobを送信するURL
                            $goodJobUrl = action_auto('Api\_3301076\InfobbsController@getSubmitGoodJob');
                            // カウント
                            $count = $getGoodJobCountValue($item->number);
                            ?>
                            <form action="{{ $goodJobUrl }}"
                                  method="get" 
                                  target="goodjob" 
                                  onsubmit="countup('{{ $number }}','{{ $count }}');">
                              <input type="hidden" name="fid" value="{{ $hanshaCode }}">
                              <input type="hidden" name="type" value="infobbs">
                              <input type="hidden" name="action" value="post">
                              <input type="hidden" name="num" value="data{{ $number }}">
                              <input type="hidden" name="treepath" value="">
                              <input type="hidden" name="hakusyu" value="GJ">
                              <input type="hidden" name="device_type" value="pc">
                              <input type="image" src="/home/img/system/btn_sr_goodjob_off.gif"
                                     onmouseover="this.src='/home/img/system/btn_sr_goodjob_on.gif'"
                                     onmouseout="this.src='/home/img/system/btn_sr_goodjob_off.gif'">
                              <div id="goodjob_count{{ $number }}" class="goodjob_count">
                                  {{ $count }}
                              </div>
                            </form>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endforeach

</font>

<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

@else
ただいま準備中です。
@endif