
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
                        $hanshaName = \App\Models\Base::getHanshaName( $baseMObj->hansha_code );
                        ?>
                        {{ $hanshaName }}
                    </td>
                </tr>

                {{-- 拠点コード --}}
                <tr>
                    <th class="bg-primary">拠点コード</th>
                    <td>
                        {{ $baseMObj->base_code }}
                    </td>
                </tr>

                {{-- 拠点名 --}}
                <tr>
                    <th class="bg-primary">拠点名</th>
                    <td>
                        {{ $baseMObj->base_name }}
                    </td>
                </tr>

                {{-- 表示フラグ --}}
                <tr>
                    <th class="bg-primary">表示フラグ</th>
                    <td>
                        {{ $CodeUtil::getBaseShowFlgName( $baseMObj->show_flg ) }}
                    </td>
                </tr>

                {{-- 公開/非公開 --}}
                <tr>
                    <th class="bg-primary">公開/非公開</th>
                    <td>
                        @if ( $baseMObj->base_published_flg === 2 )
                            非公開
                        @else
                            公開
                        @endif
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
