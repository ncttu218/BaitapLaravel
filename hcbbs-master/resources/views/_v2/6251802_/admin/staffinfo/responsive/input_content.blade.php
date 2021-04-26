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
  <dt class="staffInput__title">等級 <span class="required">*</span></dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -input grade">
        {{ Form::text( 'grade', old('grade'), ['maxlength' => '2', 'onkeyup' => "return checkNumOnly(this);", 'onchange' => "return checkNumOnly(this);"] ) }}
        <span>※半角数字、2桁で入力してください(入力例：05)</span>
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
            @if (preg_match('/^https?\:\/\//', $staffInfoObj->photo))
              <img src="{{ asset_auto($staffInfoObj->photo) }}" alt="スタッフ写真">
            @else
              @if (strstr($staffInfoObj->photo, 'data/image/' . $hanshaCode))
                  <img src="{{ asset_auto( $staffInfoObj->photo ) }}" id="image-photo">
              @else
                  <img src="{{ asset_auto( 'data/image/' . $hanshaCode . '/' . $staffInfoObj->photo ) }}" id="image-photo">
              @endif
            @endif
          @else
              <img src="{{ asset_auto('img/nophoto_s.jpg') }}"
                   id="image-photo" style="width: auto;">
          @endif
      </figure>
    </dd>
  </div>
</dl>
<dl class="staffInput__list">
  <dt class="staffInput__title">血液型</dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -input">
        {{ Form::text( 'ext_value1', old('ext_value1') ) }}
    </dd>
  </div>
</dl>

<dl class="staffInput__list">
  <dt class="staffInput__title">出身</dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -input">
        {{ Form::text( 'ext_value2', old('ext_value2') ) }}
    </dd>
  </div>
</dl>
<dl class="staffInput__list">
  <dt class="staffInput__title">資格</dt>
  <div class="staffInput__itemWrap">
    {{-- 複数 --}}
    <dd class="staffInput__item -input">
      {{ Form::text( 'ext_value3', old('ext_value3') ) }}
    </dd>
  </div>
</dl>
<dl class="staffInput__list">
  <dt class="staffInput__title">趣味</dt>
  <div class="staffInput__itemWrap">
    {{-- 複数 --}}
    <dd class="staffInput__item -input">
        {{ Form::text( 'ext_value4', old('ext_value4') ) }}
    </dd>
  </div>
</dl>
<dl class="staffInput__list">
  <dt class="staffInput__title">自己ＰＲ</dt>
  <div class="staffInput__itemWrap">
    <dd class="staffInput__item -textarea">
        {{ Form::textarea('comment', old('comment'), ['rows' => '8'] ) }}
    </dd>
  </div>
</dl>
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