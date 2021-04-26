{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master')

{{-- CSSの定義 --}}
@section('css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset_auto('css/style_ja.css') }}" />
@stop

{{-- JSの定義 --}}
@section('js')
@parent
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
<div class="row" style="background: white;">
    <form action="{{ $urlAction }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-sm-12" style="border:2px solid #F00;text-align:left;padding: 5px;">
            「一括編集ボタン」を押すと<br>
            <b>・「掲載OK／掲載不可」の変更が反映されます。</b><br>
            <input type="submit" value="一括編集" onclick="setHiddenValue(this)">
        </div>
        <div class="col-sm-12" style="margin: 10px 0;">
            @include('v2.common.admin.hobbs.pagination')
        </div>
        @foreach($blogs as $row)
        <div class="col-sm-12" style="border: 1px solid rgb(0, 0, 102);margin: 10px 0">
            <div class="row">
                <div class="col-sm-12">
                    @include($template)
                </div>
                <div class="col-sm-12">
                    カテゴリ: {{ $row->category ?? '-' }}
                    <br>
                    掲載期間:
                    @if($row->from_date)
                    {{ $row->from_date }}から
                    @endif
                    @if($row->to_date)
                    {{ $row->to_date }}まで
                    @endif
                    <br>
                    編集日時: {{ $row->updated_at }}
                </div>
                <div class="col-sm-12" style="text-align: right;">掲載処理&nbsp;
                    <label><input type="radio" name="{{ $row->number}}[published]" value="ON" {{ $row->published == 'ON' ? 'checked':null }}>掲載OK</label>&nbsp;&nbsp;
                    <label><input type="radio" name="{{ $row->number}}[published]" value="NG" {{ $row->published == 'NG' ? 'checked':null }}>掲載不可</label>&nbsp;&nbsp;
                    <label><input type="radio" name="{{ $row->number}}[published]" value="OFF" {{ $row->published == 'OFF' ? 'checked':null }}>掲載待ち</label>
                </div>
                <div class="col-sm-12">お店から: {{ $row->msg1 ?? '-' }}<br>
                    本社から:<br>
                    <textarea style="font-size: 14px;width:100%;height:150px;" placeholder="公開NGの場合、その理由をお書きください" name="{{ $row->number }}[msg2]">{{ $row->msg2 }}</textarea>
                </div>
            </div>
        </div>
        @endforeach
        
        <div class="col-sm-12" style="margin: 10px 0;">
            @include('v2.common.admin.hobbs.pagination')
        </div>
        
        <div class="col-sm-12" style="border:2px solid #F00;text-align:left;padding: 5px;">
            「一括編集ボタン」を押すと<br>
            <b>・「掲載OK／掲載不可」の変更が反映されます。</b><br>
            <input type="submit" value="一括編集" onclick="setHiddenValue(this)">
        </div>
    </form>
</div>
@stop
