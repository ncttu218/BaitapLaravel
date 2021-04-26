@php
$hanshaCode = $loginAccountObj->gethanshaCode();
$account_level = $loginAccountObj->getAccountLevel();
if ($account_level <= 2 || $account_level ===  5) {
    $menuList = config('original.admin_honsya_menu_para')[$hanshaCode] ?? [];
} else {
    $menuList = config('original.admin_menu_para')[$hanshaCode] ?? [];
}
@endphp

@foreach ($menuList as $item)
    @php
    $desc = $item['description'] ?? '';
    extract($item);
    $description = $desc;
    
    // ログイン販社の拠点一覧を取得する
    if ($hanshaCode == '5756013' || $hanshaCode == '6251802') {
        $shopList = App\Models\Base::getStaffBlogShopOptions( $hanshaCode );
    }else if ($hanshaCode == '8812701'){
        $shopList = ( new App\Http\Controllers\V2\_8812701\Codes\StaffBlogCodes )->getOptions();
    } else {
        $showFlg = 0;
        if ($item['menu_type'] == 1) {
            $showFlg = 1;
        } else if ($item['menu_type'] == 4) {
            $showFlg = 3;
        }
        $shopList = App\Models\Base::getShopOptions( $hanshaCode, false, $showFlg );
    }
    @endphp

    @switch($item['menu_type'])
        @case(1)
            @include('api.common.admin.top.menu.infobbs')
            @break

        @case(2)
            @include('api.common.admin.top.menu.staffbbs')
            @break

        @case(3)
            @if($hanshaCode == '1081179')
                @include('api.common.admin.top.menu.staff_selector_1081179')
            @else
                @include('api.common.admin.top.menu.staff_selector')
            @endif
            @break
        @case(4)
            @include('api.common.admin.top.menu.custom_selector')
            @break

        @case(5)
        @if($hanshaCode == '1081179')
            @include('api.common.admin.top.menu.showroom_selector_1081179')
        @else
            @include('api.common.admin.top.menu.showroom_selector')
        @endif
            @break

        @case(7)
            @include('api.common.admin.top.menu.message')
            @break

        @case(8)
            @include('api.common.admin.top.menu.hobbs')
            @break

        @case(9)
            @include('api.common.admin.top.menu.access_counter')
            @break

        @case(10)
            @include('api.common.admin.top.menu.custom_selector2')
            @break

        @default
            @include('api.common.admin.top.menu.custom_button')
            @break

    @endswitch
@endforeach
        