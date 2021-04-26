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
    <h2 class="c-section-title"><em>{{ $staffName }}</em>のデータを編集します</h2>
    
    <div class="c-frame-box">
        @if (isset($editable) && $editable)
        <div class="c-frame-box__head">データ編集</div>
        <div class="c-frame-box__body">
            <div class="c-separate">
                <div class="c-separate__item">
                    <a href="{{ $urlActionEditProfile }}" class="c-entry-button _color-2">個人情報の編集</a>
                    @if(isset($mailReg) && $mailReg)
                        <small>
                            <a href="#" onClick="window.open('{{ $mailFormUrl }}',
                                'KTAI','width=400,height=300,scrollbars=yes');">
                                携帯投稿用アドレス管理ページへ</a>
                        </small>
                    @endif
                </div>
                <div class="c-separate__item">
                    <a href="{{ $urlActionBlogList }}" class="c-entry-button _color-1">日記の編集</a>
                    <!--<small><a href="#" target="comment" onclick="window.open(this.href,this.target,'width=300,height=450,scrollbars=yes');return false;">最新のコメントを表示</a>
                    </small>-->
                </div>
            </div>
        </div>
        @else
        <div class="c-frame-box__head">パスワードエラー</div>
        <div class="c-frame-box__body">
            <div class="c-separate">
                パスワードが違います
            </div>
        </div>
        @endif
    </div>
    <!-- /.c-frame-box -->
</section>
@stop
