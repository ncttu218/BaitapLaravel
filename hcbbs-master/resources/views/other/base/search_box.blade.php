
{{-- Form開始 --}}
{!! Form::model(
    $search,
    ['id'=> 'mainForm', 'method' => 'GET', 'url' => action_auto( $displayObj->ctl . '@getSearch')]
) !!}

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title text-center">検索</h3>
		</div>

		<table class="table table-condensed tbl-txt-center tbl-input-line search">
			<tr>
				{{-- 販社コード --}}
				<th class="bg-primary" style="width: 100px;">
					販社コード
				</th>
				<td>
					<?php
					// 販社プルダウンの値を取得する。
					$hanshaOptions = ["" => "----"] + \App\Models\Base::getHanshaOptions();
					?>
					{!! Form::select('hansha_code', $hanshaOptions, null, ['class' => 'form-control']) !!}
				</td>

				{{-- 拠点コード --}}
				<th class="bg-primary" style="width: 100px;">
					拠点コード
				</th>
				<td>
					{!! Form::text( 'base_code', null, ['class' => 'form-control'] ) !!}
				</td>
				
				{{-- 拠点名 --}}
				<th class="bg-primary" style="width: 100px;">
					拠点名
				</th>
				<td>
					{!! Form::text( 'base_name', null, ['class' => 'form-control'] ) !!}
				</td>

			</tr>
			<tr>
				{{-- 表示フラグ --}}
				<th class="bg-primary" style="width: 100px;">
					表示フラグ
				</th>
				<td>
					{!! Form::select( 'show_flg', $CodeUtil::getBaseShowFlgList(), null, ['class' => 'form-control'] ) !!}
				</td>
			</tr>
		</table>
	</div>
</div>

{{-- 新規作成・検索機能 --}}
<div class="row mb30">
	<div class="col-sm-2">
		<button type="button" onClick="location.href='{{ action_auto( $displayObj->ctl . '@getCreate') }}'" class="btn btn-warning btn-block btn-embossed">
			<i class="fa fa-pencil-square-o"></i> 新規作成
		</button>
	</div>
	<div class="col-sm-2">
	</div>
	<div class="col-sm-4 col">
		<button type="submit" class="btn btn-info btn-block btn-embossed">
			<i class="fa fa-search"></i> 検索
		</button>
	</div>
	<div class="col-sm-2 col-sm-offset-2">
		<button type="button" onClick="location.href='{{ action_auto( $displayObj->ctl . '@getIndex') }}'" class="btn btn-success btn-block btn-embossed">
			条件クリア
		</button>
	</div>
</div>

{!! Form::close() !!}
