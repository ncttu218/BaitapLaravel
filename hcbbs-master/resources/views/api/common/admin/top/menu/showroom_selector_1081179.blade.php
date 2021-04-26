{{-- ショールーム情報画面へのフォームの表示 --}}
<div class="p-index-menu__item p-index-select">
    <div class="p-index-select__head">{{ $menu_name ?? 'スタッフ紹介集合写真' }}</div>
    <div class="p-index-select__body">
        {{-- フォームの表示 --}}
        <form class="p-index-select__form" action="https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=1081179/shop&mode=admin" method="post" target="_blank">
            <div class="p-index-select__input c-control-select">

                <?php
                // ログイン販社の拠点一覧を取得する
                $hanshaCode = $loginAccountObj->gethanshaCode();
                if ($hanshaCode == '6251802') {
                    $shopList = App\Models\Base::getShowroomBlogShopOptions( $hanshaCode );
                } else {
                    $shopList = App\Models\Base::getShopOptions( $hanshaCode );
                }
                ?>
                {{-- 拠点選択プルダウンの表示 --}}
                <select name="shop">
                    @if( isset( $shopList ) )
                        @foreach( $shopList as $base_code => $base_name )
                            @if($base_code == '90' || $base_code == 'aa' || $base_code == 'saiyo' || $base_code == 'r1')
                                @continue
                            @endif

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