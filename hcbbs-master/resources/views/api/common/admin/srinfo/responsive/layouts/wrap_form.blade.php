<!doctype html>
<html lang="ja">
<head>
  <meta charset="shift_jis">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $hanshaName }} ｜ ショールーム情報</title>
  <!--<script src="{{ asset_auto('v2/admin/srinfo/responsive') }}/js/pace.min.js"></script>-->
  <!--<link rel="stylesheet" href="{{ asset_auto('v2/admin/srinfo/responsive') }}/css/style_srinfo.css">-->
  <!--<link rel="stylesheet" href="{{ asset_auto('v2/admin/srinfo/responsive') }}/css/style_srinfo.css">-->
  <script src="https://www.hondanet.co.jp/mut_system/sr_info/js/pace.min.js"></script>
  <link rel="stylesheet" href="https://www.hondanet.co.jp/mut_system/sr_info/css/style_srinfo.css">
  <link rel="stylesheet" href="{{ asset_auto('v2/admin/srinfo/responsive') }}/css/custom.css">
  @yield('css')
</head>
<body>
  <div class="pageLoader"></div>

  <div class="pageContainer">
    <h1 class="pageTitle">
        <span class="hondacars">{{ $hanshaName }}</span>
        <span class="shop">{{ $shopName }}</span>
        <span class="title">ショールーム情報</span>
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
    {!! Form::close() !!}
  </div>

  <!--<script src="assets/js/jquery-3.4.1.min.js"></script>-->
  <script src="{{ asset_auto('js/jquery-2.2.4.min.js') }}"></script>
  @yield('js')
</body>
</html>