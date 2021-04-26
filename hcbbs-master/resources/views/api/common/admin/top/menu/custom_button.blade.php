{{-- カスタムなボタン --}}
<div class="p-index-menu__item p-index-button">
    <a class="p-index-button__target _color-4" href="{{ $menu_url ?? '' }}" target="_blank">
    	{{ $menu_name ?? '' }}</a>
    {{-- 説明文があるとき --}}
    @if( isset($description) )
        <p class="p-index-button__description">{!! nl2br( $description ) !!}</p>
    @endif
</div>
