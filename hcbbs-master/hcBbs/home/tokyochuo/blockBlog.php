<?php
$id="hc-tokyochuo";
$shop=$_GET['shop'];
$number=$_GET['number'];

//test server
//$url = "http://check-secure.hondanet.co.jp/hcBbs/plbbs?id={$id}&shop={$shop}&number=data{$number}";
//local
$url = "http://localhost/hcBbs/hcBbs/plbbs?id={$id}&shop={$shop}&number=data{$number}";

echo file_get_contents($url);
?>
