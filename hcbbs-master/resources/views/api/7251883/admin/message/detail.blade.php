{{-- カテゴリーレイアウトを継承 --}}
@extends('master.detail')

{{-- 確認内容 --}}
@section("detail")


<div class="row">
    <div class="panel panel-default">
        <table class="table table-bordered tbl-txt-center tbl-input-line">
            <tbody>
            {{-- タイトル --}}
                <tr>
                    <th class="bg-primary">タイトル</th>
                    <td>
                        {{ $messageObj ->title }}
                    </td>
                </tr>
                
                {{-- リンク先 --}}
                <tr>
                    <th class="bg-primary">リンク先</th>
                    <td>
                        {{ $messageObj->url }}
                    </td>
                </tr>
                
                {{-- リンクの開き方 --}}
                <tr>
                    <th class="bg-primary">リンクの開き方</th>
                    <td>
                        {{ $urlTargets[$messageObj->url_target] ?? '-' }}
                    </td>
                </tr>

                {{-- 掲載期間 --}}
                <tr>
                    <th class="bg-primary">掲載期間</th>
                    <td>
                        {{-- 開始日 --}}
                        @if( isset( $messageObj ->from_date ) )
                            {{ date( "Y年m月d日", strtotime( $messageObj ->from_date ) ) }}
                        @endif
                        &nbsp;から&nbsp;
                        {{-- 終了日 --}}
                        @if( isset( $messageObj ->to_date ) )
                            {{ date( "Y年m月d日", strtotime( $messageObj ->to_date ) ) }}
                        @endif
                        &nbsp;まで
                    </td>
                </tr>

                {{-- 店舗 --}}
                @if ($shopDesignation)
                <tr>
                    <th class="bg-primary">店舗</th>
                    <td>{{ $shopName }}</td>
                </tr>
                @endif

                {{-- 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ） --}}
                @if( $para_list['comment'] === '2' )

                    {{-- 店舗 --}}
                    <tr>
                        <th class="bg-primary">店舗</th>
                        <td>
                            大江店
                        </td>
                    </tr>

                @endif

            </tbody>
        </table>
    </div>
</div>

<div class="row">
    {{-- 戻るボタン --}}
    <div class="col-sm-2">
        @if ($shopDesignation)
            <button type="button" onClick="location.href ='{{ action_auto( $controller . '@getIndex') }}?shop={{ $messageObj->shop }}'" class="btn btn-warning btn-block btn-embossed">
        @else
            <button type="button" onClick="location.href ='{{ action_auto( $controller . '@getIndex') }}'" class="btn btn-warning btn-block btn-embossed">
        @endif
            <i class="fa fa-mail-reply"></i> 戻る
        </button>
    </div>

    <div class="col-sm-2">
    </div>
</div>

@stop
