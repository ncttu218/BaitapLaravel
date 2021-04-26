@foreach ($ranking as $i => $item)
<?php
// ランキング番号の英語文字
$suffix = 'th';
$number = $item['ranking'] . '';
$lastDigit = $number[strlen($number) - 1];
if ($lastDigit == '1' && $number != '11') {
    $suffix = 'st';
} else if ($lastDigit == '2' && $number != '12') {
    $suffix = 'nd';
} else if ($lastDigit == '3' && $number != '13') {
    $suffix = 'rd';
}

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
if ($item['blog'] !== null) {
    $contentStr = $item['blog']->comment;

    /**
     * サムネイル画像
     */

    // 3枚アップロードするがぞうがあるとき
    $isFromFile = false;
    if( !empty( $item['blog']->file1 ) == True ){
      $image = url_auto( $item['blog']->file1 );
      $image = $checkFileUrl($image);
      if ($image !== false) {
          $isFromFile = true;
      }
    }else if( !empty( $item['blog']->file2 ) == True ){
      $image = url_auto( $item['blog']->file2 );
      $image = $checkFileUrl($image);
      if ($image !== false) {
          $isFromFile = true;
      }
    }else if( !empty( $item['blog']->file3 ) == True ){
      $image = url_auto( $item['blog']->file3 );
      $image = $checkFileUrl($image);
      if ($image !== false) {
          $isFromFile = true;
      }
    }

    // 3枚画像が無いときは、本文の画像を参照
    if (!$isFromFile &&  preg_match('/<img.*?src=[\"\']([^\"\']+?)[\"\']/', $contentStr, $match)) {
        $image = $match[1];
    }
    $contentStr = strip_tags($contentStr);
    $limit = 50;
    $str_length = mb_strlen($contentStr);
    $contentStr = mb_substr($contentStr, 0, $limit, 'utf-8');
    if ($str_length > 0) {
        $content = trim($contentStr);
    }
    // 日付
    $time = strtotime($item['blog']->updated_at);
    if (!empty($item['blog']->from_date)) {
        $time = strtotime($item['blog']->from_date);
    }
}

/**
 * タイトルの表示
 */
$title = 'No Title';
if ($item['blog'] !== null) {
    $title = trim($item['blog']->title);
    if (!empty($title)) {
        $limit = 10;
        $str_length = mb_strlen($title);
        if ($str_length > $limit) {
            $title = mb_substr($title, 0, $limit, 'utf-8');
            $title = trim($title) . "...";
        }
    }
}

// ショールーム以外リスト
$exclusions = array('99', 'a1', 'as', 'nr');
// 拠点ブログのURL
$blogUrl = !in_array($item['blog']->shop, $exclusions) ? "home/sr{$item['blog']->shop}.html" :
          "home/blog.html?shop={$item['blog']->shop}";
?>
<a class="p-topBlogRankingArticle" href="home/sr{{ $item['blog']->shop }}.html">
    <figure class="p-topBlogRankingArticle__fig"><img src="{{ $image }}"></figure>
    <div class="p-topBlogRankingArticle__inner">
        <p class="p-topBlogRankingArticle__shop">{{ $item['shop_name'] }}</p>
        <h3 class="p-topBlogRankingArticle__title">{{ $title }}</h3>
        <time class="p-topBlogRankingArticle__time">{{ $item['blog'] !== null ? date('Y.m.d', $time) : '無し' }}</time>
    </div>
</a>
@endforeach