
<!doctype html>
<html lang="ja">
<head>
  <meta charset="shift_jis">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $hanshaName }} ｜ スタッフ紹介</title>
  <!--<script src="{{ asset_auto('v2/admin/staffinfo/responsive') }}/js/pace.min.js"></script>-->
  <!--<link rel="stylesheet" href="{{ asset_auto('v2/admin/staffinfo/responsive') }}/css/style_staff.css">-->
  <script src="https://www.hondanet.co.jp/mut_system/staff/js/pace.min.js"></script>
  <link rel="stylesheet" href="https://www.hondanet.co.jp/mut_system/staff/css/style_staff.css">
  <link rel="stylesheet" href="{{ asset_auto('v2/admin/staffinfo/responsive') }}/css/custom.css">
  @yield('css')
</head>
<body>
  <div class="pageLoader"></div>

  <div class="pageContainer">
    <h1 class="pageTitle">
        <span class="hondacars">{{ $hanshaName }}</span>
        <span class="shop">{{ $shopName }}</span>
        <span class="title">スタッフ紹介</span>
    </h1>
    @yield('header')
    <section class="sectionInner -no_space">
        {{-- コンテンツ --}}
        @yield('content')
    </section>
    <section class="sectionInner -w_desktop">
      <div class="inputEdit -footer">
        @yield('footer')
      </div>
    </section>
  </div>

  <!--<script src="assets/js/jquery-3.4.1.min.js"></script>-->
  <script src="{{ asset_auto('js/jquery-2.2.4.min.js') }}"></script>
  @yield('js')
</body>
</html>