<!-- page content -->
<div class="right_col" role="main">
   
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title">
                <h3>Danh mục quyền truy cập
                <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh mục quyền truy cập</a> 
					</small>
                </h3>
            </div>
        </div>
        <br>&nbsp;
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Thêm mới access right</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input id="name_menu" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Descriptions</label>
                                    <textarea id="description" rows="8" class="form-control"></textarea>
                                </div>
                                <button type="button" class="btn btn-primary btn-add">Thêm mới</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-8">
                    <div class="x_panel">
                        <div class="x_content">
                            <table id="datatable-buttons" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Descriptions</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($access_right as $item) { ?>
                                        <tr>
                                            <td><?= !empty($item->name) ? $item->name : ""?></td>
                                            <td><?= !empty($item->description) ? $item->description : ""?></td>
                                            <td class="text-right">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#editModal_<?= getId($item->_id)?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-danger mr-0 btn-delete" onclick="btnDelete(this)" data-id="<?= getId($item->_id)?>">
                                                    <i class="fa fa-close"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <?php foreach($access_right as $item) {?>
                                <div id="editModal_<?= getId($item->_id)?>" class="modal fade" role="dialog" name="div-modal">
                                    <input type="hidden" name="id" value="<?= getId($item->_id)?>"/>
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit</h4>
                                            </div>
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input name="name_modal" value="<?= $item->name?>" class="form-control" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Slug</label>
                                                        <input value="<?= $item->slug?>" readonly="readonly" class="form-control" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Descriptions</label>
                                                        <textarea name="description_modal" rows="8" class="form-control"><?= !empty($item->description) ? $item->description : ""?></textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-close"></i> Cancel</button>
                                                <button type="button" class="btn btn-primary btn-save-modal"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/js/access_right/index.js")?>"></script>