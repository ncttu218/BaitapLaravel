
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
			<i class="fa fa-pencil-square-o"></i> {{ $title }}
		</h5>

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body text-center" style="padding: 10px;">
                    <h5 class="mb10">
                        お知らせの登録が完了しました。
                    </h5>

                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-5">
                            <button type="button" onClick="location.href='{{ $returnUrl }}'" class="btn btn-warning btn-block btn-embossed">
                                <i class="fa fa-mail-reply"></i> 戻る
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
		
	</div>
</div>
@stop
