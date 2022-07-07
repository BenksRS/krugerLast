@php
	$fallbackClasses    = $errors->first($name) ? 'is-invalid' : NULL;

	$properties = $attributes->class(['form-control', $fallbackClasses])->merge([]);
	$properties = collect([])->merge($properties)->all();
@endphp
<div>
	<div class="row">
		@if(isset($label))
			{!! Form::label($name, $label, ['class' => 'form-label']) !!}
		@endif
		<div class="col">
			@if(in_array($type,['password', 'file']))
				{!! Form::$type($name, $properties) !!}
			@else
				{!! Form::$type($name, $value, $properties) !!}
			@endif
			@error($name)
			<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
	</div>
</div>