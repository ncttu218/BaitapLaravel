<?php
$perPage = $blogs->perPage();
$currentPage = $blogs->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $blogs->count();
$totalPage = $blogs->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;
$category = "";
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

// 最後のページ数
if ($ending + $perPage > $totalPage) {
    $nextPerPage = $totalPage - $ending;
} else {
    $nextPerPage = $perPage;
}
?>
<div class="blog__paging">
    {{ $totalPage }}件中 {{ $beginning }} - {{ $ending }}件表示 {!! '&nbsp;|&nbsp;' !!}
        @if ($currentPage > 1)
            <a href="?{{ $blogs->getPageName() }}={{ $prevPage . $paramsStr }}">前の{{ $perPage }}件</a>
        @endif
        @if ($currentPage < $totalPage && $ending < $totalPage)
            @if ($currentPage > 1)
                {!! '&nbsp;|&nbsp;' !!}
            @endif
            <a href="?{{ $blogs->getPageName() }}={{ $nextPage . $paramsStr }}">次の{{ $nextPerPage }}件</a>
        @endif
</div>