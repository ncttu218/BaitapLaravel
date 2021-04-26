@extends('v2.common.admin.staffinfo.responsive.layouts.default')

@section('header')
<section class="sectionInner -w_desktop">
  <div class="inputEdit">
    <a href="{{ action_auto( $controller . '@getCreate' ) . "?shop={$shopCode}" }}" class="button -default">新規データ追加</a>
  </div>
</section>
@endsection

@section('footer')
<p>下のボタンを押すと「等級」に設定した並び順の反映と、「削除」をチェックしたものをまとめて削除します。</p>
<p class="inputEdit__caution">※一度削除すると元に戻せません</p>
<!--<form method="post" name="btn1" action="">
  <input type="hidden" name="" value="変更を反映する">-->
  <a class="button -warning" href="#" id="btn-bulk-submit">変更を反映する</a>
<!--</form>-->
@endsection

@section('js')
<script type="text/javascript">
$('#btn-bulk-submit').click(function(e) {
    e.preventDefault();
    $('#bulk-action-form').submit();
});
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
<div class="staffListWrap">
@include('v2.common.admin.staffinfo.responsive.pagination')

{{-- フォームタグ --}}
{!! Form::model(
    null,
    ['method' => 'POST', 'url' => $urlAction, 'id' => 'bulk-action-form']
) !!}
{{ csrf_field() }}

<ul class="staffList">
  {{-- スタッフの一覧を表示 --}}
  @foreach( $list as $row )
  <li class="staffList__item">
    <div class="staffCard">
      {{-- スタッフの氏名 --}}
      <div class="staffCard__name">{{ $row->name }}</div>
      <div class="staffCard__info">
        <figure class="staffCard__figure">
          {{-- スタッフ写真 --}}
          @if (!empty($row->photo))
            @if (preg_match('/^https?\:\/\//', $row->photo))
              <img src="{{ asset_auto($row->photo) }}" alt="スタッフ写真">
            @else
              @if (strstr($row->photo, 'data/image/' . $hanshaCode))
                <img src="{{ asset_auto( $row->photo ) }}" alt="スタッフ写真">
              @else
                <img src="{{ asset_auto( 'data/image/' . $hanshaCode . '/' . $row->photo ) }}"
                   alt="スタッフ写真">
              @endif
            @endif
          @else
            <img src="{{ asset_auto('img/nophoto_s.jpg') }}" alt="スタッフ写真">
          @endif
        </figure>
          
        <div class="staffCard__job">{{ $departmentCodes[$row->department] ?? '' }}</div>
        
        @if (isset($hasLocalView) && $hasLocalView)
            @include('v2.' . $hanshaCode . '.admin.staffinfo.responsive.list_content')
        @else
            @include('v2.common.admin.staffinfo.responsive.list_content')
        @endif
        
        <div class="staffCard__edit">
          <div class="edit_delete">削除<input type="checkbox" name="ListDelete[]" value="{{ $row->number }}"></div>
          <div class="edit_grade">等級：
              <input type="text"
                     size="4" 
                     maxlength="2"
                     name="AdminEdit[{{ $row->number }}]" 
                     value="{{ $row->grade }}" 
                     onkeyup="return checkNumOnly(this);" 
                     onchange="return checkNumOnly(this);">
          </div>
          <a class="button -default" href="{{ action_auto( $controller . '@getEdit', ['id' => $row->id] ) . "?shop={$row->shop}" }}">この情報を編集する</a>
        </div>
      </div>
    </div>
  </li>
  @endforeach
</ul>
{!! Form::close() !!}
</div><!-- staffListWrap -->
@endsection
