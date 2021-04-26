@foreach ( $staffs as $row )
<?php
// サムネール画像
if (!empty($row->photo)) {
    $imageUrl = asset_auto($row->photo);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}

// スタッフ番号
$number = substr($row->number, 4);
// スタッフブログURL
$url = "st_diary.html?:{$number}&shop={$shopCode}";
?>
<li class="list-cmm-staff__item">
<a href="{{ $url }}" class="list-cmm-staff__link">
 <div class="list-cmm-staff__image">
  <img src="{{ $imageUrl }}" alt="{{ $row->name }}">
  <div class="list-cmm-staff__detail">
   <p class="list-cmm-staff__name">{{ $row->name }}</p>
   <!--<p class="list-cmm-staff__date">2020/01/09</p>-->
  </div>
 </div>
</a>
</li>
@endforeach