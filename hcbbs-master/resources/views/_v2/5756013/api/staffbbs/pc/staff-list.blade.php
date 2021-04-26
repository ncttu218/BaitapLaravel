<?php
// 役職グループ
$departmentGroups = [
    'staff10' => '01',
    'staff15' => '01',
    'staff20' => '01',
    'staff29' => '01',
    'staff30' => '02',
    'staff40' => '03',
    'staff50' => '03',
    'staff60' => '03',
    'staff70' => '03',
];
$groups = [];
foreach ( $staffs as $row ) {
    $groups[$row->department]['name'] = $departmentCodes[$row->department] ?? '';
    $groups[$row->department]['data'][] = $row;
}
?>
@foreach ( $groups as $group )
    <?php
    $departmentName = $group['name'];
    ?>
    <ul class="staff-list">
    @foreach ( $group['data'] as $row)
    <?php
    // サムネール画像
    if (!empty($row->photo)) {
        $imageUrl = asset_auto($row->photo);
    } else {
        $imageUrl = asset_auto('img/nophoto_s.jpg');
    }

    // スタッフ番号
    $number = substr($row->number, 4);
    ?>
       <li class="staff-item staff_sub_{{ $departmentGroups[$row->department] ?? '' }}"
           id="st01_{{ $number }}">
          <div class="staff-item__name">
             <span>{{ $row->name }}</span>
             <i class="staff10">{{ $departmentName }}</i>
          </div>
          <div class="staff-item__detail">
             <figure>
                <img src="{{ $imageUrl }}" border=0 height=150  f6>
             </figure>
             <dl class="staff-item__profile">
                @if (!empty($row->ext_value1))
                <dt>血液型</dt>
                <dd>{{ $row->ext_value1 ?? '-' }}</dd>
                @endif
                @if (!empty($row->ext_value5))
                <dt>星座</dt>
                <dd>{{ $row->ext_value5 ?? '-' }}</dd>
                @endif
                @if (!empty($row->ext_value2))
                <dt>出身地</dt>
                <dd>{{ $row->ext_value2 ?? '-' }}</dd>
                @endif
                <dt>資　格</dt>
                <dd>
                   <ul>
                      <li>{{ $row->ext_value3 }}</li>
                      @for ($i = 2;$i <= 6;$i++)
                        @php
                        $key = "ext_value3_{$i}";
                        @endphp
                        @if (empty($row->{$key}))
                            @continue
                        @endif
                        <li>{{ $row->{$key} }}</li>
                      @endfor
                   </ul>
                </dd>
             </dl>
             <dl class="staff-item__profile--more">
                <dt>愛してやまないもの</dt>
                <dd>
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
                </dd>
             </dl>
          </div>
          <p class="staff-item__comment">{!! nl2br(trim($row->comment)) !!}</p>
       </li>
    @endforeach
    </ul>
@endforeach
