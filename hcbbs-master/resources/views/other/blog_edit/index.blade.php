{{-- リストマスターレイアウトを継承 --}}
@extends('master.list')

{{-- CSSの定義 --}}
@section('css')
@parent
<style>
.content-container{
    margin: 10px 0;
    border-bottom: 2px solid #ccc;
    padding: 10px 0 20px;
}
.content-preview{
    height: 200px;
    overflow-y: auto;
    border: 1px solid #333;
}
textarea.content-preview{
    width: 100%;
}
.image-url-preview{
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 4px 3px;
    margin: 4px 0;
}
</style>
@stop

{{-- JSの定義 --}}
@section('js')
@parent
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
{!! Form::open( ['id'=> 'previewForm', 'method' => 'POST', 'url' => action_auto( $displayObj->ctl . '@postUpdate' )] ) !!}
<div class="row">

    {{-- メイン --}}
    <div id="main" class="col-sm-12">
        <h5 class="mb30"><i class="fa fa-th-list"></i> {{ $title }}</h5>

        <p>記事データの「base64画像」を取り除くための画面です。</p>
            <?php
            // 販社プルダウンの値を取得する。
            $hanshaOptions = ["" => "----"] + \App\Models\Base::getHanshaOptions();
            ?>
            {!! Form::select('hansha_code', $hanshaOptions, null, ['class' => 'form-control']) !!}
            
            <button type="submit" class="btn btn-block btn-primary mt10">記事データ一括修正</button>

        {{-- ページネーション --}}
        @yield('table_pager')

    </div><!-- top row -->
</div><!-- main -->

@if (isset($contents))
@foreach ($contents as $item)
<div class="row content-container">
    <div class="col-sm-6">
        <div>
            <h5>元の内容</h5>
            <div class="content-preview">
                {!! $item['content'] !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div>
            @if (isset($item['replacement']))
            <h5>結果の内容</h5>
            <label>
                <input type="checkbox" name="doConversion[]" value="{{ $item['id'] }}" checked="checked" /> 変換する
            </label>
            <textarea class="content-preview" readonly="readonly">
                {!! $item['replacement']['content'] ?? '' !!}
            </textarea>
            @foreach ($item['replacement']['images'] as $i => $image)
            <h5>画像 {{ $i + 1 }}</h5>
            <textarea class="image-url-preview" readonly="readonly">{{ $image }}</textarea>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endforeach

@if (count($contents) > 0)
    <button type="submit" class="btn btn-block btn-primary mt10">記事データ一括修正</button>
@endif
@endif

{!! Form::close() !!}
@stop
