@php
	$attributes = $attributes->class(['needs-validation'])->merge(['novalidate']);
@endphp
<div>
	@if($model)
		{!! Form::model($model, $formAttributes($attributes)) !!}
	@else
		{!! Form::open($formAttributes($attributes)) !!}
	@endif
	{!! $slot !!}
	{!! Form::close() !!}
</div>