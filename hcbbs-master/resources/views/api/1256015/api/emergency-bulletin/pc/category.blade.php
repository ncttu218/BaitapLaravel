<?php
// 販社名の設定パラメータを取得
$para_list = ( config('original.para')[$hanshaCode] );
?>

{{-- 設定ファイルのカテゴリー機能NOのとき --}}
@if( isset( $para_list['category'] ) && $para_list['category'] !== '' )
  <?php
  // カテゴリーの配列を取得
  $categoryList = explode( ",", $para_list['category'] );
  sort($categoryList);
  ?>

  <div align="left">
  </div>

@endif
