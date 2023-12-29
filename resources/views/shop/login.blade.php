<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('login/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login/css/my-login.css') }}">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper my-auto">
					@yield('content')
				</div>
			</div>
		</div>
	</section>

	<script src="{{ asset('login/js/jquery.min.js') }}"></script>
	<script src="{{ asset('login/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('login/js/my-login.js') }}"></script>
</body>
</html>