<?php
$perPage = $blogs->perPage();
$currentPage = $blogs->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $blogs->count();
$totalPage = $blogs->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

// パラメーター
$number = $_GET['staff'] ?? '';
?>

<div class="blog__paging">{{ $totalPage }}件中　{{ $beginning }} - {{ $ending }}件表示
    {{ '　｜　' }}
    @if ($currentPage > 1)
        <a href="?:{{ $number }}&{{ $blogs->getPageName() }}={{ $prevPage }}&shop={{ $shopCode }}">次の日記</a>
    @endif
    @if ($currentPage < $totalPage && $ending < $totalPage)
        @if ($currentPage > 1)
            {{ '｜' }}
        @endif
        <a href="?:{{ $number }}&{{ $blogs->getPageName() }}={{ $nextPage }}&shop={{ $shopCode }}">以前の日記</a>
    @endif
</div>
