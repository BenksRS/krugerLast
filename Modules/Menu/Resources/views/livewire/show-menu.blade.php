<ul class="navbar-nav">
	@foreach($links as $menu)
		<li class="nav-item dropdown">
                <?php $menu_link = $menu['url'] != NULL ? url("{$menu['url']}") : '#'; ?>
			<a class="nav-link dropdown-toggle arrow-none" href="{{ $menu_link }}" id="topnav-dashboard" role="button">
				<i class="{{ $menu['icon'] ?? 'bx bx-home-circle' }} me-2"></i>
				<span key="t-dashboards">{{ $menu['title'] }}</span>
				@if(count($menu['children']) > 0)
					<div class="arrow-down"></div>
				@endif
			</a>
			@if(count($menu['children']) > 0)
				<div class="dropdown-menu" aria-labelledby="topnav-dashboard">
					@foreach($menu['children'] as $child)
                            <?php $child_link = $child['url']; ?>
						<a href="{{url("$child_link") ?? '#' }}" class="dropdown-item" key="t-default">{{ $child['title'] }}</a>
					@endforeach
				</div>
			@endif
		</li>
	@endforeach
</ul>