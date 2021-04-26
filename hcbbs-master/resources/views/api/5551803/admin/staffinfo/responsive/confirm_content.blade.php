@section('css')
<style type="text/css">
    .staffCard__profile dt {
        width: 6em;
    }
    .staffCard__profile dd {
        width: calc(100% - 6em);
    }
</style>
@endsection

{{-- 役職 --}}
<div class="staffCard__job">{{ $departmentCodes[$staffInfoObj->department] ?? '' }}</div>

<dl class="staffCard__profile">
    <dt>フリガナ</dt>
    <dd>{{ $staffInfoObj->name_furi ?? '-' }}</dd>
    
    <dt>店舗</dt>
    <dd>{{ $shopName ?? '-' }}</dd>
    
    <dt>取得資格</dt>
    <dd>{{ $staffInfoObj->ext_value6 ?? '' }}</dd>
</dl>

@for ($i=1;$i<=5;$i++)
    <?php
    $keyName = 'ext_field' . $i;
    ?>
    @if (!isset($staffInfoObj->{$keyName}) || empty($staffInfoObj->{$keyName}))
      @continue
    @endif
    
    <dl class="staffCard__qualification">
        <dt>{{ $staffInfoObj->{$keyName} }}</dt>
        <dd>{{ $staffInfoObj->{'ext_value' . $i} }}</dd>
    </dl>
@endfor

<div class="staffCard__message">
    <p>{!! nl2br( $staffInfoObj->comment ) !!}</p>
</div>
