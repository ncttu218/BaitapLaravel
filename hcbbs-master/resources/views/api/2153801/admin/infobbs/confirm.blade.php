<html>
    <head>
        <title>Honda Cars 愛知　各店情報掲示板</title>
    </head>
    <body bgcolor="#ffffff" text="#000000">
    <center>
        <table cellpadding=0 cellspacing=0 border=0 width=600>
            <tr><td>
                    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=613>
                        <TR>
                            <TD COLSPAN=3 HEIGHT="15"></TD>
                        </TR>
                        <TR>
                            <TD COLSPAN=3 BGCOLOR="#068438"><IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1></TD>
                        </TR>
                        <TR>
                            <TD ROWSPAN=3 BGCOLOR="#068438" WIDTH=5 HEIGHT="2"><IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=5 HEIGHT=1></TD><TD ROWSPAN=3 BGCOLOR="#fff9d5" WIDTH=3 HEIGHT="2"></TD><TD background="2153801/infobbs/skins/image/bg011.gif" HEIGHT="2"><IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=2></TD>
                        </TR>
                        <TR>
                            <TD background="2153801/infobbs/skins/image/bg011.gif">
                                <FONT SIZE=4 COLOR="#0000ff">
                                <B>{{ $data['title'] ?? '' }}</B>
                                </FONT>
                            </TD>
                        </TR>
                        <TR>
                            <TD background="2153801/infobbs/skins/image/bg011.gif" HEIGHT="2"><IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=2></TD>
                        </TR>
                        <TR>
                            <TD COLSPAN=3 BGCOLOR="#068438"><IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1></TD>
                        </TR>
                        <TR>
                            <TD COLSPAN=3 ALIGN=RIGHT>
                                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 HEIGHT=17>
                                    <TR>
                                        <TD VALIGN=BOTTOM>
                                            <IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=1 HEIGHT=1>
                                            <FONT SIZE=2></FONT>
                                        </TD>
                                        <TD WIDTH=3></TD>
                                        <TD BGCOLOR="#068438" WIDTH=3>
                                            <IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=3 HEIGHT=1>
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
                    <hr>
                    このデータを登録します。よろしいですか？
                    <form action="{{ $urlAction }}" method=post>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type=submit name="modulate" value="修正する" >
                        <input type=submit name="register" value="登録する" >
                    </form>
                    <br>
                    <br>
            </tr></td>
        </table>
    </cener>
</body>
</html>
