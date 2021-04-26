<dl class="staffInput__list">
    <dt class="staffInput__title">氏名 <span class="required">*</span></dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -input">
        {{ Form::text( 'name', old('name') ) }}
    </dd>
  </div>
</dl>

<dl class="staffInput__list">
    <dt class="staffInput__title">フリガナ</dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -input">
        {{ Form::text( 'name_furi', old('name_furi') ) }}
    </dd>
  </div>
</dl>

<dl class="staffInput__list">
  <dt class="staffInput__title">所属・役職 <span class="required">*</span></dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -select">
      <?php
      // 肩書の一覧
      $departmentListCol = collect($departmentList);
      $departmentListCol->prepend( "----------", "" );
      ?>
      {{ Form::select('department', $departmentListCol, old('department') ) }}
    </dd>
  </div>
</dl>

<dl class="staffInput__list">
  <dt class="staffInput__title">掲載写真</dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -img">
       {{ Form::file('photo', ['id' => 'photo', 'accept' => 'image/*']) }}
      <span>注意：ファイル名に日本語（半角カナ・全角文字）は使えません</span>
      <figure>
          {{-- 掲載写真の表示 --}}
          @if( !empty( $staffInfoObj->photo ) )
            @if (preg_match('/^http/', $staffInfoObj->photo))
              <img src="{{ asset_auto($staffInfoObj->photo) }}" alt="スタッフ写真">
            @else
              @if (strstr($staffInfoObj->photo, 'data/image/' . $hanshaCode))
                  <img src="{{ asset_auto( $staffInfoObj->photo ) }}" id="image-photo">
              @else
                  <img src="{{ asset_auto( 'data/image/' . $hanshaCode . '/' . $staffInfoObj->photo ) }}" id="image-photo">
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
    </dd>
  </div>
</dl>

<dl class="staffInput__list">
  <dt class="staffInput__title">コメント</dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -textarea">
        {{ Form::textarea('comment', old('comment'), ['rows' => '8'] ) }}
    </dd>
  </div>
</dl>

<dl class="staffInput__list">
  <dt class="staffInput__title">取得資格</dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -input">
        {{ Form::text('ext_value6', old('ext_value6') ) }}
    </dd>
  </div>
</dl>

<div>
    ■以下の入力欄は項目名を自由に編集できます。上記の項目に書きたい項目がない場合ご使用ください。<br>
    例：尊敬する人・好きな言葉・おすすめの本・おすすめの映画・・・など
</div>
@for ($i=1;$i<=5;$i++)
<dl class="staffInput__list">
    <dt class="staffInput__title" style="padding: 0;">
        {{ Form::text( 'ext_field' . $i, old('ext_field' . $i), ['style' => 'padding: .3em;margin: 0;'] ) }}
    </dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -input">
        {{ Form::text( 'ext_value' . $i, old('ext_value' . $i) ) }}
    </dd>
  </div>
</dl>
@endfor

<dl class="staffInput__list">
  <dt class="staffInput__title">店舗 <span class="required">*</span></dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -select">
      <?php
      // ログイン販社の拠点一覧を取得する
      $shopList = collect($shopList);
      $shopList->prepend( "----------", "" );
      ?>
      {{ Form::select('shop', $shopList, old('shop') ) }}
    </dd>
  </div>
</dl>