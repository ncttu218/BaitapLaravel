@if($dataType == 'object')
    <div style="float: left;">[{{ trim($row->base_name) }}] {{ $row->title }}</div>
    <div style="float: right;font-size: 12px;position: absolute;right: 0;top: 50%;transform: translateY(-50%);">{{ date('Y/m/d', strtotime($row->created_at)) }}</div>
@endif
