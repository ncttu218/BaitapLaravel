<?php
$perPage = $blogs->perPage();
$currentPage = $blogs->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $blogs->count();
$totalPage = $blogs->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

// 最後のページ数
if ($ending + $perPage > $totalPage) {
    $nextPerPage = $totalPage - $ending;
} else {
    $nextPerPage = $perPage;
}
?>
<div class="infobbs_page">
    {{ $totalPage }}件中 <font color="#FF0000">{{ $beginning }} - {{ $ending }}件目</font> を表示中
    <font style="font-size :12px; lineheight :12px;">
        @if ($currentPage > 1)
            <a href="?{{ $blogs->getPageName() }}={{ $prevPage }}">前の{{ $perPage }}件</a>
        @endif
        @if ($currentPage < $totalPage && $ending < $totalPage)
            @if ($currentPage > 1)
                {{ '|' }}
            @endif
            <a href="?{{ $blogs->getPageName() }}={{ $nextPage }}">次の{{ $nextPerPage }}件</a>
        @endif
    </font>
</div>