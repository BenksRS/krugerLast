<ul class="navbar-nav">
	@foreach($links as $menu)
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle arrow-none" href="{{ $menu['url'] ?? '#' }}" id="topnav-dashboard" role="button">
				<i class="{{ $menu['icon'] ?? 'bx bx-home-circle' }} me-2"></i>
				<span key="t-dashboards">{{ $menu['title'] }}</span>
				@if(count($menu['children']) > 0)
					<div class="arrow-down"></div>
				@endif
			</a>
			@if(count($menu['children']) > 0)
				<div class="dropdown-menu" aria-labelledby="topnav-dashboard">
					@foreach($menu['children'] as $child)
						<a href="{{ $child['url'] ?? '#' }}" class="dropdown-item" key="t-default">{{ $child['title'] }}</a>
					@endforeach
				</div>
			@endif
		</li>
	@endforeach
</ul>