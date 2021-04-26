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
   * 店舗のサムネイル画像
   */
  /*$shopImage = 'home/img/';
  $shopImage .= isset($exclusions[$item->shop]) ? $exclusions[$item->shop] :
      "sr/{$item->shop}_01.jpg";*/

  /**
   * 本文の表示
   */
  // コンテンツの概要
  $content = '無し';
  $contentStr = strip_tags($contentStr);
  // 本文から指定文字列分のみ抜き出す
  $limit = 50;
  $str_length = mb_strlen($contentStr);
  $contentStr = mb_substr($contentStr, 0, $limit, 'utf-8');
  if ($str_length > 0) {
      $content = trim($contentStr) . "...";
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
    $blogImage = asset_auto('img/no_image.gif');
    if (!empty($item->comment)) {
        /**
         * サムネイル画像
         */
        // 3枚アップロードするがぞうがあるとき
        $isFromFile = false;
        if( !empty( $item->file1 ) == True ){
          $blogImage = url_auto( $item->file1 );
          $blogImage = $checkFileUrl($blogImage);
          if ($blogImage !== false) {
              $isFromFile = true;
          }
        }else if( !empty( $item->file2 ) == True ){
          $blogImage = url_auto( $item->file2 );
          $blogImage = $checkFileUrl($blogImage);
          if ($blogImage !== false) {
              $isFromFile = true;
          }
        }else if( !empty( $item->file3 ) == True ){
          $blogImage = url_auto( $item->file3 );
          $blogImage = $checkFileUrl($blogImage);
          if ($blogImage !== false) {
              $isFromFile = true;
          }
        }

        // 3枚画像が無いときは、本文の画像を参照
        if (!$isFromFile &&  preg_match('/<img.*?src=[\"\']([^\"\']+?)[\"\']/', $item->comment, $match)) {
            $blogImage = $match[1];
        }
    }
  
  /**
   * タイトルの表示
   */
  $title = trim($item->title);
  if (!empty($title)) {
    $limit = 15;
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
  //$newFlg = $isNewBlog( $item->updated_at );
  if( !empty( $item->from_date ) ) {
      $time = strtotime( $item->from_date );
      //$newFlg = $isNewBlog( $item->from_date );
  }

  /**
   * 新着マークの表示
   */
  /*$newMark = '';
  if ( $newFlg ) {
      $newMark = ' is-new';
  }*/
  ?>

    <li class="p-index-blog-box">
        <a class="p-index-blog-box__link" href="{{ $blogUrl }}">
            <div class="p-index-blog-box__image">
                <figure style="background-image:url({{ $blogImage }})"></figure>
            </div>
            <div class="p-index-blog-box__head">
                <h4 class="p-index-blog-box__title">{{ $title }}</h4>
            </div>
            <div class="p-index-blog-box__body">
                <p class="p-index-blog-box__intro">{{ $content }}</p>
            </div>
            <div class="p-index-blog-box__foot">
                <p class="p-index-blog-box__author">{{ $item->base_name }}</p>
                <p class="p-index-blog-box__date">{{ date('Y.m.d', $time) }}</p>
            </div>
        </a>
    </li>
@endforeach
