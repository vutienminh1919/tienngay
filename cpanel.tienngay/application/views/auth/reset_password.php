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
  <link href="<?php echo base_url();?>assets/build/css/font-awesome.min.css" rel="stylesheet" >

  <!-- Custom Theme Style -->
  <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/build/css/teacup.css" rel="stylesheet">


  <!-- jQuery -->
  <script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>

<body class="nav-md">
  <div id="thelogin" class="container body">
    <div class="main_container">
      <div class="container" style="max-width: 1170px">
        <div class="row flex">
          <div class="col-lg-12 text-center">
            <img src="<?php echo base_url();?>assets/imgs/logopawn.png" alt="">
          </div>
        </div>
        <div class="row flex">
          <div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
            <div class="panel panel-default panel-login">
              <div class="panel-heading">Nhập mật khẩu mới</div>

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
              <form action="<?= base_url('auth/new_pass') ?>" method="post">
                <div class="form-group">
                  <i class="fa fa-lock"></i>
                  <input id="thepasswords1" name="new_password" type="password" class="form-control" placeholder="Nhập mật khẩu mới">
                  <button type="button" class="btn btn-link passwordtoggler passwordtoggler1">
                    <i class='fa fa-eye-slash fa-5x'></i>
                  </button>
                </div>
                <div class="form-group" >
                  <i class="fa fa-lock"></i>
                  <input id="thepasswords2" name="re_password" type="password" class="form-control" placeholder="Nhập lại mật khẩu mới">
                  <button type="button" class="btn btn-link passwordtoggler passwordtoggler2">
                    <i class='fa fa-eye-slash fa-5x'></i>
                  </button>
                </div>
				  <input type="hidden" name="token_pass" value="<?= $token ?>"/>
                <script>
                  $('.passwordtoggler1').click(function(event) {
                    var x = document.getElementById("thepasswords1");
                    // event.preventDefault();
                    if (x.type === "password") {
                      x.type = "text";
                    } else {
                      x.type = "password";
                    }
                    $(this).children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
                  });
                  $('.passwordtoggler2').click(function(event) {
                    var x = document.getElementById("thepasswords2");
                    // event.preventDefault();
                    if (x.type === "password") {
                      x.type = "text";
                    } else {
                      x.type = "password";
                    }
                    $(this).children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
                  });
                </script>

                <button type="submit" class="btn btn-login">Thay đổi mật khẩu</button>
              </form>
            </div>
          </div>

          <div class="col-xs-12 copyrights">

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
</body>
</html>
