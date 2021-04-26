
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
                        <td style="font-size:10px;padding:5px;">
                            <?php
                            // ファイルパスの情報を取得する
                            $fileinfo1 = pathinfo( $data['file1'] );
                            ?>
                            {{-- PDFファイルの対応 --}}
                            @if( strtolower( $fileinfo1['extension'] ) === "pdf" )
                                <a href="{{ asset_auto($data['file1']) }}" target="_blank">
                                    <img src="{{ $CodeUtil::getPdfThumbnail( $data['file1'] ) }}" width="200" alt="{{ $data['caption1'] }}">
                                </a>
                            @else
                                <img src="{{ asset_auto($data['file1']) }}" alt="{{ $data['caption1'] }}">
                            @endif
                            <br>
                            {!! $data['caption1'] ?? '' !!}
                        </td>
                    @endif
                    @if (!empty($data['file2']))
                        <td style="font-size:10px;padding:5px;">
                            <?php
                            // ファイルパスの情報を取得する
                            $fileinfo2 = pathinfo( $data['file2'] );
                            ?>
                            {{-- PDFファイルの対応 --}}
                            @if( strtolower( $fileinfo2['extension'] ) === "pdf" )
                                <a href="{{ asset_auto($data['file2']) }}" target="_blank">
                                    <img src="{{ $CodeUtil::getPdfThumbnail( $data['file2'] ) }}" width="200" alt="{{ $data['caption2'] }}">
                                </a>
                            @else
                                <img src="{{ asset_auto($data['file2']) }}" alt="{{ $data['caption2'] }}">
                            @endif
                            <br>
                            {!! $data['caption2'] ?? '' !!}
                        </td>
                    @endif
                    @if (!empty($data['file3']))
                        <td style="font-size:10px;padding:5px;">
                            <?php
                            // ファイルパスの情報を取得する
                            $fileinfo3 = pathinfo( $data['file3'] );
                            ?>
                            {{-- PDFファイルの対応 --}}
                            @if( strtolower( $fileinfo3['extension'] ) === "pdf" )
                                <a href="{{ asset_auto($data['file3']) }}" target="_blank">
                                    <img src="{{ $CodeUtil::getPdfThumbnail( $data['file3'] ) }}" width="200" alt="{{ $data['caption3'] }}">
                                </a>
                            @else
                                <img src="{{ asset_auto($data['file3']) }}" alt="{{ $data['caption3'] }}">
                            @endif
                            <br>
                            {!! $data['caption3'] ?? '' !!}
                        </td>
                    @endif
                    @if (!empty($data['file4']))
                        <td style="font-size:10px;padding:5px;">
                            <?php
                            // ファイルパスの情報を取得する
                            $fileinfo4 = pathinfo( $data['file4'] );
                            ?>
                            {{-- PDFファイルの対応 --}}
                            @if( strtolower( $fileinfo4['extension'] ) === "pdf" )
                                <a href="{{ asset_auto($data['file4']) }}" target="_blank">
                                    <img src="{{ $CodeUtil::getPdfThumbnail( $data['file4'] ) }}" width="200" alt="{{ $data['caption4'] }}">
                                </a>
                            @else
                                <img src="{{ asset_auto($data['file4']) }}" alt="{{ $data['caption4'] }}">
                            @endif
                            <br>
                            {!! $data['caption4'] ?? '' !!}
                        </td>
                    @endif
                    @if (!empty($data['file5']))
                        <td style="font-size:10px;padding:5px;">
                            <?php
                            // ファイルパスの情報を取得する
                            $fileinfo5 = pathinfo( $data['file5'] );
                            ?>
                            {{-- PDFファイルの対応 --}}
                            @if( strtolower( $fileinfo5['extension'] ) === "pdf" )
                                <a href="{{ asset_auto($data['file5']) }}" target="_blank">
                                    <img src="{{ $CodeUtil::getPdfThumbnail( $data['file5'] ) }}" width="200" alt="{{ $data['caption5'] }}">
                                </a>
                            @else
                                <img src="{{ asset_auto($data['file5']) }}" alt="{{ $data['caption5'] }}">
                            @endif
                            <br>
                            {!! $data['caption5'] ?? '' !!}
                        </td>
                    @endif
                    @if (!empty($data['file6']))
                        <td style="font-size:10px;padding:5px;">
                            <?php
                            // ファイルパスの情報を取得する
                            $fileinfo5 = pathinfo( $data['file6'] );
                            ?>
                            {{-- PDFファイルの対応 --}}
                            @if( strtolower( $fileinfo5['extension'] ) === "pdf" )
                                <a href="{{ asset_auto($data['file6']) }}" target="_blank">
                                    <img src="{{ $CodeUtil::getPdfThumbnail( $data['file6'] ) }}" width="200" alt="{{ $data['caption6'] }}">
                                </a>
                            @else
                                <img src="{{ asset_auto($data['file6']) }}" alt="{{ $data['caption6'] }}">
                            @endif
                            <br>
                            {!! $data['caption6'] ?? '' !!}
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


