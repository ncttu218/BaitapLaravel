@extends('api.common.admin.srinfo.responsive.layouts.default')

@section('footer')
<!--<form method="get" name="btn1" action="{{ action_auto( $controller . '@getEdit' ) }}">-->
    <!--<input type="hidden" name="" value="情報を編集する">-->
    <a class="button -default" href="{{ action_auto( $controller . '@getEdit' ) }}">情報を編集する</a>
<!--</form>-->
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
