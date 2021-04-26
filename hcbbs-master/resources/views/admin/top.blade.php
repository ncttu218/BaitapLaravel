{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

{{-- CSSの定義 --}}
@section('css')
@parent
@stop

{{-- JSの定義 --}}
@section('js')
@parent
<script type="text/javascript">
$(function() {
    toggleAttention($('.js-attention-toggle'));
});
</script>
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
@include('infobbs.attention')
<section class="c-section-container _both-space">
    <h2 class="c-section-title">オプション管理画面一覧</h2>
    
    <div class="p-index-menu">
        <?php
        // 販社名の設定パラメータを取得
        $hanshaCode = $loginAccountObj->gethanshaCode();
        $para_list = config('original.para')[$hanshaCode] ?? [];
        // 本社用のメニュ設定
        $honsyaMenuCfg = config('original.admin_honsya_menu_para');
        ?>

        {{-- 本社以上の権限で、トップメニューの設定ファイルに、対象販社の本社設定情報があるとき --}}
        @if( $account_level < 3 && isset( $honsyaMenuCfg[$hanshaCode] ) )
            <?php
            // 対象販社の設定情報を配列で取得
            $admin_menu_list = ( $honsyaMenuCfg[$hanshaCode] );
            // 設定情報から、メニューの表示タイプ検索用配列を生成
            $nameArray = array_column( $admin_menu_list, 'menu_type' );
            ?>

            {{-- 本社用管理画面が設定情報に含まれていないとき --}}
            @if( !in_array( 6, $nameArray ) )
                {{-- 本社用管理画面 --}}
                <div class="p-index-menu__item p-index-button">
                    <a class="p-index-button__target _color-4" href="{{ $urlActionHobbs }}" target="_blank">本社用管理画面</a>
                    {{-- 説明文があるとき --}}
                    @if( !empty( $value['description'] ) == True )
                        <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                    @else
                        <p class="p-index-button__description"></p>
                    @endif
                </div>
            @endif

            {{-- 設定情報の配列からメニューを生成し、表示するループ --}}
            @foreach( $admin_menu_list as $value )

                {{-- 店舗ブログの表示 --}}
                @if( $value['menu_type'] === 1 )
                    {{-- 店舗ブログ --}}
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target " href="{{ $urlActionInfobbs }}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @endif
                    </div>

                {{-- スタッフブログの表示 --}}
                @elseif( $para_list['staff'] === '1' && $value['menu_type'] === 2 )
                    {{-- スタッフブログ --}}
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target " href="{{ $urlActionInfobbsStaff }}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @else
                            <p class="p-index-button__description"></p>
                        @endif
                    </div>

                    {{-- 本社用管理画面の表示 --}}
                @elseif( $value['menu_type'] === 6 )
                    {{-- 本社用管理画面 --}}
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target _color-4" href="{{ $urlActionHobbs }}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @endif
                    </div>

                @else
                    <?php
                    // URLが空でないときに、取得
                    $menu_url = ( !empty( $value['menu_url'] ) == True ) ? $value['menu_url'] : "";
                    ?>
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target _color-4" href="{!! $menu_url !!}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @else
                            <p class="p-index-button__description"></p>
                        @endif
                    </div>

                @endif

            @endforeach

        {{-- トップメニューの設定ファイルに、対象販社の設定情報があるとき --}}
        @elseif( isset( config('original.admin_menu_para')[$hanshaCode] ) )
            <?php
            // 対象販社の設定情報を配列で取得
            $admin_menu_list = ( config('original.admin_menu_para')[$hanshaCode] );
            // 設定情報から、メニューの表示タイプ検索用配列を生成
            $nameArray = array_column( $admin_menu_list, 'menu_type' );
            ?>
            {{-- 店舗ブログが設定情報に含まれていないとき --}}
            @if( !in_array( 1, $nameArray ) )
                {{-- 店舗ブログ --}}
                <div class="p-index-menu__item p-index-button">
                    <a class="p-index-button__target " href="{{ $urlActionInfobbs }}" target="_blank">店舗ブログ</a>
                    {{-- 説明文があるとき --}}
                    @if( !empty( $value['description'] ) == True )
                        <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                    @endif
                </div>
            @endif

            {{-- スタッフブログが有の販社で、かつ、スタッフブログ・スタッフ紹介が設定情報に含まれていないとき --}}
            @if( $para_list['staff'] === '1' && !in_array( 2, $nameArray ) && !in_array( 3, $nameArray ) )
                {{-- スタッフブログ --}}
                <div class="p-index-menu__item p-index-button">
                    <a class="p-index-button__target " href="{{ $urlActionInfobbsStaff }}" target="_blank">スタッフブログ</a>
                    {{-- 説明文があるとき --}}
                    @if( !empty( $value['description'] ) == True )
                        <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                    @else
                        <p class="p-index-button__description"></p>
                    @endif
                </div>
            @endif

            {{-- 設定情報の配列からメニューを生成し、表示するループ --}}
            @foreach( $admin_menu_list as $value )
            
                <?php
                // 下限の権限
                if (isset($value['min_account_level']) &&
                    $account_level < $value['min_account_level']) {
                    continue;
                }
                // 上限の権限
                if (isset($value['max_account_level']) &&
                    $account_level > $value['max_account_level']) {
                    continue;
                }
                ?>

                {{-- 店舗ブログの表示 --}}
                @if( $value['menu_type'] === 1 )
                    {{-- 店舗ブログ --}}
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target " href="{{ $urlActionInfobbs }}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @endif
                    </div>

                {{-- スタッフブログの表示 --}}
                @elseif( $para_list['staff'] === '1' && $value['menu_type'] === 2 )
                    {{-- スタッフブログ --}}
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target " href="{{ $urlActionInfobbsStaff }}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @else
                            <p class="p-index-button__description"></p>
                        @endif
                    </div>

                {{-- スタッフ紹介の表示 --}}
                @elseif( $para_list['staff'] === '1' && $value['menu_type'] === 3 )
 
                    {{-- スタッフ紹介画面へのフォームの表示 --}}
                    <div class="p-index-menu__item p-index-select">
                        <div class="p-index-select__head">{{ $value['menu_name'] }}</div>
                        <div class="p-index-select__body">
                            {{-- フォームの表示 --}}
                            <form class="p-index-select__form" action="{{ url_auto( 'staffinfo/list' ) }}"" method="get" target="_blank">
                                <div class="p-index-select__input c-control-select">

                                    <?php
                                    // ログイン販社の拠点一覧を取得する
                                    $shopList = App\Models\Base::getShopOptions( $hanshaCode );
                                    ?>
                                    {{-- 拠点選択プルダウンの表示 --}}
                                    <select name="shop">
                                        @if( isset( $shopList ) )
                                            @foreach( $shopList as $base_code => $base_name )
                                                <option value="{{ $base_code }}">{{ $base_name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- 店舗がありません --</option>
                                        @endif
                                    </select>
                                </div>
                                <label class="p-index-select__button"><input type="submit" value="管理画面を表示">管理画面を表示</label>
                            </form>
                        </div>
                    </div>

                {{-- 拠点選択フォームの表示 --}}
                @elseif( $value['menu_type'] === 4 )
                    <?php
                    // URLが空でないときに、取得
                    $menu_url = ( !empty( $value['menu_url'] ) == True ) ? $value['menu_url'] : "";
                    ?>
                    {{-- 拠点選択フォームの表示 --}}
                    <div class="p-index-menu__item p-index-select">
                        <div class="p-index-select__head">{{ $value['menu_name'] }}</div>
                        <div class="p-index-select__body">
                            {{-- フォームの表示 --}}
                            <form class="p-index-select__form" action="{!! $menu_url !!}" method="{{ !empty( $value['method'] )? $value['method'] : 'post' }}" target="_blank">
                                <div class="p-index-select__input c-control-select">

                                    <?php
                                    // ログイン販社の拠点一覧を取得する
                                    $shopList = App\Models\Base::getShopOptions( $hanshaCode, false, 3 );
                                    ?>
                                    {{-- 拠点選択プルダウンの表示 --}}
                                    <select name="shop">
                                        @if( isset( $shopList ) )
                                            @foreach( $shopList as $base_code => $base_name )
                                                <option value="{{ $base_code }}">{{ $base_name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- 店舗がありません --</option>
                                        @endif
                                    </select>
                                </div>
                                <label class="p-index-select__button"><input type="submit" value="管理画面を表示">管理画面を表示</label>
                            </form>
                        </div>
                    </div>

                {{-- ショールーム情報の表示 --}}
                @elseif( $value['menu_type'] === 5 )
 
                    {{-- ショールーム情報画面へのフォームの表示 --}}
                    <div class="p-index-menu__item p-index-select">
                        <div class="p-index-select__head">{{ $value['menu_name'] }}</div>
                        <div class="p-index-select__body">
                            {{-- フォームの表示 --}}
                            <form class="p-index-select__form" action="{{ url_auto( 'srinfo/index' ) }}"" method="get" target="_blank">
                                <div class="p-index-select__input c-control-select">

                                    <?php
                                    // ログイン販社の拠点一覧を取得する
                                    $shopList = App\Models\Base::getShopOptions( $hanshaCode );
                                    ?>
                                    {{-- 拠点選択プルダウンの表示 --}}
                                    <select name="shop">
                                        @if( isset( $shopList ) )
                                            @foreach( $shopList as $base_code => $base_name )
                                                <option value="{{ $base_code }}">{{ $base_name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- 店舗がありません --</option>
                                        @endif
                                    </select>
                                </div>
                                <label class="p-index-select__button"><input type="submit" value="管理画面を表示">管理画面を表示</label>
                            </form>
                        </div>
                    </div>
                    
                @elseif ( $value['menu_type'] === 6 )
                    {{-- 本社用管理画面 --}}
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target _color-4" href="{{ $urlActionHobbs }}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @endif
                    </div>
                    
                @else
                    <?php
                    // URLが空でないときに、取得
                    $menu_url = ( !empty( $value['menu_url'] ) == True ) ? $value['menu_url'] : "";
                    // 自動的に置換されるURL
                    if (isset($value['menu_url_auto']) && !empty($value['menu_url_auto'])) {
                        $action = config('original.formatters.' . $value['menu_url_auto']) ?? '/';
                        $menu_url = action($action);
                    }
                    ?>
                    <div class="p-index-menu__item p-index-button">
                        <a class="p-index-button__target _color-4" href="{!! $menu_url !!}" target="_blank">{{ $value['menu_name'] }}</a>
                        {{-- 説明文があるとき --}}
                        @if( !empty( $value['description'] ) == True )
                            <p class="p-index-button__description">{!! nl2br( $value['description'] ) !!}</p>
                        @else
                            <p class="p-index-button__description"></p>
                        @endif
                    </div>

                @endif

            @endforeach
         
        @else
        
            {{-- 店舗ブログ --}}
            <div class="p-index-menu__item p-index-button">
                <a class="p-index-button__target " href="{{ $urlActionInfobbs }}" target="_blank">店舗ブログ</a>
                {{--
                <p class="p-index-button__description">
                    <a href="{{ $urlActionShopRankCount }}" target="_blank">情報掲示板のアクセス集計</a>
                </p>
                --}}
            </div>

            {{-- スタッフブログが有のとき --}}
            @if( $para_list['staff'] === '1' )

                {{-- スタッフブログ --}}
                <div class="p-index-menu__item p-index-button">
                    <a class="p-index-button__target " href="{{ $urlActionInfobbsStaff }}" target="_blank">スタッフブログ</a>
                    <p class="p-index-button__description"></p>
                </div>
            @endif
            
            {{-- 本社以上の時有効 --}}
            @if($account_level < 3)
                <div class="p-index-menu__item p-index-button">
                    <a class="p-index-button__target " href="{{ $urlActionHobbs }}" target="_blank">本社用管理画面</a>
                    <p class="p-index-button__description"></p>
                </div>
            @endif
            {{-- システムアカウント以上の時有効 --}}
            @if( $account_level < 2 )
                <div class="p-index-menu__item p-index-button">
                    <a class="p-index-button__target " href="{{ $urlActionViewbbs }}" target="_blank">各店情報掲示板の公開画面</a>
                    <p class="p-index-button__description"></p>
                </div>
            @endif
        @endif
    </div>
    
    <section class="c-section-container _both-space">
        <h2 class="c-section-title">操作マニュアル</h2>
        <p><a href="{{ asset_auto('pdf/dealer_admin_manual.pdf') }}" target="_blank">情報掲示板・スタッフブログ投稿編（PDF）<i class="fa fa-window-restore"></i></a></p>
    </section>
</section>
@stop
