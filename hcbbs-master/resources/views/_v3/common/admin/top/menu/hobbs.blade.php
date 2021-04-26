{{-- 店舗ブログ --}}
@if ($account_level <= 2)
<div class="p-index-menu__item p-index-button">
    <a class="p-index-button__target _color-4" href="{{ $urlActionHobbs }}" target="_blank">{{ $title ?? '拠点情報掲示板(承認待ち一覧)' }}</a>
    {{-- 説明文があるとき --}}
    @if( isset($description) )
        <p class="p-index-button__description">{!! nl2br( $description ) !!}</p>
    @endif
</div>
@endif
