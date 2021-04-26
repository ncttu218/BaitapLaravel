<?php
$perPage = $blogs->perPage();
$currentPage = $blogs->currentPage();
$beginning = (($currentPage - 1) * $perPage) + 1;
$ending = (($currentPage - 1) * $perPage) + $blogs->count();
$totalPage = $blogs->total();
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;
?>
<div class="infobbs_page">{{ $totalPage }}件中
    <font color="#FF0000">{{ $beginning }} - {{ $ending }}件目</font> を表示中
    
    @if ($currentPage > 1)
        <font style="font-size :12px; lineheight :12px;">
            <a href="?{{ $blogs->getPageName() }}={{ $prevPage }}&shop={{ $shopCode }}">前の{{ $perPage }}件</a>
        </font>
    @endif
    
    @if ($currentPage < $totalPage && $ending < $totalPage)
        @if ($currentPage > 1)
            {{ ' | ' }}
        @endif
        <font style="font-size :12px; lineheight :12px;">
            <a href="?{{ $blogs->getPageName() }}={{ $nextPage }}&shop={{ $shopCode }}">次の{{ $perPage }}件</a>
        </font>
    @endif
</div>