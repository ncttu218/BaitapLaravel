{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

{{-- CSSの定義 --}}
@section('css')
@parent
@stop

{{-- JSの定義 --}}
@section('js')
@parent
<script type="text/javascript">
$(function() {
    toggleAttention($('.js-attention-toggle'));
});
</script>
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
@include('infobbs.attention')
<section class="c-section-container _both-space">
    <h2 class="c-section-title">オプション管理画面一覧</h2>
    
    <div class="p-index-menu">
    	@include('api.common.admin.top.menu_loader')
    </div>
    
    <section class="c-section-container _both-space">
        <h2 class="c-section-title">操作マニュアル</h2>
        <p><a href="{{ asset_auto('pdf/dealer_admin_manual.pdf') }}" target="_blank">情報掲示板・スタッフブログ投稿編（PDF）<i class="fa fa-window-restore"></i></a></p>
    </section>
</section>
@stop
