@extends('v2.common.admin.srinfo.responsive.layouts.simple')

@section('content')
<div class="inputDone">
    <p>データを登録しました。</p>
    <a href="{{ $returnUrl }}" class="button -default">管理者画面へ戻る</a>
</div>
@endsection
