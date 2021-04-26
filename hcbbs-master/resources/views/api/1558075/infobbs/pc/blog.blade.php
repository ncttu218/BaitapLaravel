<script language="JavaScript" src="/common-js/opendcs.js">
</script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<a name="0"></a>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

<font style="font-size :12px; lineheight :12px;">

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
    <tbody>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td nowrap="" class="infobbs_title02 blogTitle">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
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
                    <tbody>
                        <tr>
                            <td valign="top" bgcolor="#FFFFFF" align="left" class="InfobbsArticlesText">
                                {!! $item->comment !!}
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" bgcolor="#FFFFFF">
                                <table border="0" cellspacing="0" cellpadding="1">
                                    <tbody>
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
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

@endforeach

</font>

<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')