
{{-- カテゴリーレイアウトを継承 --}}
@extends('master.input')

@section('css')
@parent
<style type="text/css">
    .text-muted {
        font-size: 12px;
        margin-top: 20px;
    }
</style>
@endsection

{{-- 入力内容 --}}
@section("input")

{{-- 追加と編集の時で処理を分ける --}}
@if( $type == "edit" )
    {{-- 編集の時の処理 --}}
    {!! Form::model(
        $emailSettingsMObj,
        ['id'=> 'regEditForm', 'method' => 'PUT', 'url' => action_auto( $displayObj->ctl . '@putEdit') . "/" . $emailSettingsMObj->id, 'enctype' => 'multipart/form-data']
    ) !!}
@else
    {{-- 確認画面に遷移 --}}
    {!! Form::model(
        $emailSettingsMObj,
        ['id'=> 'regEditForm', 'method' => 'PUT', 'url' => action_auto( $displayObj->ctl . '@putCreate'), 'enctype' => 'multipart/form-data']
    ) !!}
@endif

{!! Form::hidden('system_name', $emailSettingsMObj->system_name) !!}
{!! Form::hidden('id', $emailSettingsMObj->id) !!}
{!! Form::hidden('original_email', $emailSettingsMObj->getOriginal('email')) !!}
{!! Form::hidden('type', $type) !!}

<script src="{{ asset_auto('js/mut_input_check.js') }}"></script>

<div class="row">
    <div class="panel panel-default">
        <table class="table table-bordered tbl-txt-center tbl-input-line">
            <tbody>
                @if ($emailSettingsMObj->system_name == 'forwarded_infobbs' || $emailSettingsMObj->system_name == 'forwarded_staff')
                    {{-- 転送メールアドレス --}}
                    <tr>
                        <th class="bg-primary">転送メール<span class="color-dpink">*</span></th>
                        <td>
                            {!! Form::text('forward_email', null, ['class' => 'form-control']) !!}
                            @if ($emailSettingsMObj->system_name == 'forwarded_infobbs')
                                <span class="text-muted">フォーマット：&lt;販社コード&gt;.infobbs@hondanet.co.jp</span>
                            @else
                                <span class="text-muted">フォーマット：&lt;販社コード&gt;.staff@hondanet.co.jp</span>
                            @endif
                        </td>
                    </tr>
                @else
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
                @endif

                {{-- 拠点コード --}}
                <tr>
                    <th class="bg-primary">拠点コード<span class="color-dpink">*</span></th>
                    <td>
                        {!! Form::text('shop_code', null, ['class' => 'form-control', 'onchange'=>'return checkAlphaNumOnly(this);', 'onkeyup'=>'return checkAlphaNumOnly(this);']) !!}
                    </td>
                </tr>

                {{-- スタッフコード --}}
                @if ($emailSettingsMObj->system_name == 'staff' || $emailSettingsMObj->system_name == 'forwarded_staff')
                <tr>
                    <th class="bg-primary">スタッフコード<span class="color-dpink">*</span></th>
                    <td>
                        {!! Form::text('staff_code', null, ['class' => 'form-control']) !!}
                        <span class="text-muted">フォーマット：data&lt;スタッフ番号&gt;</span>
                    </td>
                </tr>
                @endif

                {{-- システム名 --}}
                <tr>
                    <th class="bg-primary">システム名</th>
                    <td>
                        {{ $systemNameText }}
                    </td>
                </tr>

                {{-- メールアドレス --}}
                <tr>
                    <th class="bg-primary">メールアドレス<span class="color-dpink">*</span></th>
                    <td>
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<div class="row">
    {{-- 戻るボタン --}}
    <div class="col-sm-2">
        <button type="button" onClick="location.href ='{{ action_auto( $displayObj->ctl . '@getSearch') . '?system_name=' . $emailSettingsMObj->system_name }}'" class="btn btn-warning btn-block btn-embossed">
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
