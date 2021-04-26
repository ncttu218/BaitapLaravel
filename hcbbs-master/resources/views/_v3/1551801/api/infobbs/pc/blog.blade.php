<script language="JavaScript" src="/common-js/opendcs.js"></script>

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
      $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
      $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
      ?>
      @if ($hasNoBr)
        {!! nl2br( $item->comment ) !!}
      @else
        {!! $item->comment !!}
      @endif
      
      <div>
        <font style="font-size:10px;">   
        </font> 
      </div>
      <div style="clear:both;">
        <table>
           <tbody>
              <tr>
                 <td align="left" valign="middle">
                    <div class="hakusyu font10">
                       <p></p>
                    </div>
                 </td>
              </tr>
           </tbody>
        </table>
        <!-- ここからいいねボタン -->
        <div class="blog-like-counter">
           <a href="/common-php/likes.php?like={{ $hanshaCode }}/infobbs&amp;number={{ $item->number }}" target="likes">
               <input class="blog-like-counter__img" 
                      src="/common-img/img_blog-like.gif" 
                      onmouseover="this.src='/common-img/img_blog-like_on.gif'" 
                      onmouseout="this.src='/common-img/img_blog-like.gif'" 
                      type="image">
           </a>
           <div class="blog-like-counter__balloon">いいね!<br><span id="likes_count_{{ $item->number }}">0</span>件</div>
        </div>
        <div style="clear:both;"></div>
        <!-- ここまでいいねボタン -->
      </div>

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
    </div>
  </article>
@endforeach

{{-- ページネーション --}}
@include($templateDir . '.pagination')
