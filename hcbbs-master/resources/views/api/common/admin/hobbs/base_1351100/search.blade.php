{{-- タイトル --}}
<div class="p-entrylist-box__head" style="background: rgb(0, 0, 102);color: #FFFFFF;margin-left: -15px;margin-right: -15px;">
    <h4 class="p-entrylist-box__title" style="padding: 2px 15px;margin: 0;width: 100%;position: relative;">
        @include('api.common.admin.hobbs.column.title')
    </h4>
    @if (isset($shopName))
    <div class="p-entrylist-box__sign">
        {{ $shopName }}
    </div>
    @endif
</div>

<div class="p-entrylist-box__body">
@include('api.common.admin.hobbs.column.comment')
</div>
