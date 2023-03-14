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
  <link href="<?php echo base_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

  <!-- Custom Theme Style -->
  <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/build/css/teacup.css" rel="stylesheet">


  <!-- jQuery -->
  <script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>


</head>

<body class="nav-md">
  <div id="thelogin" class="container body">
    <div class="main_container">
      <div class="container" style="max-width: 1170px">
        <div class="row flex">
          <div class="col-lg-12 text-center">
            <img src="https://service.tienngay.vn/uploads/avatar/1672043592-cb31f5364975d66715224ad147a94527.png" alt="">
          </div>
        </div>
        <div class="row flex">
			  <div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
				<div class="panel panel-default panel-login">
				  <div class="panel-heading">Lấy lại mật khẩu</div>
					<?php if ($this->session->flashdata('error')) { ?>
						<div class="alert alert-error alert-dismissible error_notify">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<?= $this->session->flashdata('error') ?>
						</div>
					<?php } ?>
					<?php if ($this->session->flashdata('success')) { ?>
						<div class="alert alert-success alert-dismissible success_notify">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<?= $this->session->flashdata('success') ?>
						</div>
					<?php } ?>
					<form action="<?= base_url('auth/forgot_pass') ?>" method="post">
						<div class="form-group" style="margin-bottom:12px;">
							<i class="fa fa-user"></i>
							<input type="email" name="email_forgot" class="form-control" placeholder="Email"/>
						</div>
						<div class="form-group">
							<p class="thelinks">
								<span>Got password ? <a href="<?php base_url('user')?>">Login</a> </span>
							</p>
						</div>
						<button type="submit" class="btn btn-login">Xác nhận</button>
					</form>
				</div>
			  </div>

          <div class="col-xs-12 copyrights">

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
