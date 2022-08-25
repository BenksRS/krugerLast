<li class="dd-item dd-item-general" data-id="{{ $link->id }}">
	<div class="card border m-0">
		<div class="dd-handle border-end"></div>
		<div class="dd-header">
			<div class="dd-header-collapse" role="button" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#link-{{ $link->id }}"></div>
			<div class="dd-header-title">{{ $link->title }}</div>
			@include('menu::build.list.partials.actions')
		</div>
		<div class="border-top dd-body collapse" id="link-{{ $link->id }}">
			<div class="card-body">
				@include('menu::build.form.general')
			</div>
		</div>
	
	</div>
	@if(!empty($link['children']))
		<ol class="dd-list">
			@foreach($link['children'] as $i => $child)
				<livewire:menu::show-menu-link :link="$child" wire:key="menu-link-{{ $child->id }}"/>
			@endforeach
		</ol>
	@endif
</li>