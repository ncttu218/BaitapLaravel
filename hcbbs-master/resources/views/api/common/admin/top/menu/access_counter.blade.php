{{-- カスタムなボタン --}}
<div class="p-index-menu__item p-index-button">
    <a class="p-index-button__target _color-4" href="{{ $urlActionAccessCounter }}" target="_blank">アクセス集計</a>
    <p class="p-index-button__description">（情報掲示板の店舗別アクセス数を集計します）</p>
    {{-- 説明文があるとき --}}
    @if( isset($description) )
        <p class="p-index-button__description">{!! nl2br( $description ) !!}</p>
    @endif
</div>
