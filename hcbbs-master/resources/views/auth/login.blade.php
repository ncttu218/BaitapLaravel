{{-- トップマスターレイアウトを継承 --}}
@extends('master._master')

{{-- メイン部分の呼び出し --}}
@section('content')
<br/><br/>
<div class="row text-center">
	<div class="login-icon-box">
		<img src="{{ asset_auto('img/login/login.gif') }}" height="210" alt="{{ Config::get('original.title') }}" />
	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<div class="login-form">
			<h4 style="text-align: center;">{{ Config::get('original.title') }}</h4>

			<form method="POST" action="" name="login">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				
				{{-- ユーザーID --}}
				<div class="form-group">
					<input type="text" name="id" value="{{ old('id') }}" class="form-control login-field" id="login-name" placeholder="Enter your ID">
					<label class="login-field-icon fui-user" for="login-name"></label>
				</div>

				{{-- パスワード --}}
				<div class="form-group">
					<input type="password" name="password" value="{{ old('password') }}" class="form-control login-field" placeholder="Password" id="login-pass">
					<label class="login-field-icon fui-lock" for="login-pass"></label>
				</div>
				
				{{-- エラーメッセージ --}}
                @include('_errors.list')
                <br/>
				
                {{-- ログインボタン --}}
				<a class="btn btn-danger btn-lg btn-block btn-embossed" href="javascript:void(0)" onclick="document.login.submit();return false;">ログイン</a>				
			</form>
		</div>
	</div>
</div>
@stop