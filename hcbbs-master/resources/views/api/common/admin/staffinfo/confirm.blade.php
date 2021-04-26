@extends('staffinfo.layout')

@section('css')
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/import.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/font-awesome.min.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/common.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/style.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/top.css ') }}">
<link rel="stylesheet" href="{{ asset_auto( 'css/staffinfo/DEMO_sr.css ') }}">
@stop

@section('content')
<h2 class="pageTitle">{{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }}　スタッフ紹介</h2>
<div class="contents__main">
<div class="staff">
  <ul class="staff-list">

    <li class="staff-item">
      {{-- 氏名 --}}
      <div class="staff-item__name">
        <span>{{ $staffInfoObj->name }}</span>
        <i class="staff50">{{ $CodeUtil::getDegreeName( $staffInfoObj->department ) }}</i>
      </div>
      <div class="staff-item__detail">
        {{-- 写真 --}}
        @if( !empty( $staffInfoObj->photo ) )
          <figure>
            @if (strstr($staffInfoObj->photo, 'data/image/' . $hanshaCode))
                <img src="{{ asset_auto( $staffInfoObj->photo ) }}" border="0" height="150" f6="">
            @else
                <img src="{{ asset_auto( 'data/image/' . $hanshaCode . '/' . $staffInfoObj->photo ) }}" border="0" height="150" f6="">
            @endif
          </figure>
        @endif

        <dl class="staff-item__profile">
          {{-- 血液型 --}}
          <dt>血液型</dt>
          <dd>{{ $staffInfoObj->ext_value1 }}</dd>
          {{-- 出身地 --}}
          <dt>出身地</dt>
          <dd>{{ $staffInfoObj->ext_value2 }}</dd>
          {{-- 資　格 --}}
          <dt>資　格</dt>
          <dd>
            <ul>
              <li>{{ $staffInfoObj->ext_value3 }}</li>
            
            </ul>
          </dd>
        </dl>
        {{-- 愛してやまないもの --}}
        <dl class="staff-item__profile--more">
          <dt>愛してやまないもの</dt>
          <dd>
            <ul>
            <li>{{ $staffInfoObj->ext_value4 }}</li>
            
            </ul>
          </dd>
        </dl>
      </div>
      <p class="staff-item__comment">{!! nl2br( $staffInfoObj->comment ) !!}</p>  
    </li>
<!-- STANDARDSINGLE MODE END -->

<hr>
@if (!$isDeletion)
    このデータを登録します。よろしいですか？
@else
    このデータを削除します。よろしいですか？
@endif

<button type="button" onClick="history.back()">修正する</button>

{{-- フォームタグ --}}
{!! Form::model(
    $staffInfoObj,
    ['method' => 'POST', 'url' => $urlAction]
) !!}

  {!! Form::hidden( 'comp_flg', 'True' ) !!}
  @if (!$isDeletion)
    <input type=submit name=submit value="登録する" >
  @else
    <input type=submit name="erase" value="削除する" >
  @endif
{!! Form::close() !!}

</ul>
</div>
</div>
@stop
