@if($dataType == 'object')
    @if($row->file3)
        @if(substr($row->file3,0,4) == 'http')
            <a href="{{ $row->file3 }}" target="_blank"><img src="{{ $row->file3 }}"></a>
        @else
            <a href="{{ asset_auto($row->file3) }}" target="_blank"><img src="{{ asset_auto($row->file3) }}"></a>
        @endif
    @endif
@endif

@if($dataType == 'array')
    @if($data['file3'])
        @if(substr($data['file3'],0,4) == 'http')
            <a href="{{ $data['file3'] }}" target="_blank"><img src="{{ $data['file3'] }}"></a>
        @else
            <a href="{{ asset_auto($data['file3']) }}" target="_blank"><img src="{{ asset_auto($data['file3']) }}"></a>
        @endif
    @endif
@endif
