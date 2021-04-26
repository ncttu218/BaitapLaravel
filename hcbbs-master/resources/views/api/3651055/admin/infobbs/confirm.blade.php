
{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_clean')

{{-- CSSの定義 --}}
@section('css')
@parent
<style type="text/css">
.p-entrylist-box__images img{
    width: 240px;
    height: auto;
}
.c-section-container ol{
    list-style-type: decimal;
}
</style>
@stop

{{-- JSの定義 --}}
@section('js')
@parent
<script>
var doLeavingConfirmation = true;
var setHiddenValue = function(obj) {
    doLeavingConfirmation = false;
};

$(window).on('beforeunload', function() {
    if (doLeavingConfirmation) {
        return "入力が完了していません。このページを離れますか？";
    }
});
</script>
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
<section class="c-section-container _both-space">
    <h2 class="c-section-title">投稿内容の確認</h2>
    <div class="p-entrylist-box__head">
        <h3 class="p-entrylist-box__title">{{ $data['title'] }}</h3>
        <div class="p-entrylist-box__sign">{{ $shopName }}</div>
    </div>
    <div style="background:#fff; padding:30px">
        <?php if(!empty($data['file1']) || !empty($data['file2']) || !empty($data['file3']) || !empty($data['file4']) || !empty($data['file5']) || !empty($data['file6']) ){ ?> 
        <div class="p-entrylist-box__images">
            <table>
                <tr>
                    @if (!empty($data['file1']))
                        <?php
                        $data['file1'] = str_replace('img.hondanet.co.jp', "image.hondanet.co.jp", $data['file1']);
                        $data['file1'] = preg_replace('/"$/', '', $data['file1']);
                        ?>
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file1']) }}" alt="{{ $data['caption1'] }}">
                            <br>
                            {{ $data['caption1'] ?? '' }}
                        </td>
                    @endif
                    @if (!empty($data['file2']))
                        <?php
                        $data['file2'] = str_replace('img.hondanet.co.jp', "image.hondanet.co.jp", $data['file2']);
                        $data['file2'] = preg_replace('/"$/', '', $data['file2']);
                        ?>
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file2']) }}" alt="{{ $data['caption2'] }}">
                            <br>
                            {{ $data['caption2'] ?? '' }}
                        </td>
                    @endif
                    @if (!empty($data['file3']))
                        <?php
                        $data['file3'] = str_replace('img.hondanet.co.jp', "image.hondanet.co.jp", $data['file3']);
                        $data['file3'] = preg_replace('/"$/', '', $data['file3']);
                        ?>
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file3']) }}" alt="{{ $data['caption3'] }}">
                            <br>
                            {{ $data['caption3'] ?? '' }}
                        </td>
                    @endif
                    @if (!empty($data['file4']))
                        <?php
                        $data['file4'] = str_replace('img.hondanet.co.jp', "image.hondanet.co.jp", $data['file4']);
                        $data['file4'] = preg_replace('/"$/', '', $data['file4']);
                        ?>
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file4']) }}" alt="{{ $data['caption4'] }}">
                            <br>
                            {{ $data['caption4'] ?? '' }}
                        </td>
                    @endif
                    @if (!empty($data['file5']))
                        <?php
                        $data['file5'] = str_replace('img.hondanet.co.jp', "image.hondanet.co.jp", $data['file5']);
                        $data['file5'] = preg_replace('/"$/', '', $data['file5']);
                        ?>
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file5']) }}" alt="{{ $data['caption5'] }}">
                            <br>
                            {{ $data['caption5'] ?? '' }}
                        </td>
                    @endif
                    @if (!empty($data['file6']))
                        <?php
                        $data['file6'] = str_replace('img.hondanet.co.jp', "image.hondanet.co.jp", $data['file6']);
                        $data['file6'] = preg_replace('/"$/', '', $data['file6']);
                        ?>
                        <td style="font-size:10px;padding:5px;">
                            <img src="{{ asset_auto($data['file6']) }}" alt="{{ $data['caption6'] }}">
                            <br>
                            {{ $data['caption6'] ?? '' }}
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
<!-- / .c-section-container -->

<form action="{{ $urlAction }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <section class="c-section-container _bottom-space">
        <div class="c-frame-box">
            <div class="c-frame-box__head">このデータを登録します。よろしいですか？</div>
            <div class="c-frame-box__body">
                <div class="c-separate">
                    <div class="c-separate__item">
                        <label class="c-entry-button _color-2"><input type="submit" name="modulate" value="修正する" onclick="setHiddenValue(this)">修正する</label>
                    </div>
                    <div class="c-separate__item">
                        <label class="c-entry-button _color-1"><input type="submit" name="register" value="登録する" onclick="setHiddenValue(this)">登録する</label>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<!-- / .c-section-container -->
@stop


