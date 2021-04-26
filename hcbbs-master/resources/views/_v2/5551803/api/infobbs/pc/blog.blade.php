<script language="JavaScript" src="/common-js/opendcs.js"></script>
<table border="0" cellspacing="0" cellpadding="0">
    <tbody>
    {{-- ページネーションの読み込み --}}
    @include($templateDir . '.pagination')

    {{-- 記事データが存在するとき --}}
    @foreach ($blogs as $item)
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="blog">
                <tbody>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="1" cellpadding="0">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr class="blogTitle">
                                            <td align="left">
                                                <table width="100%" border="0" cellspacing="1" cellpadding="2">
                                                    <tbody>
                                                    <tr>
                                                        <td><b><font color="#FFFFFF">{{ $convertEmojiToHtmlEntity($item->title) }}</font></b></td>
                                                        <td align="right">
                                                            <font style="font-size:11pt;">
                                                                <?php
                                                                $time = strtotime($item->updated_at);
                                                                if (!empty($item->from_date)) {
                                                                    $time = strtotime($item->from_date);
                                                                }
                                                                ?>
                                                                {{ date('Y/m/d', $time) }}&nbsp;【{{ $item->base_name }}】
                                                            </font>&nbsp;
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
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="blogText">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="blogInner">
                                        <tbody>
                                        <tr>
                                            <td valign="top" align="left">
                                                <font size="2">
                                                    {{-- ページネーションの読み込み --}}
                                                    @include('v2.common.api.infobbs.image_list_default')

                                                    {!! $convertEmojiToHtmlEntity($item->comment) !!}
                                                </font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" no_wrap="">
                                                <table border="0" cellspacing="0" cellpadding="1">
                                                    <tbody>
                                                    <tr valign="bottom">
                                                        <td><font style="font-size:10px;"></font></td>
                                                        <td><font style="font-size:10px;">
                                                            </font>
                                                        </td>
                                                        <td><font style="font-size:10px;">
                                                            </font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" align="left"><font style="font-size:10px;">
                                                            </font>
                                                        </td>
                                                        <td valign="top" align="left"><font style="font-size:10px;">
                                                            </font>
                                                        </td>
                                                        <td valign="top" align="left"><font style="font-size:10px;">
                                                            </font>
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
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    @endforeach
    
    {{-- ページネーションの読み込み --}}
    @include($templateDir . '.pagination')
    </tbody>
</table>
