@if($dataType == 'object')
    @if($row->file5)
        @if(substr($row->file5,0,4) == 'http')
            <a href="{{ $row->file5 }}" target="_blank"><img src="{{ $row->file5 }}"></a>
        @else
            <a href="{{ asset_auto($row->file5) }}" target="_blank"><img src="{{ asset_auto($row->file5) }}"></a>
        @endif
    @endif
@endif

@if($dataType == 'array')
    @if($data['file5'])
        @if(substr($data['file5'],0,4) == 'http')
            <a href="{{ $data['file5'] }}" target="_blank"><img src="{{ $data['file5'] }}"></a>
        @else
            <a href="{{ asset_auto($data['file5']) }}" target="_blank"><img src="{{ asset_auto($data['file5']) }}"></a>
        @endif
    @endif
@endif
