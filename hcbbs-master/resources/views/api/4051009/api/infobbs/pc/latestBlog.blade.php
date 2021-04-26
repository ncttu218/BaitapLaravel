<?php
// ショールーム以外リスト
$exclusions = array(
  '99' => 'img_top-blog-honsha.jpg',
  'a1' => 'img_top-blog-insurance.jpg',
  'as' => 'img_top-blog-ashimo.jpg',
  'nr' => 'img_top-blog-honsha.jpg',
);
?>
@foreach ($blogs as $i => $item)
  <?php
  $contentStr = $item->comment;

  /**
   * サムネイル画像
   */
  $image = 'home/img/';
  $image .= isset($exclusions[$item->shop]) ? $exclusions[$item->shop] :
      "sr/{$item->shop}_01.jpg";

  /**
   * 本文の表示
   */
  // コンテンツの概要
  /*$content = '無し';
  $contentStr = strip_tags($contentStr);
  // 本文から指定文字列分のみ抜き出す
  $limit = 50;
  $str_length = mb_strlen($contentStr);
  $contentStr = mb_substr($contentStr, 0, $limit, 'utf-8');
  if ($str_length > 0) {
      $content = trim($contentStr) . "...";
  }*/
  
  /**
   * タイトルの表示
   */
  $title = trim($item->title);
  if (!empty($title)) {
    $limit = 10;
    $str_length = mb_strlen($title);
    if ($str_length > $limit) {
        $title = mb_substr($title, 0, $limit, 'utf-8');
        $title = trim($title) . "...";
    }
  } else {
      $title = 'No Title';
  }
  
  // 拠点ブログのURL
  $blogUrl = !isset($exclusions[$item->shop]) ? "home/sr{$item->shop}.html" :
          "home/blog.html?shop={$item->shop}";

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
      $newMark = ' is-new';
  }
  ?>
  <a class="p-topBlogArticle{{ $newMark }}" href="{{ $blogUrl }}">
    <figure class="p-topBlogArticle__fig"><img src="{{ $image }}"></figure>
    <div class="p-topBlogArticle__inner">
        <p class="p-topBlogArticle__shop">{{ $item->base_name }}</p>
        <h3 class="p-topBlogArticle__title">{{ $title }}</h3>
        <time class="p-topBlogArticle__time">{{ date('Y.m.d', $time) }}</time>
    </div>
  </a>
@endforeach
