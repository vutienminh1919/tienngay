<!DOCTYPE html>
<html>
<head>
	<title>Nhà đầu tư</title>
	<script src="{{ asset('js/tabler.min.js') }}"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.css') }}">
	<link rel="stylesheet" href="{{ asset('css/tabler.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="antialiased border-primary d-flex flex-column bg-login">
	<div class="page page-center">
		<div class="container-tight py-4">
			<div class="text-center mb-4">
				<a href="."><img src="{{ asset('images/logo.png') }}" height="80" alt=""></a>
			</div>
			<form class="card card-md login-form" action="." method="get" autocomplete="off">
				<div class="card-body">
					<h2 class="card-title text-center mb-4 login-head">Đăng nhập</h2>
					<div class="mb-3">
						<div class="input-icon mb-3">
							<span class="input-icon-addon">
								<i class="fas fa-user"></i>
							</span>
							<input type="text" class="form-control" placeholder="Username">
						</div>
						<div class="input-icon mb-2">
							<span class="input-icon-addon">
								<i class="fas fa-lock"></i>
							</span>
							<input type="password" class="form-control is-invalid" placeholder="Mật khẩu">
						</div>
						<div class="mb-3">
							<label class="form-check">
								<input type="checkbox" class="form-check-input">
								<span class="form-check-label">Lưu thông tin đăng nhập</span>
							</label>
						</div>
						<div class="mb-3 text-center">
							<div class="g-recaptcha" data-sitekey="6Le8HfAaAAAAAPE8bLRlD9lDZNTvSHb_n2PVbBG4"></div>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary login-btn">ĐĂNG NHẬP</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>