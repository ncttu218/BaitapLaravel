<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
		
        {{-- メニューのタイトル部分 --}}
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                <span class="sr-only"></span>
            </button>            
            <a class="navbar-brand" href="{{ url_auto('top/index') }}">
                <font size = "3">
                情報掲示板
                <?php
                $hansha = Config('original.hansha_code')[ $loginAccountObj->gethanshaCode() ];
                ?>
                {{ $hansha }}
                </font size>
            </a>
        </div>

        {{-- ログイン情報を表示 --}}
        <div class="collapse navbar-collapse" id="navbar-collapse-01">
            {{-- システム毎のメニュー部分の呼び出し --}}
            @if($loginAccountObj->getAccountLevel() == 1)
                {{-- 管理者権限のみマスター情報表示 --}} 
                @include('master._nav')
            @endif
            {{-- ログイン情報 --}}
            <div class="navbar-right">
                <p class="navbar-text">                  
                {{ $loginAccountObj->getUserName() }}
                </p>
                <button type="button" onClick="location.href='{{ url_auto('auth/logout') }}'" class="btn btn-default navbar-btn btn-sm">ログアウト</button>
            </div>
        </div>
    </div>
</nav>
