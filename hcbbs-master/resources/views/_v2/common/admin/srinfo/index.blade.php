<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">

<title>{{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }} ／　スタッフページ拠点コメント</title>
<style type="text/css">
<!--
FORM{margin: 0em;} 
-->
</style>
<body bgcolor="#ffffff" text="#000000" link="#0000ff" alink="#ff0000" vlink="#000099">
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tbody><tr>
  <td> 
    <table width="600" border="0" cellspacing="0" cellpadding="5">
    <tbody><tr> 
      <td bgcolor="#000066" align="center"><font color="#FFFFFF" style="font-size:20px;"><b> 
      ショールーム情報編集</b></font> </td>
    </tr>
    <!-- tr> 
      <td> <a href="3">新規データ追加</a><br>
      </td>
    </tr -->
    <tr> 
      <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tbody><tr> 
        <td bgcolor="#000066"> 
          <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tbody><tr> 
            <td bgcolor="#FFFFFF" colspan="2" valign="top"> 
            <hr noshade="" size="1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td bgcolor="#FFFFFF" width="99%" valign="top">
                <font style="font-size:20px; lineheight :20px;">
                <strong>■{{ $shopName }}</strong>
                </font>
                <hr>
            <font style="font-size:12px; lineheight :12px;">
            <?php
            if (strstr($srInfoObj->file, 'data/image/' . $hanshaCode)) {
                $imageUrl = asset_auto( $srInfoObj->file );
            } else {
                $imageUrl = asset_auto( 'data/image/' . $hanshaCode . '/' . $srInfoObj->file );
            }
            ?>
            <a href="{{ $imageUrl }}" target="_blank">
                <img src="{{ $imageUrl }}" width="980" border="0" f1="">
            </a>
            <hr>
              {!! nl2br($srInfoObj->comment) !!}
            </font> </td>
              </tr>
              <tr><td colspan="2"><a href="{{ action_auto( $controller . '@getEdit' ) }}">このデータを編集する</a></td></tr>
            </tbody></table>
            </td>
          </tr>
          </tbody></table>
        </td>
        </tr>
      </tbody></table>
      </td>
    </tr>
    <!-- LIST MODE END -->
    </tbody></table>
  </td>
  </tr>
</tbody></table>
<br>



</body></html>