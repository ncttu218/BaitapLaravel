<ul class="nav nav-tabs main-nav-tabs">
    {{-- 管理者権限の時のみ表示 --}}
    @if( $loginAccountObj->getRolePriority() == 1 )
    <li role="presentation" class="{!! Request::is('other/account/*') ? 'active' : '' !!}">
        <a href="{{ url_auto('other/account/search') }}"><i class="fa fa-list-alt"></i> アカウント</a>
    </li>
    @endif
</ul>
