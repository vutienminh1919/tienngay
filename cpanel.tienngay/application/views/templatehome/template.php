
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pawn</title>
  <!-- plugins:css -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap&subset=vietnamese" rel="stylesheet">

  <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css" >
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" >
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/home/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/home/css/wysiwyg.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/home/teacupHome.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url();?>assets/home/images/favicon.png" />

  <!-- Header JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>


</head>

<body>
  <div class="container-scroller landing-page">
    <?php $this->load->view('/templatehome/header', (isset($data))?$data:NULL); ?>
    <?php $this->load->view($template, (isset($data))?$data:NULL); ?>
    <?php $this->load->view('/templatehome/footer', (isset($data))?$data:NULL); ?>

    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <script src="<?php echo base_url();?>assets/home/js/off-canvas.js"></script>
  <script src="<?php echo base_url();?>assets/home/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url();?>assets/home/js/misc.js"></script>
  <script src="<?php echo base_url();?>assets/home/js/settings.js"></script>
  <script src="<?php echo base_url();?>assets/home/js/todolist.js"></script>

</body>

</html>
