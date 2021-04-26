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
@include('infobbs.attention')
<section class="c-section-container _both-space">
    <form action="{{ $urlAction }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {{-- カテゴリがあったら表示 --}}
        @if($category)
            カテゴリ:{{ $categorySelected }}
            <br>
            @foreach($category as $row)
                @if($row['num'] == 0)
                    {{ $row['name'] }}({{ $row['num'] }})
                @else
                    <a href="{{ $urlAction }}?cat={{ $row['name'] }}">{{ $row['name'] }}({{ $row['num'] }})</a>
                @endif
            @endforeach
        @endif
        <br>
        お近くのお店を選んで「検索」ボタンをクリックして下さい<br>
        {!! Form::select('shop',$shopList,$shop) !!}
        <input type="submit" value="検索">
        <div class="col-sm-12">
            @include('infobbs.pagination')
        </div>
        @foreach($blogs as $row)
        <div class="col-sm-12">
            @include($template)
            <br><br>
            @if($category)
                カテゴリ:{{ $row->category ?  $row->category:'全て' }}
            @endif
        </div>
        <div class="col-sm-12">&nbsp;</div>
        @endforeach
        <div class="col-sm-12">
        @include('infobbs.pagination')
        </div>
    </form>
</section>
@stop



