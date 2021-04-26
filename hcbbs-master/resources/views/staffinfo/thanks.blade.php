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
<div class="staff">
  <ul class="staff-list">
    @if ($isDeletion)
        データを削除しました。
    @else
        データを登録しました。
    @endif
    <br>
    <a href="{{ $returnUrl }}">管理者画面へ戻る</a><hr>

  </ul>
</div>
</div>
@stop
