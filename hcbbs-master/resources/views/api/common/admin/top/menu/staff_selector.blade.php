{{-- スタッフ紹介画面へのフォームの表示 --}}
<div class="p-index-menu__item p-index-select">
    <div class="p-index-select__head">{{ $title ?? 'スタッフ紹介' }}</div>
    <div class="p-index-select__body">
        {{-- フォームの表示 --}}
        <form class="p-index-select__form" action="{{ $urlActionInfobbsStaff }}" method="get" target="_blank">
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