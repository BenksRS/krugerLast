@php
	$fallbackClasses    = $errors->first($name) ? 'is-invalid' : NULL;

	$properties = $attributes->class(['form-control form-select', $fallbackClasses])->merge([]);
	$properties = collect([])->merge($properties)->all();
@endphp

<div class="row">
	@if(isset($label))
		{!! Form::label($name, $label, ['class' => 'form-label']) !!}
	@endif
	<div class="col">
		{!! Form::$type($name, $options, $value, $properties) !!}
		@error($name)
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
</div>