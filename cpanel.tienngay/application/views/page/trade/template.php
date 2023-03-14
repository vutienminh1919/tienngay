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

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/build/css/teacup.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/build/css/app.css" rel="stylesheet">

    <link rel="shortcut icon" href="<?= base_url()?>/assets/home/images/favicon.png" />
    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

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
    <script src="<?php echo base_url();?>assets/build/js/custom.js"></script>
    <script src="<?php echo base_url();?>assets/js/app.js"></script>
</body>
</html>
