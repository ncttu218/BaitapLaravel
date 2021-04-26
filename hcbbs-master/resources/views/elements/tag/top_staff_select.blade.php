{{-- @include('elements.tag.select', ['id' => $id, 'options' => $options]) --}}
@if(isset($options))
{!! Form::select($id, $select->getOptions(), $options['value'], $options) !!}
@else
{!! Form::select($id, $select->getOptions()) !!}
@endif