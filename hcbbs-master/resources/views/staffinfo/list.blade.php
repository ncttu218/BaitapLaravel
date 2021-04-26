@extends('staffinfo.layout')

@section('css')
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/import.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/font-awesome.min.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/common.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/style.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/top.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/DEMO_sr.css ') }}">
@stop

@section('content')
<h2 class="pageTitle">{{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }}　スタッフ紹介</h2>
<div class="contents__main">
    {{-- フォームタグ --}}
    {!! Form::model(
        null,
        ['method' => 'POST', 'url' => $urlAction]
    ) !!}
    {{ csrf_field() }}
    <table width="100%" border="0" cellspacing="0" cellpadding="1" height="100%">
        <tbody>
            <tr>
                <td align="center"> 
                    <table width="800" border="0" cellspacing="0" cellpadding="5">
                        <tbody>
                            <tr> 
                                <td> 
                                    <a href="{{ action_auto( $controller . '@getCreate' ) }}?shop={{ $shopCode }}">新規データ追加</a><br>
                                        <br>
                                        <font size="2">下のボタンを押すと「等級」に設定した並び順の反映と、「削除」をチェックしたものをまとめて更新します。</font><br>
                                        <font size="2" color="ff0000">※一度削除すると元に戻せません。</font><br>
                                        <input type="submit" value="まとめて更新">
                                        <hr>
                                        {{-- ページ表示 --}}
                                        @include('staffinfo.pagination')
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="staff">
                                        <ul class="staff-list">
                                            {{-- スタッフの一覧を表示 --}}
                                            @foreach( $list as $row )
                                                <li class="staff-item" id="st03_000913">
                                                    {{-- スタッフの氏名 --}}
                                                    <div class="staff-item__name">
                                                        <span>{{ $row->name }}</span>
                                                        <i class="staff10">{{ $CodeUtil::getDegreeName( $row->degree ) }}</i>
                                                    </div>

                                                    {{-- スタッフ情報 --}}
                                                    <div class="staff-item__detail">

                                                        {{-- スタッフ写真 --}}
                                                        <figure>
                                                            @if (strstr($row->photo, 'data/image/' . $hanshaCode))
                                                                <img src="{{ asset_auto( $row->photo ) }}" border="0" height="150" f6="">
                                                            @else
                                                                <img src="{{ asset_auto( 'data/image/' . $hanshaCode . '/' . $row->photo ) }}" border="0" height="150" f6="">
                                                            @endif
                                                        </figure>

                                                        {{-- 上段基本情報 --}}
                                                        <dl class="staff-item__profile">
                                                            {{-- 血液型 --}}
                                                            <dt>血液型</dt>
                                                            <dd>{{ $row->ext_value1 }}</dd>
                                                            {{-- 出身地 --}}
                                                            <dt>出身地</dt>
                                                            <dd>{{ $row->ext_value2 }}</dd>
                                                            {{-- 資　格 --}}
                                                            <dt>資　格</dt>
                                                            <dd>
                                                                <ul>
                                                                    <li>{{ $row->ext_value3 }}</li>
                                                                    <li>{{ $row->ext_value3_2 }}</li>
                                                                    <li>{{ $row->ext_value3_3 }}</li>
                                                                    <li>{{ $row->ext_value3_4 }}</li>
                                                                    <li>{{ $row->ext_value3_5 }}</li>
                                                                    <li>{{ $row->ext_value3_6 }}</li>
                                                                </ul>
                                                            </dd>
                                                        </dl>

                                                        {{-- 下段基本情報 --}}
                                                        <dl class="staff-item__profile--more">
                                                            {{-- 愛してやまないもの --}}
                                                            <dt>愛してやまないもの</dt>
                                                            <dd>
                                                                <ul>
                                                                    <li>{{ $row->ext_value4 }}</li>
                                                                    <li>{{ $row->ext_value4_2 }}</li>
                                                                    @if( !empty( $row->ext_value4_3  ) == True )
                                                                        <li>{{ $row->ext_value4_3 }}</li>
                                                                    @endif
                                                                    @if( !empty( $row->ext_value4_4  ) == True )
                                                                        <li>{{ $row->ext_value4_4 }}</li>
                                                                    @endif
                                                                    @if( !empty( $row->ext_value4_5  ) == True )
                                                                        <li>{{ $row->ext_value4_5 }}</li>
                                                                    @endif
                                                                    @if( !empty( $row->ext_value4_6  ) == True )
                                                                        <li>{{ $row->ext_value4_6 }}</li>
                                                                    @endif
                                                                </ul>
                                                            </dd>
                                                        </dl>
                                                    </div>

                                                    {{-- コメント --}}
                                                    <p class="staff-item__comment">{{ $row->comment }}</p>

                                                    {{-- 削除・編集 --}}
                                                    <div class="admin_edit">
                                                        削除<input type="checkbox" name="ListDelete[]" value="{{ $row->number }}">
                                                        &nbsp;&nbsp;
                                                        等級： <input type="text" size="4" name="AdminEdit[{{ $row->number }}]" value="{{ $row->grade }}">   &nbsp;&nbsp;
                                                        <a href="{{ action_auto( $controller . '@getEdit', ['id' => $row->id] ) }}">このデータを編集する</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <!-- LIST MODE END -->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr> 
                                <td align="center"> 
                                    <hr>
                                    {{-- ページ表示 --}}
                                    @include('staffinfo.pagination')
                                </td>
                            </tr>
                            <tr> 
                                <td>
                                    <font size="2">下のボタンを押すと「等級」に設定した並び順の反映と、「削除」をチェックしたものをまとめて更新します。</font><br>
                                    <font size="2" color="ff0000">※一度削除すると元に戻せません。</font><br>
                                    <input type="submit" value="まとめて更新">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    {!! Form::close() !!}
</div>
@stop
