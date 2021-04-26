<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>メールアドレス登録</title>
        <link rel="stylesheet" href="{{ asset_auto('mail_register/thickbox.css') }}" type="text/css" media="all">

        <style type="text/css">
            .alert-danger{
                color: #ff0000;
            }
        </style>
    </head>
    <BODY BGCOLOR="#ffffff" TEXT="#646464" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
            <tr><td bgcolor="#ffffff"><img src="{{ asset_auto('mail_register/keitai_popup.png') }}"></td></tr>
            <tr><td><font style="font-size:12px">
                    <p style="font-color:#000000;font-size:14px;margin:10px;"><strong>1.メールアドレスを登録する</strong><font style="font-size:10px;color:#ff0000;">※未登録の方のみ</font></p>
            <center>
                <br>
                携帯からのメール投稿をするためには<br>メールアドレスをこちらから登録してください。<br>
                <br>
                <form action="" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{-- エラーメッセージ --}}
                    @include('_errors.list')
                    <input type="text" size="50" name="email">
                    <br>
                    <br>
                    <input type="submit" value="メールアドレスを登録する"><br>
                    <div align="left">
                        <p style="margin:15px;">
                            <font color="#ff0000" style="font-size:10px;">
                            ※登録されたアドレスに登録メールを送付します。<br>数分経っても届かない場合、登録されたメールアドレスが間違っている場合がありますので、送信前に再度確認をお願いします。</font>
                            <br>
                        </p>
                    </div>
                </form>
            </center>
            <hr size=1 noshade>
            <p style="font-color:#000000;font-size:14px;margin:10px;"><strong>2.メールから投稿する</strong></p>
            <p style="margin:15px;">
                すでにメールアドレスを登録されている場合は<br><font color="#0000ff"><b>{{ $targetEmail }}</b></font>
                <br>宛にタイトルを件名に入れ、本文を記入し、画像を添付してメール送信をすることで投稿が可能です。<br>
                &nbsp;<a href="#"onClick="document.getElementById('qr').style.display = 'block'; return false;">→送信先メールアドレスのQRコードを表示</a>
            <div id="qr" style="display:none;">
                {!! QrCode::size(75)->generate(trim('mailto:' . $targetEmail)) !!}
            </div>
            </font>
        </p>
        <div>
            <p style="margin:15px;">
                <font style="font-size:10px" color="#ff0000">
                ※公開時、添付ファイルは本文の下に挿入されます。<br>
                ※iPhone/iPad等一部スマートフォンではEメール作成画面にて文章と画像を混在させることが可能です。
                </font>
            </p>
        </div>
    </td>
</tr>
</table>
</body>
</html>