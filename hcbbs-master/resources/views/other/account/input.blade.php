
{{-- カテゴリーレイアウトを継承 --}}
@extends('master.input')

{{-- 入力内容 --}}
@section("input")

{{-- 追加と編集の時で処理を分ける --}}
@if( $type == "edit" )
{{-- 編集の時の処理 --}}
{!! Form::model(
$userMObj,
['id'=> 'regEditForm', 'method' => 'PUT', 'url' => action_auto( $displayObj->ctl . '@putEdit') . "/" . $userMObj->id, 'enctype' => 'multipart/form-data']
) !!}
@else
{{-- 確認画面に遷移 --}}
{!! Form::model(
$userMObj,
['id'=> 'regEditForm', 'method' => 'PUT', 'url' => action_auto( $displayObj->ctl . '@putCreate'), 'enctype' => 'multipart/form-data']
) !!}
@endif

<div class="row">
    <div class="panel panel-default">
        <table class="table table-bordered tbl-txt-center tbl-input-line">
            <tbody>
                {{-- ログインID --}}
                <tr>
                    <th class="bg-primary">ログインID <span class="color-dpink">※</span></th>
                    <td>
                        {!! Form::text('user_login_id', null, ['size' => '20', 'maxlength' => '20', 'class' => 'form-control', 'required']) !!}
                        <div>※半角英数字</div>
                    </td>
                </tr>

                {{-- パスワード --}}
                <tr>
                    <th class="bg-primary">パスワード <span class="color-dpink">※</span></th>
                    <td>
                        {!! Form::text('user_password', null, ['size' => '10', 'maxlength' => '12', 'class' => 'form-control', 'required']) !!}
                        <div>※半角英数字</div>
                    </td>
                </tr>

                {{-- ユーザー名 --}}
                <tr>
                    <th class="bg-primary"> ユーザー名 <span class="color-dpink">※</span></th>
                    <td>
                        {!! Form::text('user_name', null, ['size' => '20', 'maxlength' => '20', 'class' => 'form-control', 'required']) !!}
                    </td>
                </tr>
                
                {{-- 販社 --}}
                <tr>
                    <th class="bg-primary">販社 <span class="color-dpink">※</span></th>
                    <td>
                        @if($type == 'create')
                        {{-- 新規作成 --}}
                            @if($accountLevel == 1)
                        {!! Form::select('hansha_code', Config('original.hansha_code'), $userMObj->hansha_code,['class' => 'form-control']) !!}
                            @else
                            {{-- 本社権限販社固定 --}}
                            {{ Config('original.hansha_code')[$loginAccountObj->getHanshaCode()] }}
                            <input type="hidden" name="hansha_code" value="{{ $userMObj->hansha_code }}">
                            @endif
                        @else
                        {{-- 編集は販社固定 --}}
                        {{ Config('original.hansha_code')[$userMObj->hansha_code] }}
                        <input type='hidden' name="hansha_code" value="{{ $userMObj->hansha_code }}">
                        @endif
                    </td>
                </tr>

                {{-- 店舗 --}}
                <tr>
                    <th class="bg-primary">店舗 <span class="color-dpink">※</span></th>
                    <td>
                        {!! Form::select('shop', $shopList, $userMObj->shop,['class' => 'form-control']) !!}
                    </td>
                </tr>

                {{-- 機能権限 --}}
                <tr>
                    <th class="bg-primary">機能権限 <span class="color-dpink">※</span></th>
                    <td>
                    @if($accountLevel == 1)
@if( isset( $value ) != True )
<?php $value = null; ?>
@endif
                        {!! Form::select('account_level', Config('original.authority'), $value,['class' => 'form-control']) !!}
                    @else
                    {{-- 本社権限は表示のみ --}}
                        @if($type == 'create')
                        {{-- 新規はスタッフのみ --}}
                        スタッフ
                        <input type='hidden' name="account_level" value="4">
                        @else
                        {{ Config('original.authority')[$userMObj->account_level] }}
                        <input type='hidden' name="account_level" value="{{ $userMObj->account_level }}">
                        @endif
                    @endif
                    </td>
                </tr>
                
                @if($accountLevel == 1)
                {{-- メールアドレス(六三用) --}}
                <tr>
                    <th class="bg-primary">メールアドレス(六三用)</th>
                    <td>
                        {!! Form::email('mail_mut', null, ['class' => 'form-control','multiple']) !!}
                        ※カンマ区切りで複数登録できます。
                    </td>
                </tr>

                {{-- メールアドレス(お客様用) --}}
                <tr>
                    <th class="bg-primary">メールアドレス(お客様用)</th>
                    <td>
                        {!! Form::email('mail_user', null, ['class' => 'form-control','multiple']) !!}
                        ※カンマ区切りで複数登録できます。
                    </td>
                </tr>

                {{-- 備考 --}}
                <tr>
                    <th class="bg-primary">備考</th>
                    <td>
                        {!! Form::text('bikou', null, ['size' => '40', 'maxlength' => '200', 'class' => 'form-control']) !!}
                    </td>
                </tr>
                @else
                
                <input type='hidden' name="mail_mut" value="">
                <input type='hidden' name="mail_user" value="">
                <input type='hidden' name="category" value="">
                <input type='hidden' name="bikou" value="">
                
                @endif
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
