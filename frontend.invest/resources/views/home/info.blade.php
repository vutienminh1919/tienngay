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
<body class="antialiased">
	<div class="wrapper">
		<aside class="navbar navbar-vertical navbar-expand-lg sidebar">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
					<span class="navbar-toggler-icon"></span>
				</button>
				<h1 class="navbar-brand navbar-brand-autodark">
					<a href=".">
						<img src="{{ asset('images/logo2.svg') }}" width="210" alt="Tabler">
					</a>
				</h1>
				<div class="collapse navbar-collapse" id="navbar-menu">
					<ul class="navbar-nav pt-lg-3">
						{{-- Menu 1 --}}
						<li class="nav-item mb-3">
							<a class="nav-link dropdown-toggle mb-2" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<img src="{{ asset('images/icon-folder.svg') }}">
								</span>
								<span class="nav-link-title">
									VFC approve
								</span>
							</a>
							<div class="dropdown-menu">
								<div class="dropdown-menu-columns">
									<div class="dropdown-menu-column">
										<a class="dropdown-item active mb-2" href="./empty.html" >
											Danh sách xác nhận NĐT
										</a>
										<a class="dropdown-item mb-2" href="./empty.html" >
											Danh sách NĐT App
										</a>
										<a class="dropdown-item mb-2" href="./empty.html" >
											Danh sách NĐT ủy quyền
										</a>
										<a class="dropdown-item mb-2" href="./empty.html" >
											Yêu cầu vay và chênh lệch
										</a>
									</div>
								</div>
							</div>
						</li>
						{{-- End Menu 1 --}}
						<li class="nav-item mb-3">
							<a class="nav-link" href="." >
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<img src="{{ asset('images/icon-chart.svg') }}">
								</span>
								<span class="nav-link-title">
									Config chung
								</span>
							</a>
						</li>
						{{-- End Menu 2 --}}
						<li class="nav-item mb-3">
							<a class="nav-link" href="." >
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<img src="{{ asset('images/icon-rich.svg') }}">
								</span>
								<span class="nav-link-title">
									Thu tiền và trả NĐT
								</span>
							</a>
						</li>
						{{-- End Menu 3 --}}
						<li class="nav-item mb-3">
							<a class="nav-link" href="." >
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<img src="{{ asset('images/icon-money.svg') }}">
								</span>
								<span class="nav-link-title">
									Danh sách kỳ trả tiền
								</span>
							</a>
						</li>
						{{-- End Menu 4 --}}
						<li class="nav-item mb-3">
							<a class="nav-link" href="." >
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<img src="{{ asset('images/icon-perm.svg') }}">
								</span>
								<span class="nav-link-title">
									Bảng phân quyền
								</span>
							</a>
						</li>
						{{-- End Menu 4 --}}
						<li class="nav-item mb-3">
							<a class="nav-link" href="." >
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<img src="{{ asset('images/icon-plan.svg') }}">
								</span>
								<span class="nav-link-title">
									Kế hoạch trả tiền
								</span>
							</a>
						</li>
						{{-- End Menu 5 --}}
					</ul>
				</div>
			</div>
		</aside>

		<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
			<div class="container-fluid">
				<div class="navbar-nav flex-row order-md-last">
					<div class="nav-item dropdown d-none d-md-flex me-3">
						<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
							<i class="fas fa-bell"></i>
							<span class="badge bg-red"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
							<div class="card">
								<div class="card-body">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
								</div>
							</div>
						</div>
					</div>
					<div class="nav-item dropdown">
						<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
							<span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name=TungBt)"></span>
							<div class="d-none d-xl-block ps-2">
								<div>TungBT</div>
								<div class="mt-1 small text-muted">PHP Developer</div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
							<a href="#" class="dropdown-item">Tài khoản</a>
							<a href="#" class="dropdown-item">Cài đặt</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">Đăng xuất</a>
						</div>
					</div>
				</div>
				<div class="collapse navbar-collapse" id="navbar-menu"></div>
			</div>
		</header>
	</div>
</body>
</html>