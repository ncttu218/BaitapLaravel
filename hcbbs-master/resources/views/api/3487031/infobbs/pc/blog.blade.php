<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

<div class="p-sr-blog">
  <table>
    <tbody>
      <tr>
        <td>
          <style type="text/css">
            div.hakusyu{float:left;}
          </style>

          
          <div id="showroomBlogInfo">
            {{-- 設定ファイルのカテゴリー機能NOのとき --}}
            @if( isset( $para_list['category'] ) && $para_list['category'] !== '' )
              <?php
              // カテゴリーの配列を取得
              $categoryList = explode( ",", $para_list['category'] );
              ?>

              <ul>
                <li>
                  <a href="?category=">全て({{ $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode ) }})</a>
                </li>

                {{-- カテゴリー一覧を表示するループ --}}
                @foreach ( $categoryList as $category )
                  <?php
                  $count = $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode, $category );
                  ?>

                  <li>
                    <a href="?shop={{ $shopCode }}&category={{ $category }}">{{ $category }}({{  ( isset( $count ) )? $count: 0 }})</a>
                  </li>
                @endforeach

              </ul>
            @endif
            
            {{-- ページングの読み込み --}}
            @include($templateDir . '.pagination')
          </div><!-- #showroomBlogInfo -->

          {{-- 記事データが存在するとき --}}
          @foreach ($blogs as $item)

            <div class="showroomEntryBox">
              {{-- 店舗・タイトル --}}
              <h2>[{{ $item->base_name }}]&nbsp;{{ $item->title }}</h2>

              {{-- 掲載日時 --}}
              <p class="showroomEntryDate">
                <?php
                  $time = strtotime($item->updated_at);
                  if (!empty($item->from_date)) {
                      $time = strtotime($item->from_date);
                  }
                  ?>
                  {{ date('Y/m/d', $time) }}
              </p>

              {{-- 本文 --}}
              <div class="showroomEntryBody">
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
                for( $i=1; $i<= 3; $i++ ){
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

              </div><!-- #showroomEntryBody -->

              {{-- 設定ファイルのコメント機能NOのとき --}}
              @if( $para_list['comment'] === '1' )
                <ul>
                  <li></li>
                  <li></li>
                  <li>この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 </li>

                  {{-- 感想の一覧を取得 --}}
                  <?php
                  $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
                  ?>
                  {{-- 感想の一覧にデータが存在するとき --}}
                  @if( !$commentList->isEmpty() )
                    <li>
                      @foreach ( $commentList as $commentValue )
                        <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
                      @endforeach
                    </li>
                  @endif
                  
                  <li><a href="#" onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る感想を送る</a></li>
                </ul>

              @endif

            </div><!-- #showroomEntryBox -->

          @endforeach
          <!-- ZERO END -->
          {{-- ページングの読み込み --}}
          @include($templateDir . '.pagination')

        </td>
      </tr>
    </tbody>
  </table>
</div>

