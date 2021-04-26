
{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master')

{{-- CSSの定義 --}}
@section('css')
@parent
@stop

{{-- JSの定義 --}}
@section('js')
@parent
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
<div class="row">
    <form id="form_id" action="{{ $urlAction }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div align="center">
            このデータを削除します。よろしいですか？<br>
            <input type="submit" name="can" value="キャンセル" onclick="setHiddenValue(this)">
            <input type="submit" name="del" value="削除する" onclick="setHiddenValue(this)">
        </div>
        <div style="padding: 5px;background-color: #ccc;">[{{ $name }}]&nbsp;{{ $data['title'] }}</div>
        <div>
            {{ $data['comment'] }}
        </div>
    </form>
</div>
@stop
