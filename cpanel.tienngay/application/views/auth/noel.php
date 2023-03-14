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

<body class="nav-md">
<div id="thelogin" class="container body">
	<div id="particles-js" class="main_container">
		<div class="container" style="max-width: 1170px">
			<div class="item_gift item_gift1">
				<img src="<?php echo base_url(); ?>assets/build/images/hopqua.png" alt="huou"/>
			</div>
			<div class="item_gift item_gift2">
				<img src="<?php echo base_url(); ?>assets/build/images/giay.png" alt="huou"/>
			</div>
			<div class="item_gift item_gif3">
				<img src="<?php echo base_url(); ?>assets/build/images/hopqua.png" alt="huou"/>
			</div>
			<div class="item_gift item_gift4">
				<img src="<?php echo base_url(); ?>assets/build/images/hopqua.png" alt="huou"/>
			</div>
			<div class="item_gift item_gift5">
				<img src="<?php echo base_url(); ?>assets/build/images/giay.png" alt="huou"/>
			</div>
			<div class="item_gift item_gif6">
				<img src="<?php echo base_url(); ?>assets/build/images/hopqua.png" alt="huou"/>
			</div>
			<div class="caythong caythongtrai">
				<img src="<?php echo base_url(); ?>assets/build/images/caythong.png" alt="huou"/>
			</div>

			<div class="caythong caythongphai">
				<img src="<?php echo base_url(); ?>assets/build/images/caythong.png" alt="huou"/>
			</div>
			<div class="row flex">
				<div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
					<div class="ongianoel">
						<img src="<?php echo base_url(); ?>assets/build/images/onggianoel.png" alt="noel"/>
					</div>
					<div class="deer">
						<img src="<?php echo base_url(); ?>assets/build/images/huou.png" alt="huou"/>
					</div>
					<div class="panel panel-default panel-login">

						<img style="width: auto; margin: 0 auto 30px;display: block"
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
							<button type="submit" class="btn btn-login">Login</button>
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
<style>
	canvas {
		position: absolute;
		z-index: -1;
	}
	body{
		overflow: hidden;
	}
	#thelogin {
		background: url('./assets/build/images/background.png') no-repeat;
		overflow: hidden;
		background-size: cover;
	}

	.caythong {
		position: fixed;
		bottom: 35px;

	}

	.caythongtrai {
		left: 35px;
	}

	.caythongphai {
		right: 35px;
	}

	.ongianoel {
		position: absolute;
		top: -135px;
		right: 0;
	}

	.deer {
		position: absolute;
		left: -120px;
		z-index: 0;
		bottom: 40%;
	}

	#thelogin .panel-login {
		position: relative;
	}

	.item_gift {
		position: absolute;
		top: 0;
		z-index: 9999;
		cursor: pointer;
		-webkit-transform-origin: 50% 0;
		-moz-transform-origin: 50% 0;
		-o-transform-origin: 50% 0;
		transform-origin: 50% 0;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out;
		animation: bounce 5s infinite alternate;
	}
	@keyframes bounce {
	0%{
		-webkit-transform: rotate(9deg);
		-moz-transform: rotate(9deg);
		-o-transform: rotate(9deg);
		transform: rotate(9deg);
	}
	50%{
		-webkit-transform:rotate(-18deg); -moz-transform:rotate(-18deg); -o-transform:rotate(-18deg); transform:rotate(-18deg);
	}
	100%{
		-webkit-transform:rotate(18deg); -moz-transform:rotate(18deg); -o-transform:rotate(18deg); transform:rotate(18deg);
	}
	}

	.item_gift1 {
		left: 40px;
	}

	.item_gift2 {
		left: 250px;
	}

	.item_gif3 {
		left: 400px;
		top: -100px;
	}

	.item_gift4 {
		right: 20px;
	}

	.item_gift5 {
		right: 250px;
	}

	.item_gif6 {
		right: 350px;
		top: -100px;
	}
</style>
<script type="text/javascript">
	document.write('<img style="position:fixed;z-index:9999;top:0;left:0" src="<?php echo base_url(); ?>assets/build/images/topleft.png"/><img style="position:fixed;z-index:9999;top:0;right:0" src="<?php echo base_url(); ?>assets/build/images/topright.png"/><div style="position:fixed;z-index:9999;bottom:-50px;left:0;width:100%;height:104px;background:url(<?php echo base_url(); ?>assets/build/images/footer-christmas.png) repeat-x bottom left;"></div><img style="position:fixed;z-index:9999;bottom:20px;left:20px" src="<?php echo base_url(); ?>assets/build/images/bottomleft.png"/>');
	var no = 100;
	var hidesnowtime = 0;
	var snowdistance = 'pageheight';
	var ie4up = (document.all) ? 1 : 0;
	var ns6up = (document.getElementById && !document.all) ? 1 : 0;

	function iecompattest() {
		return (document.compatMode && document.compatMode != 'BackCompat') ? document.documentElement : document.body
	}

	var dx, xp, yp;
	var am, stx, sty;
	var i, doc_width = 800,
		doc_height = 600;
	if (ns6up) {
		doc_width = self.innerWidth;
		doc_height = self.innerHeight
	} else if (ie4up) {
		doc_width = iecompattest().clientWidth;
		doc_height = iecompattest().clientHeight
	}
	dx = new Array();
	xp = new Array();
	yp = new Array();
	am = new Array();
	stx = new Array();
	sty = new Array();
	for (i = 0; i < no; ++i) {
		dx[i] = 0;
		xp[i] = Math.random() * (doc_width - 50);
		yp[i] = Math.random() * doc_height;
		am[i] = Math.random() * 20;
		stx[i] = 0.02 + Math.random() / 10;
		sty[i] = 0.7 + Math.random();
		if (ie4up || ns6up) {
			document.write('<div id="dot' + i + '" style="POSITION:absolute;Z-INDEX:' + i + ';VISIBILITY:visible;TOP:15px;LEFT:15px;"><span style="font-size:18px;color:#fff">*</span></div>')
		}
	}

	function snowIE_NS6() {
		doc_width = ns6up ? window.innerWidth - 10 : iecompattest().clientWidth - 10;
		doc_height = (window.innerHeight && snowdistance == 'windowheight') ? window.innerHeight : (ie4up && snowdistance == 'windowheight') ? iecompattest().clientHeight : (ie4up && !window.opera && snowdistance == 'pageheight') ? iecompattest().scrollHeight : iecompattest().offsetHeight;
		for (i = 0; i < no; ++i) {
			yp[i] += sty[i];
			if (yp[i] > doc_height - 50) {
				xp[i] = Math.random() * (doc_width - am[i] - 30);
				yp[i] = 0;
				stx[i] = 0.02 + Math.random() / 10;
				sty[i] = 0.7 + Math.random()
			}
			dx[i] += stx[i];
			document.getElementById('dot' + i).style.top = yp[i] + 'px';
			document.getElementById('dot' + i).style.left = xp[i] + am[i] * Math.sin(dx[i]) + 'px'
		}
		snowtimer = setTimeout('snowIE_NS6()', 10)
	}

	function hidesnow() {
		if (window.snowtimer) {
			clearTimeout(snowtimer)
		}
		for (i = 0; i < no; i++) document.getElementById('dot' + i).style.visibility = 'hidden'
	}

	if (ie4up || ns6up) {
		snowIE_NS6();
		if (hidesnowtime > 0) setTimeout('hidesnow()', hidesnowtime * 1000)
	}
</script>
</body>
</html>
