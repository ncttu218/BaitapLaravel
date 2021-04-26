{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

{{-- CSSの定義 --}}
@section('css')
@parent
<style type="text/css">
.p-entrylist-box__images img{
    width: 240px;
    height: auto;
}
</style>
@stop

{{-- JSの定義 --}}
@section('js')
@parent
<script type="text/javascript" src="{{ asset_auto('js/upload.js') }}"></script>
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
@include('v2.common.admin.infobbs.attention')

<section class="c-section-container _both-space">
    <h2 class="c-section-title">投稿内容の確認</h2>
    <div class="p-entrylist-box__head">
        <h3 class="p-entrylist-box__title">{{ $data['title'] }}</h3>
        <div class="p-entrylist-box__sign">{{ date('Y/m/d') }}</div>
    </div>
    <div style="background:#fff; padding:30px">
        <?php if( !empty($data['file']) || !empty($data['file2']) || !empty($data['file3']) ){?> 
        <div class="p-entrylist-box__images">
            <table>
                <tr>
                    @if (!empty($data['file']))
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file']) }}" alt="{{ $data['caption'] }}">
                            <br>
                            {{ $data['caption'] ?? '' }}
                        </td>
                    @endif
                    @if (!empty($data['file2']))
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file2']) }}" alt="{{ $data['caption2'] }}">
                            <br>
                            {{ $data['caption2'] ?? '' }}
                        </td>
                    @endif
                    @if (!empty($data['file3']))
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file3']) }}" alt="{{ $data['caption3'] }}">
                            <br>
                            {{ $data['caption3'] ?? '' }}
                        </td>
                    @endif
                </tr>
            </table>
        </div>
        <br>
        <?php } ?>
        {!! $data['comment'] !!}
    </div>
</section>

<section class="c-section-container _bottom-space">
    <div class="c-frame-box">
        <div class="c-frame-box__head">このデータを登録します。よろしいですか？</div>
        <div class="c-frame-box__body">
            <div class="c-separate">
                <div class="c-separate__item">
                    <form action="{{ $urlActionConfirm }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label class="c-entry-button _color-2"><input type="submit" name="modulate" value="修正する">修正する</label>
                    </form>
                </div>
                <div class="c-separate__item">
                    <form action="{{ $urlActionConfirm }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label class="c-entry-button _color-1"><input type="submit" name="register" value="登録する">登録する</label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / .c-section-container -->
@stop
