@foreach ($ranking as $i => $item)
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

$dataRankId = $i < 3 ? ' data-id=rank0' . ($i + 1) : '';

$urlReplacements = ['00' => 'HO', '99' => 'VS', '98' => 'SS', '02' => '01',
    '03' => '02', '04' => '03', '73' => '04'];
$shopId = $urlReplacements[$item['blog']->shop] ?? $item['blog']->shop;
?>
<article class="p-top-blog-art{{ $i < 3 ? '__rank' : '' }}"{{ $dataRankId }}>
    <a href="/home/sr{{ $shopId }}.html" class="p-top-blog-art__target">
        <div class="p-top-blog-art-frame">
            <div class="p-top-blog-art-frame__img" style="background-image: url({{ $image }})"></div>
        </div>
        <div class="p-top-blog-art-box">
            <div class="p-top-blog-art-box__head">
                <h2 class="p-top-blog-art-box__shop">{{ $item['shop_name'] }}</h2>
            </div>
            <div class="p-top-blog-art-box__body">
                <time class="p-top-blog-art-box__date">{{ $item['blog'] !== null ? date('Y/m/d', $time) : '無し' }}</time>
                <h3 class="p-top-blog-art-box__title">{{ $convertEmojiToHtmlEntity($title) }}</h3>
                <p class="p-top-blog-art-box__text">{{ $content }}</p>
                <span>more</span>
            </div>
        </div>
    </a>
</article>
@endforeach