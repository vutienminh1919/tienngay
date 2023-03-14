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
<canvas id="canvas" width="100%" height="100%"></canvas>
<div class="vien vientoplef">
	<img src="<?php echo base_url(); ?>assets/build/images/vien.png" alt="bangtrung"/>
</div>
<div class="vien vientopright">
	<img src="<?php echo base_url(); ?>assets/build/images/vien.png" alt="bangtrung"/>
</div>
<div class="vien vienbottomright">
	<img src="<?php echo base_url(); ?>assets/build/images/vien.png" alt="bangtrung"/>
</div>
<div class="vien vienbottomleft">
	<img src="<?php echo base_url(); ?>assets/build/images/vien.png" alt="bangtrung"/>
</div>

<div id="thelogin" class="container body">
	<div id="particles-js" class="main_container">
		<div class="container">
			
			<div class="row flex">
				<div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
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
							<button type="submit" class="btn btn-login">Tết Đoàn Viên</button>
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

	#canvas {
		position: absolute;
		z-index: 0;
	}

	#thelogin {
		background: url('./assets/build/images/trungthu.svg') no-repeat;
		overflow: hidden;
		background-size: cover;
	}

	.banhtrung {
		position: absolute;
		bottom: 100px;
		left: 100px;
		width: 400px;
	}

	.banhtrungnho {
		position: absolute;
		right: 370px;
		bottom: 50px;
	}

	.hoadao {
		position: absolute;
		right: 0;
		bottom: 0;
		width: 820px;
		text-align: right;
	}

	.countdown {
		display: flex;
		position: absolute;
		top: 0;
		bottom: 0;
		margin: auto;
		align-items: center;
		left: 50px;
	}

	.countdown div {
		position: relative;
		width: 100px;
		height: 100px;
		line-height: 100px;
		text-align: center;
		background: #138e47;
		border-radius: 50px;
		color: #fff;
		margin: 0 15px;
		font-size: 3em;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.12),
		0 2px 2px rgba(0, 0, 0, 0.12),
		0 4px 4px rgba(0, 0, 0, 0.12),
		0 8px 8px rgba(0, 0, 0, 0.12),
		0 16px 16px rgba(0, 0, 0, 0.12);
	}

	.countdown div:before {
		content: "";
		position: absolute;
		bottom: -30px;
		left: 0;
		width: 100%;
		height: 50px;
		background: #ec1e24;
		color: #dddddd;
		font-size: 0.35em;
		line-height: 50px;
		border-radius: 10px;
	}

	.countdown #day:before {
		content: 'Ngày';
	}

	.countdown #hour:before {
		content: 'Giờ';
	}

	.countdown #minute:before {
		content: 'Phút';
	}

	.countdown #second:before {
		content: 'Giây';
	}

	#thelogin .panel-login {
		position: relative;
		z-index: 9999;
		/* background: url('./assets/build/images/canhdao.png') #fff no-repeat; */
		background-size: cover;
		background-position: right;
	}

	.vien {
		position: absolute;
		width: 200px;
		z-index: 9	;
	}

	.vientoplef {
		transform: rotate(90deg);
	}

	.vientopright {
		right: 0;
		transform: rotate(180deg);
	}

	.vienbottomleft {
		transform: rotate(0deg);
		bottom: 0;
		left: 0;
	}

	.vienbottomright {
		transform: rotate(-90deg);
		bottom: 0;
		right: 0;
	}
</style>
<script type="text/javascript">
	/*Lấy thời gian tết âm lịch (mily giây)*/
	var tetAmLich = new Date(2022, 1, 1, 0, 0, 0).getTime();

	function newYear() {
		/*Lấy thời gian ngày hiện tại (mily giây) */
		var ngayHienTai = new Date().getTime();

		/*Tính thời gian còn lại (mily giây) */
		thoigianConLai = tetAmLich - ngayHienTai;

		/*Chuyển đơn vị thời gian tương ứng sang mili giây*/
		var giay = 1000;
		var phut = giay * 60;
		var gio = phut * 60;
		var ngay = gio * 24;

		/*Tìm ra thời gian theo ngày, giờ, phút giây còn lại thông qua cách chia lấy dư(%) và làm tròn số(Math.floor) trong Javascript*/
		var d = Math.floor(thoigianConLai / (ngay));
		var h = Math.floor((thoigianConLai % (ngay)) / (gio));
		var m = Math.floor((thoigianConLai % (gio)) / (phut));
		var s = Math.floor((thoigianConLai % (phut)) / (giay));

		/*Hiển thị kết quả ra các thẻ Div với ID tương ứng*/
		if (thoigianConLai > 0) {
			document.getElementById("day").innerText = d;
			document.getElementById("hour").innerText = h;
			document.getElementById("minute").innerText = m;
			document.getElementById("second").innerText = s;
		} else {
			document.getElementById("headline").innerText = "It's my birthday!";
			document.getElementById("countdown").style.display = "none";
			document.getElementById("content").style.display = "block";
		}

	}

	/*Thiết Lập hàm sẽ tự động chạy lại sau 1s*/
	setInterval(function () {
		newYear()
	}, 1000)
	// when animating on canvas, it is best to use requestAnimationFrame instead of setTimeout or setInterval
	// not supported in all browsers though and sometimes needs a prefix, so we need a shim
	window.requestAnimFrame = (function () {
		return window.requestAnimationFrame ||
				window.webkitRequestAnimationFrame ||
				window.mozRequestAnimationFrame ||
				function (callback) {
					window.setTimeout(callback, 1000 / 60);
				};
	})();

	// now we will setup our basic variables for the demo
	var canvas = document.getElementById('canvas'),
			ctx = canvas.getContext('2d'),
			// full screen dimensions
			cw = window.innerWidth,
			ch = window.innerHeight,
			// firework collection
			fireworks = [],
			// particle collection
			particles = [],
			// starting hue
			hue = 120,
			// when launching fireworks with a click, too many get launched at once without a limiter, one launch per 5 loop ticks
			limiterTotal = 20,
			limiterTick = 0,
			// this will time the auto launches of fireworks, one launch per 80 loop ticks
			timerTotal = 500,
			timerTick = 0,
			mousedown = false,
			// mouse x coordinate,
			mx,
			// mouse y coordinate
			my;


	// set canvas dimensions
	canvas.width = cw;
	canvas.height = ch;

	// now we are going to setup our function placeholders for the entire demo

	// get a random number within a range
	function random(min, max) {
		return Math.random() * (max - min) + min;
	}

	// calculate the distance between two points
	function calculateDistance(p1x, p1y, p2x, p2y) {
		var xDistance = p1x - p2x,
				yDistance = p1y - p2y;
		return Math.sqrt(Math.pow(xDistance, 2) + Math.pow(yDistance, 2));
	}

	// create firework
	function Firework(sx, sy, tx, ty) {
		// actual coordinates
		this.x = sx;
		this.y = sy;
		// starting coordinates
		this.sx = sx;
		this.sy = sy;
		// target coordinates
		this.tx = tx;
		this.ty = ty;
		// distance from starting point to target
		this.distanceToTarget = calculateDistance(sx, sy, tx, ty);
		this.distanceTraveled = 0;
		// track the past coordinates of each firework to create a trail effect, increase the coordinate count to create more prominent trails
		this.coordinates = [];
		this.coordinateCount = 3;
		// populate initial coordinate collection with the current coordinates
		while (this.coordinateCount--) {
			this.coordinates.push([this.x, this.y]);
		}
		this.angle = Math.atan2(ty - sy, tx - sx);
		this.speed = 2;
		this.acceleration = 1.05;
		this.brightness = random(50, 70);
		// circle target indicator radius
		this.targetRadius = 1;
	}

	// update firework
	Firework.prototype.update = function (index) {
		// remove last item in coordinates array
		this.coordinates.pop();
		// add current coordinates to the start of the array
		this.coordinates.unshift([this.x, this.y]);

		// cycle the circle target indicator radius
		if (this.targetRadius < 8) {
			this.targetRadius += 0.3;
		} else {
			this.targetRadius = 1;
		}

		// speed up the firework
		this.speed *= this.acceleration;

		// get the current velocities based on angle and speed
		var vx = Math.cos(this.angle) * this.speed,
				vy = Math.sin(this.angle) * this.speed;
		// how far will the firework have traveled with velocities applied?
		this.distanceTraveled = calculateDistance(this.sx, this.sy, this.x + vx, this.y + vy);

		// if the distance traveled, including velocities, is greater than the initial distance to the target, then the target has been reached
		if (this.distanceTraveled >= this.distanceToTarget) {
			createParticles(this.tx, this.ty);
			// remove the firework, use the index passed into the update function to determine which to remove
			fireworks.splice(index, 1);
		} else {
			// target not reached, keep traveling
			this.x += vx;
			this.y += vy;
		}
	}

	// draw firework
	Firework.prototype.draw = function () {
		ctx.beginPath();
		// move to the last tracked coordinate in the set, then draw a line to the current x and y
		ctx.moveTo(this.coordinates[this.coordinates.length - 1][0], this.coordinates[this.coordinates.length - 1][1]);
		ctx.lineTo(this.x, this.y);
		ctx.strokeStyle = 'hsl(' + hue + ', 100%, ' + this.brightness + '%)';
		ctx.stroke();

		ctx.beginPath();
		// draw the target for this firework with a pulsing circle
		//ctx.arc( this.tx, this.ty, this.targetRadius, 0, Math.PI * 2 );
		ctx.stroke();
	}

	// create particle
	function Particle(x, y) {
		this.x = x;
		this.y = y;
		// track the past coordinates of each particle to create a trail effect, increase the coordinate count to create more prominent trails
		this.coordinates = [];
		this.coordinateCount = 5;

		while (this.coordinateCount--) {
			this.coordinates.push([this.x, this.y]);
		}
		// set a random angle in all possible directions, in radians
		this.angle = random(0, Math.PI * 2);
		this.speed = random(1, 10);
		// friction will slow the particle down
		this.friction = 0.95;
		// gravity will be applied and pull the particle down
		this.gravity = 0.6;
		// set the hue to a random number +-20 of the overall hue variable
		this.hue = random(hue - 20, hue + 20);
		this.brightness = random(50, 80);
		this.alpha = 1;
		// set how fast the particle fades out
		this.decay = random(0.0075, 0.009);
	}

	// update particle
	Particle.prototype.update = function (index) {
		// remove last item in coordinates array
		this.coordinates.pop();
		// add current coordinates to the start of the array
		this.coordinates.unshift([this.x, this.y]);
		// slow down the particle
		this.speed *= this.friction;
		// apply velocity
		this.x += Math.cos(this.angle) * this.speed;
		this.y += Math.sin(this.angle) * this.speed + this.gravity;
		// fade out the particle
		this.alpha -= this.decay;

		// remove the particle once the alpha is low enough, based on the passed in index
		if (this.alpha <= this.decay) {
			particles.splice(index, 1);
		}
	}

	// draw particle
	Particle.prototype.draw = function () {
		ctx.beginPath();
		// move to the last tracked coordinates in the set, then draw a line to the current x and y
		ctx.moveTo(this.coordinates[this.coordinates.length - 1][0], this.coordinates[this.coordinates.length - 1][1]);
		ctx.lineTo(this.x, this.y);
		ctx.strokeStyle = 'hsla(' + this.hue + ', 100%, ' + this.brightness + '%, ' + this.alpha + ')';

		ctx.stroke();
	}

	// create particle group/explosion
	function createParticles(x, y) {
		// increase the particle count for a bigger explosion, beware of the canvas performance hit with the increased particles though
		var particleCount = 20;
		while (particleCount--) {
			particles.push(new Particle(x, y));
		}
	}


	// main demo loop
	function loop() {
		// this function will run endlessly with requestAnimationFrame
		requestAnimFrame(loop);

		// increase the hue to get different colored fireworks over time
		hue += 0.5;

		// normally, clearRect() would be used to clear the canvas
		// we want to create a trailing effect though
		// setting the composite operation to destination-out will allow us to clear the canvas at a specific opacity, rather than wiping it entirely
		ctx.globalCompositeOperation = 'destination-out';
		// decrease the alpha property to create more prominent trails
		ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
		ctx.fillRect(0, 0, cw, ch);
		// change the composite operation back to our main mode
		// lighter creates bright highlight points as the fireworks and particles overlap each other
		ctx.globalCompositeOperation = 'lighter';

		// loop over each firework, draw it, update it
		var i = fireworks.length;
		while (i--) {
			fireworks[i].draw();
			fireworks[i].update(i);
		}

		// loop over each particle, draw it, update it
		var i = particles.length;
		while (i--) {
			particles[i].draw();
			particles[i].update(i);

		}


		// launch fireworks automatically to random coordinates, when the mouse isn't down
		if (timerTick >= timerTotal) {
			timerTick = 0;
		} else {
			var temp = timerTick % 400;
			if (temp <= 15) {
				fireworks.push(new Firework(100, ch, random(190, 200), random(90, 100)));
				fireworks.push(new Firework(cw - 100, ch, random(cw - 200, cw - 190), random(90, 100)));
			}

			var temp3 = temp / 10;

			if (temp > 319) {
				fireworks.push(new Firework(300 + (temp3 - 31) * 100, ch, 300 + (temp3 - 31) * 100, 200));
			}

			timerTick++;
		}

		// limit the rate at which fireworks get launched when mouse is down
		if (limiterTick >= limiterTotal) {
			if (mousedown) {
				// start the firework at the bottom middle of the screen, then set the current mouse coordinates as the target
				fireworks.push(new Firework(cw / 2, ch, mx, my));
				limiterTick = 0;
			}
		} else {
			limiterTick++;
		}
	}

	// mouse event bindings
	// update the mouse coordinates on mousemove
	canvas.addEventListener('mousemove', function (e) {
		mx = e.pageX - canvas.offsetLeft;
		my = e.pageY - canvas.offsetTop;
	});

	// toggle mousedown state and prevent canvas from being selected
	canvas.addEventListener('mousedown', function (e) {
		e.preventDefault();
		mousedown = true;
	});

	canvas.addEventListener('mouseup', function (e) {
		e.preventDefault();
		mousedown = false;
	});

	// once the window loads, we are ready for some fireworks!
	window.onload = loop;
</script>
