@props(['header','title','subtitle','footer'])

<div {{ $attributes->class(['card']) }}>

	@if(isset($header))
		<div {{ $header->attributes->class(['card-header']) }}>{{ $header }}</div>
	@endif

	<div class="card-body">

		@if(isset($title))
			<h4 {{ $title->attributes->class(['card-title']) }}>{{ $title }}</h4>
		@endif

		@if(isset($subtitle))
			<p {{ $subtitle->attributes->class(['card-text']) }}>{{ $subtitle }}</p>
		@endif

		{{ $slot }}
	</div>

	@if(isset($footer))
		<div {{ $footer->attributes->class(['card-footer']) }}>
			<small class="text-muted">{{ $footer }}</small>
		</div>
	@endif

</div>
