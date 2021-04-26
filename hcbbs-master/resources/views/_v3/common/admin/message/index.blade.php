{{-- リストマスターレイアウトを継承 --}}
@extends('master.list')

{{-- メイン部分の呼び出し --}}
@section('content')
<div class="row">

    {{-- メイン --}}
    <div id="main" class="col-sm-12">
        <h5 class="mb30"><i class="fa fa-th-list"></i> {{ $title }}</h5>

        {{-- 新規投稿 --}}
        <div class="row mb30">
            <div class="col-sm-2">
                @if ($shopDesignation)
                    <button type="button" onClick="location.href='{{ action_auto( $controller . '@getCreate') }}?shop={{ $shopCode }}'" class="btn btn-warning btn-block btn-embossed">
                @else
                    <button type="button" onClick="location.href='{{ action_auto( $controller . '@getCreate') }}'" class="btn btn-warning btn-block btn-embossed">
                @endif
                    <i class="fa fa-pencil-square-o"></i> 新規投稿
                </button>
            </div>

        </div>

        <form action="{{ $urlAction }}" method="post">
            {{ csrf_field() }}

            {{-- 削除ボタン --}}
            @section('del_button')
            <div style="border:2px solid #F00;text-align:left;padding: 5px;">
                下のボタンを押すと「削除」をチェックしたものをまとめて削除します。<br>
                <font color="ff0000">※一度削除すると元に戻せません。</font><br>
                <input type="submit" value="まとめて削除">
            </div>
            @show

            <br/>
            <div class="row">
                <div id="account-list" class="panel panel-default">
                    <table class="table table-bordered table-hover tbl-pdg tbl-txt-center" style="vertical-align: middle;">
                        <thead>
                            <tr class="bg-primary">
                                <th class="list_th" colspan="3">タイトル</th>
                                <th class="list_th" rowspan="2">操作</th>
                            </tr>
                            <tr class="bg-primary">
                                <th>掲載期間</th>
                                <th>並び替え</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( !empty( $showData ) )
                                @foreach( $showData as $key => $value )

                                    <tr>
                                        {{-- タイトル --}}
                                        <td class="list_td" colspan="3">
                                            {{ $value ->title }}
                                        </td>

                                        {{-- 操作 --}}
                                        <td class="list_td" rowspan="2">
                                            {{-- 詳細 --}}
                                            <a href="{{ action_auto( $controller . '@getDetail', ['id' => $value->id, 'shop' => $value->shop] ) }}" title="詳細">
                                                <i class="fui-search"></i>
                                            </a>
                                            {{-- 編集 --}}
                                            <a href="{{ action_auto( $controller . '@getEdit', ['id' => $value->id, 'shop' => $value->shop] ) }}" title="編集">
                                                <i class="fui-new"></i>
                                            </a>
                                        </td>

                                    </tr>
                                    <tr>
                                        {{-- 掲載期間 --}}
                                        <td class="list_td">
                                            {{-- 開始日 --}}
                                            @if( isset( $value ->from_date ) )
                                                {{ date( "Y年m月d日", strtotime( $value ->from_date ) ) }}
                                            @endif
                                            &nbsp;から&nbsp;
                                            {{-- 終了日 --}}
                                            @if( isset( $value ->to_date ) )
                                                {{ date( "Y年m月d日", strtotime( $value ->to_date ) ) }}
                                            @endif
                                            &nbsp;まで
                                        </td>
                                        
                                        {{-- 並び替え --}}
                                        <?php
                                        $separatorChar = $shopDesignation ? '&' : '?';
                                        $moveUppestUrl = $urlAction . "{$separatorChar}action=uppest&number={$value->number}";
                                        $moveUpperUrl = $urlAction . "{$separatorChar}action=upper&number={$value->number}";
                                        $moveLowerUrl = $urlAction . "{$separatorChar}action=lower&number={$value->number}";
                                        $moveLowestUrl = $urlAction . "{$separatorChar}action=lowest&number={$value->number}";
                                        ?>
                                        <td class="list_td">
                                            <a href="{{ $moveUppestUrl }}">△一番上へ移動</a>&nbsp;
                                            <a href="{{ $moveUpperUrl }}">▲一つ上へ移動</a>&nbsp;
                                            <a href="{{ $moveLowerUrl }}">▼一つ下へ移動</a>&nbsp;
                                            <a href="{{ $moveLowestUrl }}">▽一番下へ移動</a>
                                        </td>

                                        {{-- 削除 --}}
                                        <td class="list_td">
                                            <label>
                                                <input type="checkbox" name="{{ $value->number }}[del]">この記事を削除する
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            {{-- データがない時の表示 --}}
                            @include( 'master.list.none' )

                            @endif
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- 削除ボタン --}}
            @yield('del_button')

        </form>

    </div><!-- top row -->
</div><!-- main -->
@stop
