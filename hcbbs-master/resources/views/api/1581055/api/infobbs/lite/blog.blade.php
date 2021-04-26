<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<article>
    <div class="blog__header">
        {{-- タイトル --}}
        <p class="blog__title">
            <span>【{{ $item->base_name }}】</span>
            {{ $item->title }}
        </p>
        {{-- 掲載日時 --}}
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
    {{-- 本文 --}}
    <div class="blog__body">
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
        @if( !empty( $imgFiles ) == True )
        <div>
            <font> 
            {{-- 定形画像の数分繰り返す --}}
            @for( $i=1; $i<= 3; $i++ )
            @if( !empty( $imgFiles[$i]['file'] ) == True )
            <?php
            // ファイルパスの情報を取得する
            $fileinfo = pathinfo( $imgFiles[$i]['file'] );
            ?>
            <br>
            <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
            {{-- PDFファイルの対応 --}}
            @if( strtolower( $fileinfo['extension'] ) === "pdf" )
                <img src="{{ $CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
            @else
                <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
            @endif
            </a>
            {{-- 画像の説明文が存在するとき --}}
            @if( !empty( $imgFiles[$i]['caption'] ) == True )
            <p>{{ $imgFiles[$i]['caption'] }}</p>
            @endif
            @endif
            @endfor
            </font> 
        </div>
        @endif

        {{-- 設定ファイルのコメント機能NOのとき --}}
        @if( $para_list['comment'] === '1' )
        <tr>
            <td>
            <table width="100%">
                <tr>
                <td align="left" valign="middle">
                    <div class="hakusyu font10">
                    この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 
                    </div>
            
                    {{-- 感想の一覧にデータが存在するとき --}}
                    <?php
                    $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
                    ?>
                    @if( !$commentList->isEmpty() )
                       @foreach ( $commentList as $commentValue )
                         @if (empty($commentValue->mark))
                             @continue
                         @endif
                         <div class="hakusyu">
                             <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" style="width: 26px !important;">{{ $commentValue->comment_count }}
                         </div>
                       @endforeach
                    @endif

                    <div class="hakusyu font10">
                    <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
                    </div>
                </td>
                </tr>
            </table>
            </td>
        </tr>
        @endif

    </div>
</article>
@endforeach

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
