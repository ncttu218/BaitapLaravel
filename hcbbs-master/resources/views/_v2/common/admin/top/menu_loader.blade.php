@php
$hanshaCode = $loginAccountObj->gethanshaCode();
if ($account_level <= 2) {
    $menuList = config('original.admin_honsya_menu_para')[$hanshaCode] ?? [];
} else {
    $menuList = config('original.admin_menu_para')[$hanshaCode] ?? [];
}
// ログイン販社の拠点一覧を取得する
if ($hanshaCode == '5756013' || $hanshaCode == '6251802') {
    $shopList = App\Models\Base::getStaffBlogShopOptions( $hanshaCode );
} else {
    $shopList = App\Models\Base::getShopOptions( $hanshaCode );
}
@endphp

@foreach ($menuList as $hanshaCode => $item)
    @php
    extract($item)
    @endphp

    @switch($item['menu_type'])
        @case(1)
            @include('v2.common.admin.top.menu.infobbs')
            @break

        @case(2)
            @include('v2.common.admin.top.menu.staffbbs')
            @break

        @case(3)
            @include('v2.common.admin.top.menu.staff_selector')
            @break

        @case(4)
            @include('v2.common.admin.top.menu.custom_selector')
            @break

        @case(5)
            @include('v2.common.admin.top.menu.showroom_selector')
            @break

        @case(7)
            @include('v2.common.admin.top.menu.message')
            @break

        @case(8)
            @include('v2.common.admin.top.menu.hobbs')
            @break

        @case(9)
            @include('v2.common.admin.top.menu.access_counter')
            @break

        @default
            @include('v2.common.admin.top.menu.custom_button')
            @break

    @endswitch
@endforeach
        