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


	<body >

		<!-- Begin page -->
		<div id="layout-wrapper">





						{{ $slot }}

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
