<?php
// 記事番号
$number = str_replace('data', '', $item->number);
// 共有URL
$url = "http%3A%2F%2Fwww.hondanet.co.jp%2Fhondacars-fukushima%2Fhome%2Fblog.html?:{$number}";
// タイトル
$title = urlencode($item->title);
?>
<div class="infobbs_shareBox">
    <ul>
    <li>
        <a href="https://plus.google.com/share?url={{ $url }}">
            <img src="img/icon_share_googleplus.jpg" alt="Google＋" class="/cgi/shareIcon">
        </a>
    </li>
    <li>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank">
            <img src="img/icon_share_facebook.jpg" alt="facebook" class="/cgi/shareIcon">
        </a>
    </li>
    <li>
        <a href="https://twitter.com/share?url={{ $url }}&amp;text={{ $title }}">
            <img src="img/icon_share_twitter.jpg" alt="Twitter" class="/cgi/shareIcon">
        </a>
    </li>
    <li>
        <a href="http://line.me/R/msg/text/?{{ $title }}%20{{ $url }}">
            <img src="img/icon_share_line.jpg" alt="LINE" class="/cgi/shareIcon">
        </a>
    </li>
    </ul>
</div>
