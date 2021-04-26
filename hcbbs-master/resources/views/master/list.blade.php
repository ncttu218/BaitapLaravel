{{-- トップマスターレイアウトを継承 --}}
@extends('master._master')

{{-- CSSの定義 --}}
@section('css')
@parent
<style type="text/css">
.table > thead > tr > .list_th{
	text-align: center;
	vertical-align: middle;
}

.table > tbody > tr > .list_td{
	text-align: center;
	vertical-align: middle;
}
</style>
@stop

{{-- JSの定義 --}}
@section('js')
@parent
@stop
