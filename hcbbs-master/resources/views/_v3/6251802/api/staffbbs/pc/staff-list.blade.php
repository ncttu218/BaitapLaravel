@foreach ($filteredStaffData as $row)
<article class="staff-card" style="height: 485px;">
<div class="staff-card__img">
    <img src="{{ asset_auto($row->photo) }}" border="0" height="150" f6="" style="width: 100%;">
</div>
<div class="staff-card__data">
  <div class="staff-card__head">
    <h3 class="staff-card__name">{{ $row->name }}</h3>
    <i class="staff-card__ruby">{{ $row->name_furi }}</i>
  </div>
  <div class="staff-card__detail">
    <dl>
      <dt>役職</dt>
      <dd>{{ ($departmentCodes[$row->department] ?? '') . ' ' . $row->position }}</dd>
    </dl>
    <dl>
      <dt>資格</dt>
      <dd>{!! implode('、', $row->qualification) !!}</dd>
    </dl>
    <dl>
      <dt>血液型</dt>
      <dd>{{ $row->extra['bloodType'] }}</dd>
    </dl>
    <dl>
      <dt>出身地</dt>
      <dd>{{ $row->extra['hometown'] }}</dd>
    </dl>
    <dl>
      <dt>趣味</dt>
      <dd>{!! implode('、', $row->hobby) !!}</dd>
    </dl>
    <dl>
      <dt>自己PR</dt>
      <dd>{{ $row->message }}</dd>
    </dl>
  </div>
</div>
</article>
@endforeach