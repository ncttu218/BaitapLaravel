<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
        <title>Honda Cars 愛知</title>
        <style type="text/css">
            TD{font-size:12px;}
        </style></head>
    <body background="#ffffff" text="#000000">
        <div align=left>

            <div id="topmsg"></div>

            <font style="font-size:16px;" color="#333399"><b>Honda Cars 愛知 管理画面</b></font>
            <hr size=1 width=600 noshade color="#ff0000" align=left>
            <table width=600 cellpadding=0 cellspacing=0 border=0><tr><td bgcolor=red>
                        <table width=600 cellpadding=2 cellspacing=1 border=0><tr><td bgcolor=white>
                                    <font style="font-size:12px;">
                                    <font color=black><b>【六三グラフィックスからのお知らせ】</b></font><br>
                                    <font color="990000" size=2>■画像ファイルアップロードついて</font><br>
                                    サーバーの負荷が増大しているため、各CGIコンテンツ内において画像ファイルをアップロードする際の制限を設けました。<br>
                                    画像が横1600ピクセル×横1200ピクセルを超えるサイズはアップロードできません。<br>
                                    また、BMPファイルについてもアップロードできません。<br>
                                    これらは、どちらもファイルサイズが数百KB～数MBと巨大なものになり、サーバーの回線や処理能力を過大に消費するために、<b><font color=red>システムをご利用頂いている他販社様や一般のお客様の閲覧に影響を及ぼします。</font></b>(処理がいつまでたっても終わらない、画像が表示されないなど)<br>
                                    大変申し訳ございませんが、上記サイズ以下の大きさに縮小をかけたうえでのご利用をお願いいたします。<br>
                                    <br>
                                    <font color="990000" size=2>■CGIコンテンツの不具合発生の対応について</font><br>
                                    下記CGIコンテンツの不具合の際にはこちらのフォームからお知らせください→<a href="http://cgi.hondanet.co.jp/ER/" target="_blank">不具合報告フォーム</a><br>
                                    <font color=red style="font-size:10px;">※なお、こちらのフォームは下記のCGIの不具合に関するお問い合わせのみを受け付けております。<br>
                                    ディーラーコンタクトシステム(DCS)のフォームや、HM提供の展示試乗車コンテンツの不具合に関してはHonda Cars ホームページ事務局へお知らせください。<br>
                                    ホームページの掲載内容についての更新依頼などは担当営業までお願いいたします。</font><br>
                                    <br>
                                    </font>
                                </td></tr></table>
                    </td></tr></table>
            <br>


            <table width=600 cellpadding=3 cellspacing=0 border=0>


                <tr>
                    <td bgcolor="#ff99cc"><font color="#ffffff"><b>■@ichi.com 試乗キャンペーン管理画面</b></font></td>
                    <td td bgcolor="#ff99cc" align=right><font color="#ffffff"></font></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <a href=https://secure.hondanet.co.jp/cgi/admin/shijo_admin.cgi target=_blank>拠点用管理画面</a><br><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ff99cc"><font color="#ffffff"><b>■@ichi.com 車検キャンペーン管理画面</b></font></td>
                    <td td bgcolor="#ff99cc" align=right><font color="#ffffff"></font></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <a href=https://secure.hondanet.co.jp/cgi/admin/syaken_admin.cgi target=_blank>拠点用管理画面</a><br><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#088436"><font color="#ffffff"><b>■情報掲示板</b></font></td>
                    <td td bgcolor="#088436" align=right><font color="#ffffff">2153801/infobbs</font></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <form action="{{ $urlInfobbsAdmin }}" method="get" target="_blank" style="margin:0em;">
                            <select name="shop">
                                @foreach ($shopList as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <br>
                            <input type=submit value="情報掲示板の管理者画面を表示">
                        </form><br>
                        <a href="{{ $urlListPreview }}" target="_blank">情報掲示板の公開画面</a><font size=-1>(編集できません)</font><br><br></td></tr>
                <tr>
                    <td bgcolor="#aa0000">
                        <font color="#ffffff">
                            <b>■拠店ページ ビジュアル改廃</b>
                        </font>
                    </td>
                    <td td bgcolor="#aa0000" align=right>
                        <font color="#ffffff">2153801/infobbs</font>
                    </td>
                </tr>
                <tr>
                    <td colspan=2>
                        <form action="{{ $urlDesignEdit ?? '' }}" method="get" target="_blank" style="margin:0em;">
                            <select name="shop">
                                @foreach ($shopList as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <br>
                            <input type=submit value="拠店ページ ビジュアル改廃の管理者画面を表示">
                        </form>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#088436">
                        <font color="#ffffff"><b>■来場イベント引換券印刷システム</b></font>
                    </td>
                    <td td bgcolor="#088436" align=right>
                        <font color="#ffffff">2153801/coupon</font>
                    </td>
                </tr>
                <tr>
                    <td colspan=2>
                        <form action="http://cgi3.hondanet.co.jp/cgi/grbbs3_edit.cgi?mode=admin&id=2153801/coupon&time=1592447140" method=post target="_blank" style="margin:0em;">
                            <input type="hidden" name="auth" value="">
                            <select name="SearchText_店舗">
                                @foreach ($shopList as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <br>
                            <input type=submit value="来場イベント引換券印刷システムの管理者画面を表示">
                            <input type=hidden name=Seq_code value=24805>
                        </form><br>
                        <a href="https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count_aichi.cgi?id=2153801/coupon" target="_blank">来場イベント引換券印刷システム閲覧数集計</a><br><br>
                        <br></td></tr>
                <tr>
                    <td bgcolor="#660000">
                        <font color="#ffffff"><b>■アクセス集計</b></font></td><td td bgcolor="#660000" align=right><font color="#ffffff"></font></td></tr><tr><td colspan=2>
                        <a href="{{ $urlActionAccessCounter }}" target="_blank">各店情報掲示板 店舗別集計ツール</a><br><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#009900"><font color="#ffffff"><b>■お礼メール</b></font></td><td td bgcolor="#009900" align=right><font color="#ffffff"></font></td></tr><tr><td colspan=2>
                        <a href="https://secure.hondanet.co.jp/cgi/admin/mail_sender.cgi?id=hc-aichi" target="_blank">お礼メール配信ツール</a><br><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#AACCFF">
                        <font color="#ffffff"><b>■情報掲示板　更新情報</b></font></td><td td bgcolor="#AACCFF" align=right><font color="#ffffff"></font></td></tr><tr><td colspan=2>
                        <a href="{{ $urlBlogUpdateLog }}" target=_blank>更新状況表示</a><br><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#cccccc">
                        <font color="#ffffff"><b>■社内用中古車情報</b>
                        </font>
                    </td>
                    <td td bgcolor="#cccccc" align=right><font color="#ffffff">2153801/usedcar</font></td></tr><tr><td colspan=2>
                        <form action="https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?mode=admin&id=2153801/usedcar&time=1592447140" method=post target="_blank" style="margin:0em;">
                            <input type="hidden" name="auth" value="">
                            <select name="SearchText_ブロック">
                                @foreach ($usedcarBlockCodes as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <br>
                            <input type=submit value="社内用中古車情報の管理者画面を表示">
                            <input type=hidden name=Seq_code value=10.0.240.236>
                        </form><br>
                        <a href="http://www.hondanet.co.jp/hondacars-aichi/syanai/usedcar.html" target="_blank">拠点用閲覧画面</a><br><br><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ff99cc"><font color="#ffffff"><b>■@ichi.com イベント掲示板</b></font></td><td td bgcolor="#ff99cc" align=right><font color="#ffffff">2153801/ladysday</font></td></tr><tr><td colspan=2>
                        <form action="https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?mode=admin&id=2153801/ladysday&time=1592447140" method=post target="_blank" style="margin:0em;">
                            <input type="hidden" name="auth" value="">
                            <select name="SearchText_店舗">
                                @foreach ($eventBlockCodes as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select><br>
                            <input type=submit value="@ichi.com イベント掲示板の管理者画面を表示">
                            <input type=hidden name=Seq_code value=10.0.240.236>
                        </form><br>
                        <br>
                    </td>
                </tr>
                <tr><td colspan=2 bgcolor="#ff3333"><font color="#ffffff"><b>■フォームアクセス数参照</b></font></td></tr>
                <tr><td colspan=2><a href=https://secure.hondanet.co.jp/cgi/admin/csv.cgi?id=cgi/2153801&read=hc-aichi target="_blank">フォームアクセス数参照ツール</a>&nbsp;  </td></tr>
            </table>
        </div>
    </body>
</html>
