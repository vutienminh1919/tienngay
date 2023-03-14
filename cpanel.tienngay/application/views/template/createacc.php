<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Gentelella Alela! | </title>

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
            <img src="<?php echo base_url();?>assets/imgs/logopawn.png" alt="">
          </div>
        </div>
        <div class="row flex">
          <div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
            <div class="panel panel-default panel-login">
              <div class="panel-heading">Create Account</div>
              <form>
                <div class="form-group" >
                  <i class="fa fa-user"></i>
                  <input type="text" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                  <i class="fa fa-lock"></i>
                  <input id="thepasswords1" type="password" class="form-control" placeholder="Password">
                  <button type="button" class="btn btn-link passwordtoggler showpasswords1">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
                <div class="form-group"  style="margin-bottom:12px;">
                  <i class="fa fa-lock"></i>
                  <input id="thepasswords2" type="password" class="form-control" placeholder="Password">
                  <button type="button" class="btn btn-link passwordtoggler showpasswords2">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
                <div class="form-group">
                  <p class="thelinks">
                    <span class="float-right">Already a member ? <a href="#">Log in </a>  </span>
                  </p>
                </div>

                <button type="submit" class="btn btn-register">Submit</button>
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
  $('.showpasswords1').click(function(event) {
    var x = document.getElementById("thepasswords1");
    // event.preventDefault();
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
    $('.showpasswords1').children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
  });

  $('.showpasswords2').click(function(event) {
    var x = document.getElementById("thepasswords2");
    // event.preventDefault();
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
    $('.showpasswords2').children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
  });

</script>
</body>
</html>
