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
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">

        {{-- メニューのタイトル部分 --}}
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                <span class="sr-only"></span>
            </button>            
            <a class="navbar-brand" href="{{ $urlTop }}">
                <font size = "3">
                情報掲示板
                {{ $hansha }}
                </font size>
            </a>
        </div>

        {{-- ログイン情報を表示 --}}
        <div class="collapse navbar-collapse" id="navbar-collapse-01">
            {{-- システム毎のメニュー部分の呼び出し --}}
            @if($loginAccountObj->getAccountLevel() <= 2)
            <ul class="nav navbar-nav">
                {{-- 管理者, 六三権限の時に表示 --}}
                @if($loginAccountObj->getAccountLevel() == 1)
                <li><a href="{{ url_auto( 'other/account/search' ) }}" {!! Request::is( 'other/account/*' ) ? 'style="color: #ee8"' : '' !!}>アカウント管理</a></li>
                
                <li><a href="{{ url_auto( 'other/base/search' ) }}" {!! Request::is( 'other/base/*' ) ? 'style="color: #ee8"' : '' !!}>拠点管理</a></li>

                <li><a href="{{ url_auto( 'other/blog_edit/index' ) }}" {!! Request::is( 'other/blog_edit/*' ) ? 'style="color: #ee8"' : '' !!}>記事データ修正</a></li>

                <li><a href="{{ url_auto( 'other/email_settings/index' ) }}" {!! Request::is( 'other/email_settings/*' ) ? 'style="color: #ee8"' : '' !!}>投稿アドレス</a></li>
                @endif
            </ul>
            @endif
            {{-- ログイン情報 --}}
            <div class="navbar-right">
                <p class="navbar-text">
                    {{ $loginAccountObj->getUserName() }}
                </p>
                <button type="button" onClick="location.href ='{{ url_auto('auth/logout') }}'" class="btn btn-default navbar-btn btn-sm">ログアウト</button>
            </div>
        </div>
    </div>
</nav>
