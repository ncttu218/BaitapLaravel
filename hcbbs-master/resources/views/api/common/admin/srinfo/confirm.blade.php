
<html>
    <head>
    <title>{{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }} ／ショールーム</title>
    <STYLE TYPE="text/css">
    .l {
      font-size : 16px;
      line-height : 20px;
    }
    .m {
      font-size : 12px;
      line-height : 14px;
    }
    .s { font-size : 10px }
    a:hover {
      color : #d50000;
      text-decoration : none;
    }
    </STYLE>
    </head>
    <body bgcolor="#ffffff" text="#000000" link="#0000ff" alink="#ff0000" vlink="#000099">
    <table cellpadding=0 cellspacing=0 border=0 width=600>
    <tr><td>
    
    
    
    <link rel="stylesheet" type="text/css" href="http://www.hondacars-saitama.co.jp/site/css/import.css" />
    
    
        <div id="sr011">
        <!--<div id="sr013"><img src="img/c/t159.gif" alt="店長ごあいさつ" width="277" height="42" /></div>-->
        <div id="sea001"></div>
        <div class="clear"></div>
        </div>
    
        <div id="cgi030">
    
        <table border="0" cellspacing="0" cellpadding="0" class="cgi034">
        <tr>
        <td>
        
        <!--ごあいさつ ここから-->
    <p>
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
    <img src="{{ $imageUrl ?? '' }}" align="left" width="150" class="cgi031" />
    {!! nl2br($data['comment']) ?? '' !!}
    </p>
    <div align="right">
        {{ $shopName ?? '' }} 店長<br />
        {{ $data['mastername'] ?? '' }}
    </div>
    <!--ごあいさつ ここまで-->
        
        </td>
        </tr>
        </table>
        </div>
    
    </div>
    <!--中央列ここまで-->
    <hr>
    <font color=orange>このデータを登録します。よろしいですか？</font>
    <form action="{{ $urlAction ?? '' }}" method="post">
        {{ csrf_field() }}
        @foreach ($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
        @endforeach
        <input type="submit" name="edit" value="修正する">
        <input type="submit" name="ok" value="登録する">
    </form>
    <br>
    <br>
    </tr>
    </td>
    </table>
</body>
</html>
    