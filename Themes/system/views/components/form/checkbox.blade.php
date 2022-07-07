@php
	$items = [
		'radio'     => ['type' => 'radio'],
		'checkbox'  => ['type' => 'checkbox'],
		'switch'    => ['type' => 'checkbox', 'class' => 'form-switch form-switch-md', 'attributes' => ['role' => 'switch']],
	];

	$item = $items[$type];
	$itemType = $items[$type]['type'];

	$fallbackClasses    = $errors->first($name) ? 'is-invalid' : NULL;

	$properties = $attributes->class(['form-check-input', $fallbackClasses])->merge([]);
	$properties = collect([])->merge($properties)->all();
@endphp

<div class="row">
	@if(isset($label))
		{!! Form::label($name, $label, ['class' => 'form-label']) !!}
	@endif
	<div class="col">
		@if(!empty($options) && is_array($options))
			@foreach($options as $key => $option)

				@php
					$id = $attributes->get('id', $name) . '-' . $key;
					$properties = collect($properties)->merge(['id' => $id])->all();
				@endphp

				<div class="form-check form-check-inline mb-3 {{ $item['class'] ?? '' }}">
					{!! Form::$itemType($name, $key, NULL, $properties) !!}
					{!! Form::label($id, $option, ['class' => 'form-check-label']) !!}
				</div>
			@endforeach
		@endif
		@error($name)
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>
</div>