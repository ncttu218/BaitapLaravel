
{{-- カテゴリーレイアウトを継承 --}}
@extends('master.input')

{{-- JSの定義 --}}
@section('js')
@parent
<script>
    $(function(){
            // datepickerの呼び出し
        $('.datepicker').datepicker({
            showButtonPanel: false,
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
@stop

{{-- 入力内容 --}}
@section("input")

{{-- フォームタグ --}}
{!! Form::model(
    $messageObj,
    ['method' => 'POST', 'url' => $urlAction, 'files' => true, 'id' => 'formInput']
) !!}
    {{ csrf_field() }}
    
    {!! Form::hidden('type', $type) !!}
    
    @if ($type == 'edit')
        {!! Form::hidden( 'id', $messageId ) !!}
    @endif

    <div class="row">
        <div class="panel panel-default">
            <table class="table table-bordered tbl-txt-center tbl-input-line">
                <tbody>
                    {{-- タイトル --}}
                    <tr>
                        <th class="bg-primary">タイトル	 <span class="color-dpink">※</span></th>
                        <td>
                            {!! Form::text('title', null, ['class' => 'form-control']) !!}
                        </td>
                    </tr>

                    {{-- 掲載期間 --}}
                    <tr>
                        <th class="bg-primary">掲載期間</th>
                        <td>
                            <div class="form-inline">
                                <?php
                                // 開始日のフォーマット変更
                                if( isset( $messageObj->from_date ) == True ){
                                    $messageObj->from_date = date( "Y-m-d", strtotime( $messageObj ->from_date ) );
                                }
                                // 終了日のフォーマット変更
                                if( isset( $messageObj->to_date ) == True ){
                                    $messageObj->to_date = date( "Y-m-d", strtotime( $messageObj ->to_date ) );
                                }
                                ?>
                                {!! Form::text('from_date', null, ['class' => 'form-control datepicker', 'style' => 'width: 25%;']) !!}
                                <label>～</label>
                                {!! Form::text('to_date', null, ['class' => 'form-control datepicker', 'style' => 'width: 25%;']) !!}
                            </div>

                            ※開始日、終了日のみの入力も可能です。
                        </td>
                    </tr>
                    
                    {{-- 設定ファイルの1行メッセージ機能が、2（ 店舗指定有の時 ） --}}
                    @if( $para_list['message'] === '2' )

                        {{-- 店舗 --}}
                        <tr>
                            <th class="bg-primary">店舗</th>
                            <td>
                                {!! Form::hidden( 'shop', null ) !!}
                                {{ $shopName }}
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
            <button type="button" onClick="location.href ='{{ action_auto( $controller . '@getIndex') }}?shop={{ $shopCode }}'" class="btn btn-warning btn-block btn-embossed">
                <i class="fa fa-mail-reply"></i> 戻る
            </button>
        </div>

        {{-- 確認画面 --}}
        <div class="col-sm-4 col-sm-offset-2">
            {!! Form::submit( "確認画面へ", ['class' => 'btn btn-info btn-block btn-embossed']) !!}
        </div>

        <div class="col-sm-2">
        </div>
    </div>

{!! Form::close() !!}

@stop
