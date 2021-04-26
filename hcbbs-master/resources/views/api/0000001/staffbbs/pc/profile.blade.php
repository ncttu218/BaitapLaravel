<?php
// サムネール画像
if (!empty($staff->photo)) {
    $imageUrl = asset_auto($staff->photo);
} else {
    $imageUrl = asset_auto('img/sozai/no_photo.jpg');
}
?>

<div class="p-st-information">
    <div class="p-st-photo"><img src="{{ $imageUrl }}"></div>
    <div class="p-st-profile">
        <div class="p-st-profile__job">{{ $staff->pos }}</div>
        <div class="p-st-profile__row">

            <dl class="p-st-profile__item">
                <dt><span class="furigana">ふりがな</span>氏名</dt>
                <dd><span class="furigana">{{ $staff->name_furi }}</span>{{ $staff->name }}</dd>
            </dl>

            <dl class="p-st-profile__item">
                <dt>勤務地</dt>
                <dd>{{ $shopName }}</dd>
            </dl>
        </div>

        <div class="p-st-profile__row">
            <dl class="p-st-profile__item">
                <dt>資格</dt>
                <dd>{{ $staff->qualification }}</dd>
            </dl>

            <dl class="p-st-profile__item">
                <dt>趣味</dt>
                <dd>{{ $staff->hobby }}</dd>
            </dl>
        </div>
    </div>
</div>
<div class="p-st-message">
    <p class="p-st-message__title">スタッフからのメッセージ</p>
    <div class="p-st-message__body">
        {{ $staff->msg }}
    </div>
</div>