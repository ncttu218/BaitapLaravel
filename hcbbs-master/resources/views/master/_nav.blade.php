<ul class="nav navbar-nav">
    {{-- 管理者, 六三権限の時に表示 --}}
    <li><a href="{{ url_auto( 'other/account/search' ) }}" {!! Request::is( 'other/account/*' ) ? 'style="color: #ee8"' : '' !!}>アカウント管理</a></li>

    <li><a href="{{ url_auto( 'other/base/search' ) }}" {!! Request::is( 'other/base/*' ) ? 'style="color: #ee8"' : '' !!}>拠点管理</a></li>
</ul>
