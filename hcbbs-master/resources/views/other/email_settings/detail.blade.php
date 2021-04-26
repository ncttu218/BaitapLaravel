
{{-- カテゴリーレイアウトを継承 --}}
@extends('master.detail')

{{-- 確認内容 --}}
@section("detail")
<div class="row">
    <div id="account-list" class="panel panel-default">
        <table class="table table-bordered tbl-txt-center tbl-input-line">
            <tbody>
            
                {{-- 販社コード --}}
                <tr>
                    <th class="bg-primary">販社コード</th>
                    <td>
                        <?php
                        // 販社の値を取得する。
                        $hanshaName = \App\Models\Base::getHanshaName( $emailSettingsMObj->hansha_code );
                        ?>
                        {{ $hanshaName }}
                    </td>
                </tr>

                {{-- 拠点コード --}}
                <tr>
                    <th class="bg-primary">拠点コード</th>
                    <td>
                        {{ $emailSettingsMObj->shop_code }}
                    </td>
                </tr>

                {{-- スタッフコード --}}
                {{-- スタッフコード --}}
                @if ($emailSettingsMObj->system_name == 'staff' || $emailSettingsMObj->system_name == 'forwarded_staff')
                <tr>
                    <th class="bg-primary">スタッフコード</th>
                    <td>
                        {{ $emailSettingsMObj->staff_code }}
                    </td>
                </tr>
                @endif

                {{-- システム名 --}}
                <tr>
                    <th class="bg-primary">システム名</th>
                    <td>
                        {{ $systemName }}
                    </td>
                </tr>

                {{-- メールアドレス --}}
                <tr>
                    <th class="bg-primary">メールアドレス</th>
                    <td>
                        {{ $emailSettingsMObj->email }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<div class="row">
    {{-- 戻るボタン --}}
    <div class="col-sm-2">
        <button type="button" onClick="location.href ='{{ action_auto( $displayObj->ctl . '@getSearch') . '?system_name=' .  $emailSettingsMObj->system_name }}'" class="btn btn-warning btn-block btn-embossed">
            <i class="fa fa-mail-reply"></i> 戻る
        </button>
    </div>
</div>

@stop
