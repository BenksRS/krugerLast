@props(['title','subtitle'])

<div {{ $attributes->class(['card']) }}>
	<div class="card-body">

		@if(isset($title))
			<h4 {{ $title->attributes->class(['card-title']) }}>{{ $title }}</h4>
		@endif

		@if(isset($subtitle))
			<p {{ $subtitle->attributes->class(['card-title-desc']) }}>{{ $subtitle }}</p>
		@endif
		{{ $slot }}
	</div>
</div>
