{{-- ブログデータが存在するとき --}}
@if( !empty( $blog ) )
  <article>
    <div class="blog__header">
      {{-- タイトル --}}
      <p class="blog__title"><span>【{{ $shopName }}】</span>{{ $blog->title }}</p>

      {{-- 掲載日時 --}}
      <p class="blog__date">
        <?php
        $time = strtotime($blog->updated_at);
        if (!empty($blog->from_date)) {
            $time = strtotime($blog->from_date);
        }
        ?>
        {{ date('Y/m/d', $time) }}
      </p>
    </div>
    {{-- 本文 --}}
    <div class="blog__body">
      <?php
        // 記事が改行が必要かの判定
        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $blog->comment);
        ?>
        @if ($hasNoBr)
          {!! nl2br( $blog->comment ) !!}
        @else
          {!! $blog->comment !!}
       @endif

      <?php
      $imgFiles = [];

      // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
      for( $i=1; $i<= 3; $i++ ){
        $imgFiles[$i]['file'] = $blog->{'file' . $i};
        $imgFiles[$i]['caption'] = $blog->{'caption' . $i};
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
    </div>

    <?php
    // 販社名の設定パラメータを取得
    $para_list = ( Config('original.para')[$hanshaCode] );
    ?>

    {{-- トップメニューの設定ファイルに、対象販社の設定情報があるとき --}}
    @if( $para_list['comment'] === '1' )

      <table style="width: 100%; margin-bottom: 5px;">
        <tr>
          <td align="right" valign="middle">
            <div class="hakusyu font10" style="text-align: right;">
              <p></p>
              この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $blog->number  ) }}件 
            </div>

            {{-- 感想の一覧を取得 --}}
            <?php
            $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $blog->number );
            
            ?>
            {{-- 感想の一覧にデータが存在するとき --}}
            @if( !$commentList->isEmpty() )
            <div class="hakusyu font10" style="text-align: right;">
                @foreach ( $commentList as $commentValue )
                  <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
                @endforeach
              </div>
            @endif
            
            <div class="hakusyu font10" style="text-align: right;">
              <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $blog->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
            </div>
          </td>
        </tr>
      </table>
    @endif
  </article>
@else
  ブログが投稿されていません。
@endif
