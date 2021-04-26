<?php
$perPage = $blogs->perPage();
$currentPage = $blogs->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $blogs->count();
$totalPage = $blogs->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

// パラメーター
$allows = ['category', 'shop'];
$params = [];
foreach ($allows as $key) {
    $params[$key] = $_GET[$key] ?? '';
}
$paramsStr = '';
if (count($params) > 0) {
    $paramsStr = '&' . http_build_query($params);
}

$maxNumber = 10;
$endNumber = $maxNumber;
$x = $currentPage;
while(true) {
    if ($x % $maxNumber == 0) {
        $endNumber = $x;
        break;
    }
    $x++;
}
$lastPage = $blogs->lastPage();
$beginNumber = $endNumber - $maxNumber + 1;
if ($endNumber > $lastPage) {
    $endNumber = $lastPage;
}
?>

<div class="blog-pager">
    @if ($currentPage > 1)
        <a class="blog-pager-arrow _prev" href="?{{ $blogs->getPageName() }}={{ $prevPage . $paramsStr }}#blog"></a>
    @else
        <a class="blog-pager-arrow _prev is-disabled" href="#"></a>
    @endif
    <ul class="blog-pager-number">
    @for ($i = $beginNumber;$i <= $endNumber; $i++)
        <li>
            <a href="?{{ $blogs->getPageName() }}={{ $i . $paramsStr }}#blog"{{ $currentPage == $i ? ' class=is-current' : '' }}>{{ $i }}</a>
        </li>
    @endfor
    </ul>
    @if ($currentPage < $totalPage && $ending < $totalPage)
        <a class="blog-pager-arrow _next" href="?{{ $blogs->getPageName() }}={{ $nextPage . $paramsStr }}#blog"></a>
    @else
        <a class="blog-pager-arrow _next is-disabled" href="#"></a>
    @endif
</div>