<?php
// 販社名の設定パラメータを取得
$para_list = ( config('original.para')[$hanshaCode] );

if( empty( $shopExclusion ) ){
  $shopExclusion = ['99'];
}
// 店舗除外
$categoryCounterOptions = [ 'shopExclusion' => $shopExclusion ];
?>

{{-- 設定ファイルのカテゴリー機能NOのとき --}}
@if( isset( $para_list['category'] ) && $para_list['category'] !== '' )
  <?php
  // カテゴリーの配列を取得
  $categoryList = explode( ",", $para_list['category'] );
  sort($categoryList);
  ?>

  <div align="left">
      <a href="?shop={{ $shopCode }}&category=">全て({{ $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode, '', $categoryCounterOptions ) }})</a>&nbsp;
    
    {{-- カテゴリー一覧を表示するループ --}}
    @foreach ( $categoryList as $category )
      <?php
      $count = $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode, $category, $categoryCounterOptions );
      if (!isset($count) || $count == 0 ) {
          continue;
      }
      ?>
      <a href="?shop={{ $shopCode }}&category={{ $category }}">
        {{ $category }}({{  ( isset( $count ) ) ? $count: 0 }})
      </a>&nbsp;
    @endforeach
  </div>

@endif
