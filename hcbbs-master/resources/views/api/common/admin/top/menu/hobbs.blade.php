{{-- 店舗ブログ --}}
<?php
    $path = 'original.admin_honsya_menu_para.'.$hanshaCode.'.0.menu_name';
    $menu_title = config($path);
?>
@if ($account_level <= 2 || $account_level ===  5)
<div class="p-index-menu__item p-index-button">
    <a class="p-index-button__target _color-4" href="{{ $urlActionHobbs }}" target="_blank">{{ $title ?? $menu_title }}</a>
    {{-- 説明文があるとき --}}
    @if( isset($description) )
        <p class="p-index-button__description">{!! nl2br( $description ) !!}</p>
    @endif
</div>
@endif
