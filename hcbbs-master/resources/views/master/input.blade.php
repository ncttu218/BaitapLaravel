
{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master')

{{-- メイン部分 --}}
@section('content')
<div class="row">
	
	{{-- メニューの読み込み --}}
	@yield("tabs")
	
	{{-- メイン --}}
	<div id="main" class="col-sm-12">
		<h5 class="mb30">
			<i class="fa fa-pencil-square-o"></i> {{ $title }} データ入力
		</h5>
		
		<p class="color-dpink">※は必須項目です。</p>
		
		{{-- エラーメッセージ --}}
		@include('_errors.list')
		
		{{-- 入力内容の読み込み --}}
		@yield("input")
		
	</div>
</div>
@stop