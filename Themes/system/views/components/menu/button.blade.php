@aware(['layout'])
@switch($layout)
	@case('horizontal')
	<button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
		<i class="fa fa-fw fa-bars"></i>
	</button>
	@break
	@default
	<button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
		<i class="fa fa-fw fa-bars"></i>
	</button>
	@break
@endswitch