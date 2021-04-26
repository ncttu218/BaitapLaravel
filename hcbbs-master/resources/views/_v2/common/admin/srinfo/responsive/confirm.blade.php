@extends('v2.common.admin.srinfo.responsive.layouts.wrap_form')

@section('footer')
<p>このデータを登録します。よろしいですか？</p>

{{-- フォームタグ --}}
{!! Form::model(
      $srInfoObj,
      ['method' => 'POST', 'url' => $urlAction, 'id' => 'formInput']
) !!}
{!! Form::hidden( 'comp_flg', 'True' ) !!}
<div class="buttonConfirm2">
  <!--<form method="post" name="btn1" action="">
    <input type="hidden" name="" value="修正する">-->
    <div>
        <a class="button -warning" href="#" onclick="history.back()">修正する</a>
    </div>
  <!--</form>
  <form method="post" name="btn1" action="">
    <input type="hidden" name="" value="登録する">-->
    <div>
        <button type="submit" class="button -submit">登録する</a>
    </div>
  <!--</form>-->
</div>
{!! Form::close() !!}
@endsection

@section('content')
<?php
if (strstr($srInfoObj->file, 'data/image/' . $hanshaCode)) {
    $imageUrl = asset_auto( $srInfoObj->file );
} else {
    $imageUrl = asset_auto( 'data/image/' . $hanshaCode . '/' . $srInfoObj->file );
}
?>
<div class="srinfoListWrap">
<div class="srinfoCardWrap">
  <div class="srinfoCard">
    <div class="srinfoCard__shop">{{ $shopName }}</div>
    <figure class="srinfoCard__figure">
        <img src="{{ $imageUrl }}">
      </figure>
      <div class="srinfoCard__message">
        <p>{!! nl2br($srInfoObj->comment) !!}</p>
      </div>
  </div>
</div>
</div>
@endsection
