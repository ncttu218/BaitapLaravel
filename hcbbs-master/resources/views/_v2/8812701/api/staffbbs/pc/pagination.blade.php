<?php
$perPage = $blogs->perPage();
$currentPage = $blogs->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $blogs->count();
$totalPage = $blogs->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

// パラメーター
$allows = ['staff'];
$params = [];
foreach ($allows as $key) {
    $params[$key] = $_GET[$key] ?? '';
}
$paramsStr = '';
if (count($params) > 0) {
    $paramsStr = '&' . http_build_query($params);
}
?>

<div align="right" class="font12">{{ $totalPage }}件中{{ $beginning }}-{{ $ending }}件を表示
    {{ '>>' }}
    @if ($currentPage == 1)
        @if ($currentPage < $totalPage && $ending < $totalPage)
            <a href="?{{ $blogs->getPageName() }}={{ $nextPage . $paramsStr }}">以前の日記</a>
        @endif
    @else
        @if ($currentPage > 1)
            <a href="?{{ $blogs->getPageName() }}={{ $prevPage . $paramsStr }}">次の日記</a>
        @endif
        @if ($currentPage < $totalPage && $ending < $totalPage)
            @if ($currentPage > 1)
                {{ '|' }}
            @endif
            <a href="?{{ $blogs->getPageName() }}={{ $nextPage . $paramsStr }}">以前の日記</a>
        @endif
    @endif
</div>
