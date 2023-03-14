<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Danh sách khách hàng
                <br>
                <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách khách hàng</a>
                </small>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Số điện thoại</th>
                                    <th>Hình thức</th>
                                    <th>Thành phố</th>
                                    <th>Dịch vụ</th>
                                    <th>Trạng thái gọi điện</th>
                                    <th style="width: 17%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($leads as $item) { ?>
                                    <tr>
                                        <td><?= !empty($item->phone_number) ? $item->phone_number : ""?></td>
                                        <td>
                                            <?php if($item->type_finance == 1) echo "Vay tiền"?>
                                            <?php if($item->type_finance == 2) echo "Cầm cố"?>
                                        </td>
                                        <td>
                                            <?php if(!empty($item->city) && $item->city == 'hn') echo "Hà nội"?>
                                            <?php if(!empty($item->city) && $item->city == 'hcm') echo "Hồ chí minh"?>
                                        </td>
                                        <td>
                                            <?php if(!empty($item->service) && $item->service == 'ccxm') echo "Cầm cố xe máy"?>
                                            <?php if(!empty($item->service) && $item->service == 'ccoto') echo "Cầm cố ô tô"?>
                                            <?php if(!empty($item->service) && $item->service == 'dkxm') echo "Đăng ký xe máy"?>
                                            <?php if(!empty($item->service) && $item->service == 'dkoto') echo "Đăng ký ô tô"?>
                                        </td>
                                        <td>
                                            <?php if($item->call == 1) echo "Chưa gọi điện"?>
                                            <?php if($item->call == 2) echo "Đã gọi điện"?>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-primary"  onclick="window.location.href='<?= base_url("lead/displayUpdate/").getId($item->_id)?>'">
                                                <i class="fa fa-edit"></i> Sửa
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
<script src="<?= base_url("assets")?>/js/role/search.js"></script>
