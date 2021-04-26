@if($dataType == 'object')
    {!! nl2br($row->comment) !!}
@endif
@if($dataType == 'array')
    {!! nl2br($data['comment']) !!}
@endif

