
<!-- saved from url=(0106)https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1011801/shop&mode=singleedit&num=data000001&shop=03 -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>{{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }} ／　スタッフページ拠点コメント</title>
<body bgcolor="#ffffff" text="#000000" link="#0000ff" alink="#ff0000" vlink="#000099">
<center>
<table cellpadding="3" cellspacing="0" border="0" width="600">
<tbody><tr>
    <td bgcolor="#000066" align="center"> <font color="#ffffff" style="font-size :12px; lineheight :12px;"><b> 
      {{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }} ／　スタッフページ拠点コメント
     ／掲載データ編集画面</b><br>
<br>
    </font> </td>
  </tr></tbody></table>
<br>
{{-- フォームタグ --}}
    {!! Form::model(
        $srInfoObj,
        ['method' => 'POST', 'url' => $urlAction, 'files' => true, 'id' => 'formInput']
    ) !!}
      {{ csrf_field() }}
<table width="600" cellpadding="1" cellspacing="0" border="0">
<tbody><tr><td bgcolor="#000000">
      <table width="100%">
      <tbody><tr> 
        <td bgcolor="#000066"> <font color="#FFFFFF" style="font-size :12px; lineheight :12px;"> 
        スタッフ集合写真 </font> </td>
        <td bgcolor="#ffffff">
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
            <br>
        <font color="#000000" style="font-size :12px; lineheight :12px;"> 
        </font> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr> 
          <td><font color="#000000" style="font-size :12px; lineheight :12px;"> 
            {{ Form::file('file') }}
            <input type="checkbox" name="ファイル" value="file_del">
            この画像を削除 </font></td>
          </tr>
        </tbody></table>
        </td>
      </tr>
      <tr> 
        <td bgcolor="#000066"> <font color="#FFFFFF" style="font-size :12px; lineheight :12px;"> 
        拠点名 </font> </td>
        <td bgcolor="#ffffff"> <font color="#000000" style="font-size :12px; lineheight :12px;">
            {{ $shopName }}
        </font> </td>
      </tr>
      <tr> 
        <td bgcolor="#000066"> <font color="#FFFFFF" style="font-size :12px; lineheight :12px;"> 
        コメント </font> </td>
        <td bgcolor="#ffffff"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
        <textarea name="comment" cols="50" rows="15">{{ $srInfoObj->comment }}</textarea>
        </font> </td>
      </tr>
      </tbody></table>
<input type="reset" value="内容をクリア "><input type="submit" value="　次へ　"><br>
</td></tr></tbody></table>
        <input type="hidden" name="id" value="{{ $srInfoObj->id }}">
    {!! Form::close() !!}
</center>

</body></html>