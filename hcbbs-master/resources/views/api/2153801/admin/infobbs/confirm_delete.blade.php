<html>
    <head>
        <title>Honda Cars 青山　各店情報掲示板</title>
    </head>
    <body bgcolor="#ffffff" text="#000000">
    <center>
        <table cellpadding=0 cellspacing=0 border=0 width=600>
            <tr><td>
                    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=613>
                        <TR>
                            <TD COLSPAN=3 BGCOLOR="#CC0000"><IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1></TD>
                        </TR>
                        <TR>
                            <TD ROWSPAN=3 BGCOLOR="#CC0000" WIDTH=5 HEIGHT="2"><IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=5 HEIGHT=1></TD><TD ROWSPAN=3 BGCOLOR="#fff9d5" WIDTH=3 HEIGHT="2"></TD><TD background="0000001/infobbs/skins/image/bg011.gif" HEIGHT="2"><IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=2></TD>
                        </TR>
                        <TR>
                            <TD background="0000001/infobbs/skins/image/bg011.gif">
                                <table cellpadding=0 cellspacing=0 border=0 width=100%>
                                    <tr><td><FONT SIZE=4 COLOR="#0000ff"><B>{{ $data['title'] ?? '' }}</B></FONT></td>
                                        <td align=right><a href="" target="main"><font color="#CC0000">【{{ $shopName }}】</font></a></td></tr>
                                </table>
                            </TD>
                        </TR>
                        <TR>
                            <TD background="0000001/infobbs/skins/image/bg011.gif" HEIGHT="2"><IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=2></TD>
                        </TR>
                        <TR>
                            <TD COLSPAN=3 BGCOLOR="#CC0000"><IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1></TD>
                        </TR>
                        <TR>
                            <TD COLSPAN=3 ALIGN=RIGHT>
                                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 HEIGHT=17>
                                    <TR>
                                        <TD VALIGN=BOTTOM>
                                            <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1>
                                            <FONT SIZE=2>{{ isset($createdAt) && !empty($createdAt) ? date('Y/m/d', strtotime($createdAt)) : '' }}</FONT>
                                        </TD>
                                        <TD WIDTH=3></TD>
                                        <TD BGCOLOR="#CC0000" WIDTH=3>
                                            <IMG src="0000001/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=3 HEIGHT=1>
                                        </TD>
                                    </TR>
                                </TABLE>
                            </TD>
                        </TR>
                        <TR>
                            <TD COLSPAN=3 HEIGHT="5"></TD>
                        </TR>
                    </TABLE>
                    @include($templateDir . '.confirm_content')
                    <br>このデータを削除します。よろしいですか？
                    <form action="{{ $urlAction }}" method=post>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type=hidden name=num value=data032053>
                        <input type=hidden name=ref_mode value=>
                        <input type=button value="キャンセル" onCLICK=history.go(-1)><input type=submit value=削除する></form>
                    <hr>
                    <br>
                    <br>
            </tr>
        </td>
        </table>
    </center>
</body>
</html>
