
{{-- Form開始 --}}
{!! Form::model(
    $search,
    ['id'=> 'mainForm', 'method' => 'GET', 'url' => action_auto( $displayObj->ctl . '@getSearch') . '?system_name=' . $systemName]
) !!}

{!! Form::hidden('system_name', $systemName) !!}

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
                                    $options = \App\Models\Base::getHanshaOptions();
                                    if ($systemName == 'forwarded_infobbs') {
                                        // 販社プルダウンの値を取得する。
                                        $dataOptions = [];
                                        foreach ($options as $key => $value) {
                                            $newKey = "{$key}.infobbs@hondanet.co.jp";
                                            $dataOptions[$newKey] = $value;
                                        }
                                        $hanshaOptions = ["" => "----"] + $dataOptions;
                                        echo Form::select('forward_email', $hanshaOptions, null, ['class' => 'form-control']);
                                    } else if ($systemName == 'forwarded_staff') {
                                        // 販社プルダウンの値を取得する。
                                        $dataOptions = [];
                                        foreach ($options as $key => $value) {
                                            $newKey = "{$key}.staff@hondanet.co.jp";
                                            $dataOptions[$newKey] = $value;
                                        }
                                        $hanshaOptions = ["" => "----"] + $dataOptions;
                                        echo Form::select('forward_email', $hanshaOptions, null, ['class' => 'form-control']);
                                    } else {
                                        // 販社プルダウンの値を取得する。
                                        $hanshaOptions = ["" => "----"] + $options;
                                        echo Form::select('hansha_code', $hanshaOptions, null, ['class' => 'form-control']);
                                    }
                                    ?>
				</td>

				{{-- 拠点コード --}}
				<th class="bg-primary" style="width: 100px;">
					拠点コード
				</th>
				<td>
					{!! Form::text( 'shop_code', null, ['class' => 'form-control'] ) !!}
				</td>
				
				{{-- スタッフコード --}}
                                @if ($systemName == 'staff' || $systemName == 'forwarded_staff')
				<th class="bg-primary" style="width: 100px;">
					スタッフコード
				</th>
				<td>
					{!! Form::text( 'staff_code', null, ['class' => 'form-control'] ) !!}
				</td>
                                @endif

			</tr>
			<tr>
				{{-- メールアドレス --}}
				<th class="bg-primary" style="width: 100px;">
					メールアドレス
				</th>
				<td>
					{!! Form::text( 'email', null, ['class' => 'form-control'] ) !!}
				</td>
			</tr>
		</table>
	</div>
</div>

{{-- 新規作成・検索機能 --}}
<div class="row mb30">
	<div class="col-sm-2">
		<button type="button" onClick="location.href='{{ action_auto( $displayObj->ctl . '@getCreate', ['mail_post_type' => $systemName]) }}'" class="btn btn-warning btn-block btn-embossed">
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
		<button type="button" onClick="location.href='{{ action_auto( $displayObj->ctl . '@getSearch') . '?system_name=' . $systemName }}'" class="btn btn-success btn-block btn-embossed">
			条件クリア
		</button>
	</div>
</div>

{!! Form::close() !!}
