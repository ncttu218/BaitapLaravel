{{-- リストマスターレイアウトを継承 --}}
@extends('master.list')

{{-- メイン部分の呼び出し --}}
@section('content')
<div class="row">

    {{-- メイン --}}
    <div id="main" class="col-sm-12">

        {{-- タブ --}}
        @include('elements.tag.mail_post_type_tabs', ['selector' => 'system_name', 'selected' => $systemName, 'unset' => ['forward_email']])
        
        <h5 class="mb30"><i class="fa fa-th-list"></i> {{ $title }}</h5>

        {{-- 新規作成・検索機能 --}}
        @include( 'other.email_settings.search_box' )

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
                            @if ($systemName == 'forwarded_infobbs' || $systemName == 'forwarded_staff')
                                <th>転送メール</th>
                            @endif
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
                            @if ($systemName == 'staff' || $systemName == 'forwarded_staff')
                            <th>
                                @include( 'master.list.sort', [
                                    'name' => 'スタッフコード', 'url' => $sortUrl,
                                    'sort_key' => 'system_name', 'sortTypes' => $sortTypes
                                ])
                            </th>
                            @endif
                            <th>メールアドレス</th>
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
                            @if ($value->system_name == 'forwarded_infobbs' || $value->system_name == 'forwarded_staff')
                                {{-- メールアドレス --}}
                                <td class="list_td">
                                    {{ $value->forward_email }}
                                </td>
                            @endif
                            
                            <td class="list_td">
                                <?php
                                // 販社の値を取得する。
                                if ($value->system_name == 'forwarded_infobbs' || $value->system_name == 'forwarded_staff') {
                                    $value->hansha_code = preg_replace('/^([0-9]{7})\.(?:infobbs|staff).+$/', '$1', $value->forward_email);
                                }
                                $hanshaName = \App\Models\Base::getHanshaName( $value->hansha_code );
                                ?>
                                {{ $hanshaName }}
                            </td>

                            {{-- 拠点コード --}}
                            <td class="list_td">
                                {{ $value->shop_code }}
                            </td>

                            {{-- スタッフコード --}}
                            @if ($systemName == 'staff' || $systemName == 'forwarded_staff')
                            <td class="list_td">
                                {{ $value->staff_code }}
                            </td>
                            @endif

                            {{-- メールアドレス --}}
                            <td class="list_td">
                                {{ $value->email }}
                            </td>

                            {{-- 操作 --}}
                            <td class="list_td">
                                {{-- 詳細 --}}
                                <a href="{{ action_auto( $displayObj->ctl . '@getDetail', ['id' => $value->id] ) . '?system_name=' . $value->system_name }}" title="詳細">
                                    <i class="fui-search"></i>
                                </a>
                                {{-- 編集 --}}
                                <a href="{{ action_auto( $displayObj->ctl . '@getEdit', ['id' => $value->id] ) . '?system_name=' . $value->system_name }}" title="編集">
                                    <i class="fui-new"></i>
                                </a>
                                {{-- 削除 --}}
                                @if($loginAccountObj->getAccountLevel() == 1)
                                    <a href="{{ action_auto( $displayObj->ctl . '@getDelete', ['id' => $value->id] ) . '?system_name=' . $value->system_name }}" onclick="return confirm('本当に削除してよろしいでしょうか？');" title="削除">
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
