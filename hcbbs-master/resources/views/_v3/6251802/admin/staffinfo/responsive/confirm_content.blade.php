{{-- 役職 --}}
<div class="staffCard__job">{{ $departmentCodes[$staffInfoObj->department] ?? '' }}</div>

<dl class="staffCard__profile">
    <dt>フリガナ</dt>
    <dd>{{ $staffInfoObj->name_furi ?? '-' }}</dd>
    <dt>店舗</dt>
    <dd>{{ $shopName ?? '-' }}</dd>
    {{-- 血液型 --}}
    <dt>血液型</dt>
    <dd>{{ $staffInfoObj->ext_value1 ?? '-' }}</dd>

    {{-- 出身地 --}}
    <dt>出身地</dt>
    <dd>{{ $staffInfoObj->ext_value2 ?? '-' }}</dd>
</dl>

<dl class="staffCard__qualification">
    <dt>資格</dt>
    {{-- 資格 --}}
    {{-- 複数 --}}
    <dd>{{ $staffInfoObj->ext_value3 }}</dd>
</dl>

<dl class="staffCard__like">
    <dt>趣味</dt>
    {{-- 趣味 --}}
    {{-- 複数 --}}
    <dd>{{ $staffInfoObj->ext_value4 }}</dd>
</dl>

<div class="staffCard__message">
    <p>{!! nl2br( $staffInfoObj->comment ) !!}</p>
</div>
