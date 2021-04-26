<?php
$url = 'http://check.hondanet.co.jp';
$url2 = 'http://check.hondanet.co.jp/web_manual/js_demo/home';
?>
@include('site.functions')
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="shift_jis">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<meta name="description" content="東京都のHonda正規ディーラー Honda Cars 青山 （株式会社ホンダカーズ青山） のホームページです。新車、試乗車、自動車保険、点検・車検、整備。車のことなら何でもおまかせ下さい！">
<title>ショールームブログ | ショールーム | Honda Cars 青山</title>
<link rel="stylesheet" href="http://check.hondanet.co.jp/web_manual/js_demo/home/css/common.css?20190904150656" charset="UTF-8">
<link rel="stylesheet" href="http://check.hondanet.co.jp/web_manual/js_demo/home/css/style.css?20190904150656" charset="UTF-8">
<link rel="stylesheet" media="print" href="http://check.hondanet.co.jp/web_manual/js_demo/home/css/print.css" charset="UTF-8">
<link rel="stylesheet" href="/common-css/timeswitch.css">
<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700" rel="stylesheet"></head>
<body class="l-page" data-id="blog" data-category="showroom">
<div class="l-loader" id="js-loader">
  <div></div>
</div><div class="l-wrapper" id="js-wrapper">
	<header id="js-header" class="l-header">
  <div class="l-header__inner">
    <h1 class="l-header-logo">
      <a href="<?= $url ?>/web_manual/js_demo/"
        ><img
          src="http://check.hondanet.co.jp/web_manual/js_demo/home/img/logo_header.png"
          srcset="http://check.hondanet.co.jp/web_manual/js_demo/home/img/logo_header@2x.png 2x"
          alt="Honda Cars 青山"
      /></a>
    </h1>
    <nav id="js-global-navigation" class="l-header-nav">
      <ul class="l-header-nav-list">
        <li class="l-header-nav-list__item _showroom">
          <a href="#" class="l-header-nav-list__link"
            >ショールーム</a
          >
          <div class="l-header-local">
            @include('site.menu')
          </div>
        </li>

        <li class="l-header-nav-list__item _car">
          <a href="#" class="l-header-nav-list__link"
            >クルマ情報</a
          >
          <div class="l-header-local">
            <ul class="l-header-local-list">
              <li class="l-header-local-list__item">
                <a href="#">ラインアップ</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">おすすめ車</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">展示・試乗車情報</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">中古車情報</a>
              </li>
            </ul>
          </div>
        </li>

        <li class="l-header-nav-list__item _campaign">
          <a href="#" class="l-header-nav-list__link"
            >キャンペーン</a
          >
        </li>

        <li class="l-header-nav-list__item _maintenance">
          <a href="#" class="l-header-nav-list__link"
            >点検・整備</a
          >
          <div class="l-header-local">
            <ul class="l-header-local-list">
              <li class="l-header-local-list__item">
                <a href="#">点検スケジュール</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">初回1ヶ月点検</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">初回6ヶ月点検</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">法定12ヶ月点検</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">安心点検</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">車検</a>
              </li>
            </ul>
          </div>
        </li>

        <li class="l-header-nav-list__item _maintenance">
          <a href="#" class="l-header-nav-list__link"
            >カーライフ</a
          >
          <div class="l-header-local">
            <ul class="l-header-local-list">
              <li class="l-header-local-list__item">
                <a href="#">カーケアメニュー</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">ボディコーティング</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">自動車保険</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">Honda Total Care</a>
              </li>
            </ul>
          </div>
        </li>

        <li class="l-header-nav-list__item _company">
          <a href="#" class="l-header-nav-list__link"
            >会社情報</a
          >
          <div class="l-header-local">
            <ul class="l-header-local-list">
              <li class="l-header-local-list__item">
                <a href="#">会社概要</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">環境保全活動</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">ご利用にあたって</a>
              </li>
              <li class="l-header-local-list__item">
                <a href="#">プライバシーポリシー</a>
              </li>
            </ul>
          </div>
        </li>

        <li class="l-header-nav-list__item _recruit">
          <a
            href="/home/jump/recruit.html"
            target="_blank"
            class="l-header-nav-list__link"
            >採用情報</a
          >
        </li>
      </ul>
    </nav>

    <div id="js-header-trigger" class="l-header-trigger">
      <div class="l-header-trigger__inner">
        <span></span> <span></span> <span></span>
      </div>
      <span class="l-header-trigger__title">MENU</span>
    </div>
  </div>

  <div id="js-sp-navigation" class="l-sp-navigation">
    <a class="l-sp-navigation__button" href="#"
      >当社への問い合わせはこちらから</a
    >
    <a
      class="l-sp-navigation__button"
      href="#"
      target="_blank"
      >メンテナンスのお見積・ご予約はこちらから</a
    >
  </div>
</header>

<aside id="js-side-menu" class="l-sidebar-menu">
  <a href="#js-coupon-container" class="l-sidebar-menu__button js-modal">
    <i class="l-sidebar-menu__icon _coupon"><img src="<?= $url ?>/web_manual/js_demo/home/img/icon_coupon01.png" alt="#"></i>
    <span class="l-sidebar-menu__title">今月の<br>サービス券</span>
  </a>

  <a href="#" class="l-sidebar-menu__button">
    <i class="l-sidebar-menu__icon _contact"><img src="<?= $url ?>/web_manual/js_demo/home/img/icon_contact01.png" alt="#"></i>
    <span class="l-sidebar-menu__title">お問合わせ</span>
  </a>
</aside>
	<main class="l-main">
		<!--[if lt IE 9]>
    <div class="showIE">
      <p class="showIE__text">当サイトをご覧になる場合、以下のブラウザを推奨いたします。</p>
      <p class="showIE__text">Windows :
        <a href="//www.hondanet.co.jp/jump/browser/ie.html" target="_blank">Internet Explorer 11.x以降</a> /
        <a href="//www.hondanet.co.jp/jump/browser/chrome.html" target="_blank">Chrome 最新版</a> /
        <a href="//www.hondanet.co.jp/jump/browser/firefox.html" target="_blank">FireFox 最新版</a>
      </p>
      <p class="showIE__text">Macintosh :
        <a href="//www.hondanet.co.jp/jump/browser/safari.html" target="_blank">Safari 最新版</a> /
        <a href="//www.hondanet.co.jp/jump/browser/chrome.html" target="_blank">Chrome 最新版</a> /
        <a href="//www.hondanet.co.jp/jump/browser/firefox.html" target="_blank">FireFox 最新版</a>
      </p>
      <p class="showIE__text">これらのブラウザ以外でご覧いただくと、機能の一部が正しく動作しない場合があります。<br>
      また、推奨環境下でもお客様のウェブブラウザの設定によっては、ご利用できないもしくは正しく表示されない場合がございます。</p>
    </div>
<![endif]-->
		
		<div class="l-page-heading">
			<div class="l-page-heading__inner">
				<div class="l-page-heading__content">
					<h2 class="l-page-heading__title">ショールームブログ<span>SHOWROOM</span></h2>
				</div>
				<div class="l-breadcrumbs">
		<ol class="c-breadcrumbs">
			<li><a href="<?= $url ?>/web_manual/js_demo/">HOME</a></li>
			<li><a href="#">ショールーム</a></li>
			<li>ショールームブログ</li>
		</ol>
	</div>
			</div>
		</div>
		
		<div class="l-page-contents">
			<section class="c-section-container _bg_white">
  <div class="c-section-inner">
    <div class="p-blog-content">
      <div class="p-blog-dropsort">
        <p class="p-blog-dropsort__text">お近くのお店を選択してください</p>
        <form name="sort_form">
          <?php
          $shopCode = isset($_GET['shop']) ? $_GET['shop'] : '';
          ?>
          <select name="sort" onchange="dropsort()">
            <option value=""> --- 選択してください --- </option>
              <option value="blog01?shop=01"<?= $shopCode == '01' ? ' selected' : '' ?>>青山店</option>
              <option value="blog01?shop=02"<?= $shopCode == '02' ? ' selected' : '' ?>>港店</option>
              <option value="blog01?shop=03"<?= $shopCode == '03' ? ' selected' : '' ?>>江東店</option>
              <option value="blog01?shop=04"<?= $shopCode == '04' ? ' selected' : '' ?>>渋谷店</option>
              <option value="blog01?shop=05"<?= $shopCode == '05' ? ' selected' : '' ?>>表参道店</option>
              <option value="blog01?shop=06"<?= $shopCode == '06' ? ' selected' : '' ?>>品川店</option>
            </select>
        </form>
      </div>
      <!--ここからPHP-->
      <?php
      $queryStr = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
      $url = asset_auto('/api/blog?hansha_code=0000001') . '&' . $queryStr;
      echo http_get_contents($url);
      ?>
      <!--ここまでPHP-->
    </div>
  </div>
</section>
		</div>
	</main>
	<footer class="l-footer">
  <div id="js-coupon-container" class="c-coupon-container">
    <div class="c-coupon">
      <div class="c-coupon-image"><img src="<?= $url2 ?>/home/img/service.png" alt="" /></div>
      <p class="c-coupon-text">
        【サービス券をご利用の際】印刷をするか、こちらの画面をご提示ください。
      </p>
      <a
        href="#"
        onclick="window.print(); return false;"
        class="c-button is-default c-coupon-button"
        >サービス券を印刷する</a
      >
    </div>
  </div>

  <div class="l-footer-contact">
    <a class="l-footer-contact-box" href="#">
      <h2 class="l-footer-contact-box__title">
        CONTACT<span>お問い合わせ</span>
      </h2>
      <p class="l-footer-contact-box__text">
        カタログ請求・見積り・商談申込みから点検車検まで、お気軽にお問合わせください。
      </p>
    </a>
  </div>

  <div class="l-footer-sitemap">
    <a href="#" class="l-footer-arrow js-scroll">PAGETOP</a>
    <div class="l-footer-sitemap__inner">
      <section class="l-footer-sitemap__section">
        <div class="l-footer-sitemap-list">
          <h3 class="l-footer-sitemap-list__category js-local-open">
            ショールーム
          </h3>
          <ul class="l-footer-sitemap-list__items">
            <li class="l-footer-sitemap-list__item">
              <a href="#">ショールーム一覧</a>
            </li>

            <li class="l-footer-sitemap-list__item">
              <a href="#">ショールームブログ</a>
            </li>
          </ul>
        </div>

        <div class="l-footer-sitemap-list">
          <h3 class="l-footer-sitemap-list__category js-local-open">
            キャンペーン
          </h3>
          <ul class="l-footer-sitemap-list__items">
            <li class="l-footer-sitemap-list__item">
              <a href="#">キャンペーン情報</a>
            </li>
          </ul>
        </div>
      </section>

      <section class="l-footer-sitemap__section">
        <div class="l-footer-sitemap-list">
          <h3 class="l-footer-sitemap-list__category js-local-open">
            クルマ情報
          </h3>
          <ul class="l-footer-sitemap-list__items">
            <li class="l-footer-sitemap-list__item">
              <a href="#">ラインアップ</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">おすすめ車</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">展示・試乗車情報</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">中古車情報</a>
            </li>
          </ul>
        </div>

      </section>

      <section class="l-footer-sitemap__section">
        <div class="l-footer-sitemap-list">
          <h3 class="l-footer-sitemap-list__category js-local-open">
            メンテナンス
          </h3>
          <ul class="l-footer-sitemap-list__items">
            <li class="l-footer-sitemap-list__item">
              <a href="#">点検スケジュール</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">初回1ヶ月点検</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">初回6ヶ月点検</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">法定12ヶ月点検</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">安心点検</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">車検</a>
            </li>
          </ul>
        </div>
      </section>

      <section class="l-footer-sitemap__section">
        <div class="l-footer-sitemap-list">
          <h3 class="l-footer-sitemap-list__category js-local-open">
            カーライフ
          </h3>
          <ul class="l-footer-sitemap-list__items">
            <li class="l-footer-sitemap-list__item">
              <a href="#">カーケアメニュー</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">ボディコーティング</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">自動車保険</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">Honda Total Care</a>
            </li>
          </ul>
        </div>
      </section>

      <section class="l-footer-sitemap__section">
        <div class="l-footer-sitemap-list">
          <h3 class="l-footer-sitemap-list__category js-local-open">
            会社情報
          </h3>
          <ul class="l-footer-sitemap-list__items">
            <li class="l-footer-sitemap-list__item">
              <a href="#">会社概要</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#" target="_blank">採用情報</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">環境保全活動</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">ご利用にあたって</a>
            </li>
            <li class="l-footer-sitemap-list__item">
              <a href="#">プライバシーポリシー</a>
            </li>
          </ul>
        </div>
      </section>
    </div>

    <p class="l-footer-info">
      <!--<small class="l-footer-info__secondhandNumber"><span>株式会社ホンダカーズ青山</span>東京都公安委員会 古物商許可証番号 第000000000000号</small>-->
      <small class="l-footer-info__copyright"
        >&copy; Honda Cars AOYAMA. All Rights Reserved.</small
      >
    </p>
  </div>
</footer>
<!-- / .l-footer -->
</div>
<script type="text/javascript" src="//typesquare.com/accessor/apiscript/typesquare.js?~wwNnx7Klhs%3D" charset="utf-8"></script>
<script src="http://check.hondanet.co.jp/web_manual/js_demo/home/js/jquery-2.2.4.min.js"></script>
<script src="//www.hondanet.co.jp/common-js/dcs.js"></script>
<script src="//www.hondanet.co.jp/common-js/mut.ua.js"></script>
<script src="//www.hondanet.co.jp/common-php/getServerDtimeObj.php"></script>
<script src="//www.hondanet.co.jp/common-js/mut.calendar.class.js"></script>
<script src="//www.hondanet.co.jp/common-js/mut.business.class.js"></script>
<script src="http://check.hondanet.co.jp/web_manual/js_demo/home/js/jquery.easing.1.3.js"></script>
<script src="http://check.hondanet.co.jp/web_manual/js_demo/home/js/moment.js"></script>
<script src="http://check.hondanet.co.jp/web_manual/js_demo/home/js/mut.calendar.settings.js"></script>
<script src="http://check.hondanet.co.jp/web_manual/js_demo/home/js/modaal.min.js"></script>
<script src="http://check.hondanet.co.jp/web_manual/js_demo/home/js/common.js"></script>
<!-- chatbot -->
<script>(function () { //繝√Ε繝�ヨ繝懊ャ繝郁ｪｭ縺ｿ霎ｼ縺ｿ
    var w = window, d = document;
    var s = ('https:' == document.location.protocol ? 'https://' : 'http://') + "app.chatplus.jp/cp.js";
    d["__cp_d"] = ('https:' == document.location.protocol ? 'https://' : 'http://') + "app.chatplus.jp";
    d["__cp_c"] = "6668484e_1";
    var a = d.createElement("script"), m = d.getElementsByTagName("script")[0];
    a.async = true, a.src = s, m.parentNode.insertBefore(a, m);
  })();
</script>	<script>
  function dropsort() {
    var browser = document.sort_form.sort.value;
    location.href = browser
  }
  </script>
</body>
</html>