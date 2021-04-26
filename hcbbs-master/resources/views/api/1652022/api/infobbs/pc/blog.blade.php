<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
        <title>Honda Cars 高崎東 　情報掲示板</title>
        <link rel="stylesheet" type="text/css" media="all" href="{{ asset_auto('/') }}css/takasaki-higashi.css?20200825" />
        <script language="JavaScript">
            <!--
            function openNewMosikomiWindow(url) {
            	window.open(url,'DCS','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=750,height=690,left=0,top=0');
            }
            //-->
        </script>
    </head>

    <body>
        <table align="center">
            <tr>
                <td>
                    <table id="wrap">
                        <tr>
                            <td>
                                <div id="header">
                                    <img id="main_title" src="{{ asset_auto('/') }}img/takasaki-higashi/title.gif" alt="情報掲示板" />
                                    <p id="logo"></p>
                                    <div class="clear"></div>
                                </div>
                                <!--header End-->
                                <div>
                                    <div class="clear"></div>
                                </div>
                                <!--search End-->
                                {{-- ページネーションの読み込み --}}
                                @include($templateDir . '.pagination')
                                
                                {{-- 記事データが存在するとき --}}
                                @if (count($blogs) > 0)
                                @foreach ($blogs as $item)
                                <?php
                                // 日付
                                $time = strtotime( $item->updated_at );
                                $newFlg = $isNewBlog( $item->updated_at );
                                if( !empty( $item->from_date ) ) {
                                    $time = strtotime( $item->from_date );
                                    $newFlg = $isNewBlog( $item->from_date );
                                }
                                ?>
                                <!--エントリー【写真下】ここから-->
                                <table class="section" width="100%">
                                    <tr>
                                        <td>
                                            <div id="section_head">
                                                <div id="section_head_message">
                                                    <img src="{{ asset_auto('/') }}img/takasaki-higashi/message.gif" align="absmiddle" />
                                                    @if ($newFlg)
                                                    <font color="red" size="2">　<b>ＮＥＷ!</b></font>
                                                    @endif
                                                </div>
                                                <p id="section_head_day">
                                                    <?php
                                                    $pencilIcon = '<img src="' . asset_auto('/') . 'img/takasaki-higashi/pencil.gif" width="17" height="14" align="absmiddle" />';
                                                    ?>
                                                    <?php
                                                    $time = strtotime($item->updated_at); 
                                                    if (!empty($item->from_date)) { 
                                                        $time = strtotime($item->from_date); 
                                                    } 
                                                    ?>
                                                    {!! $pencilIcon . date('Y/m/d', $time) !!}
                                                </p>
                                                <p id="section_head_title"><b>{{ $item->title }}</b></p>
                                            </div>
                                            <!--section_head End-->
                                            @if ($item->pos == '2')
                                            <div class="entry3">
                                                {{-- 画像 --}}
                                                @include($templateDir . '.image')
                                            </div>
                                            @endif
                                            <p class="entry2">
                                                <?php
                                                // 記事が改行が必要かの判定
                                                $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                                                ?>
                                                @if ($hasNoBr) 
                                                {!! nl2br( $item->comment ) !!} 
                                                @else 
                                                {!! $item->comment !!} 
                                                @endif
                                            </p>
                                            @if ($item->pos == '3')
                                            <div class="entry3">
                                                {{-- 画像 --}}
                                                @include($templateDir . '.image')
                                            </div>
                                            @endif
                                            <div class="entry6"></div>
                                        </td>
                                    </tr>
                                </table>
                                <!--エントリー【写真下】ここまで-->
                                @endforeach
                                @else
                                <table class="section" width="100%">
                                    <tr>
                                        <td>
                                            <div class="entry2">ただいま準備中です。</div>
                                        </td>
                                    </tr>
                                </table>
                                @endif

                                {{-- ページネーションの読み込み --}}
                                @include($templateDir . '.pagination')

                                <div id="pagetop">
                                    <a href="#" onClick="backToTop(); return false"><img src="{{ asset_auto('/') }}img/takasaki-higashi/pagetop.gif" /></a>
                                </div>
                                <div class="clear"></div>
                                <div id="footer">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="10" height="30">&nbsp;</td>
                                            <td width="1" height="30" bgcolor="#000000">&nbsp;</td>
                                            <td width="700" height="30">
                                                <table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td height="30" nowrap="nowrap" background="{{ asset_auto('/') }}img/takasaki-higashi/bg_copy.gif" style="padding: 0 0 0 6px; font-size: 10px; height: 30px; margin: 0 auto;">
                                                            Copyrights(C) 2020 Honda Cars 高崎東 Co.,Ltd.All Rights Reserved.
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table width="100%" align="center" cellpadding="0" cellspacing="0" id="under">
                        <tr>
                            <td width="10">
                                <img src="{{ asset_auto('/') }}img/takasaki-higashi/under_left.gif" width="10" height="14" />
                            </td>
                            <td background="{{ asset_auto('/') }}img/takasaki-higashi/under.gif">
                                <img src="{{ asset_auto('/') }}img/takasaki-higashi/0.gif" width="713" height="1" />
                            </td>
                            <td width="9">
                                <img src="{{ asset_auto('/') }}img/takasaki-higashi/under_right.gif" width="9" height="14" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
