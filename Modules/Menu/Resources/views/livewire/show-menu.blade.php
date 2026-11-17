<ul class="navbar-nav">
	@foreach($links as $menu)
		@php $hasChildren = $menu->children->isNotEmpty(); @endphp
	
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle arrow-none"
			   href="{{ filled($menu->url) ? url($menu->url) : '#' }}"
			   id="topnav-menu-{{ $menu->id }}"
			   role="button">
				<i class="{{ $menu->icon ?? 'bx bx-home-circle' }} me-2"></i>
				<span>{{ $menu->title }}</span>
				@if($hasChildren)
					<div class="arrow-down"></div>
				@endif
			</a>
			
			@if($hasChildren)
				<div class="dropdown-menu" aria-labelledby="topnav-menu-{{ $menu->id }}">
					@foreach($menu->children as $child)
						<a href="{{ filled($child->url) ? url($child->url) : '#' }}" class="dropdown-item">
							{{ $child->title }}
						</a>
					@endforeach
				</div>
			@endif
		</li>
	@endforeach
</ul>