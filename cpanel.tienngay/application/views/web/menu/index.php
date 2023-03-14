<!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title">
                <h3>Quản lý danh mục
                     <br>
                    <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Quản lý danh mục</a>
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
                            <h2>Thêm mới</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                <div class="form-group">
                                    <label><i class="fa fa-user"></i> Tên</label>
                                    <input id="name_menu" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-bandcamp"></i> Icon</label>
                                    <input id="icon_menu" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-link"></i> Url</label>
                                    <input id="url" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-folder-open" ></i> Chọn danh mục cha</label>
                                    <select id="parent" class="form-control">
                                        <option value="none">none</option>
                                        <?php

                                            function showCategories($menu, $parent_id = "", $char = "") {
                                                foreach ($menu as $item) {
                                                    if ($item->parent_id == $parent_id) {
                                                        echo '<option value="'.getId($item->_id).'">';
                                                            echo $char . $item->name;
                                                        echo '</option>';
                                                        // Tiếp tục đệ quy để tìm con của item đang lặp
                                                        showCategories($menu, getId($item->_id), $char.' - ');
                                                    }
                                                }
                                            }
                                            showCategories($menu);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-language"></i> Ngôn ngữ</label>
                                    <select id="language" class="form-control">
                                        <option value="vietnamese">VN</option>
                                        <option value="english">EN</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-text-width"></i> Mô tả</label>
                                    <textarea id="description" rows="8" class="form-control"></textarea>
                                </div>
                                <button type="button" class="btn btn-primary btn-add-new-menu w-100"><i class="fa fa-plus"></i> Thêm</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-8">
                    <div class="x_panel">
                        <div class="x_content">
                            <table id="datatable-buttons"  class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Url</th>
                                        <th>Mô tả</th>
                                        <th class="text-right">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        function showCategoriesTable($menu, $parent_id = "", $char = "") {
                                            foreach ($menu as $item) {
                                                if ($item->parent_id == $parent_id) {
                                    ?>
                                                    <tr>
                                                        <td><?= $char.$item->name?></td>
                                                        <td><?= !empty($item->url) ? $item->url : ""?></td>
                                                        <td><?= !empty($item->description) ? $item->description : ""?></td>
                                                        <td class="text-right">
                                                            <button class="btn btn-primary"  data-toggle="modal" data-target="#editModal_<?= getId($item->_id)?>">
                                                                <i class="fa fa-edit"></i> Sửa
                                                            </button>
                                                            <button class="btn btn-danger mr-0 btn-delete" data-id="<?= getId($item->_id)?>">
                                                                <i class="fa fa-close"></i> Xóa
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!--Modal-->
                                                    <div id="editModal_<?= getId($item->_id)?>" class="modal fade" role="dialog" name="div-modal">
                                                        <input type="hidden" name="id" value="<?= getId($item->_id)?>"/>
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Sửa</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Tên</label>
                                                                            <input name="name_modal" value="<?= $item->name?>" class="form-control" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Icon</label>
                                                                            <input name="icon_modal" value="<?= !empty($item->icon) ? $item->icon : "";?>"  class="form-control" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Url</label>
                                                                            <input name="url_modal" value="<?= !empty($item->url) ? $item->url : ""?>" class="form-control" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Chọn danh mục cha</label>
                                                                            <select name="parent_modal" class="form-control">
                                                                                <option>none</option>
                                                                                <?php showCategoriesModal($menu, "","",$item->parent_id);?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Ngôn ngữ</label>
                                                                            <select name="language_modal" class="form-control">
                                                                            <?php
                                                                                $language = !empty($item->language) ? $item->language : "";
                                                                            ?>
                                                                                <option value="vietnamese" <?php if($language == "vietnamese") echo 'selected';?>  >VN</option>
                                                                                <option value="english"  <?php if($language == "english") echo 'selected';?> >EN</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Mô tả</label>
                                                                            <textarea name="description_modal" rows="8" class="form-control"><?= !empty($item->description) ? $item->description : ""?></textarea>
                                                                        </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-close"></i> Hủy</button>
                                                                    <button type="button" class="btn btn-primary btn-save-modal"><i class="fa fa-save"></i> Lưu lại</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    <?php showCategoriesTable($menu, getId($item->_id), $char.' - ');}}}?>
                                    <?php showCategoriesTable($menu);?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<script src="<?= base_url("assets")?>/js/menu.js"></script>
