<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>

		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

		<title>{{ config('core.site_name') }} - Dashboard</title>

		@include('vendor.css')
		@livewireStyles

	</head>

	<body data-layout="horizontal" data-topbar="dark">
{{--		<div id="layout-wrapper">--}}

			<!-- ============================================================== -->
			<!-- Start right Content here -->
			<!-- ============================================================== -->


				{{ $slot }}

			<!-- end main content-->

{{--		</div>--}}


		@include('vendor.js')
		@livewireScripts
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
	</body>
</html>
