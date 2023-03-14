<?php $vehicles=! empty($_GET[ 'vehicles']) ? $_GET[ 'vehicles'] : ""; $name_property=! empty($_GET[ 'name_property']) ? $_GET[ 'name_property'] : ""; ?>
<div class="right_col" role="main">
<div class="theloading" style="display:none">
<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
<span><?= $this->lang->line('Loading') ?>...</span>
</div>
<div class="col-xs-12 fix_to_col" id="fix_to_col">
<div class="table_app_all">
<div class="top">
<div class="row">
<div class="col-xs-8">
<div class="title">
<span class="tilte_top_tabs">
    Danh sách biểu phí / Chi tiết biểu phí 
</span>
</div>
</div>
<div class="col-xs-4 text-right">
<div class="btn_list_filter text-right mt-0">

<div class="button_functions btn-fitler">
    <button class="btn btn-secondary btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-filter"></i>
                                </button>
                                <div class="dropdown-menu drop_select" aria-labelledby="dropdownMenuButton">
                                    <div class="card-body">
                                        <form method="get" action="">
                                            <div class="mb-3">
                                                <div class="text-large" style="color: #333;font-weight: 600;text-transform: uppercase;">Lọc dữ liệu</div>
                                                <hr style="margin: 5px 0;">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><strong>Mã nhà đầu tư</strong>
                                                </label>
                                                <div>
                                                    <input type="text" name="key" class="form-control" value="" autocomplete="off" placeholder="Mã nhà đầu tư">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><strong>Tên nhà đầu tư</strong>
                                                </label>
                                                <div>
                                                    <input type="text" name="name" class="form-control" value="" autocomplete="off" placeholder="Tên nhà đầu tư">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><strong>Thời gian</strong>
                                                </label>
                                                <div>
                                                    <input type="date" name="fdate" class="form-control" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><strong>Lãi suất</strong>
                                                </label>
                                                <div>
                                                    <select class="sellect form-control" id="sl_ls" style="appearance: auto;">
                                                        <option value="">1</option>
                                                        <option value="">1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group text-right">
                                                <button type="submit" class="btn btn-success btn_search">
                                                    Tìm kiếm
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
</div>
<div class="button_functions">
    <div class="dropdown">
        <button class="btn btn-secondary btn-success dropdown-toggle btn-func" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Chức năng &nbsp<i class="fa fa-caret-down "></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a id="details-show-his-change__id__" class="dropdown-item show_history_info_btn" href="javascript:void(0)" data-id="" data-toggle="modal" data-target=".updatebpModal">cập nhật biếu phí</a>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>


<div class="middle table_tabs">
<div class="divTable">
<div class="headRow">
<div class="divCell" align="left">Mục lục</div>
<div class="divCell">Ngày tạo</div>
<div class="divCell">Ngày áp dụng</div>
<div class="divCell">Người tạo</div>
<div class="divCell">Người cập nhật gần nhất</div>
<div class="divCell">Mô tả</div>
<div class="divCell width-31"></div>
</div>
<div class="divRow">
<div class="divCell">Cầm cố không giữ tài sản</div>
<div class="divCell">15/05/2021</div>
<div class="divCell">15/07/2021</div>
<div class="divCell">namett@tienngay.vn </div>
<div class="divCell">namett@tienngay.vn</div>
<div class="divCell">Áp dụng cho....</div>
<div class="divCell width-31 no-css">

<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <a id="details--" href="javascriptvoid:0">
<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
</a>
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a id="details-show-info__id__" data-id="" class="dropdown-item show_info_btn_chose" href="javascript:void(0)">xem biểu phí</a>
    <a id="delete-his-change__id__" class="dropdown-item delete_history_info_btn" href="javascript:void(0)" data-toggle="modal" data-target="#deleteModal" data-id="">xóa biểu phí</a>
</div>

</div>
</div>
<div class="divRow">
<div class="divCell">Cầm cố giữ tài sản</div>
<div class="divCell">15/05/2021</div>
<div class="divCell">15/07/2021</div>
<div class="divCell">namett@tienngay.vn </div>
<div class="divCell">namett@tienngay.vn</div>
<div class="divCell">Áp dụng cho....</div>
<div class="divCell width-31 no-css">
<button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <a id="details--" href="javascriptvoid:0">
<img class="not_hover" src="<?php echo base_url('assets/build/')?>images/menu 2.svg" alt="list">
<img class="hover" src="<?php echo base_url('assets/build/')?>images/hover.svg" alt="list">
</a>
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a id="details-show-info__id__" data-id="" class="dropdown-item show_info_btn_chose" href="javascript:void(0)">xem biểu phí</a>
    <a id="delete-his-change__id__" class="dropdown-item delete_history_info_btn" href="javascript:void(0)" data-toggle="modal" data-target="#deleteModal" data-id="">xóa biểu phí</a>
</div>
</div>

<div class=" show_grade_money_update">
<div class="grade_level">
    <div class="box_list" style="font-weight: bold;">
        <div class="box_box" style="background: transparent;">
            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-2">
                    <span>Đơn vị</span>
                </div>
                <div class="col-sm-2 text-left" style="font-size: 12px;">
                    X
                    <=1 00.000.000 </div>
                        <div class="col-sm-2 text-center" style="font-size: 12px;">
                            200.000.000
                            < X < 100.000.000 </div>
                                <div class="col-sm-2 text-right" style="font-size: 12px;">
                                    200.000.000
                                    < X </div>
                                </div>
                        </div>
                </div>
            </div>
            <div class="grade_level">
                <label>Tiền phải thu</label>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Lãi suất NĐT</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x1_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x2_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Phí tư vấn quản lý</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x3_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x4_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x5_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Phí thẩm định và lưu trữ tài sản đảm bảo</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x6_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x7_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x8_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grade_level">
                <label>Phí phạt</label>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Phí phạt chậm trả</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x9_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x10_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x11_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Phí phạt tất toán trước 1/3</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x12_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x13_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x14_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Phí phạt tất toán trước 2/3</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x15_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x16_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x17_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Phí phạt tất toán trước hạn khi trả các TH còn lại</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x18_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x19_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x20_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grade_level">
                <label>Phí phạt</label>
                <div class="box_list">
                    <div class="box_box">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="title_box_list">
                                    <span>Các khoản ngoại lệ</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="discount_box_list">
                                    <span>Đồng</span>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list pull-left">
                                    <input type="text" name="" id="x21_update_list" class="form-control" placeholder="x" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div class="x_box_list">
                                    <input type="text" name="" id="x22_update_list" class="form-control" placeholder="x1" />
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <div class="x_box_list pull-right">
                                    <input type="text" name="" id="x23_update_list" class="form-control" placeholder="x2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>


</div>
</div>
</div>
<div class="modal fade updatebpModal" tabindex="-1" role="dialog" aria-labelledby="updatebpModal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Thêm biểu phí</h4>
</div>
<div class="modal-body">
    <form id="requestacallform" method="POST" name="requestacallform">
        <div class="form-group mb-3">
            <label>Thời gian áp dụng</label>
            <input id="timeupdate" type="date" class="form-control" name="timeupdate" />
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Chọn tiền áp dụng</label>
                <select id="multi-select_money" class="multi-select_money" multiple="multiple">
                    <option value="<=X1, X1 < X < X2, >= X2">
                        <=X1, X1 < X < X2,>= X2</option>
                    <option value=">=X1, &lt;X1">>=X1, &lt;X1 </option>
                    <option value="<=X1, &gt;X1">
                        <=X1, &gt;X1</option>
                </select>
            </div>
            <div class="col-md-12" style="margin: 10px 0 0;">
                <label>Khoản tiền áp dụng</label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="money_update_x" id="money_update_x" placeholder="X">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="money_update_x1" id="money_update_x1" placeholder="X1">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="money_update_x2" id="money_update_x2" placeholder="X2">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-success btn_update_x">Áp dụng</button>
            </div>
            <div style="clear: left;"></div>
        </div>
        <div class="btn_select_list_grade list_grade_money_update">
            <div class="grade_level">
                <div class="box_list" style="margin: 15px 0 0;font-weight: bold;">
                    <div class="box_box" style="background: transparent;">
                        <div class="row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-2">
                                <span>Đơn vị</span>
                            </div>
                            <div class="col-sm-2 text-left" style="font-size: 12px;">
                                X
                                <=1 00.000.000 </div>
                                    <div class="col-sm-2 text-center" style="font-size: 12px;">
                                        200.000.000
                                        < X < 100.000.000 </div>
                                            <div class="col-sm-2 text-right" style="font-size: 12px;">
                                                200.000.000
                                                < X </div>
                                            </div>
                                    </div>
                            </div>
                        </div>
                        <div class="grade_level">
                            <label>Tiền phải thu</label>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Lãi suất NĐT</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x1_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x2_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Phí tư vấn quản lý</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x3_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x4_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x5_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Phí thẩm định và lưu trữ tài sản đảm bảo</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x6_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x7_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x8_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grade_level">
                            <label>Phí phạt</label>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Phí phạt chậm trả</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x9_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x10_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x11_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Phí phạt tất toán trước 1/3</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x12_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x13_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x14_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Phí phạt tất toán trước 2/3</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x15_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x16_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x17_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Phí phạt tất toán trước hạn khi trả các TH còn lại</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x18_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x19_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x20_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grade_level">
                            <label>Phí phạt</label>
                            <div class="box_list">
                                <div class="box_box">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="title_box_list">
                                                <span>Các khoản ngoại lệ</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="discount_box_list">
                                                <span>Đồng</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list pull-left">
                                                <input type="text" name="" id="x21_update_list" class="form-control" placeholder="x" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="x_box_list">
                                                <input type="text" name="" id="x22_update_list" class="form-control" placeholder="x1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <div class="x_box_list pull-right">
                                                <input type="text" name="" id="x23_update_list" class="form-control" placeholder="x2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-success btn_update_list_update_x" disabled="false">Tạo mới</button>
    </div>
    </div>
    </div>
</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="float: left;">Xóa biểu phí</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="color: #333;">
        Mọi thao tác xóa sẽ không thể khôi phục lại. Bạn có muốn xóa biểu phí này?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        <button type="button" id="btn-delete" class="btn btn-success btn-delete">Xóa</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/property/oto.js"></script>
<style type="text/css">
@media (min-width: 768px) {
    .col-sm-1\.5 {
        width: 11.9%;
    }
}

.divTable {
    display: table;
    width: 100%;
    border-spacing: 3px;
    padding: 10px;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 0 7px 1px #ddd;
}

.headRow .divCell {
    background: #FBFBFB;
    color: #047734;
    border-top: unset;
    font-weight: 600;
    height: 30px;
    line-height: 30px;
    padding: 0 6px;
}

.divRow {
    display: table-row;
    width: auto;
}

.divCell {
    float: left;
    /*fix for  buggy browsers*/
    
    display: table-column;
    width: 167px;
    position: relative;
    border-bottom: 1px solid #ddd;
    padding: 6px 6px;
    color: #232E3C;
}

.width-31 {
    width: 31px;
}

.divCell.open .dropdown-menu {
    left: -128px;
}

.divCell.open .dropdown-menu a {
    line-height: 1;
}

.no-css {
    padding: 0;
    height: 32px;
    line-height: 32px;
}

.no-css button {
    padding: 0;
}

.btn_select_radio,
.btn_select_list_grade {
    display: none;
    clear: both;
}

.show_grade_money_update {
    background: #f0f0f0;
    padding: 10px;
    display: none;
}

.grade_level label {
    margin-top: 10px;
    margin-bottom: 10px;
    text-transform: uppercase;
    color: #000;
}

.box_list {
    margin-bottom: 10px;
}

.box_box {
    background: #fff;
    padding: 7px;
    color: #000;
    border-radius: 10px;
}

.box_box .row {
    align-items: center;
}

.title_box_list {
    display: list-item;
    margin-left: 20px;
}

.box_box .x_box_list {
    width: 50%;
    margin: 0 auto;
}

.modal-content {
    overflow: unset;
}

.btn-group,
.btn-group-vertical {
    display: block;
}

.multiselect {
    width: 100%;
    text-align: left;
    display: block;
    float: unset !important;
}

.multiselect-container {
    width: 100%;
}

.dropdown-menu>.active>a,
.dropdown-menu>.active>a:focus,
.dropdown-menu>.active>a:hover {
    background: unset;
}

.btn-success {
    background: #047734;
    border: 1px solid #047734;
}

.modal-title {
    color: #333;
}

label {
    color: #777171;
}

.table-responsive {
    overflow-x: unset;
    overflow: unset;
}

tr td .dropdown-menu {
    left: -125px;
}

.button_functions .dropdown-menu {
    left: -50px;
}

.btn-fitler .dropdown-menu {
    left: -140px;
    width: 300px;
}

.marquee {
    display: none;
}

.modal {
    opacity: 1;
}

.company_close.btn-secondary {
    background: #EFF0F1;
    color: #000;
    border: 1px solid;
}

.checkbox {
    filter: invert(1%) hue-rotate(290deg) brightness(1);
}

.btn_bar {
    border-style: none;
    background: unset;
    margin-bottom: 0;
}

.hover {
    display: none;
}

.btn_bar:hover .not_hover {
    display: none;
}

.btn_bar:hover .hover {
    display: block;
    margin-bottom: -4px;
}

.propertype {
    position: absolute;
    border-top: unset !important;
    padding: 6px !important;
}

.propertype .dropdown-menu {
    left: -105px;
}

#alert_delete_pro_choo .delete_property {
    position: fixed;
    width: 378px;
    height: 175px;
    background: #fff;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    display: flex;
    align-items: center;
    border-radius: 5px;
    border-top: 2px solid #D63939;
    padding: 0 25px;
    color: #000;
}

#alert_delete_pro_choo .delete_property .popup_content h2 {
    color: #000;
}

.caret {
    float: right;
    position: relative;
    top: 8px;
}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('#multi-select_money').multiselect({
            nonSelectedText: '- Chọn tiền áp dụng -',
            allSelectedText: 'Chọn tất cả',
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.btn_update_x').on('click', function() {
            $('.btn_update_list_update_x').removeAttr('disabled');
            $('.list_grade_money_update').show();
        });
        $('.show_info_btn_chose').on('click', function() {
            $(this).parent().parent().next().css("display", "flow-root");
        });
        $('#btn-delete').on('click', function() {
            $('#successModal').show();
        });
        $('.company_close').on('click', function() {
            $('#successModal').hide();
            $('#deleteModal').hide();
            $('.modal-backdrop').removeClass('modal-backdrop fade in');
            location.reload();
        });
    });
</script>
<script type="text/javascript">
    function selectAll(invoker) {
        var inputElements = document.getElementsByTagName('input');
        for (var i = 0; i < inputElements.length; i++) {
            var myElement = inputElements[i];
            if (myElement.type === "checkbox") {
                myElement.checked = invoker.checked;
            }

        }
        $('.detele-all').toggle();
    }
</script>
<link href="<?php echo base_url('assets/')?>/build/css/bootstrap-multiselect.css" rel="stylesheet">
<script src="<?php echo base_url('assets/')?>/build/js/bootstrap-multiselect.js"></script>