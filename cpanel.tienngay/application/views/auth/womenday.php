<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Lms Tienngay | </title>

	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="<?php echo base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/build/css/teacup.css" rel="stylesheet">
	<link rel="shortcut icon" href="<?= base_url() ?>/assets/home/images/favicon.png"/>

	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="page_login nav-md">
<div id="thelogin" class="container body">
	<div id="particles-js" class="main_container">
		<div class="container">
			
			<div class="row flex">
				<div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
            
					<div class="panel panel-default panel-login">
						<img style="width: 200px; margin: 0 auto 10px;display: block"
							 src="<?php echo base_url(); ?>assets/imgs/logo.png" alt="">
						<form action="<?= base_url('auth/doLogin') ?>" method="post">
							<?php if ($this->session->flashdata('error')) { ?>
								<div class="alert alert-danger alert-result">
									<?= $this->session->flashdata('error') ?>
								</div>
							<?php } ?>
							<?php if ($this->session->flashdata('success')) { ?>
								<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
							<?php } ?>
							<?php if (validation_errors()) { ?>
								<div class="alert alert-danger">
									<?php echo validation_errors(); ?>
								</div>
							<?php } ?>
							<div class="form-group">
								<i class="fa fa-user"></i>
								<input type="text" class="form-control" name='email' placeholder="Email" required="">
							</div>
							<div class="form-group" style="margin-bottom:12px;">
								<i class="fa fa-lock"></i>
								<input id="thepasswords" type="password" class="form-control" name='password'
									   placeholder="Password" required="">
								<button type="button" class="btn btn-link passwordtoggler">
									<i class="fa fa-eye"></i>
								</button>
							</div>
							<div class="form-group">
								<p class="thelinks text-center">

									<span>Quên mật khẩu? <a href="<?php echo base_url('auth/forgot') ?>">Lấy lại mật khẩu</a> </span>
								</p>
							</div>
							<?php echo $widget; ?>
							<?php echo $script; ?>

							<div class="g-recaptcha"
								 data-sitekey="<?= $this->config->item("recaptcha_site_key") ?>"></div>
							<button type="submit" class="btn btn-login">Tôi chọn yêu thương phụ nữ</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('.passwordtoggler').click(function (event) {
		var x = document.getElementById("thepasswords");
		// event.preventDefault();
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
		$(this).children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
	});
</script>
</body>
</html>
<style>
	body {
		overflow: hidden;
	}
	#thelogin {
		background: url('./assets/build/images/bg_8-3.png') #fff no-repeat;
		overflow: hidden;
		background-size: cover;
	}
	#thelogin .panel-login {
		position: relative;
		z-index: 9999;
		background: url('./assets/build/images/bg_panel_women.png') #fff no-repeat;
		background-size: contain;
		background-position: right;
	}
	#thelogin .btn:not(.passwordtoggler){
		background: linear-gradient(177.8deg, #EE598F 3.39%, #F175A2 94.6%) !important
	}
	#thelogin .panel-login {
		padding: 10px;
		margin-top: 0;
	}
	#thelogin .panel-login form .form-group {
		margin-bottom: 10px;
	}
	#thelogin .row.flex {
		margin-top: 50px;
		margin-left: -300px;
	}
	@media (max-width: 768px)
	{
		#thelogin {
			/* background: url(./assets/build/images/bg_8-3.png) #fff no-repeat -200px; */
			overflow: hidden;
			background-size: unset;
		}
		#thelogin .row.flex {
			margin-left: -10px;
		}
		#thelogin {
			background: url(./assets/build/images/bg_8-3.png) #fff right no-repeat;
		}
	}
</style>
