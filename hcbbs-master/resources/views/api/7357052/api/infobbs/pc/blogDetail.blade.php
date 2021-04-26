<script language="JavaScript" src="/common-js/opendcs.js">
</script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<a name="0"></a>

<font style="font-size :12px; lineheight :12px;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
    <tbody>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td nowrap="" class="infobbs_title02">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="font_black" align="left">[{{ $blog->base_name }}]&nbsp;{{ $blog->title }}</div>
                                            </td>
                                            <td>
                                                <div class="font_black font10" align="right">
                                                    <?php
                                                    $time = strtotime($blog->updated_at);
                                                    if (!empty($blog->from_date)) {
                                                        $time = strtotime($blog->from_date);
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
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr>
                        <td valign="top" bgcolor="#FFFFFF" align="left" class="InfobbsArticlesText">
                            <font size="2">
                                @include('api.common.api.infobbs.image_list_default')
                                
                                <?php
                                // 記事が改行が必要かの判定
                                $blog->comment = str_replace('[NOW_TIME]', time(), $blog->comment);
                                $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $blog->comment);
                                ?>
                                @if ($hasNoBr)
                                    {!! nl2br( $blog->comment ) !!}
                                @else
                                    {!! $blog->comment !!}
                                @endif
                                <div class="infobbs_inquiry"><br></div>
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
                            {{-- ページネーションの読み込み --}}
                            @include($templateDir . '.fb-like', ['item' => $blog])
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>

</font>
