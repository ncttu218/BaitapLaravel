{{-- リストマスターレイアウトを継承 --}}
@extends('master.list')

{{-- メイン部分の呼び出し --}}
@section('content')
<div class="row">

    {{-- メイン --}}
    <div id="main" class="col-sm-12">
        <h5 class="mb30"><i class="fa fa-th-list"></i> {{ $title }}</h5>

        {{-- 新規作成・検索機能 --}}
        @include( 'other.base.search_box' )

        {{-- ページネーション --}}
        @section('table_pager')
            {{-- ペジネートをインポート --}}
            @include( 'master.list.paginate', ['data' => $showData] )
        @show

        {{-- 販社一覧 --}}
        <div class="row">
            <div id="account-list" class="panel panel-default">
                <table class="table table-bordered table-hover tbl-pdg">
                    <thead>
                        <tr class="bg-primary tbl-txt-center">
                            <th>
                                @include( 'master.list.sort', [
                                    'name' => 'ID', 'url' => $sortUrl,
                                    'sort_key' => 'id', 'sortTypes' => $sortTypes
                                ])
                            </th>
                            <th>
                                @include( 'master.list.sort', [
                                    'name' => '販社コード', 'url' => $sortUrl,
                                    'sort_key' => 'hansha_code', 'sortTypes' => $sortTypes
                                ])
                            </th>
                            <th>
                                @include( 'master.list.sort', [
                                    'name' => '拠点コード', 'url' => $sortUrl,
                                    'sort_key' => 'base_code', 'sortTypes' => $sortTypes
                                ])
                            </th>
                            <th>拠点名</th>
                            <th>
                                @include( 'master.list.sort', [
                                    'name' => '表示フラグ', 'url' => $sortUrl,
                                    'sort_key' => 'show_flg', 'sortTypes' => $sortTypes
                                ])
                            </th>
                            <th>
                                @include( 'master.list.sort', [
                                    'name' => '公開/非公開', 'url' => $sortUrl,
                                    'sort_key' => 'base_published_flg', 'sortTypes' => $sortTypes
                                ])
                            </th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( !$showData->isEmpty() )
                        @foreach( $showData as $key => $value )
                        <tr>
                            {{-- ID --}}
                            <td class="list_td">
                                {{ $value->id }}
                            </td>

                            {{-- 販社コード --}}
                            <td class="list_td">
                                <?php
                                // 販社の値を取得する。
                                $hanshaName = \App\Models\Base::getHanshaName( $value->hansha_code );
                                ?>
                                {{ $hanshaName }}
                            </td>

                            {{-- 拠点コード --}}
                            <td class="list_td">
                                {{ $value->base_code }}
                            </td>

                            {{-- 拠点名 --}}
                            <td class="list_td">
                                {{ $value->base_name }}
                            </td>

                            {{-- 表示フラグ --}}
                            <td class="list_td">
                                {{ $CodeUtil::getBaseShowFlgName( $value->show_flg ) }}
                            </td>

                            {{-- 公開/非公開 --}}
                            <td class="list_td">
                                @if ( $value->base_published_flg === 2 )
                                    <span style="color: red;">非公開</span>
                                @else
                                    公開
                                @endif
                            </td>

                            {{-- 操作 --}}
                            <td class="list_td">
                                {{-- 詳細 --}}
                                <a href="{{ action_auto( $displayObj->ctl . '@getDetail', ['id' => $value->id] ) }}" title="詳細">
                                    <i class="fui-search"></i>
                                </a>
                                {{-- 編集 --}}
                                <a href="{{ action_auto( $displayObj->ctl . '@getEdit', ['id' => $value->id] ) }}" title="編集">
                                    <i class="fui-new"></i>
                                </a>
                                {{-- 削除 --}}
                                @if($loginAccountObj->getAccountLevel() == 1)
                                    <a href="{{ action_auto( $displayObj->ctl . '@getDelete', ['id' => $value->id] ) }}" onclick="return confirm('本当に削除してよろしいでしょうか？');" title="削除">
                                        <i class="fui-trash"></i>
                                    </a>
                                @endif
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

        {{-- ページネーション --}}
        @yield('table_pager')

    </div><!-- top row -->
</div><!-- main -->
@stop
