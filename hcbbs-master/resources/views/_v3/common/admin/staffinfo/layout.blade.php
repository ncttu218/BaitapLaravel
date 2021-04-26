<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">

<!-- load inc_meta.html -->
<meta name="viewport" content="width=device-width">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="keywords" content="">
<meta name="description" content="">
<title>スタッフ紹介 | {{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }}</title>

@yield('css')
    
</head>
<body>
    <div id="wrap">
        <div id="contentsWrap">
            <div class="contents">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>