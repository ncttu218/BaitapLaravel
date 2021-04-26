<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
		
	{{-- メニューのタイトル部分 --}}
	<div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                <span class="sr-only"></span>
            </button>  
            <a class="navbar-brand">
            {{ $loginAccountObj->getUserName() }}
            </a>
	</div>

        {{-- ログイン情報を表示 --}}
        <div class="collapse navbar-collapse" id="navbar-collapse-01">
            {{-- システム毎のメニュー部分の呼び出し --}}
<!--            @include('master._nav')-->
			
            {{-- ログイン情報 --}}
            <div class="navbar-right">
                <p class="navbar-text">各店情報掲示板</p>
            </div>
	</div>
    </div>
</nav>
