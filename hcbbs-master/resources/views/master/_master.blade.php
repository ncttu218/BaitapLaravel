<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="format-detection" content="telephone=no">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="robots" content="noindex,nofollow">
<meta name="googlebot" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
    {{ $loginAccountObj ? $loginAccountObj->getUserName() : "" }}
    {{ Config::get('original.title') }}
</title>

{{-- CSSの定義 --}}
@section('css')
<link rel="stylesheet" href="{{ asset_auto('css/vendor/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset_auto('jquery-ui/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset_auto('css/flat-ui.css') }}">
<link rel="stylesheet" href="{{ asset_auto('datetimepicker/jquery.datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset_auto('css/style.css') }}">
@show

{{-- JSの定義 --}}
@section('js')
<script src="{{ asset_auto('js/vendor/jquery.min.js') }}"></script>
<script src="{{ asset_auto('jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset_auto('jquery-ui/jquery.ui.datepicker-ja.js') }}"></script>
<script src="{{ asset_auto('js/vendor/video.js') }}"></script>
<script src="{{ asset_auto('js/flat-ui.min.js') }}"></script>
<script src="{{ asset_auto('js/application.js') }}"></script>
<script src="{{ asset_auto('datetimepicker/build/jquery.datetimepicker.full.js') }}"></script>
@show

{{-- タブのアイコン --}}
@section('img')
<link rel="shortcut icon" href="{{ asset_auto('img/icon.gif') }}">
@show

</head>

{{-- Loginの時に処理を分ける --}}
<body>

<div id="wrap">

    {{-- ヘッダー部分の呼び出し --}}
    @if( $loginAccountObj != null )
	@include('master._header')
    @endif
	
    <div id="contents">
        <div class="container">
	{{-- タブ部分の呼び出し --}}
	@yield('content')
	</div>
    </div>

	{{-- フッター部分の呼び出し --}}
 @include('master._footer')

</div>
@if ($loginAccountObj && $loginAccountObj->getHanshaCode() === '1006078')
<img src="http://cgi2.hondanet.co.jp/cgi/admin/admin_seq.cgi?id=cgi/1006078/master">
@endif
</body>
</html>
