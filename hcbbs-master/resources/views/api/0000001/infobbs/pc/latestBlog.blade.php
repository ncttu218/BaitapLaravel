@foreach ($blogs as $i => $item)
  <?php
  $contentStr = $item->comment;

  /**
   * サムネイル画像
   */

  // 定形画像 3枚アップロードする画像があるとき

  $image = asset_auto('img/no_image.gif');
  // 3枚アップロードするがぞうがあるとき
  if( !empty( $item->file1 ) == True ){
    // ファイルパスの情報を取得する
    $fileinfo1 = pathinfo( $item->file1 );
    // PDFファイルの場合
    if( strtolower( $fileinfo1['extension'] ) === "pdf" ){
        $image = \App\Original\Util\CodeUtil::getPdfThumbnail( $item->file1 );
    }else{
        $image = url_auto( $item->file1 );
    }
  }else if( !empty( $item->file2 ) == True ){
    // ファイルパスの情報を取得する
    $fileinfo2 = pathinfo( $item->file2 );
    // PDFファイルの場合
    if( strtolower( $fileinfo2['extension'] ) === "pdf" ){
        $image = \App\Original\Util\CodeUtil::getPdfThumbnail( $item->file2 );
    }else{
        $image = url_auto( $item->file2 );
    }
  }else if( !empty( $item->file3 ) == True ){
    // ファイルパスの情報を取得する
    $fileinfo2 = pathinfo( $item->file3 );
    // PDFファイルの場合
    if( strtolower( $fileinfo2['extension'] ) === "pdf" ){
        $image = \App\Original\Util\CodeUtil::getPdfThumbnail( $item->file3 );
    }else{
        $image = url_auto( $item->file3 );
    }

  // 3枚画像が無いときは、本文の画像を参照
  }else if(preg_match( '/<img.*?src=[\"\']([^\"\']+?)[\"\']/', $contentStr, $match ) ) {
    $image = $match[1];
  }

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
  
  // 拠点ブログのURL
  $blogUrl = "home/sr{$item->shop}.html#blog";

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
      $newMark = ' _new';
  }
  ?>
  <article class="p-top-blog-article{{ $newMark }} swiper-slide">
    {{-- ショールームページへのリンク先 --}}
    <a href="{{ $blogUrl }}" class="p-top-blog-article__target">
      {{-- サムネイル画像 --}}
      <div class="p-top-blog-article__picture">
        <div class="p-top-blog-article__image" style="background-image: url('{{ $image }}');"></div>
      </div>
      <div class="p-top-blog-article__inner">
        <h3 class="p-top-blog-article__title">{{ $item->title }}</h3>
        <p class="p-top-blog-article__text">{{ $content }}</p>
      </div>

      <div class="p-top-blog-article__info">
        <h4 class="p-top-blog-article__shop">{{ $item->base_name }}</h4>
        <time class="p-top-blog-article__date">{{ date('Y.m.d', $time) }}</time>
      </div>
    </a>
  </article>
@endforeach
