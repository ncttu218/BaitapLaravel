{{-- 拠点選択フォームの表示 --}}
<div class="p-index-menu__item p-index-select">
    <div class="p-index-select__head">{{ $menu_name ?? '' }}</div>
    <div class="p-index-select__body">
        {{-- フォームの表示 --}}
        <form class="p-index-select__form" action="{{ $menu_url ?? '' }}" method="{{ $method ?? 'post' }}" target="_blank">
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
