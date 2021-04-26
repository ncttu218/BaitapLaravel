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
?>

<div class="blog__paging">
    <?php
    echo "{$totalPage}件中　{$beginning} - {$ending}件表示";
    echo '　｜　';
    if ($currentPage > 1) {
        echo '<a href="?' . $blogs->getPageName() . '=' . $prevPage . $paramsStr . '">前の' . $perPage . '件</a>';
        echo ' | ';
    }
    if ($currentPage < $totalPage && $ending < $totalPage) {
        echo '<a href="?' . $blogs->getPageName() . '=' . $nextPage . $paramsStr . '">次の' . $perPage . '件</a>';
    }
    ?>
</div>
