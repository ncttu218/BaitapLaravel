@extends('api.common.admin.staffinfo.responsive.layouts.default')

@section('footer')
@if (!$isDeletion)
    <p>このデータを登録します。よろしいですか？</p>
@else
    <p>このデータを削除します。よろしいですか？</p>
@endif

{{-- フォームタグ --}}
{!! Form::model(
      $staffInfoObj,
      ['method' => 'POST', 'url' => $urlAction, 'id' => 'formInput']
) !!}
{!! Form::hidden( 'comp_flg', 'True' ) !!}
<div class="buttonConfirm2">
  <!--<form method="post" name="btn1" action="">
    <input type="hidden" name="" value="修正する">-->
    <div>
        <a class="button -warning" href="#" onclick="goBack()">修正する</a>
    </div>
  <!--</form>
  <form method="post" name="btn1" action="">
    <input type="hidden" name="" value="登録する">-->
    <div>
        @if (!$isDeletion)
        <a class="button -submit" href="#" id="btn-submit-save" onclick="invalidate()">登録する</a>
        @else
        <button type="submit" class="button -warning" name="erase" value="1" onclick="invalidate()">削除する</button>
        @endif
    </div>
  <!--</form>-->
</div>
{!! Form::close() !!}
@endsection

@section('js')
<script type="text/javascript">
$('#btn-submit-save').click(function(e) {
    e.preventDefault();
    $('#formInput').submit();
});

var invalidateForm = false;
/**
 * ページを離れる確認を外すフラグ
 * 
 * @returns {void}
 */
var invalidate = function() {
    invalidateForm = true;
}
var goBack = function () {
    invalidate();
    history.back();
}
// ページを離れる確認メッセージ
$(window).bind('beforeunload', function(e){
    if (!invalidateForm) {
        return 'このページを離れますか？';
    }
});
</script>
@endsection

@section('content')
<div class="staffConfirmWrap">
<ul class="staffList">
  <li class="staffList__item">
    <div class="staffCard">
      {{-- 氏名 --}}
      <div class="staffCard__name">{{ $staffInfoObj->name }}</div>
      
      {{-- 写真 --}}
      <div class="staffCard__info">
        <figure class="staffCard__figure">
          @if (isset($staffInfoObj->photo))
            @if (preg_match('/^http/', $staffInfoObj->photo))
                <img src="{{ asset_auto($staffInfoObj->photo) }}" alt="スタッフ写真">
            @else
                @if (strstr($staffInfoObj->photo, 'data/image/' . $hanshaCode))
                  <img src="{{ asset_auto( $staffInfoObj->photo ) }}" alt="スタッフ写真">
                @else
                  <img src="{{ asset_auto( 'data/image/' . $hanshaCode . '/' . $staffInfoObj->photo ) }}" alt="スタッフ写真">
                @endif
            @endif
          @else
            @if ($hanshaCode == '5551803')
                <img src="{{ asset_auto('img/5551803_staffinfo_default.gif') }}" alt="スタッフ写真">
            @else
                <img src="{{ asset_auto('img/nophoto_s.jpg') }}" alt="スタッフ写真">
            @endif
          @endif
        </figure>
        
        {{-- 役職 --}}
        {{--<div class="staffCard__job">{{ $CodeUtil::getDegreeName( $staffInfoObj->department ) }}</div>--}}
        {{--<div class="staffCard__job">{{ $departmentCodes[$staffInfoObj->department] ?? '' }}</div>--}}
  
        @if (isset($hasLocalView) && $hasLocalView)
          @include('api.' . $hanshaCode . '.admin.staffinfo.responsive.confirm_content')
        @else
          @include('api.common.admin.staffinfo.responsive.confirm_content')
        @endif
  
      </div>
    </div>
  </li>
</ul>
</div>
@endsection
