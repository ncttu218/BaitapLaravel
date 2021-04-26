{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

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
@include('v2.common.admin.infobbs.attention')
<section class="c-section-container _both-space">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h2 class="c-section-title">各店舗情報掲示板</h2>
    
    <table class="c-item-table">
        <thead class="c-item-table__head">
            <tr class="c-item-table__row">
                <th class="c-item-table__name">店舗名</th>
                <th class="c-item-table__button">新規投稿</th>
                <th class="c-item-table__button">編集・削除</th>
            </tr>
        </thead>
        <tbody class="c-item-table__body">
            @foreach($shopList as $shop_no => $shop_name)
            <tr class="c-item-table__row">
                <th class="c-item-table__name">{{ $shop_name }}</th>
                <td class="c-item-table__button">
                    <a href="{{ $urlActionInfobbs.'/new'.'?shop='.$shop_no }}" class="c-entry-button _color-1">新規</a>
                </td>
                <td class="c-item-table__button">
                    <a href="{{ $urlActionInfobbs.'?shop='.$shop_no }}" class="c-entry-button _color-2">編集</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="c-simple-button-container">
        <a href="{{ $urlActionTop }}" class="c-simple-button">管理画面一覧へ戻る</a>
    </p>
</section>
@stop
