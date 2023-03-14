<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Quản lý khấu hao tài sản
                <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Quản lý khấu hao tài sản</a>
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
                                    <li><a href="#" data-toggle="modal" data-target="#createModal">Thêm mới loại khấu hao</a></li>
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
                                <?php if(!empty($datas)) { foreach($datas as $item) { ?>
                                    <tr>
                                        <td><?= !empty($item->name) ? $item->name : ""?></td>
                                        <td class="text-right">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal_<?= getId($item->_id)?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger mr-0 btn-delete" data-id="<?= getId($item->_id)?>">
                                                <i class="fa fa-close"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php }}?>
                            </tbody>
                          </table>
                            <?php if(!empty($datas)) { foreach($datas as $item) { ?>
                                <!--Start model edit-->
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

                                                        <select class="form-control" id="property_id_<?= getId($item->_id)?>" >

                                                            <?php 
                                                                if(!empty($mainPropertyData)) {
                                                                    foreach($mainPropertyData as $key => $value){
                                                            ?>
                                                                <option <?php if($value->_id->{'$oid'} ==  $item->property_id) echo "selected"?> value="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>"><?= !empty($value->name) ? $value->name : "" ?></option>
                                                            <?php }}?>
                                                        </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-close"></i> Cancel</button>
                                                    <button type="button" class="btn btn-primary btn-edit-modal"><i class="fa fa-save"></i> Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End model edit-->
                            <?php }}?>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input id="name_modal" class="form-control" >
                </div>
                <div class="form-group">
                    <label>Loại tài sản cha</label>
                    <select class="form-control" id="property_id" >

                        <?php 
                            if(!empty($mainPropertyData)) {
                                foreach($mainPropertyData as $key => $value){
                        ?>
                             <option value="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>"><?= !empty($value->name) ? $value->name : "" ?></option>
                        <?php }}?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-close"></i> Cancel</button>
                <button type="button" class="btn btn-primary btn-save-modal"><i class="fa fa-save"></i> Create</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url("assets")?>/js/depreciation_property.js"></script>