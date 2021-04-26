<script language="JavaScript" src="/common-js/opendcs.js">
</script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<a name="0"></a>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

{{-- カテゴリー --}}
@include($templateDir . '.category')

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
                            <td nowrap="" class="infobbs_title02">
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
                    <tr>
                        <td valign="top" bgcolor="#FFFFFF" align="left" class="InfobbsArticlesText">
                            <font size="2">
                                @include('api.common.api.infobbs.image_list_default')
                                
                                <?php
                                // 画像のパスを置換する。
                                $item->comment = str_replace( "img.hondanet.co.jp", "image.hondanet.co.jp", $item->comment );
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
                </table>
                <tr>
                     <td align="right">
                        {{-- ページネーションの読み込み --}}
                        @include($templateDir . '.comment')
                     </td>
                  </tr>
            </td>
        </tr>
    </tbody>
</table>

@endforeach

</font>

<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')