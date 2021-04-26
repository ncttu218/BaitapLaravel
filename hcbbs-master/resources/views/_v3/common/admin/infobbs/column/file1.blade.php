@if($dataType == 'object')
    @if($row->file1)
        @if(substr($row->file1,0,4) == 'http')
            <a href="{{ $row->file1 }}" target="_blank"><img src="{{ $row->file1 }}"></a>
        @else
            <a href="{{ asset_auto($row->file1) }}" target="_blank"><img src="{{ asset_auto($row->file1) }}"></a>
        @endif
    @endif
@endif

@if($dataType == 'array')
    @if($data['file1'])
        @if(substr($data['file1'],0,4) == 'http')
            <a href="{{ $data['file1'] }}" target="_blank"><img src="{{ $data['file1'] }}"></a>
        @else
            <a href="{{ asset_auto($data['file1']) }}" target="_blank"><img src="{{ asset_auto($data['file1']) }}"></a>
        @endif
    @endif
@endif
