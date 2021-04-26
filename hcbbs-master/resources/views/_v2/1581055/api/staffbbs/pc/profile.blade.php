<?php
// サムネール画像
if (!empty($staff->photo2)) {
    $imageUrl = asset_auto($staff->photo2);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}
?>

{{-- 写真 --}}
<div class="staff_container_prof">
   <img src="{{ $imageUrl }}">
   <p>{{ $staff->position }}</p>
</div>

{{-- プロフィール --}}
<div class="staff_container_data">
   <dl>
      <dt>
         <span>ふりがな</span>氏名
      </dt>
      <dd>
         <span>{{ $staff->name_furi }}</span>
         {{ $staff->name }}
      </dd>
   </dl>
   <dl>
      <dt>勤務地</dt>
      <dd>{{ $shopName }}</dd>
   </dl>
   @if (!empty($staff->qualification))
   <dl>
      <dt>資　格</dt>
      <dd>{!! nl2br($staff->qualification) !!}</dd>
   </dl>
   @endif
   @if (!empty($staff->hobby))
   <dl>
      <dt>趣　味</dt>
      <dd>{!! nl2br($staff->hobby) !!}</dd>
   </dl>
   @endif
   @foreach ($staff->extra as $key => $value)
   <dl>
      <dt>{{ $key }}</dt>
      <dd>{!! nl2br($value) !!}</dd>
   </dl>
   @endforeach
</div>

{{-- メッセージ --}}
<div class="staff_container_message">
   <dl>
      <dt>メッセージ</dt>
      <dd>{!! nl2br($staff->message) !!}</dd>
   </dl>
</div>

<img src="//cgi2-aws.hondanet.co.jp/cgi/plog.cgi?id=tmp1581055/staff&amp;number=data019307" width="1" height="1">