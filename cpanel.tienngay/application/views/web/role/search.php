<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Quản lý quyền
                    <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Quản lý quyền</a>
					</small>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <a class="btn btn-primary w-100" href="<?= base_url("role/displayCreate")?>">Thêm mới quyền</a>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th style="width: 17%;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roles->data)) {
                                	
								 foreach($roles->data as $role) { ?>
                                    <tr>
                                        <td><?= !empty($role->name) ? $role->name : ""?></td>
                                        <td class="text-right">
                                            <button class="btn btn-primary"  onclick="window.location.href='<?= base_url("role/displayUpdate?id=").getId($role->_id)?>'">
                                                <i class="fa fa-edit"></i> Sửa
                                            </button>
                                            <button class="btn btn-danger mr-0 btn-delete" data-id="<?= getId($role->_id)?>">
                                                <i class="fa fa-close"></i> Xóa
                                            </button>
                                        </td>
                                    </tr>
                                <?php }}?>
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets")?>/js/role/search.js"></script>
