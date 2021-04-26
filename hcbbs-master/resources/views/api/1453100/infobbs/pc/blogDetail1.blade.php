<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

<section class="blog">
  <h2 class="borderOrange">
      <p>
          {{ $blog->title }}
          <span>
              <?php
              $time = strtotime($blog->updated_at);
              if (!empty($blog->from_date)) {
                  $time = strtotime($blog->from_date);
              }
              ?>
              {{ date('Y/m/d', $time) }}
          </span>
      </p>
  </h2>
  <div class="section_inner">
      <article class="blog_box">
          {!! $blog->comment !!}
          <figure>
          <ul class="photo">
          </ul>
          </figure>
        </article>
    </div><!-- /.section_inner -->

</section>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td nowrap class="infobbs_title02">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            {{-- タイトル --}}
            <td>
              <div class="font_black" align="left">[{{ $blog->base_name }}]&nbsp;{{ $blog->title }}</div>
            </td>

            {{-- 掲載日時 --}}
            <td>
              <div class="font_black font10" align="right">
                <?php
                $time = strtotime($blog->updated_at);
                if (!empty($blog->from_date)) {
                    $time = strtotime($blog->from_date);
                }
                ?>
                {{ date('Y/m/d', $time) }}
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="infobbs_article">
    {{-- 本文 --}}
    <tr> 
      <td valign="top" bgcolor="#FFFFFF" align="left"><font size="2">
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
                  <br>
                  <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
                    <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
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
      </td>
    </tr>

    {{-- 設定ファイルのコメント機能NOのとき --}}
    @if( $para_list['comment'] === '1' )
      <tr>
        <td>
          <table width="100%">
            <tr>
               <td>
                <?php
                  $blogUrl = "";
                  if( !empty( Config('original.sr_link_para')[$hanshaCode]['pc'][$blog->shop] ) ){
                     // ショールーム以外リスト
                     $sr_link = ( Config('original.sr_link_para')[$hanshaCode]['pc'][$blog->shop] );

                     // 拠点ブログのURL
                     $number = preg_replace('/^data([0-9]+)$/', '$1', $blog->number);
                     $blogUrl = "168_info_{$sr_link}.html?num={$number}";
                  }
                  ?>
                  <div class="fb-like" data-href="http://www.sekisho-honda.com/hondacars-ibarakinishi/home/{{ $blogUrl }}" data-send="false" data-width="450" data-show-faces="true"></div>
               </td>
               <td align="left" valign="middle">
                <div class="hakusyu font10">
                  この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $blog->number  ) }}件 
                </div>

                <div class="hakusyu font10">
                  <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $blog->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    @endif
  </table>