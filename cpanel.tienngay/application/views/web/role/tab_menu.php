<div role="tabpanel" class="tab-pane fade" id="tab_menu" aria-labelledby="profile-tab">
    <div class="x_panel">
        <div class="x_title">
            <h2>Chọn danh mục</h2>
            <ul class="nav navbar-right panel_toolbox" style="min-width: initial;">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cogs"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" onclick="showModalMenu(this)">Thêm mới</a></li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table" id="tbl_menu">
                <thead>
                    <tr>
                        <th>Danh mục</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($role->menus) && count($role->menus) > 0) {
                            foreach($role->menus as $item) {
                                $key = key((array)$item);
                                $value = $item->$key;
                    ?>
                                <tr>
                                    <input type='hidden' id='name' value='<?= $value->name?>'>
                                    <input type='hidden' id='menu_id' value='<?= $key?>'>
                                    <td><?= $value->name?></td>
                                    <td><a onclick='remove(this)' class='close-link' data-user-id='<?= $key?>'><i class='fa fa-close'></i></a></td>
                                </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--Start modal-->
<div class="modal fade" id="modal_select_menu" tabindex="-1" role="dialog" aria-labelledby="addNewModal">
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
                            <table id="tbl_modal_menu" class="table table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Danh mục</th>
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
                <button type="button" onclick="saveModalMenu(this)" class="btn btn-success">
                    <i class="fa fa-save" aria-hidden="true"></i> Lưu lại
                </button>
            </div>
        </div>
    </div>
</div>
