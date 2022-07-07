@props(['type'  => 'submit', 'color' => 'primary', 'value'])

@php
	$properties = $attributes->class(['waves-effect', 'waves-light', 'btn', 'btn-'.$color])->merge(['type' => $type]);
@endphp

<button {{ $properties }}>
	{{ $value ?? $slot }}
</button>