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

// 記事のタイトル・概要・サムネール
$content = '無し';
$image = asset_auto('img/no_image.gif');
if ($item['blog'] !== null) {
    $contentStr = $item['blog']->comment;

    /**
     * サムネイル画像
     */

    // 3枚アップロードするがぞうがあるとき
    if( !empty( $item['blog']->file1 ) == True ){
      $image = url_auto( $item['blog']->file1 );
    }else if( !empty( $item['blog']->file2 ) == True ){
      $image = url_auto( $item['blog']->file2 );
    }else if( !empty( $item['blog']->file3 ) == True ){
      $image = url_auto( $item['blog']->file3 );

    // 3枚画像が無いときは、本文の画像を参照
    }else if (preg_match('/<img.*?src=[\"\']([^\"\']+?)[\"\']/', $contentStr, $match)) {
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

// 拠点ブログのURL
$blogUrl = "home/sr{$item['shop_code']}.html#blog";
?>
<article class="p-top-blog-article">
<div class="p-top-blog-ranking-num"><span>{{ $item['ranking'] }}</span>{{ $suffix }}</div>
<a href="{{ $blogUrl }}" class="p-top-blog-article__target">
  <div class="p-top-blog-article__picture">
    <div class="p-top-blog-article__image" style="background-image: url('{{ $image }}');"></div>
  </div>
  <div class="p-top-blog-article__inner">
    <h3 class="p-top-blog-article__title">{{ $item['blog'] !== null ? $item['blog']->title : '無し' }}</h3>
    <p class="p-top-blog-article__text">{{ $content }}</p>
  </div>

  <div class="p-top-blog-article__info">
    <h4 class="p-top-blog-article__shop">{{ $item['shop_name'] }}</h4>
    <time class="p-top-blog-article__date">{{ $item['blog'] !== null ? date('Y.m.d', $time) : '無し' }}</time>
  </div>
</a>
</article>
@endforeach
