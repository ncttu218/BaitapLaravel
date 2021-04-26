<?php
// ページ数算出
$currentPage = $blogs->currentPage();
$lastPage = $blogs->lastPage();
$page_end = $currentPage;
$page_span = '0 - 0 / 0件';

if($blogs->total() > 0){
    $page_end = $currentPage + 10;
    if($page_end > $lastPage){
        $page_end = $lastPage;
    }
    $page_span = "{$blogs->firstItem()} - {$blogs->lastItem()} / {$blogs->total()}件";
}

$before = $currentPage - 1;
$before_hid = '';
if($before <= 0){
    $before_hid = ' style="display:none;';
}

$next = $currentPage + 1;
$next_hid = '';
if($next > $lastPage){
    $next_hid = ' style="display:none;';
}
?>

<div class="p-entrylist-navigation">
    <div class="p-entrylist-pager">
        <div class="p-entrylist-pager__item"<?php echo $before_hid;?>>
            <a href="{{ $blogs->url($before) }}" class="p-entrylist-pager__prev">前</a>
        </div>
        <?php
        for ($p = $currentPage; $p <= $page_end; $p++){
            $current = '';
            if ($p == $currentPage){
                $current = '_current';
            }
            ?>
            <div class="p-entrylist-pager__item">
                <a href="{{ $blogs->url($p) }}" class="p-entrylist-pager__button <?php echo $current;?>"><?php echo $p;?></a>
            </div>
        <?php } ?>
        <div class="p-entrylist-pager__item"<?php echo $next_hid;?>>
            <a href="{{ $blogs->url($next) }}" class="p-entrylist-pager__next">次</a>
        </div>
    </div>
    <div class="p-entrylist-count"><?php echo $page_span;?></div>
</div>
<!-- /.p-entrylist-navigation -->
