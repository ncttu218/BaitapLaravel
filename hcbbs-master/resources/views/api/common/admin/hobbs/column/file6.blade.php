@if($dataType == 'object')
    @if($row->file6)
        @if(substr($row->file6,0,4) == 'http')
            <a href="{{ $row->file6 }}" target="_blank"><img src="{{ $row->file6 }}"></a>
        @else
            <a href="{{ asset_auto($row->file6) }}" target="_blank"><img src="{{ asset_auto($row->file6) }}"></a>
        @endif
    @endif
@endif

@if($dataType == 'array')
    @if($data['file6'])
        @if(substr($data['file6'],0,4) == 'http')
            <a href="{{ $data['file6'] }}" target="_blank"><img src="{{ $data['file6'] }}"></a>
        @else
            <a href="{{ asset_auto($data['file6']) }}" target="_blank"><img src="{{ asset_auto($data['file6']) }}"></a>
        @endif
    @endif
@endif
