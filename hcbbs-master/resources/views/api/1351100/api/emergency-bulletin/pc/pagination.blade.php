<?php
$perPage = $showData->perPage();
$currentPage = $showData->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $showData->count();
$totalPage = $showData->total();
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
    @if ($totalPage > $perPage)
        {{ '　｜　' }}
        @if ($currentPage > 1)
            <a href="?{{ $showData->getPageName() }}={{ $prevPage . $paramsStr }}">前の{{ $perPage }}件</a>
        @endif
        @if ($currentPage < $totalPage)
            @if ($currentPage > 1)
                {{ '｜' }}
            @endif
            <a href="?{{ $showData->getPageName() }}={{ $nextPage . $paramsStr }}">次の{{ $perPage }}件</a>
        @endif
    @endif
</div>
