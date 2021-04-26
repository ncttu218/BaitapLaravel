
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML lang="ja">
    <HEAD>
        <META HTTP-EQUIV="content-type" CONTENT="text/html;charset=Shift_JIS">
        <TITLE>Honda Cars 愛知 オフィシャルサイト</TITLE>
        <LINK REL=stylesheet TYPE="text/css" HREF="0000001/infobbs/css/csswie.css">
        <SCRIPT LANGUAGE="JavaScript">
            <!--
        if (navigator.appVersion.indexOf("Mac") > 1) {
                //Mac
                document.write('<link rel="stylesheet" href="0000001/infobbs/css/cssmac.css">')
            } else {
                if (navigator.appName.charAt(0) == "M") {
                    //Win IE
                    document.write('<link rel="stylesheet" href="0000001/infobbs/css/csswie.css">')
                } else {
                    //Win NN
                    document.write('<link rel="stylesheet" href="0000001/infobbs/css/csswnn.css">')
                }
            }
            function openNewMosikomiWindow(url) {
                dateObj = new Date();
                var hour = dateObj.getHours();
                var minutes = dateObj.getMinutes();
                var seconds = dateObj.getSeconds();
                var windowName = hour + "" + minutes + "" + seconds;
                var heightSize = Math.round(screen.height * 0.8);
                window.open(url, windowName, "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=750,height=" + heightSize + ",left=0,top=0");
            }
            //-->
        </SCRIPT>
        <script type="text/javascript" src="http://www.hondanet.co.jp/jump/hm/hc-aichi/dcs.js"></script>
    </HEAD>
    <BODY BACKGROUND="0000001/infobbs/skins/image/bg004.gif" BGCOLOR="#ffffff" TEXT="#4a4a4a" rightMargin=0 leftMargin=0 topMargin=0 bottomMargin=0 marginheight="0" marginwidth="0">
        {{-- ページ表示 --}}
        @include($templateDir . '.pagination_preview')
        @foreach($blogs as $row)
        <?php
        // 画像データ
        $imageData = [];
        for ($i = 1; $i <= 3; $i++) {
            $varName = "file{$i}";
            if (empty($row->{$varName})) {
                continue;
            }
            $imageData[$i] = [
                'url' => $row->{$varName},
                'caption' => $row->{'caption' . $i}
            ];
        }
        $imageData['hasData'] = count($imageData) > 0;
        ?>
        <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=613>
            <TR>
                <TD COLSPAN=3 BGCOLOR="#CC0000">
                    <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1></TD>
            </TR>
            <TR>
                <TD ROWSPAN=3 BGCOLOR="#CC0000" WIDTH=5 HEIGHT="2">
                    <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=5 HEIGHT=1>
                </TD>
                <TD ROWSPAN=3 BGCOLOR="#fff9d5" WIDTH=3 HEIGHT="2"></TD>
                <TD background="0000001/infobbs/skins/image/bg011.gif" HEIGHT="2">
                    <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=2>
                </TD>
            </TR>
            <TR>
                <TD background="0000001/infobbs/skins/image/bg011.gif">
                    <table cellpadding=0 cellspacing=0 border=0 width=100%>
                        <tr>
                            <td>
                                <FONT SIZE=4 COLOR="#0000ff"><B>{{ $row->title }}</B></FONT>
                            </td>
                            <td align=right>
                                <a href="" target="main"><font color="#CC0000">【{{ $row->base_name }}】</font></A>
                            </td>
                        </tr>
                    </table>
                </TD>
            </TR>
            <TR>
                <TD background="0000001/infobbs/skins/image/bg011.gif" HEIGHT="2">
                    <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=2>
                </TD>
            </TR>
            <TR>
                <TD COLSPAN=3 BGCOLOR="#CC0000">
                    <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1>
                </TD>
            </TR>
            <TR>
                <TD COLSPAN=3 ALIGN=RIGHT>
                    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 HEIGHT=17>
                        <TR>
                            <TD VALIGN=BOTTOM>
                                <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1>
                                <FONT SIZE=2>{{ date('Y/m/d', strtotime($row->created_at)) }}</FONT>
                            </TD>
                            <TD WIDTH=3></TD>
                            <TD BGCOLOR="#CC0000" WIDTH=3>
                                <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=3 HEIGHT=1>
                            </TD>
                        </TR>
                    </TABLE>
                </TD>
            </TR>
        </TABLE>
        <table border="0" cellspacing="0" cellpadding="0" width="613" background="0000001/infobbs/skins/image/00.gif">
            {{-- トップにある画像 --}}
            @if ($row->pos == 2)
                @include($templateDir . '.images.list_horizontal')
            @endif
            <tr>
                @if ($row->pos == 1)
                    @include($templateDir . '.images.list_vertical')
                @endif
                <td valign="TOP" width="613">
                    {{-- 記事が改行が必要かの判定 --}}
                    @if (has_no_nl($row->comment))
                    {!! nl2br( $row->comment ) !!}
                    @else
                    {!! $row->comment !!}
                    @endif
                </td>
                @if ($row->pos == 0)
                    @include($templateDir . '.images.list_vertical')
                @endif
            </tr>
            @if ($row->pos == 3)
                @include($templateDir . '.images.list_horizontal')
            @endif
            
            <tr>
                <td valign="TOP"><br></td>
            </tr>
            <tr>
                <td colspan="3" height="15"></td>
            </tr>

        </table>
        @endforeach
        <!-- STANDARD MODE END -->
        <!-- STANDARD MODE END -->
        <!-- STANDARD MODE END -->
        {{-- ページ表示 --}}
        @include($templateDir . '.pagination_preview')
        <BR>
        <p>
        </P>
    </BODY>
</HTML>