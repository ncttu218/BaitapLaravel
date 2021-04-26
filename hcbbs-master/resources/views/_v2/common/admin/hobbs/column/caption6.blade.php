@if($dataType == 'object')
    {{ $row->caption6 }}
@endif
@if($dataType == 'array')
    @if(isset($data['caption6']))
    {{ $data['caption6'] }}
    @endif
@endif
