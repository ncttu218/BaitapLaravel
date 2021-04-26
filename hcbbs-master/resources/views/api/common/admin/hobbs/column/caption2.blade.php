@if($dataType == 'object')
    {{ $row->caption2 }}
@endif
@if($dataType == 'array')
    {{ $data['caption2'] }}
@endif
