{{-- 拠点選択フォームの表示 --}}
<div class="p-index-menu__item p-index-select">
    <div class="p-index-select__head">{{ $menu_name ?? '' }}</div>
    <div class="p-index-select__body">
        {{-- フォームの表示 --}}
        <form class="p-index-select__form" action="{{ $menu_url ?? '' }}" method="{{ $method ?? 'post' }}" target="_blank">
            <div class="p-index-select__input c-control-select">
                @if( isset( $shopList ) )
                <?php
                // 除外する店舗コード
                $exclusion = [];
                if (config()->has("{$hanshaCode}.custom.usedCarShopIdExclusion")) {
                    $exclusionCfg = config("{$hanshaCode}.custom.usedCarShopIdExclusion");
                    if (is_array($exclusionCfg)) {
                        $exclusion = $exclusionCfg;
                    }
                }
                // 緊急掲示板の店舗コードがあれば、削除する
                if (isset($emergencyBulletinShopCode) && !empty($emergencyBulletinShopCode)) {
                    $exclusion[] = $emergencyBulletinShopCode;
                }
                foreach ($exclusion as $shopId) {
                    if (!isset($shopList[$shopId])) {
                        continue;
                    }
                    unset($shopList[$shopId]);
                }
                ?>
                @endif
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
