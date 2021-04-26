@extends('api.common.admin.staffinfo.responsive.layouts.simple')

@section('content')
<div class="inputDone">
    @if ($isDeletion)
        <p>データを削除しました。</p>
    @else
        <p>データを登録しました。</p>
    @endif
    <a href="{{ $returnUrl }}" class="button -default">管理者画面へ戻る</a>
</div>
@endsection
