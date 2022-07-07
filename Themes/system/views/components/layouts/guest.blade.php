<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
		
		<link rel="canonical" href="{{ request()->url() }}">
		
		<title>{{ config('core.site_name') }} - {{ $title ?? 'Login' }}</title>
		
		<!-- App favicon -->
		<link rel="shortcut icon" href="{{ themes('images/favicon.ico') }}">
		
		<!-- Bootstrap Css -->
		<link href="{{ themes('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
		<!-- Icons Css -->
		<link href="{{ themes('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- App Css-->
		<link href="{{ themes('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
	
	</head>
	<body>
		<div class="account-pages my-5 pt-sm-5">
			<div class="container">
				{{ $slot }}
			</div>
		</div>

		<!-- JAVASCRIPT -->
		<script src="{{ themes('libs/jquery/jquery.min.js')}}"></script>
		<script src="{{ themes('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ themes('libs/metismenu/metisMenu.min.js') }}"></script>
		<script src="{{ themes('libs/simplebar/simplebar.min.js') }}"></script>
		<script src="{{ themes('libs/node-waves/waves.min.js') }}"></script>
		
		<!-- App js -->
		<script src="{{ themes('js/app.js') }}"></script>
	</body>
</html>
