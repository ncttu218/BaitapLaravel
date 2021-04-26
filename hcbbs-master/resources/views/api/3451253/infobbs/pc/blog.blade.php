{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
// 画像リンクのチェック
$checkFileUrl = function( $url ) {
    $pattern = '/((?:http|\/\/).+?\.(?:[jJ][pP][eE][gG]|[jJ][pP][gG]|[pP][nN][gG]|[gG][iI][fF]|[bB][mM][pP])).*?$/';
    if (!preg_match($pattern, $url)) {
        return false;
    }
    $url = preg_replace_callback($pattern, function( $match ) {
        return $match[1];
    }, $url);
    return $url;
};

// 記事のタイトル・概要・サムネール
$content = '無し';
$image = asset_auto('img/no_image.gif');
if (isset($item->comment)) {
    $contentStr = $item->comment;

    /**
     * サムネイル画像
     */

    // 3枚アップロードするがぞうがあるとき
    $isFromFile = false;
    if( !empty( $item->file1 ) == True ){
      $image = url_auto( $item->file1 );
      $image = $checkFileUrl($image);
      if ($image !== false) {
          $isFromFile = true;
      }
    }else if( !empty( $item->file2 ) == True ){
      $image = url_auto( $item->file2 );
      $image = $checkFileUrl($image);
      if ($image !== false) {
          $isFromFile = true;
      }
    }else if( !empty( $item->file3 ) == True ){
      $image = url_auto( $item->file3 );
      $image = $checkFileUrl($image);
      if ($image !== false) {
          $isFromFile = true;
      }
    }

    // 3枚画像が無いときは、本文の画像を参照
    if (!$isFromFile &&  preg_match('/<img.*?src=[\"\']([^\"\']+?)[\"\']/', $contentStr, $match)) {
        $image = $match[1];
    }

    // 画像のパスを置換する。
    $image = str_replace( "img.hondanet.co.jp", "image.hondanet.co.jp", $image );
    
    $contentStr = strip_tags($contentStr);
    $limit = 78;
    $str_length = mb_strlen($contentStr);
    if ($str_length > $limit) {
        $contentStr = mb_substr($contentStr, 0, $limit, 'utf-8');
        $content = trim($contentStr) . '. . .';
    }
    // 日付
    $time = strtotime($item->updated_at);
    if (!empty($item->from_date)) {
        $time = strtotime($item->from_date);
    }
}

// 拠点ブログのURL
$number = preg_replace('/^data([0-9]+)$/', '$1', $item->number);
$blogUrl = "176_blog.html?shop={$item->shop}&num={$number}";

// 日付
$time = strtotime( $item->updated_at );
$newFlg = $isNewBlog( $item->updated_at );
if( !empty( $item->from_date ) ) {
    $time = strtotime( $item->from_date );
    $newFlg = $isNewBlog( $item->from_date );
}

/**
 * 新着マークの表示
 */
$newMark = '';
if ( $newFlg ) {
   $newMark = '<p class="srblog_new">NEW</p>';
}
?>

  <article class="srblog_box wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
    <a href="{{ $blogUrl }}">
      <div class="srblog_data">
        <div class="srblog_detail">
            {{-- タイトル --}}
            <p class="srblog_title">{{ $item->title }}</p>
            <p class="srblog_day">
              <?php
              $time = strtotime($item->updated_at);
              if (!empty($item->from_date)) {
                  $time = strtotime($item->from_date);
              }
              ?>
              {{ date('Y/m/d', $time) }}
            </p>
            {!! $newMark !!}
          </div><!-- /.srblog_detail -->
        <div class="srblog_text">{{ $content }} </div>
      </div><!-- /.srblog_data -->
        <figure>
            <img src="{{ $image }}" class="photo">
            <p><img src="img/bt_readmore_txt.png" alt="続きを読む"></p>
        </figure>
      </a>
  </article><!-- /.srblog_box -->
@endforeach

