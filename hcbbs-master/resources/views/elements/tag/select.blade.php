{{-- 選択する値がなければNULLで初期化 --}}
@if( isset( $value ) != True )
<?php $value = null; ?>
@endif

@if(isset($options))
{!! Form::select($id, $select->getOptions(), $value, $options) !!}
@else
{!! Form::select($id, $select->getOptions(), $value) !!}
@endif