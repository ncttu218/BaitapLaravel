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

// 最後のページ数
if ($ending + $perPage > $totalPage) {
    $nextPerPage = $totalPage - $ending;
} else {
    $nextPerPage = $perPage;
}
?>
<p class="showroomPageLink">
    {{ $totalPage }}件中 <span>{{ $beginning }} - {{ $ending }}件目</span> を表示中 
    <?php
    if ($currentPage > 1) {
        echo '<a href="?' . $blogs->getPageName() . '=' . $prevPage . $paramsStr . '">前の' . $perPage . '件</a>';
    }
    if ($currentPage < $totalPage && $ending < $totalPage) {
        if ($currentPage > 1) {
            echo '｜';
        }
        echo '<a href="?' . $blogs->getPageName() . '=' . $nextPage . $paramsStr . '">次の' . $nextPerPage . '件</a>';
    }
    ?>
</a>

