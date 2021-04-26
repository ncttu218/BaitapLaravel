
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
			<i class="fa fa-pencil-square-o"></i> {{ $title }} データ確認
		</h5>

		{{-- エラーメッセージ --}}
		@include('_errors.list')
		
		{{-- 入力内容の読み込み --}}
		@yield("detail")
		
	</div>
</div>
@stop