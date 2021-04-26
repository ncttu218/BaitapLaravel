@foreach ( $staffs as $row)
<?php
// サムネール画像
if (!empty($row->photo)) {
    if (!preg_match('/data\/image\//', $row->photo)) {
        $imageUrl = "//cgi3-aws.hondanet.co.jp/cgi/1103901/staff/data/image/{$row->photo}";
    } else {
        $imageUrl = asset_auto($row->photo);
    }
} else {
    $imageUrl = asset_auto('img/nophoto_s.jpg');
}

// スタッフ番号
$number = substr($row->number, 4);
?>
<div class="p-staff-panel">
    <div class="p-staff-panel__head">
        <span class="p-staff-panel__name">{{ $row->name }}
            <ruby class="p-staff-panel__ruby">{{ $row->name_furi }}</ruby></span>
        <span class="p-staff-panel__job">{{ $departmentCodes[$row->department] ?? '' }}</span>
    </div>

    <div class="p-staff-panel__profile">
        <figure class="p-staff-panel__photo" style="background-image: url('{{ $imageUrl }}');"></figure>
        <ul class="p-staff-panel__detail">
            <li class="p-staff-panel__astro">
                <span>星座</span>
                <span>{{ $row->ext_value1 ?? '-' }}</span>
            </li>
            <li class="p-staff-panel__blood">
                <span>血液型</span>
                <span>{{ $row->ext_value2 ?? '-' }}</span>
            </li>
            <li class="p-staff-panel__love">
                <span>愛してやまないもの</span>
                <ul>
                    <li>{{ $row->ext_value4 }}</li>
                    @for ($i = 2;$i <= 6;$i++)
                        @php
                        $key = "ext_value4_{$i}";
                        @endphp
                        @if (empty($row->{$key}))
                            @continue
                        @endif
                        <li>{{ $row->{$key} }}</li>
                    @endfor
                </ul>
            </li>
        </ul>
    </div>

    <p class="p-staff-panel__comment">{!! nl2br(trim($row->comment)) !!}</p>
</div>

@endforeach
