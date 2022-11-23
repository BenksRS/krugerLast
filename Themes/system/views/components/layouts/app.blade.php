@props(['layout' => 'vertical'])
	<!doctype html>
<html lang="en">
	<head>

		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

		<title>{{ config('core.site_name') }} - Dashboard</title>

		@include('vendor.css')
        @livewireStyles
	</head>


	<body {{ $layout == 'vertical' ? 'data-sidebar=dark' : 'data-layout=horizontal data-topbar=dark'  }} >

		<!-- Begin page -->
		<div id="layout-wrapper">

			<header id="page-topbar">
				<div class="navbar-header">
					<div class="d-flex">
						<!-- LOGO -->
						<div class="navbar-brand-box">
							<a href="/" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ themes('images/logo/dark/logo-sm.png') }}" alt="" height="22">
                                </span>
								<span class="logo-lg">
                                    <img src="{{ themes('images/logo/dark/logo-lg.png') }}" alt="" height="34">
                                </span>
							</a>

							<a href="/" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ themes('images/logo/light/logo-sm.png') }}" alt="" height="22">
                                </span>
								<span class="logo-lg">
                                    <img src="{{ themes('images/logo/light/logo-lg.png') }}" alt="" height="34">
                                </span>
							</a>
						</div>
						<button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
							<i class="fa fa-fw fa-bars"></i>
						</button>

							@livewire('dashboard::search', key('dash_search'))
						<!-- App Search-->


					<div class="d-flex">
						<div class="dropdown d-inline-block">
							<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="rounded-circle header-profile-user" src="{{ themes('images/users/avatar-kruger.png') }}" alt="Header Avatar">
								<span class="d-none d-xl-inline-block ms-1" key="t-henry">
									@auth{{ Auth::user()->name }}@endauth
								</span> <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<!-- item-->
								<a class="dropdown-item" href="{{ url('profile') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i>
									<span key="t-profile">Profile</span></a>
											<div class="dropdown-divider"></div>
								<a class="dropdown-item text-danger" href="{{ route('auth.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
									<i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
									<span key="t-logout">Logout</span> </a>
								<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</div>
						</div>


					</div>
				</div>
				</div>
			</header>

			<!-- Menu-->
			<x-dynamic-component component="menu.{{ $layout }}"/>


			<!-- ============================================================== -->
			<!-- Start right Content here -->
			<!-- ============================================================== -->

			<div class="main-content">

				<div class="page-content">
					<div class="container-fluid">
						{{ $slot }}
					</div>
					<!-- container-fluid -->
				</div>
				<!-- End Page-content -->


				<footer class="footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<script>document.write(new Date().getFullYear())</script>
								© {{ config('core.site_name') }}
							</div>
						</div>
					</div>
				</footer>

			</div>
			<!-- end main content-->

		</div>
		<!-- END layout-wrapper -->

{{--		<!-- Right Sidebar -->--}}
{{--		<div class="right-bar">--}}
{{--			<div data-simplebar class="h-100">--}}
{{--				<div class="rightbar-title d-flex align-items-center px-3 py-4">--}}

{{--					<h5 class="m-0 me-2">Settings</h5>--}}

{{--					<a href="javascript:void(0);" class="right-bar-toggle ms-auto">--}}
{{--						<i class="mdi mdi-close noti-icon"></i> </a>--}}
{{--				</div>--}}

{{--				<!-- Settings -->--}}
{{--				<hr class="mt-0"/>--}}
{{--				<h6 class="text-center mb-0">Choose Layouts</h6>--}}

{{--				<div class="p-4">--}}
{{--					<div class="mb-2">--}}
{{--						<img src="{{ themes('images/layouts/layout-1.jpg') }}" class="img-thumbnail" alt="layout images">--}}
{{--					</div>--}}

{{--					<div class="form-check form-switch mb-3">--}}
{{--						<input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>--}}
{{--						<label class="form-check-label" for="light-mode-switch">Light Mode</label>--}}
{{--					</div>--}}

{{--					<div class="mb-2">--}}
{{--						<img src="{{ themes('images/layouts/layout-2.jpg') }}" class="img-thumbnail" alt="layout images">--}}
{{--					</div>--}}
{{--					<div class="form-check form-switch mb-3">--}}
{{--						<input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">--}}
{{--						<label class="form-check-label" for="dark-mode-switch">Dark Mode</label>--}}
{{--					</div>--}}

{{--					<div class="mb-2">--}}
{{--						<img src="{{ themes('images/layouts/layout-3.jpg') }}" class="img-thumbnail" alt="layout images">--}}
{{--					</div>--}}
{{--					<div class="form-check form-switch mb-3">--}}
{{--						<input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">--}}
{{--						<label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>--}}
{{--					</div>--}}

{{--					<div class="mb-2">--}}
{{--						<img src="{{ themes('images/layouts/layout-4.jpg') }}" class="img-thumbnail" alt="layout images">--}}
{{--					</div>--}}
{{--					<div class="form-check form-switch mb-5">--}}
{{--						<input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">--}}
{{--						<label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>--}}
{{--					</div>--}}


{{--				</div>--}}

{{--			</div> <!-- end slimscroll-menu-->--}}
{{--		</div>--}}
{{--		<!-- /Right-bar -->--}}

		<!-- Right bar overlay-->
{{--		<div class="rightbar-overlay"></div>--}}

		@include('vendor.js')
        {{--  teste toaster --}}

        @toastr_js
        @toastr_render

        {{-- end teste toaster--}}

        @livewireScripts

        <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
	</body>
</html>
