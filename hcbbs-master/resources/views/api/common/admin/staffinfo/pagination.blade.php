<?php
// ページ数算出
$currentPage = $list->currentPage();
$lastPage = $list->lastPage();
$page_end = $currentPage;
$page_span = '0 - 0 / 0件';

if($list->total() > 0){
    $page_end = $currentPage + 10;
    if($page_end > $lastPage){
        $page_end = $lastPage;
    }
    $page_span = "{$list->firstItem()} - {$list->lastItem()} / {$list->total()}件";
}
?>
<div align="right">
    {{ count($list) }}件中
    <font color="#FF0000">
    {{ $page_span }}
    </font>を表示中
    <font style="font-size :12px; lineheight :12px;">
    </font>
</div>