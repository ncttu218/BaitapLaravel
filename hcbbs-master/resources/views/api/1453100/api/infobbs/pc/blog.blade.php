<?php
// 販社名の設定パラメータを取得
$para_list = (Config('original.para')[$hanshaCode]);
?>

{{-- 拠点検索ボックス --}}
<div class="c-blog__control" id="js-blog-control">
    <form action="?&SortField=DATE" method="get" style="margin:0em;">
        <span style="font-size :10px; lineheight :10px;">お近くのお店を選んで「検索」ボタンをクリックして下さい</span>
        <?php
        // ログイン販社の拠点一覧を取得する
        $shopList = App\Models\Base::getShopOptions($hanshaCode, true);
        ?>
        {{-- 拠点選択プルダウンの表示 --}}
        <select name="shop" id="AutoSelect_27">
            <option value=""></option>
            <option value="">全店</option>
            @foreach( $shopList as $base_code => $base_name )
                <?php $selected = $base_code == $shopCode ? 'selected' : '' ?>
                <option value="{{ $base_code }}" {{ $selected }}>{{ $base_name }}</option>
            @endforeach
        </select> 
        <input type=submit value="検索">
    </form>
</div>

<table class="c-blog__inner">
    <tbody>
        <tr>
            <td id="js-blog">
                <script language="JavaScript" src="/common-js/opendcs.js"></script>
                <link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
                <link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">

                {{-- 設定ファイルのカテゴリー機能NOのとき --}}
                @if( isset( $para_list['category'] ) && $para_list['category'] !== '' )
                    <?php
                    // カテゴリーの配列を取得
                    $categoryList = explode(",", $para_list['category']);
                    ?>
                    <div align="left">
                        <a href="?category=">全て({{ $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode ) }})</a>&nbsp;

                        {{-- カテゴリー一覧を表示するループ --}}
                        @foreach ( $categoryList as $category )
                            <?php
                            $count = $CodeUtil::getBlogTotalSum($hanshaCode, $shopCode, $category);
                            ?>
                            <a href="?shop={{ $shopCode }}&category={{ $category }}">
                                {{ $category }}({{  ( isset( $count ) )? $count: 0 }})
                            </a>&nbsp;
                        @endforeach
                    </div>
                @endif

                {{-- ページネーションの読み込み --}}
                @include($templateDir . '.pagination')

                {{-- 記事データが存在するとき --}}
                @foreach ($blogs as $item)
                    <article>
                        <div class="blog__header">
                            <p class="blog__title"><span>【{{ $item->base_name }}】</span>{{ $item->title }}</p>
                            <p class="blog__date">
                                <?php
                                $time = strtotime($item->updated_at);
                                if (!empty($item->from_date)) {
                                    $time = strtotime($item->from_date);
                                }
                                ?>
                                {{ date('Y/m/d', $time) }}
                            </p>
                        </div>
                        <div class="blog__body">
                            <div>
                                <?php
                                // 記事が改行が必要かの判定
                                $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                                ?>
                                @if ($hasNoBr)
                                    {!! nl2br( $item->comment ) !!}
                                @else
                                    {!! $item->comment !!}
                                @endif
                                <?php
                                $imgFiles = [];
                                // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
                                for ($i = 1; $i <= 3; $i++) {
                                    $imgFiles[$i]['file'] = $item->{'file' . $i};
                                    $imgFiles[$i]['caption'] = $item->{'caption' . $i};
                                }
                                ?>
                                {{-- 定形画像が入力されていれば、画面に出力する。 --}}
                                @if( !empty( $imgFiles ) == true )
                                    <div>
                                        {{-- 定形画像の数分繰り返す --}}
                                        @for( $i=1; $i<= 3; $i++ )
                                            @if( !empty( $imgFiles[$i]['file'] ) == true )
                                                <?php
                                                // ファイルパスの情報を取得する
                                                $fileinfo = pathinfo( $imgFiles[$i]['file'] );
                                                ?>
                                                <br>
                                                <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}" target="_blank">
                                                    {{-- PDFファイルの対応 --}}
                                                    @if( strtolower( $fileinfo['extension'] ) === "pdf" )
                                                        <img src="{{ $CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
                                                    @else
                                                        <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
                                                    @endif
                                                </a>
                                                {{-- 画像の説明文が存在するとき --}}
                                                @if( !empty( $imgFiles[$i]['caption'] ) == true )
                                                    <p>{{ $imgFiles[$i]['caption'] }}</p>
                                                @endif
                                            @endif
                                        @endfor
                                    </div>
                                @endif
                            </div>

                            {{-- 設定ファイルのコメント機能NOのとき --}}
                            @if( $para_list['comment'] === '1' )
                                <div style="clear:both;">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td align="left" valign="middle">
                                                <div class="hakusyu font10">
                                                    この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件
                                                </div>

                                                {{-- 感想の一覧を取得 --}}
                                                <?php
                                                $commentList = $CodeUtil::getBlogCommentCountList($hanshaCode, $item->number);
                                                ?>
                                                {{-- 感想の一覧にデータが存在するとき --}}
                                                @if( !$commentList->isEmpty() )
                                                    @foreach ( $commentList as $commentValue )
                                                        <div class="hakusyu">
                                                            <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div class="hakusyu font10">
                                                    <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">
                                                        感想を送る
                                                    </button>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach

                {{-- ページネーションの読み込み --}}
                @include($templateDir . '.pagination')
            </td>
        </tr>
    </tbody>
</table>
