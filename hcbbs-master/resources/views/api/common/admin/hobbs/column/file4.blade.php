@if($dataType == 'object')
    @if($row->file4)
        @if(substr($row->file4,0,4) == 'http')
            <a href="{{ $row->file4 }}" target="_blank"><img src="{{ $row->file4 }}"></a>
        @else
            <a href="{{ asset_auto($row->file4) }}" target="_blank"><img src="{{ asset_auto($row->file4) }}"></a>
        @endif
    @endif
@endif

@if($dataType == 'array')
    @if($data['file4'])
        @if(substr($data['file4'],0,4) == 'http')
            <a href="{{ $data['file4'] }}" target="_blank"><img src="{{ $data['file4'] }}"></a>
        @else
            <a href="{{ asset_auto($data['file4']) }}" target="_blank"><img src="{{ asset_auto($data['file4']) }}"></a>
        @endif
    @endif
@endif
