@extends('api.common.admin.staffinfo.responsive.layouts.wrap_form')

@section('css')
<style type="text/css">
    .required{
        color: red;
    }
</style>
@endsection

@section('header')
@if ($type == 'edit')
    <h2 class="subTitle">掲載データ編集画面</h2>
@else
    <h2 class="subTitle">掲載データ新規登録画面</h2>
@endif

{{-- フォームタグ --}}
{!! Form::model(
    $staffInfoObj,
    ['method' => 'POST', 'url' => $urlAction, 'files' => true, 'id' => 'formInput']
) !!}
  {{ csrf_field() }}

@if ( $type != 'create' )
    <input type="hidden" name="id" value="{{ $staffInfoObj->id }}">
@endif
<input type="hidden" name="number" value="{{ $staffInfoObj->number }}">
@endsection

@section('footer')
<div class="buttonConfirm2">
  <!--<form method="post" name="btn1" action="">-->
  <!--<input type="hidden" name="" value="修正する">-->
  {{-- 削除・次へボタン --}}
  <div>
    @if ( $type != 'create' )
      <button type="submit" class="button -warning" name="erase" value="1" onclick="invalidate()">データを削除</button>
      <!--<a class="button -warning" href="#">データを削除</a>-->
    @else
      <a class="button -warning" href="{{ $urlActionList }}">キャンセル</a>
    @endif
  </div>
  <!--</form>-->
  <!--<form method="post" name="btn1" action="">-->
  <!--<input type="hidden" name="" value="登録する">-->
  <div>
    <a class="button -submit" href="#" id="btn-submit-confirm">入力確認</a>
  </div>
  <!--</form>-->
</div>
@endsection

@section('js')
<script type="text/javascript">
$('#btn-submit-confirm').click(function(e) {
    e.preventDefault();
    invalidate();
    $('#formInput').submit();
});

/**
 * 計画設定フォームで変わった値のチェック変数
 */
var $form = $('form#formInput'),
    origForm = $form.serialize(),
    invalidateForm = false;
    
/**
 * ページを離れる確認を外すフラグ
 * 
 * @returns {void}
 */
var invalidate = function() {
    invalidateForm = true;
}
// ページを離れる確認メッセージ
$(window).bind('beforeunload', function(e){
    if ($form.serialize() !== origForm && !invalidateForm) {
        return 'このページを離れますか？';
    }
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

var src = document.getElementById("photo");
var target = document.getElementById("image-photo");
showImage(src,target);

// 数字だけが入力されているかを調べる
function checkNumOnly( txt_obj ){
    // 入力された値を取得
    var txtValue = txt_obj.value;

    //入力値に 0～9 以外があれば
    if( txtValue.match( /[^0-9]+/ ) ){
        // 0～9 以外を削除
        txt_obj.value = txtValue.replace( /[^0-9]+/g,"" );
    }
    return true;
}
</script>
@endsection

@section('content')
<div class="staffInputWrap">
<div class="staffInput">
    
  @include('_errors.list')
  
  @if (isset($hasLocalView) && $hasLocalView)
    @include('api.' . $hanshaCode . '.admin.staffinfo.responsive.input_content')
  @else
    @include('api.common.admin.staffinfo.responsive.input_content')
  @endif
</div>
</div>
</section>
@endsection
