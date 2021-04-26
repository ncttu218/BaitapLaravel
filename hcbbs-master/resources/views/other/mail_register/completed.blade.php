<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>メールアドレス登録</title>
        <link rel="stylesheet" href="{{ asset_auto('mail_register/thickbox.css') }}" type="text/css" media="all">

    </head>
    <BODY BGCOLOR="#ffffff" TEXT="#646464" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
            <tr><td bgcolor="#ffffff"><img src="{{ asset_auto('mail_register/keitai_popup.png') }}"></td></tr>
            <tr><td><font style="font-size:12px">
                    <br>メールによる投稿は<br>
                    <font color="#0000ff"><b>{{ $targetEmail }}</b>
                    </font><br>に画像を添付してメール送信してください。<br><br>
                    <a href="#" onClick="window.close();">閉じる</a><hr size=1 noshade><div>
                        <p style="margin:15px;">
                            <font style="font-size:10px" color="#ff0000">
                            ※公開時、添付ファイルは本文の下に挿入されます。<br>
                            ※iPhone/iPad等一部スマートフォンではEメール作成画面にて文章と画像を混在させることが可能です。
                            </font>
                        </p>
                    </div>
                </td></tr>
        </table>
    </body>
</html>