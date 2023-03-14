<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Thiết lập nhóm quyền
                <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Thiết lập nhóm quyền</a> 
					</small>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?= base_url("groupRole/displayCreate")?>">Thêm mới group role</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width: 17%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($groupRoles->data as $role) { ?>
                                    <tr>
                                        <td><?= !empty($role->name) ? $role->name : ""?></td>
                                        <td class="text-right">
                                            <button class="btn btn-primary"  onclick="window.location.href='<?= base_url("groupRole/displayUpdate?id=").getId($role->_id)?>'">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger mr-0 btn-delete" data-id="<?= getId($role->_id)?>">
                                                <i class="fa fa-close"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets")?>/js/group_role/search.js"></script>