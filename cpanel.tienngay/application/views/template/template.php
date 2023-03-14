<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= !empty($pageName) ? $pageName : ""?></title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
  <!-- NProgress -->
  <link href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- bootstrap-daterangepicker -->
  <link href="<?php echo base_url();?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/build/css/teacup.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/build/css/styles.css" rel="stylesheet">

  <!-- Datatables -->
  <link href="<?php echo base_url();?>/assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/js/selectize/css/selectize.bootstrap3.css">

  <link rel="shortcut icon" href="<?= base_url()?>/assets/home/images/favicon.png" />
  <!-- jQuery -->
  <script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>assets/teacupplugin/simpleUpload.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url();?>assets/vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="<?php echo base_url();?>assets/vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="<?php echo base_url();?>assets/vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- jQuery Sparklines -->
  <script src="<?php echo base_url();?>assets/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- Flot -->
  <script src="<?php echo base_url();?>assets/vendors/Flot/jquery.flot.js"></script>
  <script src="<?php echo base_url();?>assets/vendors/Flot/jquery.flot.pie.js"></script>
  <script src="<?php echo base_url();?>assets/vendors/Flot/jquery.flot.time.js"></script>
  <script src="<?php echo base_url();?>assets/vendors/Flot/jquery.flot.stack.js"></script>
  <script src="<?php echo base_url();?>assets/vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="<?php echo base_url();?>assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="<?php echo base_url();?>assets/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="<?php echo base_url();?>assets/vendors/DateJS/build/date.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="<?php echo base_url();?>assets/vendors/moment/min/moment.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>


  <!-- Datatables -->
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/jszip/dist/jszip.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/pdfmake/build/vfs_fonts.js"></script>

  <!-- bootstrap-datetimepicker -->
  <link href="<?php echo base_url();?>/assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
  <script src="<?php echo base_url();?>/assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/selectize/js/standalone/selectize.js"></script>
  <script>
  window._url = {
    base_url: "<?= base_url()?>",
    process_create_menu: "<?= base_url("menu/create")?>",
    process_update_menu: "<?= base_url("menu/update")?>",
    process_delete_menu: "<?= base_url("menu/delete")?>",
    get_user_in_role: "<?= base_url("role/getUser")?>",
    get_store_in_role: "<?= base_url("role/getStore")?>",
    get_menu_in_role: "<?= base_url("role/getMenu")?>",
    get_access_right_in_role: "<?= base_url("role/getAccessRight")?>",
    process_create_role: "<?= base_url("role/create")?>",
    process_update_role: "<?= base_url("role/update")?>",
    process_search_role: "<?= base_url("role/search")?>",
    process_delete_role: "<?= base_url("role/delete")?>",
    process_create_depre: "<?= base_url("depreciationProperty/create")?>",
    process_delete_depre: "<?= base_url("depreciationProperty/delete")?>",
    process_update_depre: "<?= base_url("depreciationProperty/update")?>",
    process_update_lead: "<?= base_url("lead/update")?>",
    process_create_access_right: "<?= base_url("accessRight/create")?>",
    process_update_access_right: "<?= base_url("accessRight/update")?>",
    process_delete_access_right: "<?= base_url("accessRight/delete")?>",
    display_create_contract: "<?= base_url("pawn/createContract")?>"
  }
  </script>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php $this->load->view('template/left', (isset($data))?$data:NULL); ?>
      <?php $this->load->view('template/header', (isset($data))?$data:NULL); ?>
      <?php $this->load->view($template, (isset($data))?$data:NULL); ?>
      <?php $this->load->view('template/footer', (isset($data))?$data:NULL); ?>
      <?php $this->load->view('page/modal/success');?>
      <?php $this->load->view('page/modal/error');?>
    </div>
  </div>

  <?php $this->load->view('template/calling');?>

  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url();?>assets/build/js/custom.js"></script>
  <script src="<?php echo base_url();?>assets/build/js/dashboard.js"></script>
</body>
</html>
