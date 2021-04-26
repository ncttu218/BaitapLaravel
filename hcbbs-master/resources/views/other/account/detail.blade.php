
{{-- カテゴリーレイアウトを継承 --}}
@extends('master.detail')

{{-- 確認内容 --}}
@section("detail")
<div class="row">
    <div id="account-list" class="panel panel-default">
        <table class="table table-bordered tbl-txt-center tbl-input-line">
            <tbody>
                {{-- ログインID --}}
                <tr>
                    <th class="bg-primary">ログインID</th>
                    <td>
                        {{ $userMObj->user_login_id }}
                    </td>
                </tr>

                {{-- パスワード --}}
                <tr>
                    <th class="bg-primary">パスワード</th>
                    <td>
                        {{ $userMObj->user_password }}
                    </td>
                </tr>

                {{-- ユーザー名 --}}
                <tr>
                    <th class="bg-primary">ユーザー名</th>
                    <td>
                        {{ $userMObj->user_name }}
                    </td>
                </tr>
                
                {{-- 販社 --}}
                <tr>
                    <th class="bg-primary">販社</th>
                    <td>
                        {{ Config('original.hansha_code')[$userMObj->hansha_code] }}
                    </td>
                </tr>

                {{-- 店舗No --}}
                <tr>
                    <th class="bg-primary">店舗</th>
                    <td>
                        {{ $shop_name }}
                    </td>
                </tr>

                {{-- 機能権限 --}}
                <tr>
                    <th class="bg-primary">機能権限</th>
                    <td>
                        {{ Config('original.authority')[$userMObj->account_level] }}
                    </td>
                </tr>

                {{-- メールアドレス(六三用) --}}
                <tr>
                    <th class="bg-primary"> メールアドレス(六三用)</th>
                    <td>
                        {{ $userMObj->mail_mut }}
                    </td>
                </tr>

                {{-- メールアドレス(お客様用) --}}
                <tr>
                    <th class="bg-primary"> メールアドレス(お客様用)</th>
                    <td>
                        {{ $userMObj->mail_user }}
                    </td>
                </tr>
                
                {{-- 本社承認機能 --}}
                <tr>
                    <th class="bg-primary"> 本社承認機能</th>
                    <td>
                        <?php 
                            $para = Config('original.para')[$userMObj->hansha_code];
                        ?>
                        {{ $para['published_mode'] ? 'ON':'OFF'}}
                    </td>
                </tr>
                {{-- カテゴリ --}}
                <tr>
                    <th class="bg-primary"> カテゴリ</th>
                    <td>
                        {{ $para['category'] }}
                    </td>
                </tr>

                {{-- 備考 --}}
                <tr>
                    <th class="bg-primary">備考</th>
                    <td>
                        {!! nl2br( $userMObj->bikou ) !!}
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
</div>

@stop
