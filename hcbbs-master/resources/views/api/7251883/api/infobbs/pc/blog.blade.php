<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css" />
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css" />
<a name="0"></a>
{{-- ページネーション --}}
@include($templateDir . '.pagination')
<font style="font-size: 12px; lineheight: 12px;">
    {{-- 記事データが存在するとき --}}
    @if (count($blogs) > 0)
    @foreach ($blogs as $item)
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td nowrap="" class="infobbs_title02">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="font_black" align="left">
                                        {{ $item->title }}
                                    </div>
                                </td>
                                <td>
                                    <div class="font_black font10" align="right">
                                        <?php
                                        // 日付
                                        $time = strtotime($item->updated_at);
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

    <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tbody>
            <tr>
                <td valign="top" bgcolor="#FFFFFF" align="left">
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

                        {{-- 画像 --}}
                        @include($templateDir . '.images')
                        <br />
                        <div class="infobbs_inquiry"><br /></div>
                    </font>
                </td>
            </tr>
            <tr>
                <td valign="top" bgcolor="#FFFFFF" nowrap="">
                    <table border="0" cellspacing="0" cellpadding="1">
                        <tbody>
                            <tr valign="bottom" nowrap="" align="left">
                                <td bgcolor="#FFFFFF"><font style="font-size: 10px;"></font></td>
                                <td bgcolor="#FFFFFF"><font style="font-size: 10px;"> </font></td>
                                <td bgcolor="#FFFFFF"><font style="font-size: 10px;"> </font></td>
                            </tr>
                            <tr align="left" nowrap="">
                                <td valign="top" bgcolor="#FFFFFF"><font style="font-size: 10px;"> </font></td>
                                <td valign="top" bgcolor="#FFFFFF"><font style="font-size: 10px;"> </font></td>
                                <td valign="top" bgcolor="#FFFFFF"><font style="font-size: 10px;"> </font></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="right">
                    {{-- コメント --}}
                    @include($templateDir . '.comment')
                </td>
            </tr>
        </tbody>
    </table>
    @endforeach
    @else
    ただいま準備中です。
    @endif
    <!-- ZERO END -->
</font>
{{-- ページネーション --}}
@include($templateDir . '.pagination')
<font style="font-size: 12px; lineheight: 12px;"></font>
