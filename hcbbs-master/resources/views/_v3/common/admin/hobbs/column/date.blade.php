@if($dataType == 'object')
    {{ substr($row->updated_at,0,10) }}
@endif
@if($dataType == 'array')
-
@endif
