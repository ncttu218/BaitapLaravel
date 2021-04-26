
{{-- カテゴリーレイアウトを継承 --}}
@extends('master.input')

{{-- 入力内容 --}}
@section("input")

{{-- 追加と編集の時で処理を分ける --}}
@if( $type == "edit" )
{{-- 編集の時の処理 --}}
{!! Form::model(
$baseMObj,
['id'=> 'regEditForm', 'method' => 'PUT', 'url' => action_auto( $displayObj->ctl . '@putEdit') . "/" . $baseMObj->id, 'enctype' => 'multipart/form-data']
) !!}
@else
{{-- 確認画面に遷移 --}}
{!! Form::model(
$baseMObj,
['id'=> 'regEditForm', 'method' => 'PUT', 'url' => action_auto( $displayObj->ctl . '@putCreate'), 'enctype' => 'multipart/form-data']
) !!}
@endif

<script src="{{ asset_auto('js/mut_input_check.js') }}"></script>

<div class="row">
    <div class="panel panel-default">
        <table class="table table-bordered tbl-txt-center tbl-input-line">
            <tbody>
                {{-- 販社コード --}}
                <tr>
                    <th class="bg-primary">販社コード<span class="color-dpink">*</span></th>
                    <td>
                        <?php
                        // 販社プルダウンの値を取得する。
                        $hanshaOptions = ["" => "----"] + \App\Models\Base::getHanshaOptions();
                        ?>
                        {!! Form::select('hansha_code', $hanshaOptions, null, ['class' => 'form-control', 'onchange'=>'return checkNumOnly(this);', 'onkeyup'=>'return checkNumOnly(this);']) !!}
                    </td>
                </tr>

                {{-- 拠点コード --}}
                <tr>
                    <th class="bg-primary">拠点コード<span class="color-dpink">*</span></th>
                    <td>
                        {!! Form::text('base_code', null, ['class' => 'form-control', 'onchange'=>'return checkAlphaNumOnly(this);', 'onkeyup'=>'return checkAlphaNumOnly(this);']) !!}
                    </td>
                </tr>

                {{-- 拠点名 --}}
                <tr>
                    <th class="bg-primary">拠点名<span class="color-dpink">*</span></th>
                    <td>
                        {!! Form::text('base_name', null, ['class' => 'form-control']) !!}
                    </td>
                </tr>

                {{-- 表示フラグ --}}
                <tr>
                    <th class="bg-primary">表示フラグ</th>
                    <td>
                        {!! Form::select( 'show_flg', $CodeUtil::getBaseShowFlgList(), null, ['class' => 'form-control'] ) !!}
                    </td>
                </tr>


                {{-- 公開/非公開 --}}
                <tr>
                    <th class="bg-primary">公開/非公開</th>
                    <td>
                        <?php
                        // 販社プルダウンの値を取得する。
                        $publishedList = [
                            "1" => "公開",
                            "2" => "非公開",
                        ];
                        ?>
                        {!! Form::select( 'base_published_flg', $publishedList, null, ['class' => 'form-control'] ) !!}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<div class="row">
    {{-- 戻るボタン --}}
    <div class="col-sm-2">
        <button type="button" onClick="location.href ='{{ action_auto( $displayObj->ctl . '@getIndex') }}'" class="btn btn-warning btn-block btn-embossed">
            <i class="fa fa-mail-reply"></i> 戻る
        </button>
    </div>

    {{-- 確認画面 --}}
    <div class="col-sm-4 col-sm-offset-2">
        {!! Form::submit( $type == "edit" ? '編集' : '登録', ['id' => $buttonId, 'class' => 'btn btn-info btn-block btn-embossed']) !!}
    </div>

    <div class="col-sm-2">
    </div>
</div>

{!! Form::close() !!}

@stop
