<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />
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
<link rel="stylesheet" type="text/css" href="{{ asset_auto('css/style_ja.css') }}" />
<link rel="stylesheet" href="{{ asset_auto('datetimepicker/jquery.datetimepicker.css') }}">
<style type="text/css">
.p-entrylist-box__body .p-entrylist-box__summary > div{
    word-wrap: break-word;
}
</style>
@section('css')
@show

{{-- タブのアイコン --}}
@section('img')
<link rel="shortcut icon" href="{{ asset_auto('img/icon.gif') }}">
@show

</head>

{{-- Loginの時に処理を分ける --}}
<body class="l-page">

<div class="l-wrapper" id="js-wrapper">

    {{-- ヘッダー部分の呼び出し --}}
    @if( $loginAccountObj != null )
	@include('master._header_ja')
    @endif
	
    <main class="l-main" id="js-main" role="main">
        <div class="l-page-contents">
            {{-- タブ部分の呼び出し --}}
            @yield('content')
	</div>
    </main>

{{-- フッター部分の呼び出し --}}
@include('master._footer_ja')

</div>

{{-- JSの定義 --}}
<script src="{{ asset_auto('js/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset_auto('datetimepicker/build/jquery.datetimepicker.full.js') }}"></script>
<script src="{{ asset_auto('js/common.js') . '?' . time() }}"></script>
@section('js')
@show
<div id="scrollBar">
    <a href="#"><img src="{{ asset_auto('img/scrollTop.png') }}" style="width:50px;"></a>
</div>
@if ($loginAccountObj && $loginAccountObj->getHanshaCode() === '1006078')
<img src="http://cgi2.hondanet.co.jp/cgi/admin/admin_seq.cgi?id=cgi/1006078/master">
@elseif( !empty( $loginAccountObj->getHanshaCode()  ) )
<img src="http://cgi2.hondanet.co.jp/cgi/admin/admin_seq.cgi?id=cgi/{{ $loginAccountObj->getHanshaCode() }}/master">
@endif
</body>

</html>
