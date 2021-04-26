{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_non')

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
<div style="font-size: 13px"align="left">
    <b>■画像アップロード</b>
    <br>
    記事本文内に画像を貼りつける場合、あらかじめ画像データをサーバーにアップする必要があります。<br>
以下のフォームにてアップロード処理をするとその画像に対応したタグが表示されます。<br>
    <div style="border-width: 1px;border-style: solid;border-color:#f00;color:#f00;">
※BMPファイルは自動的に縮小が出来ませんので使用しないで下さい。<br>
ファイルサイズも巨大になってしまい閲覧するエンドユーザーからも重くて見れない原因となりますので、JPGファイルのご利用をお願いします。<br>
※また、記事本文内に画像を複数枚掲載される場合には、適宜改行の挿入をお願いいたします。<br>
画像を複数横に並べると、レイアウトが崩れる原因となります。
    </div>
    <form action="{{ $urlAction }}" enctype="multipart/form-data" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
アップロードファイル<input type="file" name="file" required> <br>
        @if($msg)
        <div style="font-size: 15;color: #f00">{{ $msg }}</div>
        @endif
横サイズ
        <select name="width">
        <option value="1000">1000
        </option><option value="800">800
        </option><option value="600">600
        </option><option value="480">480
        </option><option value="400" selected="">400
        </option><option value="300">300
        </option><option value="200">200
        </option><option value="100">100
        </option><option value="50">50
        </option></select>ピクセル<br>
        指定した横サイズより大きいサイズの場合は指定サイズに縮小されます。<br>
        <input type="submit" value="アップロード">
    </form>
@if($upload == 'on')
    <br>
    アップロードされたファイルのURLは<br>
    <a href="{!! asset_auto($fileName) !!}" target="_blank">
    {!! asset_auto($fileName) !!}
    </a>
    <br>
    です
    <br>
    ※リッチテキストモードで画像挿入する場合はこちらを貼り付けてください。<br>
    <br>

    通常モードで記事本文に画像を貼る場合は以下のコードをコピー＆ペーストしてください。<br>
    <span style="color :#00f">
    {{ '<img src="' }}{!! asset_auto($fileName) !!}{{ '" width="' }}{{ $width }}{{ '">' }}
    </span>
    <br>

    <br>
    アップロードされたファイル（横{{ $width }}ピクセル)<br>
    <a href="{{ asset_auto($fileName) }}" target="_blank"><img src="{{ asset_auto($fileName) }}"></a>
@endif
</div>
@stop

