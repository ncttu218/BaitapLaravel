{{-- タイトル --}}
<div class="p-entrylist-box__head">
    <h3 class="p-entrylist-box__title">
        @include('v2.common.admin.infobbs.column.title')
    </h3>
    @if (isset($shopName))
    <div class="p-entrylist-box__sign">
        {{ $shopName }}
    </div>
    @endif
</div>
