{{-- 店舗ブログ --}}
@if (isset($use_selector) && $use_selector)
<div class="p-index-menu__item p-index-select">
    <div class="p-index-select__head">{{ $menu_name ?? '' }}</div>
    <div class="p-index-select__body">
        {{-- フォームの表示 --}}
        <form class="p-index-select__form" action="{{ $urlActionMessage }}" method="{{ $method ?? 'post' }}" target="_blank">
            <div class="p-index-select__input c-control-select">
                {{-- 拠点選択プルダウンの表示 --}}
                <select name="shop">
                    @if( isset( $shopList ) )
                        @foreach( $shopList as $base_code => $base_name )
                            <option value="{{ $base_code }}">{{ $base_name }}</option>
                        @endforeach
                    @else
                        <option value="">-- 店舗がありません --</option>
                    @endif
                </select>
            </div>
            <label class="p-index-select__button"><input type="submit" value="管理画面を表示">管理画面を表示</label>
        </form>
    </div>
</div>
@else

@if ($account_level <= 2 || $hanshaCode == '4051009' || $account_level ===  5 || (isset($role_check) && $role_check === false))
    <div class="p-index-menu__item p-index-button">
        <a class="p-index-button__target _color-4" href="{{ $urlActionMessage }}" target="_blank">{{ $menu_name ?? 'TOPページ1行メッセージ' }}</a>
        {{-- 説明文があるとき --}}
        @if( isset($description) )
            <p class="p-index-button__description">{!! nl2br( $description ) !!}</p>
        @endif
    </div>
@endif

@endif
