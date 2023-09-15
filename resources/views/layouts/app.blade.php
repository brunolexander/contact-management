<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Contact Management &mdash; @yield('title')</title>
	<link ref="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

	<link rel="stylesheet" href="{{ asset('libs/bootstrap5/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('libs/fontawesome6/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('libs/fontawesome6/css/solid.min.css') }}">

	@yield('styles')

</head>
<body>
	
	@yield('content')

	<script src="{{ asset('libs/jquery.min.js') }}"></script>
	<script src="{{ asset('libs/bootstrap5/js/bootstrap.bundle.min.js') }}"></script>

	@yield('scripts')

</body>
</html>