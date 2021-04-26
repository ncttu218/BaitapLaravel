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

                {{-- 設定ファイルの1行メッセージ機能が、1（ 店舗指定無の時 ） --}}
                @if( $para_list['comment'] === '1' )

                    {{-- リンク先URL --}}
                    <tr>
                        <th class="bg-primary">リンク先URL</th>
                        <td>
                            <a href="{{ $messageObj ->url }}" target="{{ $messageObj ->url_target }}">
                                {{ $messageObj ->url }}
                            </a>
                            <br/>

                            {{-- リンク先 --}}
                            <?php
                            $url_target_list = [
                                "" => "",
                                "_blank" => "別ウインドウ",
                                "_parent" => "同ウインドウ",
                            ];

                            $url_target_name = "";

                            // リンク先があるとき
                            if( isset( $messageObj ->url_target ) ){
                                $url_target_name = $url_target_list[$messageObj ->url_target];
                            }
                            ?>
                            リンク先： {{ $url_target_name }}

                        </td>
                    </tr>

                @endif

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

                <?php
                // 販社名の設定パラメータを取得
                $para_list = ( Config('original.para')[$hanshaCode] );
                ?>

                {{-- 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ） --}}
                @if( $para_list['message'] === '2' )

                    {{-- 店舗 --}}
                    <tr>
                        <th class="bg-primary">店舗</th>
                        <td>
                            {{ $shopName }}
                        </td>
                    </tr>

                @endif

            </tbody>
        </table>
    </div>
</div>

<div class="row">
    {{-- 修正するボタン --}}
    <div class="col-sm-2">
        <button type="button" onClick="history.back()" class="btn btn-warning btn-block btn-embossed">
            <i class="fa fa-mail-reply"></i> 修正する
        </button>
    </div>

    {{-- フォームタグ --}}
    {!! Form::model(
        $messageObj,
        ['method' => 'POST', 'url' => $urlAction]
    ) !!}

    {!! Form::hidden( 'comp_flg', 'True' ) !!}

        {{-- 確認画面 --}}
        <div class="col-sm-4 col-sm-offset-2">
            {!! Form::submit( "登録する", ['class' => 'btn btn-info btn-block btn-embossed']) !!}
        </div>

        <div class="col-sm-2">
        </div>
    {!! Form::close() !!}

    
</div>

@stop
