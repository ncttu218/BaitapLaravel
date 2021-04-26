<?php
$url = 'http://check.hondanet.co.jp';
$url2 = 'http://check.hondanet.co.jp/web_manual/js_demo';
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
  <title>
    Honda Cars 青山 -
    東京都のHondaディーラー</title>
  <link rel="canonical" href="http://check.hondanet.co.jp/">
  <link rel="stylesheet" href="http://check.hondanet.co.jp/web_manual/js_demo/home/css/common.css?20190904143727" charset="UTF-8">
<link rel="stylesheet" href="http://check.hondanet.co.jp/web_manual/js_demo/home/css/style.css?20190904143727" charset="UTF-8">
<link rel="stylesheet" media="print" href="http://check.hondanet.co.jp/web_manual/js_demo/home/css/print.css" charset="UTF-8">
<link rel="stylesheet" href="{{ $url }}/common-css/timeswitch.css">
<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700" rel="stylesheet"></head>

<body class="l-page" data-id="index" data-category="index">
  <div class="l-loader" id="js-loader">
  <div></div>
</div>  <div class="l-wrapper" id="js-wrapper">
    <header id="js-header" class="l-header">
  <div class="l-header__inner">
    <h1 class="l-header-logo">
      <a href="{{ $url }}/web_manual/js_demo/"
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
            href="{{ $url }}/home/jump/recruit.html"
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
    <i class="l-sidebar-menu__icon _coupon"><img src="{{ $url }}/web_manual/js_demo/home/img/icon_coupon01.png" alt="#"></i>
    <span class="l-sidebar-menu__title">今月の<br>サービス券</span>
  </a>

  <a href="#" class="l-sidebar-menu__button">
    <i class="l-sidebar-menu__icon _contact"><img src="{{ $url }}/web_manual/js_demo/home/img/icon_contact01.png" alt="#"></i>
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

      <div class="l-page-contents _no-space">
        <div class="p-index-mv" id="js-mv-wrapper">
          <div id="js-mv-slider" class="p-top-main-visual">
            <div class="p-index-mv-item">
              <div class="p-index-mv-item__left" style="background-image: url('<?= $url2 ?>/home/img/main-visual01_01.jpg');"></div>
              <div class="p-index-mv-item__right" style="background-image: url('<?= $url2 ?>/home/img/main-visual01_02.jpg');"></div>
            </div>
            <div class="p-index-mv-item">
              <div class="p-index-mv-item__left" style="background-image: url('<?= $url2 ?>/home/img/main-visual02_01.jpg');"></div>
              <div class="p-index-mv-item__right" style="background-image: url('<?= $url2 ?>/home/img/main-visual02_02.jpg');"></div>
            </div>
            <div class="p-index-mv-item">
              <div class="p-index-mv-item__left" style="background-image: url('<?= $url2 ?>/home/img/main-visual03_01.jpg');"></div>
              <div class="p-index-mv-item__right" style="background-image: url('<?= $url2 ?>/home/img/main-visual03_02.jpg');"></div>
            </div>
          </div>
          <div class="p-index-mv-text">
            <em class="p-index-mv-text__head">
              <span class="p-index-mv-text__line">Honda Cars</span>
              <span class="p-index-mv-text__line">AOYAMA</span>
            </em>

            <p class="p-index-mv-text__foot">
              <span class="border"></span>
              <span class="p-index-mv-text__line">Honda Cars 青山は、</span>
              <span class="p-index-mv-text__line">いつもあなたのそばにいる。</span>
            </p>
          </div>
        </div>
                <div class="p-top-business-day">
          <span class="p-top-business-day__today" id="js-today"></span>
          <span class="p-top-business-day__content" id="js-business-day"></span>
          <a class="c-button is-primary p-top-business-day__button" href="">営業日カレンダー</a>
        </div>

        <section class="c-section-container _bg-white">
          <div class="c-section-inner">
            <div class="c-module-box">
              <div class="c-module-box__inner">
                <h2 class="c-module-box__title">【ファーストビュー内で確認できるJS実装コンテンツ】</h2>
                <ul class="c-module-box__list">
                  <li>・メインビジュアルアニメーション</li>
                  <li>・営業日判定システム</li>
                  <li>・追従メニュー（グローバルナビ）</li>
                  <li>・追従ボタン（サービス券・お問い合わせ）</li>
                  <li>・モーダルウィンドウ（サービス券）</li>
                  <li>・チャットボット</li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <section class="c-section-container _both-space _bg-white">
          <div class="c-section-inner">
            <h2 class="c-module-header">スライダー</h2>
            <div id="js-car-slider" class="p-top-slider">
              <div><a href="http://www.hondanet.co.jp/jump/19crv.html" target="_blank"><img src="http://www.hondanet.co.jp/imgs/19crv_slide.jpg"></a></div>
              <div><a href="http://www.hondanet.co.jp/jump/s660.html" target="_blank"><img src="http://www.hondanet.co.jp/imgs/19s660_slide.jpg"></a></div>
              <div><a href="http://www.hondanet.co.jp/jump/19jade.html" target="_blank"><img src="http://www.hondanet.co.jp/imgs/19jade_slide.jpg"></a></div>
              <div><a href="http://www.hondanet.co.jp/jump/nvan.html" target="_blank"><img src="http://www.hondanet.co.jp/imgs/nvan_slide.jpg"></a></div>
              <div><a href="http://www.hondanet.co.jp/jump/nbox_slope.html" target="_blank"><img src="http://www.hondanet.co.jp/imgs/nbox_slope_slide.jpg"></a></div>
              <div><a href="http://www.hondanet.co.jp/jump/185vezel.html" target="_blank"><img src="http://www.hondanet.co.jp/imgs/185vezel_slide.jpg"></a></div>
              <div><a href="{{ $url }}/home/jump/safety_map.html" target="_blank"><img src="http://www.hondanet.co.jp/imgs/kanto/saitama/safetymap_slide.jpg"></a></div>
            </div>
          </div>
          <a class="c-button is-default c-module-more-button" href="https://www.nxworld.net/example/slick-examples/current-class-examples.html" target="_blank">スライダーアニメーション例はこちら</a>
        </section>

        <section class="c-section-container _bottom-space _bg-white">
          <header class="c-section-header">
            <h2 class="c-section-header__title">
              <span class="en">FIND CONTENT</span>
              <span class="ja">目的から探す</span>
            </h2>
          </header>

          <div class="c-section-inner">
            <h2 class="c-module-header">ボタンアニメーション</h2>
            <div class="p-top-main-index">
              <a href="{{ $url }}/home/showroom.html" class="p-top-main-index-box">
                <div class="p-top-main-index-box__image" style="background-image: url(<?= $url2 ?>/home/img/img_top-showroom01.jpg);"></div>
                <div class="p-top-main-index-box__inner">
                  <h2 class="p-top-main-index-box__title">お店を探す</h2>
                  <p class="p-top-main-index-box__lead">お近くのお店をご案内いたします。<br>ご来店をお待ちしております。</p>
                </div>
              </a>

              <a href="{{ $url }}/home/democar.html" class="p-top-main-index-box">
                <div class="p-top-main-index-box__image" style="background-image: url(<?= $url2 ?>/home/img/img_top-car01.jpg);"></div>
                <div class="p-top-main-index-box__inner">
                  <h2 class="p-top-main-index-box__title">クルマを探す</h2>
                  <p class="p-top-main-index-box__lead">豊富なラインアップから、<br>ご提案させていただきます。</p>
                </div>
              </a>

              <a href="{{ $url }}/home/maintenance.html" class="p-top-main-index-box">
                <div class="p-top-main-index-box__image" style="background-image: url(<?= $url2 ?>/home/img/img_top-maintenance01.jpg);"></div>
                <div class="p-top-main-index-box__inner">
                  <h2 class="p-top-main-index-box__title">点検･整備について</h2>
                  <p class="p-top-main-index-box__lead">点検･整備はHonda車の<br>プロにお任せください。</p>
                </div>
              </a>
            </div>
            <a class="c-button is-default c-module-more-button" href="https://codepen.io/maheshambure21/full/kXwgyJ" target="_blank">ボタンアニメーション例はこちら</a>
          </div>
        </section>


        <section class="c-section-container _both-space p-top-blog-container">
          <header class="c-section-header">
            <h2 class="c-section-header__title">
              <span class="en">SHOWROOM BLOG</span>
              <span class="ja">ショールームブログ</span>
            </h2>
          </header>
          <div class="c-section-inner">
            <h2 class="c-module-header">ブログシステム / ブログアクセスランキング</h2>
          </div>

          <div class="c-section-inner p-top-blog-inner">

            <h2 class="p-top-blog__title">ブログアクセスランキング</h2>
            <div class="p-top-blog-ranking">
                <!--ここからPHP-->
                <?php
                $queryStr = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
                $url = asset_auto('/api/ranking?hansha_code=0000001') . '&' . $queryStr;
                echo http_get_contents($url);
                ?>
                <!--ここまでPHP-->
            </div>
          </div>
        </section>
        
        <section class="c-section-container _both-space _bg-white p-top-blog-container">
          <div class="c-section-inner">
           
            <h2 class="p-top-blog__title">最新のブログ</h2>
            <div id="js-blog-slider" class="p-top-blog-slider swiper-container">
              <div class="p-top-blog-slider__inner swiper-wrapper">

                <!--ここからPHP-->
                <?php
                $queryStr = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
                $url = asset_auto('/api/latest-blog?hansha_code=0000001') . '&' . $queryStr;
                echo http_get_contents($url);
                ?>
                <!--ここまでPHP-->

              </div>

              <div class="js-blog-prev swiper-button-prev"></div>
              <div class="js-blog-next swiper-button-next"></div>
              <div class="js-blog-scroll swiper-scrollbar"></div>
            </div>

            <a class="c-button is-default c-module-more-button" href="{{ $url2 }}/home/blog.html">ブログ一覧はこちら</a>

          </div>
        </section>


        <section class="c-section-container _top-space">
          <div class="p-top-showroom">
            <header class="c-section-header">
              <h2 class="c-section-header__title">
                <span class="en">SHOWROOM</span>
                <span class="ja">店舗一覧</span>
              </h2>
            </header>

            <div class="c-section-inner">
              <h2 class="c-module-header">タブ切り替え / 店舗絞り込み</h2>
            </div>

            <div class="p-top-showroom-tab">
              <div class="p-top-showroom-tab__inner">
                <div class="p-top-showroom-tab__item is-active js-tab" data-area="area04">全エリア</div>
                <div class="p-top-showroom-tab__item js-tab" data-area="area01">港区エリア</div>
                <div class="p-top-showroom-tab__item js-tab" data-area="area02">渋谷区エリア</div>
                <div class="p-top-showroom-tab__item js-tab" data-area="area03">江東区エリア</div>
              </div>
            </div>

            <div class="c-section-inner">
              <div class="p-top-showroom-list">
                <div class="p-top-showroom-list__inner">
                  <section class="p-top-showroom-area is-active js-area" id="area04">
                    <h2 class="p-top-showroom-area__title">
                      <span class="area">全エリア</span>
                    </h2>

                    <div class="p-top-showroom-area__list">
                                            <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr01.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/01_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">青山店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都渋谷区青山0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr01.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                            <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr02.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/02_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">港店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都港区六本木0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr02.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                            <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr03.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/03_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">江東店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都江東区潮見0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr03.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                            <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr04.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/04_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">渋谷店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都渋谷区区0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr04.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                            <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr05.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/05_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">表参道店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都渋谷区0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr05.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                            <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr06.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/06_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">品川店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都港区品川0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr06.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                          </div>
                  </section>

                  <section class="p-top-showroom-area js-area" id="area01">
                    <h2 class="p-top-showroom-area__title">
                      <span class="area">港区エリア</span>
                    </h2>

                    <div class="p-top-showroom-area__list">
                                                                  <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr01.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/01_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">青山店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都渋谷区青山0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr01.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                                                                                                                                                                                                                                                        <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr06.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/06_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">品川店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都港区品川0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr06.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                                                </div>
                  </section>

                  <section class="p-top-showroom-area js-area" id="area02">
                    <h2 class="p-top-showroom-area__title">
                      <span class="area">渋谷区エリア</span>
                    </h2>

                    <ul class="p-top-showroom-area__list">
                                                                                                              <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr02.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/02_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">港店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都港区六本木0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr02.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                                                                                                                    <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr04.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/04_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">渋谷店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都渋谷区区0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr04.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                                                                        <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr05.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/05_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">表参道店</h3>
                            <p class="p-top-showroom-item__zip">〒000-0000</p>
                            <p class="p-top-showroom-item__address">東京都渋谷区0-0-0</p>
                            <p class="p-top-showroom-item__tel">TEL：0000-00-0000</p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr05.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                                                                                            </ul>
                  </section>

                  <section class="p-top-showroom-area js-area" id="area03">
                    <h2 class="p-top-showroom-area__title">
                      <span class="area">江東区エリア</span>
                    </h2>

                    <ul class="p-top-showroom-area__list">
                                                                                                                                                          <article class="p-top-showroom-item js-showroom-card">
                        <a href="{{ $url2 }}/home/sr03.html" class="p-top-showroom-item__target">
                          <div class="p-top-showroom-item__image">
                            <div class="p-top-showroom-item__picture" style="background-image: url('<?= $url2 ?>/home/img/sr/03_01.jpg');');"></div>
                          </div>

                          <div class="p-top-showroom-item__inner">
                            <h3 class="p-top-showroom-item__name">
                              江東店                            </h3>
                            <p class="p-top-showroom-item__zip">〒
                              000-0000                            </p>
                            <p class="p-top-showroom-item__address">
                              東京都江東区潮見0-0-0                            </p>
                            <p class="p-top-showroom-item__tel">TEL：
                              0000-00-0000                            </p>
                          </div>
                        </a>
                        <a href="{{ $url2 }}/home/sr03.html" class="p-top-showroom-item__button">店舗詳細へ</a>
                      </article>
                                                                                                                                                                                                    </ul>
                  </section>
                </div>
              </div>

              <script src="//maps.google.com/maps/api/js?key=AIzaSyA-vlnKGWxli0Qq9Mm_UMwF8qVs575u7Vc"></script>
              <script src="{{ $url2 }}/home/js/gmapOpen.js"></script>
              <script>
                var gmapArr = {
                  "01": {
                    "shop_cd": "01",
                    "shop_name": "拠点名",
                    "tel": "0000-000-000",
                    "fax": "0000-000-000",
                    "hours": "10:00~19:00",
                    "close": "毎週水曜日定休",
                    "lat": "35.658394",
                    "lng": "139.816623",
                    "zip": "135-0052",
                    "marker": "",
                    "mkrSz": "",
                    "mkrPos": "",
                    "mkrOf": "",
                    "target": "_self",
                    "sort": "0"
                  },
                  "02": {
                    "shop_cd": "02",
                    "shop_name": "拠点名",
                    "tel": "0000-000-000",
                    "fax": "0000-000-000",
                    "hours": "10:00~19:00",
                    "close": "毎週水曜日定休",
                    "lat": "35.664462",
                    "lng": "139.713059",
                    "zip": "107-0062",
                    "marker": "",
                    "mkrSz": "",
                    "mkrPos": "",
                    "mkrOf": "",
                    "target": "_self",
                    "sort": "0"
                  }
                };
                gmapOpen('js-gmap', gmapArr, 6);
              </script>
              <h2 class="c-module-header -top-space">Google Map</h2>
              <div id="js-gmap" class="p-top-gmap"></div>
              <a class="c-button is-default c-module-more-button" href="https://www.hondacars-yokohama.co.jp/home/showroom.html" target="_blank">エリア拡大実装版はこちら</a>
            </div>
          </div>
        </section>

        <section class="c-section-container _bottom-space">
          <div class="c-section-inner">
            <h2 class="c-module-header -top-space">休店日カレンダー</h2>
            <div id="js-calendar" class="c-calendar">
              <div class="c-calendar-box">
                <div class="c-calendar-box__head">
                  <p class="c-calendar-box__month">
                    <span class="cal_year"></span>
                    <span class="cal_month"></span>
                  </p>
                </div>

                <div class="c-calendar-box__body">
                  <div id="cal0" class="calWrap"></div>
                </div>
              </div>

              <div class="c-calendar-box">
                <div class="c-calendar-box__head">
                  <p class="c-calendar-box__month">
                    <span class="cal_year"></span>
                    <span class="cal_month"></span>
                  </p>
                </div>

                <div class="c-calendar-box__body">
                  <div id="cal1" class="calWrap"></div>
                </div>
              </div>

              <div class="c-calendar-box__legend">
                <p class="c-calendar-hours">営業時間 10：00 ～ 19:00</p>

                <ul class="c-calendar-box__note">
                  <li>:全店休店日</li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <section class="c-section-container _both-space _bg-white">
          <header class="c-section-header">
            <h2 class="c-section-header__title">
              <span class="en">NEWS</span>
              <span class="ja">最新のお知らせ</span>
            </h2>
          </header>

          <div class="c-section-inner">
            <h2 class="c-module-header">Honda Cars 共通 最新情報リスト</h2>
                        <div class="p-top-topics-list">
              <!-- Topics start -->
                            <article class="p-top-topics-item _campaign">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="{{ $url }}/home/campaign.html">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">シャトル残クレ実質年率1.9％キャンペーン実施中</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _car">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="https://www.hondanet.co.jp/jump/20freed.html" target="_blank">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">NEW FREED COMING THIS AUTUMN</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _car">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="https://www.hondanet.co.jp/jump/19nwgn.html" target="_blank">
                  <h3 class="p-top-topics-item__head">2019.08.09</h3>
                  <p class="p-top-topics-item__text">あなたの毎日に、うれしい時間を届けたい。新しいN-WGN発売。</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _campaign">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="{{ $url }}/home/campaign.html">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">フリードご成約かつご登録いただいた方にHonda純正ナビ購入クーポン5万円分プレゼント！</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _campaign">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="{{ $url }}/home/campaign.html">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">フィット残クレ実質年率1.9％キャンペーン実施中</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _car">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="https://www.hondanet.co.jp/jump/shuttle.html" target="_blank">
                  <h3 class="p-top-topics-item__head">2019.05.10</h3>
                  <p class="p-top-topics-item__text">たいせつを知る人の。New SHUTTLE</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _campaign">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="{{ $url }}/home/campaign.html">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">フィットご成約かつご登録でHonda純正ナビプレゼント！</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _campaign">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="{{ $url }}/home/campaign.html">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">ヴェゼルご成約でHonda純正ナビ購入クーポン10万円分をプレゼント！ </p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _campaign">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="{{ $url }}/home/campaign.html">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">ステップ ワゴンご成約でHonda純正ナビ購入クーポン15万円分をプレゼント！</p>
                  </a>
                </div>
              </article>
                            <article class="p-top-topics-item _other">
                <div class="p-top-topics-item__inner">
                  <a class="topics-link" href="http://www.hondacars-saitamakita.co.jp/home/jump/reservation.html" target="_blank">
                  <h3 class="p-top-topics-item__head">お知らせ</h3>
                  <p class="p-top-topics-item__text">メンテナンス予約、始めました！</p>
                  </a>
                </div>
              </article>
                            <!-- Topics end -->
            </div>
          </div>
        </section>
      </div>
    </main>
    <footer class="l-footer">
  <div id="js-coupon-container" class="c-coupon-container">
    <div class="c-coupon">
      <div class="c-coupon-image"><img src="{{ $url2 }}/home/img/service.png" alt="" /></div>
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
</script>  <script src="{{ $url2 }}/home/js/anime.min.js"></script>
  <script src="{{ $url2 }}/home/js/slick.min.js"></script>
  <script src="{{ $url2 }}/home/js/index.js"></script>
  <script src="{{ $url2 }}/home/js/swiper.min.js"></script>
  <script>
  /* 営業日表示設定
  =============================== */
  var date = "09月04日(水)";
  $('#js-today').text(date);

  bus_init({
    'target': '#js-business-day',
    'rank': ['calDaysClass', 'calXDaysClass', 'calWeeksClass', 'calMonthsClass'],
    'default': '<p class="p-top-business-day__text">本日は営業日です。<span class="p-top-business-day__hours">営業時間  10:00-19:00</span></p>',
    'message': [
              ['^cal_close01','<p class="p-top-business-day__text">本日は休店日です。<span class="p-top-business-day__hours">営業時間  10:00-19:00</span></p>'],
              ['^cal_noClose','<p class="p-top-business-day__text">本日は営業日です。<span class="p-top-business-day__hours">営業時間  10:00-19:00</span></p>'],
            ]  });

  var showroomArea = $('.js-area');
	var showroomAreaTab = $('.js-tab');
	var showroomCard = $('.js-showroom-card');

	showroomAreaTab.on('click', function(){
		showroomAreaTab.removeClass('is-active');
		$(this).addClass('is-active');

		var showroomAreaType = $(this).data('area');

		showroomArea.each(function(){
			if( $(this).attr('id') === showroomAreaType ){
        $(this).addClass('is-active');
			}else{
        $(this).removeClass('is-active');
      }
    });
  });
  </script>
</body>
</html>