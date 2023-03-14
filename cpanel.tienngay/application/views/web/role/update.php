<!-- page content -->
<div class="right_col" role="main">
    <div class="row top_tiles">
        <div class="col-xs-12">
            <div class="page-title">
                <h3>Cập nhật phân quyền nhóm
                <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('role/search')?>">Quản lý quyền </a> / <a href="#">Cập nhật phân quyền nhóm </a>
					</small>
                    </h3>
            </div>
        </div>
        <br>&nbsp;
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-xs-12 col-lg-11">
                            <div class="row">
                                <div class="col-lg-3">
                                    <input id="role_id" class="form-control" type="hidden" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
                                    <input id="role_name" class="form-control" type="text" value="<?= !empty($role->name) ? $role->name : ""?>">
                                </div>
                                <div class="col-lg-2 text-right">
                                    <button class="btn btn-primary w-100 btn-update-role"><i class="fa fa-plus" aria-hidden="true"></i> Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_user" id="tab_user_nav" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                        Người dùng</a>
                                    </li>
                                    <li role="presentation" class="">
                                        <a href="#tab_store" role="tab" id="tab_store_nav" data-toggle="tab" aria-controls="profile" aria-expanded="false">
                                        Phòng giao dịch</a>
                                    </li>
                                    <li role="presentation" class="">
                                        <a href="#tab_menu" role="tab" id="tab_menu_nav" data-toggle="tab" aria-controls="profile" aria-expanded="false">
                                        Danh mục</a>
                                    </li>
                                    <li role="presentation" class="">
                                        <a href="#tab_access_right" role="tab" id="tab_right_nav" data-toggle="tab" aria-controls="profile" aria-expanded="false">
                                        Quyền truy cập</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <?php
                                        //echo"<pre>";
                                        //var_dump($role);
                                        //die;
                                    ?>
                                    
                                    <?php $this->load->view("web/role/tab_user", $role)?>
                                    <?php $this->load->view("web/role/tab_store", $role)?>
                                    <?php $this->load->view("web/role/tab_menu", $role)?>
                                    <?php $this->load->view("web/role/tab_access_right", $role)?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/js/role/index.js")?>"></script>
