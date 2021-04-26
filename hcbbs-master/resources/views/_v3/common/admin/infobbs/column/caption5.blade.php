@if($dataType == 'object')
    {{ $row->caption5 }}
@endif
@if($dataType == 'array')
    @if(isset($data['caption5']))
    {{ $data['caption5'] }}
    @endif
@endif
