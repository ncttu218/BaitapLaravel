@if($dataType == 'object')
    {{ $row->caption1 }}
@endif
@if($dataType == 'array')
    {{ $data['caption1'] }}
@endif
