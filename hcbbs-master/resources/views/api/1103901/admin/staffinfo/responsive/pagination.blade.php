<?php
// ページ数算出
$currentPage = $list->currentPage();
$lastPage = $list->lastPage();
$page_end = $currentPage;
$page_span = '0 - 0 / 0件';

$perPage = $list->perPage();
$currentPage = $list->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $list->count();
$totalPage = $list->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

if($list->total() > 0){
    $page_end = $currentPage + 10;
    if($page_end > $lastPage){
        $page_end = $lastPage;
    }
    $countList = count($list);
    $page_span = "{$list->firstItem()} - {$list->lastItem()}件目";
}

// パラメーター
$allows = ['shop'];
$params = [];
foreach ($allows as $key) {
    $params[$key] = $_GET[$key] ?? '';
}
$paramsStr = '';
if (count($params) > 0) {
    $paramsStr = '&' . http_build_query($params);
}
?>

<div class="staffListPager">
    {{ $list->total() }}件中 <span>{{ $page_span }}</span> を表示中
    
    @if ($currentPage > 1)
        <a href="?{{ $list->getPageName() }}={{ $prevPage . $paramsStr }}">前の{{ $perPage }}件</a>
        @if ($currentPage < $totalPage && $ending < $totalPage)
            {{ '｜' }}
        @endif
    @endif
    
    @if ($currentPage < $totalPage && $ending < $totalPage)
        <a href="?{{ $list->getPageName() }}={{ $nextPage . $paramsStr }}">次の{{ $perPage }}件</a>
    @endif
</div>