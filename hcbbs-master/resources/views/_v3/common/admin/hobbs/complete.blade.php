{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_clean')

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
<section class="c-section-container _both-space">
    <h2 class="c-section-title">{{ $msg }}</h2>

    <p class="c-simple-button-container">
        <a href="{{ $urlAction }}" class="c-simple-button">管理者画面へ戻る</a>
    </p>
</section>
<!-- / .c-section-container -->
@stop
