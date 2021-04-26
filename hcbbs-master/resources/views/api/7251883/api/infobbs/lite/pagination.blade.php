<?php
$perPage = $blogs->perPage();
$currentPage = $blogs->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $blogs->count();
$totalPage = $blogs->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

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
<div class="blog__paging">{{ $totalPage }}件中　{{ $beginning }} - {{ $ending }}件表示
    {{ '　｜　' }}
    @if ($currentPage > 1)
        <a href="?{{ $blogs->getPageName() }}={{ $prevPage . $paramsStr }}">前の{{ $perPage }}件</a>
    @endif
    @if ($currentPage > 1 && $currentPage < $totalPage && $ending < $totalPage)
        {{ '｜' }}
    @endif
    @if ($currentPage < $totalPage && $ending < $totalPage)
        <a href="?{{ $blogs->getPageName() }}={{ $nextPage . $paramsStr }}">次の{{ $perPage }}件</a>
    @endif
</div>
