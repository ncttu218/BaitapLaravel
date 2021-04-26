{{-- 店舗ブログ --}}
<div class="p-index-menu__item p-index-button">
    <a class="p-index-button__target " href="{{ $urlActionInfobbs }}" target="_blank">{{ $menu_name ?? '店舗ブログ' }}</a>
    {{-- 説明文があるとき --}}
    @if( isset($description) )
        <p class="p-index-button__description">{!! nl2br( $description ) !!}</p>
    @endif
</div>
