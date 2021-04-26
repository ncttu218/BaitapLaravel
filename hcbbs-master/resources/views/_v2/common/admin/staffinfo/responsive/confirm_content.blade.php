{{-- 役職 --}}
<div class="staffCard__job">{{ $CodeUtil::getDegreeName( $staffInfoObj->department ) }}</div>

<dl class="staffCard__profile">
    <dt>店舗</dt>
    <dd>{{ $shopName ?? '-' }}</dd>
    {{-- 血液型 --}}
    <dt>血液型</dt>
    <dd>{{ $staffInfoObj->ext_value1 ?? '-' }}</dd>
    {{-- 星座 --}}
    <dt>星座</dt>
    <dd>{{ $staffInfoObj->ext_value5 ?? '-' }}</dd>

    {{-- 出身地 --}}
    <dt>出身地</dt>
    <dd>{{ $staffInfoObj->ext_value2 ?? '-' }}</dd>
</dl>

<dl class="staffCard__qualification">
    <dt>資格</dt>
    {{-- 資格 --}}
    {{-- 複数 --}}
    <dd>{{ $staffInfoObj->ext_value3 }}</dd>
    @for ($i = 2;$i <= 6;$i++)
      @php
      $key = "ext_value3_{$i}";
      @endphp
      @if (empty($staffInfoObj->{$key}))
          @continue
      @endif
      <dd>{{ $staffInfoObj->{$key} }}</dd>
    @endfor
</dl>

<dl class="staffCard__like">
    <dt>愛してやまないもの</dt>
    {{-- 愛してやまないもの --}}
    {{-- 複数 --}}
    <dd>{{ $staffInfoObj->ext_value4 }}</dd>
    @for ($i = 2;$i <= 6;$i++)
      @php
      $key = "ext_value4_{$i}";
      @endphp
      @if (empty($staffInfoObj->{$key}))
          @continue
      @endif
      <dd>{{ $staffInfoObj->{$key} }}</dd>
    @endfor
</dl>

<div class="staffCard__message">
    <p>{!! nl2br( $staffInfoObj->comment ) !!}</p>
</div>
