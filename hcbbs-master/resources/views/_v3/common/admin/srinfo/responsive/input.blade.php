@extends('v2.common.admin.srinfo.responsive.layouts.wrap_form')

@section('header')
<h2 class="subTitle">掲載データ編集画面</h2>
{{-- フォームタグ --}}
{!! Form::model(
    $srInfoObj,
    ['method' => 'POST', 'url' => $urlAction, 'files' => true, 'id' => 'formInput']
) !!}
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $srInfoObj->id }}">
@endsection

@section('footer')
<div class="buttonConfirm2">
  <!--<form method="post" name="btn1" action="">-->
  <!--<input type="hidden" name="" value="修正する">-->
  {{-- 削除・次へボタン --}}
    <!--<div>
      <button type="reset" class="button -warning">リセット</>
  </div>-->
  <!--</form>-->
  <!--<form method="post" name="btn1" action="">-->
  <!--<input type="hidden" name="" value="登録する">-->
  <div style="width: 100%;">
    <button type="submit" class="button -submit">入力確認</button>
  </div>
  <!--</form>-->
</div>
@endsection

@section('js')
<script type="text/javascript">
var initialImage = $('#image-photo').attr('src');

$('button[type=reset]').click(function(e){
    $('#image-photo').attr('src', initialImage);
});

function showImage(src,target) {
  var fr=new FileReader();
  // when image is loaded, set the src of the image where you want to display it
  fr.onload = function(e) {
      target.src = this.result;
      target.style.width = '100%';
  };
  src.addEventListener("change",function() {
    // fill fr with image data    
    fr.readAsDataURL(src.files[0]);
  });
}

var src = document.getElementById("src");
var target = document.getElementById("image-photo");
showImage(src,target);
</script>
@endsection

@section('content')
<?php
if (strstr($srInfoObj->file, 'data/image/' . $hanshaCode)) {
    $imageUrl = asset_auto( $srInfoObj->file );
} else {
    $imageUrl = asset_auto( 'data/image/' . $hanshaCode . '/' . $srInfoObj->file );
}
?>
<div class="srinfoInputWrap">
  <div class="srinfoInput">
    <dl class="srinfoInput__list">
      <dt class="srinfoInput__title">掲載写真</dt>
      <div class="srinfoInput__itemWrap">
        <dd class="srinfoInput__item -img">
          {{ Form::file('file', ['id' => 'src', 'accept' => 'image/*']) }}
          <span>注意：ファイル名に日本語（半角カナ・全角文字）は使えません</span>
          <!--<input type="checkbox" name="" value="file_del">この画像を削除-->
          <figure>
              <img src="{{ $imageUrl }}" id="image-photo">
          </figure>
        </dd>
      </div>
    </dl>
    <dl class="srinfoInput__list">
      <dt class="srinfoInput__title">コメント</dt>
      <div class="srinfoInput__itemWrap">
        <dd class="srinfoInput__item -textarea">
            {{ Form::textarea('comment', old('comment'), ['rows' => '8']) }}
        </dd>
      </div>
    </dl>
    <dl class="srinfoInput__list">
      <dt class="srinfoInput__title">店舗</dt>
      <div class="srinfoInput__itemWrap">
        {{ $shopName }}
        <!--<dd class="srinfoInput__item -select">
            <select name="">
              <option hidden>----------</option>
        </select>-->
        </dd>
      </div>
    </dl>
  </div>
</div>
@endsection
