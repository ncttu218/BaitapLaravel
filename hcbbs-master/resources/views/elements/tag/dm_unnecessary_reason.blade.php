@if(isset($options))
{!! Form::select($id, $select->getOptions(), null, $options) !!}
@else
{!! Form::select($id, $select->getOptions(), $value) !!}
@endif