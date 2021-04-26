<?php
// ショールーム以外リスト
/*$exclusions = array(
    '99' => 'img_top-blog-honsha.jpg',
    'a1' => 'img_top-blog-insurance.jpg',
    'as' => 'img_top-blog-ashimo.jpg',
    'nr' => 'img_top-blog-honsha.jpg',
);*/
?>
@foreach ($blogs as $i => $item)
<?php
$contentStr = $item->comment;

/**
 * サムネイル画像
 */
/*$image = 'home/img/';
$image .= isset($exclusions[$item->shop]) ? $exclusions[$item->shop] :
        "sr/{$item->shop}_01.jpg";*/

/**
 * 本文の表示
 */
// コンテンツの概要
/*$content = '無し';
$contentStr = strip_tags($contentStr);
// 本文から指定文字列分のみ抜き出す
$limit = 50;
$str_length = mb_strlen($contentStr);
$contentStr = mb_substr($contentStr, 0, $limit, 'utf-8');
if ($str_length > 0) {
    $content = trim($contentStr) . "...";
}*/

// 拠点ブログのURL
/*$blogUrl = !isset($exclusions[$item->shop]) ? "home/sr{$item->shop}.html" :
        "home/blog.html?shop={$item->shop}";*/
$urls = [
    'nr' => '/motor/',
];
$blogUrl = $urls[$item->shop] ?? '#';

// 日付
$time = strtotime($item->updated_at);
//$newFlg = $isNewBlog($item->updated_at);
if (!empty($item->from_date)) {
    $time = strtotime($item->from_date);
    //$newFlg = $isNewBlog($item->from_date);
}

/**
 * 新着マークの表示
 */
/*$newMark = '';
if ($newFlg) {
    $newMark = ' is-new';
}*/
?>
<div class="p-top-blog-article">
    <a class="blog-link" href="{{ $blogUrl }}" target="_blank">
        <div class="p-top-blog-article__inner">
            <div class="p-top-blog-article__category">{{ date('Y.m.d', $time) }}</div>
            <div class="p-top-blog-article__description">{{ $item->title }}</div>
        </div>
    </a>
</div>
@endforeach
