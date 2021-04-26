@if($dataType == 'object')
    {{ $row->caption4 }}
@endif
@if($dataType == 'array')
    @if(isset($data['caption4']))
    {{ $data['caption4'] }}
    @endif
@endif
