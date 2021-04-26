{{-- 役職 --}}
<div class="staffCard__job">
    {{ $departmentCodes[$staffInfoObj->department] ?? '' }}
    {{ $staffInfoObj->position ?? '' }}
</div>

<dl class="staffCard__profile">
    <dt>フリガナ</dt>
    <dd>{{ $staffInfoObj->name_furi ?? '-' }}</dd>
    <dt>店舗</dt>
    <dd>{{ $shopName ?? '-' }}</dd>
    {{-- 星座 --}}
    <dt>星座</dt>
    <dd>{{ $staffInfoObj->ext_value1 ?? '-' }}</dd>

    {{-- 血液型 --}}
    <dt>血液型</dt>
    <dd>{{ $staffInfoObj->ext_value2 ?? '-' }}</dd>
</dl>

<dl class="staffCard__like">
    <dt>愛してやまないもの</dt>
    {{-- 愛してやまないもの --}}
    {{-- 複数 --}}
    @if (!empty($staffInfoObj->ext_value4))
        <dd>{{ $staffInfoObj->ext_value4 }}</dd>
    @endif
    @if (!empty($staffInfoObj->ext_value4_2))
        <dd>{{ $staffInfoObj->ext_value4_2 }}</dd>
    @endif
    @if (!empty($staffInfoObj->ext_value4_3))
        <dd>{{ $staffInfoObj->ext_value4_3 }}</dd>
    @endif
</dl>

<div class="staffCard__message">
    <p>{!! nl2br( $staffInfoObj->comment ) !!}</p>
</div>
