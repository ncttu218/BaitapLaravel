<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>{{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }} ／　スタッフページ拠点コメント</title>
<style type="text/css">
.alert.alert-danger{
  font-size: 12px;
  color: #f00;
  margin: 10px;
}
</style>
</head>
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
<table width="600" cellpadding="1" cellspacing="0" border="0">
<tbody>
  <tr>
    <td bgcolor="#000000">
      <table width="100%">
        <tbody>
        {{-- 拠点名 --}}
        <tr> 
            <td bgcolor="#000066">
                <font color="#FFFFFF" style="font-size :12px; lineheight :12px;"> 
                拠点名
                </font>
            </td>
            <td bgcolor="#ffffff">
                <font color="#000000" style="font-size :12px; lineheight :12px;">
                {{ $shopName }}
                </font>
            </td>
        </tr>
        {{-- コメント --}}
        <tr> 
            <td bgcolor="#000066">
                <font color="#FFFFFF" style="font-size :12px; lineheight :12px;"> 
                    コメント
                </font>
            </td>
            <td bgcolor="#ffffff">
                @include('_errors.list')
                <font color="#000000" style="font-size :12px; lineheight :12px;">
                {{ Form::textarea('comment', $data['comment'] ?? '', ['cols' => '50', 'rows' => '15']) }}
                </font>
            </td>
        </tr>
        {{-- 店長名 --}}
        <tr> 
            <td bgcolor="#000066">
                <font color="#FFFFFF" style="font-size :12px; lineheight :12px;"> 
                店長名
                </font>
            </td>
            <td bgcolor="#ffffff">
                <font color="#000000" style="font-size :12px; lineheight :12px;">
                    {{ Form::text('mastername', $data['mastername'] ?? '', ['size' => 50]) }}
                </font>
            </td>
        </tr>
        {{-- 店長写真 --}}
        <tr> 
            <td bgcolor="#000066">
                <font color="#FFFFFF" style="font-size :12px; lineheight :12px;"> 
                店長写真
                </font>
            </td>
            <td bgcolor="#ffffff">
                <?php
                if (isset($data['file_master']) && !empty($data['file_master'])) {
                    if (preg_match('/^[^\/]+$/', $data['file_master'])) {
                        $imageUrl = "https://cgi3-aws.hondanet.co.jp/cgi/{$hanshaCode}/shop/data/image/{$data['file_master']}";
                    } else {
                        if (strstr($data['file_master'], 'data/image/' . $hanshaCode)) {
                            $imageUrl = asset_auto( $data['file_master'] );
                        } else {
                            $imageUrl = asset_auto( 'data/image/' . $hanshaCode . '/' . $data['file_master'] );
                        }
                    }
                } else {
                    $imageUrl = asset_auto('img/no_image.gif');
                }
                ?>
                <a href="{{ $imageUrl ?? '' }}" target="_blank">
                    <img src="{{ $imageUrl ?? '' }}" id="target" width="150" border="0" f1="">
                </a>
                <br>
            <font color="#000000" style="font-size :12px; lineheight :12px;"> 
            </font> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                  <tr> 
                    <td>
                        <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                        {{ Form::file('file_master', ['id' => 'src', 'accept' => 'image/*']) }}
                        <input type="checkbox" name="file_del" value="ファイル">
                        この画像を削除
                        </font>
                    </td>
                  </tr>
                </tbody>
            </table>
            </td>
        </tr>
        </tbody>
      </table>
      <input type="reset" value="内容をクリア ">
      <input type="submit" value="　次へ　"><br>
    </td>
  </tr>
</tbody>
</table>
        <input type="hidden" name="id" value="{{ $data['id'] ?? '' }}">
    {!! Form::close() !!}
</center>
<script type="text/javascript">
function showImage(src,target) {
  var fr=new FileReader();
  // when image is loaded, set the src of the image where you want to display it
  fr.onload = function(e) { target.src = this.result; };
  src.addEventListener("change",function() {
    // fill fr with image data    
    fr.readAsDataURL(src.files[0]);
  });
}

var src = document.getElementById("src");
var target = document.getElementById("target");
showImage(src,target);
</script>
</body></html>