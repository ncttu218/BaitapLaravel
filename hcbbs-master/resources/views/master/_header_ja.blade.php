<header class="l-header">
    <div class="l-header__inner">
        <div class="l-header__container">
            <h1 class="l-header-main">
                <?php
                $code = $loginAccountObj->gethanshaCode();
                $hansha = Config('original.hansha_code')[$code];
                // v2を使うか
                if ($CodeUtil::isV2($code)) {
                    // v2のTOP
                    $urlTop = url_auto('v2/admin/' . $code . '/top');
                } else {
                    // v2じゃないTOP
                    $urlTop = url_auto('top/index');
                }
                ?>
                <a href="{{ $urlTop }}" style="color: #ffffff; text-decoration: none;">
                    <span class="l-header-main__name">{{ $hansha }} 管理画面</span>
                </a>
                <span class="l-header-main__code">販社コード：{{ $code }}</span>
            </h1>
            <div class="admin-menu">
                {{-- システム管理者権限の時 --}}
                @if($loginAccountObj->getAccountLevel() == 1)

                    <a href="{{ url_auto( 'other/account/search' ) }}">アカウント管理</a>
                    
                    <a href="{{ url_auto( 'other/base/search' ) }}">拠点管理</a>

                    <a href="{{ url_auto( 'other/blog_edit/index' ) }}">記事データ修正</a>

                    <a href="{{ url_auto( 'other/email_settings/index' ) }}">投稿アドレス</a>
                @endif
                <a href="{{ url_auto('auth/logout') }}" class="button">ログアウト</a>
            </div>
        </div>
    </div>
</header>
