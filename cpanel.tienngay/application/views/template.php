<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <title><?= !empty($pageName) ? $pageName : ""?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/datepicker/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/datepicker/css/datepicker.css" rel="stylesheet" />

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/build/css/teacup.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/build/css/app.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="<?php echo base_url();?>/assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/selectize/css/selectize.bootstrap3.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/transaction/tree_select/jquery.bootstrap.treeselect.css">


    <link rel="shortcut icon" href="<?= base_url()?>/assets/home/images/favicon.png" />
    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Simple Upload -->
    <script src="<?php echo base_url();?>assets/teacupplugin/simpleUpload.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>assets/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>


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
    <script src="<?php echo base_url();?>/assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<script src="//cdn.jsdelivr.net/npm/jquery.marquee@1.6.0/jquery.marquee.min.js" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <!-- bootstrap-datetimepicker -->
    <link href="<?php echo base_url();?>/assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="<?php echo base_url();?>/assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/selectize/js/standalone/selectize.js"></script>
        <script src="<?php echo base_url();?>assets/js/ckeditor/ckeditor.js"></script>
    <script>
        window._url = {
            base_url: "<?= base_url()?>",
            token_phonenet: "<?= $this->config->item("access_key_phonenet")?>",
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
            display_create_contract: "<?= base_url("pawn/createContract")?>",
            user_search_autocomplete: "<?= base_url("user/searchAutocomplete")?>",
			contract_search_autocomplete: "<?= base_url("pawn/searchAutoCompleteContract")?>",
            process_create_contract: "<?= base_url("pawn/processCreateContract")?>",
            process_update_contract: "<?= base_url("pawn/processUpdateContract")?>",
            contract: "<?= base_url("pawn/contract")?>",
            user_list: "<?= base_url("user")?>",
            process_create_user: "<?= base_url("user/processCreateUser")?>",
            process_update_user: "<?= base_url("user/processUpdateUser")?>",
            process_upload_image: "<?= base_url("pawn/doUploadImage")?>",
            process_contract_delete_image: "<?= base_url("pawn/deleteImage")?>",
            process_change_language: "<?= base_url("auth/changeLanguage")?>",
            getMsg: "<?= base_url("user/getMsg")?>",
            process_create_group_role: "<?= base_url("groupRole/create")?>",
            process_update_group_role: "<?= base_url("groupRole/update")?>",
            process_search_group_role: "<?= base_url("groupRole/search")?>",
            process_delete_group_role: "<?= base_url("groupRole/delete")?>",
            process_upload_banking: "<?= base_url("transaction/doUploadImage")?>",
            process_transaction_delete_image: "<?= base_url("transaction/deleteImage")?>"
        }
    </script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />


</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <?php $this->load->view('left', (isset($data))?$data:NULL); ?>
        <?php $this->load->view('header', (isset($data))?$data:NULL); ?>
        <?php $this->load->view($template, (isset($data))?$data:NULL); ?>
        <?php $this->load->view('footer', (isset($data))?$data:NULL); ?>
        <?php $this->load->view('page/modal/success');?>
        <?php $this->load->view('page/modal/error');?>
    </div>
</div>
    <!-- Custom Theme Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/build/js/custom.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/build/js/custom.js"></script>
    <script src="<?php echo base_url();?>assets/js/app.js"></script>
    <script src="<?php echo base_url();?>assets/js/app.js"></script>
    <script src="<?php echo base_url();?>assets/js/helper/contract_helper.js"></script>
    <script src="<?php echo base_url();?>assets/build/js/dashboard.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-messaging.js"></script>
<script src="<?php echo base_url();?>assets/js/firebase/firebase.js"></script>
</body>
</html>
