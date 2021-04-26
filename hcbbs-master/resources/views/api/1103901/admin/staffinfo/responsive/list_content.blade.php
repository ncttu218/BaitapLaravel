<dl class="staffCard__profile">
    <dt>フリガナ</dt>
    <dd>
        {{-- フリガナ --}}
        {{ $row->name_furi ?? '-' }}
    </dd>
    
    <dt>星座</dt>
    <dd>
        {{-- 星座 --}}
        {{ $row->ext_value1 ?? '-' }}
    </dd>

    <dt>血液型</dt>
    <dd>
        {{-- 血液型 --}}
        {{ $row->ext_value2 ?? '-' }}
    </dd>
</dl>

<dl class="staffCard__like">
    <dt>愛してやまないもの</dt>
    {{-- 愛してやまないもの --}}
    {{-- 複数 --}}
    <dd>{{ $row->ext_value4 }}</dd>
    @for ($i = 2;$i <= 6;$i++)
    @php
    $key = "ext_value4_{$i}";
    @endphp
    @if (empty($row->{$key}))
        @continue
    @endif
    <dd>{{ $row->{$key} }}</dd>
    @endfor
</dl>

<div class="staffCard__message">
    {{-- コメント --}}
    @if (!empty($row->comment))
    <p>{{ $row->comment }}</p>
    @endif
</div>
