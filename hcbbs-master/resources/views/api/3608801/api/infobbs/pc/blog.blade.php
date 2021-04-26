<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type='text/css'>
<link rel="stylesheet" href="/common-css/cgi_common.css" type='text/css'>

<a name="0"></a>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
<br clear="all">

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// タイトルの文字変換
$item->title = $convertEmojiToHtmlEntity($item->title);
// 本文の文字変換
$item->comment = $convertEmojiToHtmlEntity($item->comment);
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td nowrap class="infobbs_title02">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            {{-- タイトル --}}
            <td>
              <div class="font_black" align="left">[{{ $item->base_name }}]&nbsp;{{ $item->title }}</div>
            </td>

            {{-- 掲載日時 --}}
            <td>
              <div class="font_black font10" align="right">
                <?php
                $time = strtotime($item->updated_at);
                if (!empty($item->from_date)) {
                    $time = strtotime($item->from_date);
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
        $releaseDate = strtotime('2020-05-22');
        $createdDate = strtotime($item->created_at);
        if ($createdDate <= $releaseDate) {
            $pattern = '/(<p[^>]+?><span[^>]+?>)[\r\n]+?(<\/span>)/';
            $item->comment = preg_replace_callback($pattern, function ($match) {
                return $match[1] . '<br>' . $match[2];
            }, $item->comment);
            $pattern = '/(<p[^>]+?>)[\r\n]+?(<p.+?>)/';
            $item->comment = preg_replace_callback($pattern, function ($match) {
                return $match[1] . '<br>' . $match[2];
            }, $item->comment);
            $pattern = '/([\r\n]+?<\/span>)([\r\n]+[\r\n]+?)(<p.+?>)/';
            $item->comment = preg_replace_callback($pattern, function ($match) {
                return $match[1] . nl2br($match[2]) . $match[3];
            }, $item->comment);
            
            echo $item->comment;
            echo '<br>';
            echo '<br>';
        } else {
            echo $item->comment;
        }
        ?>
          
        <div class="infobbs_inquiry">
            <br>
            @if (!empty($item->form_addr))
            <a href="{{ $item->form_addr }}" target="_blank">{{ $item->inquiry_inscription }}</a>
            @endif
        </div>
          
        <?php
        $imgFiles = [];
        // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
        for( $i=1; $i<= 3; $i++ ){
          $imgFiles[$i]['file'] = $item->{'file' . $i};
          $caption = $item->{'caption' . $i};
          $caption = $convertEmojiToHtmlEntity($caption);
          $imgFiles[$i]['caption'] = $caption;
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
                      <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="200" border=0  f7>
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
      </td>
    </tr>

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
                  
                {{-- 感想の一覧を取得 --}}
                <?php
                $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
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
                  <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    @endif
  </table>

@endforeach

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
