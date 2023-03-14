<div role="tabpanel" class="tab-pane fade" id="tab_access_right" aria-labelledby="profile-tab">
    <div class="x_panel">
        <div class="x_title">
            <h2>Chọn quyền truy cập</h2>
            <ul class="nav navbar-right panel_toolbox" style="min-width: initial;">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cogs"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" onclick="showModalAccessRight(this)">Thêm mới</a></li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table" id="tbl_access_right">
                <thead>
                    <tr>
                        <th>Quyền truy cập</th>
                        <th>Slug</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($role->access_rights) && count($role->access_rights) > 0) {
                            foreach($role->access_rights as $item) {
                                $key = key((array)$item);
                                $value = $item->$key;
                    ?>
                                <tr>
                                    <input type='hidden' id='name' value='<?= $value->name?>'>
                                    <input type='hidden' id='slug' value='<?= $value->slug?>'>
                                    <input type='hidden' id='access_right_id' value='<?= $key?>'>
                                    <td><?= $value->name?></td>
                                    <td><?= $value->slug?></td>
                                    <td><a onclick='remove(this)' class='close-link' data-user-id='<?= $key?>'><i class='fa fa-close'></i></a></td>
                                </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--Start modal-->
<div class="modal fade" id="modal_select_access_right" tabindex="-1" role="dialog" aria-labelledby="addNewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm mới</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal form-label-left">
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="tbl_modal_access_right" class="table table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Quyền truy cập</th>
                                        <th>Slug</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger"  data-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i> Hủy
                </button>
                <button type="button" onclick="saveModalAccessRight(this)" class="btn btn-success">
                    <i class="fa fa-save" aria-hidden="true"></i> Lưu lại
                </button>
            </div>
        </div>
    </div>
</div>
