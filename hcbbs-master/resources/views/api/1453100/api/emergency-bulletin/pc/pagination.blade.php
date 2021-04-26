<?php
$perPage = $showData->perPage();
$currentPage = $showData->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $showData->count();
$totalPage = $showData->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

// パラメーター
//$allows = ['shop'];
//$params = [];
//foreach ($allows as $key) {
//    $params[$key] = $_GET[$key] ?? '';
//}
//$paramsStr = '';
//if (count($params) > 0) {
//    $paramsStr = '&' . http_build_query($params);
//}
?>

<div class="infobbs_page">
    {{ $totalPage }}件中　{{ $beginning }} - {{ $ending }}件目を表示中
    @if ($totalPage > $perPage)
        {{ '　｜　' }}
        @if ($currentPage > 1)
            <a href="?{{ $showData->getPageName() }}={{ $prevPage }}">前の{{ $perPage }}件</a>
        @endif
        @if ($currentPage < $totalPage)
            @if ($currentPage > 1)
                {{ '｜' }}
            @endif
            <a href="?{{ $showData->getPageName() }}={{ $nextPage }}">次の{{ $perPage }}件</a>
        @endif
    @endif
</div>
