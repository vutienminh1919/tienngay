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
	<link rel="shortcut icon" href="<?= base_url() ?>/assets/home/images/favicon.png" />

	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="nav-md">
	<div id="thelogin" class="container body">
		<div id="particles-js" class="main_container">
			<div class="container" style="margin-top: 5%;">
				<div class="row flex">
					<div class="col-xs-12 col-md-12 col-lg-12">
						<div class="panel panel-default panel-login" style="margin-bottom: 150px;">
							<div class="title-2023" style=" text-align: center;">
								<img src="https://service.tienngay.vn/uploads/avatar/1675071903-deb58bf5a92dd7f1c60c7c83c98b9acf.png" alt="">
							</div>
							<div style="display: flex; justify-content: space-evenly; padding-top: 60px">
								<div class="cat cat-left">
									<img src="https://service.tienngay.vn/uploads/avatar/1675067579-39d42a1866d06f591e6fa44aeb39f511.gif" alt="">
								</div>
								<div class="style-login">
									<div class="img-login">
										<img src="https://service.tienngay.vn/uploads/avatar/1675067087-634c28a5188bca3ffca9dd961a911c70.png" alt="" width="100%">
									</div>
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
											<input id="thepasswords" type="password" class="form-control" name='password' placeholder="Password" required="">
											<button type="button" class="btn btn-link passwordtoggler">
												<i class="fa fa-eye"></i>
											</button>
										</div>
										<div>
											<p class="thelinks text-left">

												<span style="color: #B8B8B8">Quên mật khẩu? <a href="<?php echo base_url('auth/forgot') ?>" style="color: #0E9549">Lấy lại mật khẩu</a> </span>
											</p>
										</div>
										<?php echo $widget; ?>
										<?php echo $script; ?>

										<div class="g-recaptcha" data-sitekey="<?= $this->config->item("recaptcha_site_key") ?>"></div>
										<button type="submit" class="btn btn-login">Đăng nhập</button>
									</form>
								</div>
								<div class="cat">
									<img src="https://service.tienngay.vn/uploads/avatar/1675067579-39d42a1866d06f591e6fa44aeb39f511.gif" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('.passwordtoggler').click(function(event) {
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
	<style>
		#thelogin {
			/* background: url('./assets/build/images/bg_default.png') no-repeat center; */
			background-image: url('https://service.tienngay.vn/uploads/avatar/1675071854-7c3b3e1e49ce84ab35b8678657d099ce.png');
			overflow: hidden;
			background-size: cover;
		}

		#thelogin .form-group i.fa {

			color: #fff;
		}

		#thelogin .form-control {
			color: black;
		}

		#thelogin .panel-login {
			padding: 0;
			margin-top: 0;
		}

		.cat {
			background-image: url(https://service.tienngay.vn/uploads/avatar/1675067702-5e81029427ae96704ccb7c8bd1fc2af9.png);
			border-radius: 50px;
			width: 350px;
			height: 350px;
			background-size: contain;
			position: relative;
			margin-top: 30px;
		}

		.cat img {
			width: 295px;
			height: 382px;
			position: absolute;
			top: -55px;
			left: 35px;
		}

		.cat-left {
			-moz-transform: scaleX(-1);
			-o-transform: scaleX(-1);
			-webkit-transform: scaleX(-1);
			transform: scaleX(-1);
			filter: FlipH;
			-ms-filter: "FlipH";
		}

		.style-login {
			background-color: #FFFFFF;
			padding: 0px 24px 24px 24px;
			border-radius: 16px;
			border: 1px solid #E8E8E8;
			box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.15);
		}

		.img-login {
			padding: 24px;
		}

		.panel {
			margin-bottom: 0;
			background-color: transparent;
			border: transparent;
			border-radius: unset;
			-webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
			box-shadow: unset;
		}

		#thelogin .form-group p.thelinks {
			color: #fff;
		}

		#thelogin .form-control::placeholder {
			/* Chrome, Firefox, Opera, Safari 10.1+ */
			color: #B8B8B8;
			opacity: 1;
			/* Firefox */
		}

		#thelogin .form-control:-ms-input-placeholder {
			/* Internet Explorer 10-11 */
			color: #B8B8B8;
		}

		#thelogin .form-control::-ms-input-placeholder {
			/* Microsoft Edge */
			color: #B8B8B8;
		}

		i {
			color: #8C8C8C !important;
		}

		img.img_tiger {
			transform: rotateY(178deg) rotateZ(10deg);
		}

		#thelogin .panel-login form .form-group {
			margin-bottom: 20px;
		}

		#thelogin .btn:not(.passwordtoggler) {
			margin-top: 20px;
		}

		.btn-login {
			background: #0F9B55 !important;
			font-style: normal;
			font-weight: 600;
			font-size: 16px !important;
			line-height: 20px;
			color: #fff;
		}

		@media screen and (max-width: 900px) and (min-width: 700px) {
			.title-2023 img {
				width: 80%;
			}

			.cat {
				display: none;
			}
		}

		@media screen and (max-width: 48em) {
			.title-2023 img {
				width: 100%;
				padding-top: 100px;
			}

			.cat {
				display: none;
			}
		}
	</style>
</body>

</html>