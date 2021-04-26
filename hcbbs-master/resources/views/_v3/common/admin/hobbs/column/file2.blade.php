@if($dataType == 'object')
    @if($row->file2)
        @if(substr($row->file2,0,4) == 'http')
            <a href="{{ $row->file2 }}" target="_blank"><img src="{{ $row->file2 }}"></a>
        @else
            <a href="{{ asset_auto($row->file2) }}" target="_blank"><img src="{{ asset_auto($row->file2) }}"></a>
        @endif
    @endif
@endif

@if($dataType == 'array')
    @if($data['file2'])
        @if(substr($data['file2'],0,4) == 'http')
            <a href="{{ $data['file2'] }}" target="_blank"><img src="{{ $data['file2'] }}"></a>
        @else
            <a href="{{ asset_auto($data['file2']) }}" target="_blank"><img src="{{ asset_auto($data['file2']) }}"></a>
        @endif
    @endif
@endif
