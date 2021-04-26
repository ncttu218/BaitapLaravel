<?php
// ページ数算出
$currentPage = $blogs->currentPage();
$lastPage = $blogs->lastPage();
$page_end = $currentPage;
$totalData = $blogs->total();
$beginning = $blogs->firstItem();
$ending = $blogs->lastItem();
$perPage = $blogs->perPage();
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
<div align=right>
    {{ $totalData }}件中
    <font color="#FF0000">
    {{ $beginning }} - {{ $ending }}件目
    </font>を表示中
    @if ($totalData > $perPage)
    <font style="font-size :12px; lineheight :12px;">
        @if ($currentPage > 1)
            <a href="?{{ $blogs->getPageName() }}={{ $prevPage . $paramsStr }}">前の{{ $perPage }}件</a>
        @endif
        @if ($currentPage < $totalData && $ending < $totalData)
            @if ($currentPage > 1)
                {{ '｜' }}
            @endif
            <a href="?{{ $blogs->getPageName() }}={{ $nextPage . $paramsStr }}">次の{{ $perPage }}件</a>
        @endif
    </font>
    @endif
</div>
