<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/heyU/validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<!-- page content -->
<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "pti_vta";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
$code = !empty($_GET['code']) ? $_GET['code'] : "";
$code_pti_vta = !empty($_GET['code_pti_vta']) ? $_GET['code_pti_vta'] : "";
$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";
$filter_by_status = !empty($_GET['filter_by_status']) ? $_GET['filter_by_status'] : "";
$filter_by_sell_per = !empty($_GET['filter_by_sell_per']) ? $_GET['filter_by_sell_per'] : "";
$customer_name_another = !empty($_GET['customer_name_another']) ? $_GET['customer_name_another'] : "";
$customer_cmt = !empty($_GET['customer_cmt']) ? $_GET['customer_cmt'] : "";
    function get_obj($id)
        {
            switch ($id) {
                case 'banthan':
                    return "Bản thân";
                    break;
                default:
                return "Người thân";
                    break;

            }
        }
        ?>
?>
<div class="right_col" role="main">
    <div class="theloading" id="theloading" style="display:none">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        <span><?= $this->lang->line('Loading') ?>...</span>
    </div>
    <div class="row">
        <div class="col-xs-12">

            <div class="page-title">
                <div class="title_left">
                    <h3>Danh sách thu tiền PTI Vững Tâm An (ngừng bán từ ngày 19/03/2022!!!)</h3>
                </div>
                <div class="title_right text-right">
                    <a href="<?php echo base_url() ?>pti_vta/form_add_pti_vta" class="btn btn-info">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Thêm giao dịch
                    </a>
                    <a href="<?php echo base_url() ?>pti_vta/add_transaction_pay_money" class="btn btn-success"
                       target="_blank">
                        <i class="fa fa-save" aria-hidden="true"></i>
                        Tạo lệnh đóng tiền
                    </a>

                    <div class="dropdown" style="display:inline-block">
                        <button class="btn btn-success dropdown-toggle"
                                onclick="$('#lockdulieu').toggleClass('show');">
                            <span class="fa fa-filter"></span>
                            Lọc dữ liệu
                        </button>
                        <ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
                            style="padding:15px;width:430px;max-width: 85vw;">
                            <div class="row">
                                <form action="<?php echo base_url('pti_vta') ?>" method="get"
                                      style="width: 100%">
                
                <?php if ($tab == "pti_vta") { ?>
                    <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Trạng thái</label>
                         <select class="form-control"
                                placeholder="Tất cả"
                                name="filter_by_status">
                        <option value="" selected><?= $this->lang->line('All') ?></option>
                            <?php 
                            foreach (status_bao_hiem() as $key =>$value) { ?>
                                <option <?php echo $filter_by_status == $key ? 'selected' : '' ?>
                                        value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                  <div class="col-xs-12 col-md-6" style="padding-left: 10px">
                    <div class="form-group">
                        <label>Email người bán</label>
                         <input type="text" name="filter_by_sell_per" class="form-control" value="<?= !empty($filter_by_sell_per) ? $filter_by_sell_per : "" ?>">
                       
                    </div>
                </div>
               
                <div class="col-xs-12 col-md-12">
                    <label>Thời gian tạo bảo hiểm</label>
                </div>
                <div class="col-xs-12 col-md-6" style="padding-left: 10px">
                    <div class="form-group">
                        <label> Từ </label>
                        <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ? $fdate : "" ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label> Đến </label>
                        <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ? $tdate : "" ?>">

                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label> Người mua </label>
                        <input type="text" name="customer_name" class="form-control" value="<?= !empty($customer_name) ? $customer_name : "" ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6" style="padding-left: 10px">
                    <div class="form-group">
                        <label> Người được hưởng </label>
                        <input type="text" name="customer_name_another" class="form-control"  value="<?= !empty($customer_name_another) ? $customer_name_another : "" ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label> Số điện thoại </label>
                        <input type="number" name="customer_phone" class="form-control" value="<?= !empty($customer_phone) ? $customer_phone : "" ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6" style="padding-left: 10px">
                    <div class="form-group">
                        <label> CCCD/CMT/GKS </label>
                        <input type="text" name="customer_cmt" class="form-control"  value="<?= !empty($customer_cmt) ? $customer_cmt : "" ?>">
                    </div>
                </div>
                <?php } ?>
                   <?php if ($tab == "transaction") { ?>
                <div class="col-xs-12 col-md-12">
                    <label>Thời gian nạp tiền</label>
                </div>
                <div class="col-xs-12 col-md-6" >
                    <div class="form-group">
                        <label> Từ </label>
                        <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ? $fdate : "" ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6" style="padding-left: 10px">
                    <div class="form-group">
                        <label> Đến </label>
                        <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ? $tdate : "" ?>">

                    </div>
                </div>
                <?php } ?>
                

                                    <?php if ($tab == "pti_vta") { ?>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label> Mã giao dịch </label>
                                            <input type="text" name="code_pti_vta" class="form-control" value="<?= !empty($code_pti_vta) ? $code_pti_vta : "" ?>">
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($tab == "transaction") { ?>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control"
                                placeholder="Tất cả"
                                name="filter_by_status">
                        <option value="" selected><?= $this->lang->line('All') ?></option>
                            <?php 
                            foreach (status_bao_hiem() as $key =>$value) { ?>
                                <option <?php echo $status == $key ? 'selected' : '' ?>
                                        value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                   
                    </div>
                </div>

                <div class="col-xs-12 col-md-6" style="padding-left: 10px">
                    <div class="form-group">
                        <label>Người giao dịch</label>
                       
                        <input type="text" name="filter_by_sell_per" class="form-control" value="<?= !empty($filter_by_sell_per) ? $filter_by_sell_per : "" ?>">
                    </div>
                </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group">
                                                <label> Mã phiếu thu </label>
                                                <input type="text" name="code" class="form-control" value="<?= !empty($code) ? $code : "" ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label>PGD:</label>
                                    <select class="form-control"
                                                    placeholder="Tất cả"
                                                    name="filter_by_store">
                                                <option value="" selected><?= $this->lang->line('All') ?></option>
                                                <?php foreach ($storeData as $p) { ?>
                                                    <option <?php echo $store == $p->store_id ? 'selected' : '' ?>
                                                            value="<?php echo $p->store_id; ?>"><?php echo $p->store_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <input type="hidden" name="tab" class="form-control"
                                               value="<?= !empty($tab) ? $tab : "" ?>">
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label> <br>
                                            <button class="btn btn-primary w-100">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </ul>
                    </div>
                    <?php
                    if (($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles)) && $tab=="pti_vta" ) { ?>
                        <a href="<?php echo base_url() ?>excel/exportPti_vta?<?= 'tab='. $tab . '&fdate=' . $fdate . '&tdate=' . $tdate . '&customer_name=' . $customer_name . '&customer_phone=' . $customer_phone . '&code=' . $code . '&code_pti_vta=' . $code_pti_vta . '&filter_by_store=' . $filter_by_store. '&customer_cmt=' . $customer_cmt . '&customer_name_another=' . $customer_name_another . '&filter_by_status=' . $filter_by_status . '&filter_by_sell_per=' . $filter_by_sell_per; ?>" class="btn btn-success"
                           target="_blank">
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Xuất Excel
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>


        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">

                        <div class="col-xs-12 text-right">

                            <ul id="myTab1" class="nav nav-tabs bar_tabs left" role="tablist">
                                <li role="presentation" class="<?= ($tab == 'pti_vta') ? 'active' : '' ?>">
                                    <a href="<?php echo base_url() ?>pti_vta?tab=pti_vta"
                                       id="naptientaixeheyu1-tabb"
                                       aria-expanded="true"> Giao dịch KH</a>
                                </li>
                                <li role="presentation" class="<?= ($tab == 'transaction') ? 'active' : '' ?>"><a
                                            href="<?php echo base_url() ?>pti_vta?tab=transaction"
                                            id="naptientaixeheyu2-tabb"
                                            aria-expanded="false"> Giao
                                        dịch đóng tiền</a>
                                </li>

                            </ul>
                        </div>
                    </div>


                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <div id="myTabContent2" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in <?= ($tab == 'pti_vta') ? 'active' : '' ?>"
                                 id="naptientaixeheyu1"
                                 aria-labelledby="naptientaixeheyu1-tab">
                                
                                <?php if ($tab == 'pti_vta') { ?>
                                        <div>
                                            <?php if ($filter_by_status !=""){ ?>
                                    <table width="250px;">
                                                <tr>
                                                    <th>Tổng giao dịch <?= status_bao_hiem($filter_by_status) ?>:&nbsp;</th>
                                                    <td><?php
                                                        if (!empty($total)) {
                                                            if ($total < 10) {
                                                                echo '0' . $total;
                                                            } else if ($total >= 10) {
                                                                echo $total;
                                                            } else {
                                                                echo 0;
                                                            }
                                                        }  else {
                                                            echo 0;
                                                        };?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </td>
                                                    <td>
                                                        <b style="color: red;">=<?= $total_money  ?></b>
                                                    </td>
                                                </tr>
                                            </table>

                                <?php }else{ ?>
                                            <table width="250px;">
                                                <tr>
                                                    <th>Tổng giao dịch:</th>
                                                    <td><?php
                                                        if (!empty($total)) {
                                                            if ($total < 10) {
                                                                echo '0' . $total;
                                                            } else if ($total >= 10) {
                                                                echo $total;
                                                            } else {
                                                                echo 0;
                                                            }
                                                        }  else {
                                                            echo 0;
                                                        };?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </td>
                                                    <td>
                                                        <b style="color: red;">=<?= $total_money  ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Số giao dịch đã nạp:</th>
                                                    <td><?php
                                                        if (!empty($total_sended)) {
                                                            if ($total_sended < 10) {
                                                                echo '0' . $total_sended;
                                                            } else if ($total_sended >= 10) {
                                                                echo $total_sended;
                                                            } else {
                                                                echo 0;
                                                            }
                                                        } else {
                                                            echo 0;
                                                        }
                                                        ;?></td>
                                                        <td>
                                                        <b style="color: red;">=<?= $total_sended_money  ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Số giao dịch chưa nạp:</th>
                                                    <td><?php
                                                        if (!empty($total_not_send_yet)) {
                                                            if ($total_not_send_yet < 10) {
                                                                echo '0' . $total_not_send_yet;
                                                            } else if ($total_not_send_yet >= 10) {
                                                                echo $total_not_send_yet;
                                                            } else {
                                                                echo 0;
                                                            }
                                                        }  else {
                                                            echo 0;
                                                        }
                                                        ;?></td>
                                                        <td>
                                                        <b style="color: red;">=<?= $total_not_send_yet_money  ?></b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php }?>
                                    <br>
                                    <div class="table-responsive" style="overflow-y: auto">
                                        <table
                                                class="table table-bordered m-table table-hover table-calendar table-report ">
                                            <thead style="background:#3f86c3; color: #ffffff;">
                                            <tr>
                                                <th style="text-align: center">Mã giao dịch</th>
                                                <th style="text-align: center">Thời gian nộp tiền</th>
                                                <th style="text-align: center">Người mua</th>
                                                <th style="text-align: center">Đối tượng mua</th>
                                                <th style="text-align: center">Người được hưởng</th>
                                                <th style="text-align: center">Số điện thoại</th>
                                                <th style="text-align: center">Mệnh giá</th>
                                                <th style="text-align: center">Người giao dịch</th>
                                                <th style="text-align: center">Người tạo</th>
                                                <th style="text-align: center">Địa điểm giao dịch</th>
                                                <th style="text-align: center">Trạng thái</th>
                                                <th style="text-align: center">GCN</th>
                                                
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php if (!empty($transaction)) : ?>
                                                <?php foreach ($transaction as $key => $value) { ?>
                                                    <tr style="text-align: center">
                                                        <td><?php echo !empty($value->pti_code) ? $value->pti_code : '' ?></td>
                                                        <td><?php echo !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : '' ?></td>
                                                        <td><?php echo !empty($value->request->btendn) ? $value->request->btendn : '' ?></td>
                                                        <td><?php echo !empty($value->data_origin->obj) ? get_obj($value->data_origin->obj) : '' ?></td>
                                                        <td><?php echo !empty($value->customer_info->customer_name) ? $value->customer_info->customer_name : '' ?></td>
                                                        <td><?php echo !empty($value->customer_info->customer_phone) ? $value->customer_info->customer_phone : '' ?></td>
                                                        <td><?php echo !empty($value->price) ? number_format($value->price) . " VND" : '' ?></td>
                                                        <td><?php echo !empty($value->created_by) ? $value->created_by : '' ?></td>
                                                        <td><?php echo !empty($value->type_pti == "HD") ? $value->contract_info->created_by : $value->created_by ?></td>
                                                        <td><?php echo !empty($value->store->name) ? $value->store->name : '' ?></td>
                                                        <td>
                                                            <?php if ($value->status == 10): ?>
                                                                <span class="label label-info">PGD đã thu tiền</span>
                                                            <?php elseif ($value->status == 2): ?>
                                                                <span class="label label-default">Chờ kế toán xác nhận</span>
                                                            <?php elseif ($value->status == 1): ?>
                                                                <span class="label label-success">Kế toán đã duyệt</span>
                                                            <?php elseif ($value->status == 3): ?>
                                                                <span class="label label-danger">Kế toán hủy</span>
                                                            <?php elseif ($value->status == 11): ?>
                                                                <span class="label label-warning">Kế toán trả về</span>
                                                            <?php endif; ?>
                                                        </td>
                                                       <td>
                                                        <?php
                                                        // từ ngày 16/01/2022 sẽ xem chứng từ qua file pdf. Các dữ liệu trước đó dữ nguyên không thay đổi.
                                                        $created_at = $pti->created_at;
                                                        if (isset($pti->updated_at)) {
                                                          $created_at = $pti->updated_at;
                                                        }
                                                        $targetDate = strtotime("2022/01/16");
                                                        ?>
                                                        <?php if(!empty($pti->pti_info->data)) { ?>
                                                            <?php if ($created_at > $targetDate) { ?>
                                                                <a class="btn btn-success btn-sm" target="_blank" 
                                                                    href="<?php echo base_url("/pti_vta/viewGCN?so_id=").$pti->pti_info->so_id?>">Xem</a>
                                                            <?php } else { ?>
                                                                <a class="btn btn-success btn-sm" target="_blank" href="https://giaychungnhan.pti.com.vn/">Xem</a>
                                                                <br>
                                                                Mã tra cứu:
                                                                <br>
                                                                <?php echo !empty($pti->pti_info->chung_thuc) ? $pti->pti_info->chung_thuc : '' ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php else : ?>
                                                <tr style="text-align: center">
                                                    <td colspan="10">Không có dữ liệu</td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div>
                                        <nav class="text-right">
                                            <?php echo $pagination ?>
                                        </nav>
                                    </div>
                                <?php } ?>
                            </div>


                            <div role="tabpanel"
                                 class="tab-pane fade in <?= ($tab == 'transaction') ? 'active' : '' ?>"
                                 id="naptientaixeheyu2"
                                 aria-labelledby="naptientaixeheyu2-tab">
                                <?php if ($tab == 'transaction') { ?>
                                    <div class="table-responsive" style="overflow-y: auto">
                                        <table
                                                class="table table-bordered m-table table-hover table-calendar table-report ">
                                            <thead style="background:#3f86c3; color: #ffffff;">
                                            <tr>
                                                <th style="text-align: center">Chức năng</th>
                                                <th style="text-align: center">Mã phiếu thu</th>
                                                <th style="text-align: center">Người giao dịch</th>
                                                <th style="text-align: center">Thời gian nộp tiền</th>
                                                <th style="text-align: center">Số tiền đóng</th>
                                                <th style="text-align: center">Trạng thái</th>
                                                <th style="text-align: center">Kế toán ghi chú</th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php if (!empty($transaction)) : ?>
                                                <?php foreach ($transaction as $value) { ?>
                                                    <tr style="text-align: center">
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle"
                                                                        type="button" id="dropdownMenuButton"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false"
                                                                        style="text-align: center; background-color: #5bc0de; color: white">
                                                                    Chức năng
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu"
                                                                    style="z-index: 99999;">
                                                                    <li>
                                                                        <a href="<?php echo base_url() ?>pti_vta/detail_transaction?code=<?php echo $value->code ?>">Xem
                                                                            chi tiết
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                    if ($value->status == 11) { ?>
                                                                        <li><a class="dropdown-item"
                                                                               href="<?php echo base_url('transaction/sendApprove?id=' . $value->_id->{'$oid'}); ?>">
                                                                                <?php echo "Gửi kế toán duyệt lại" ?>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                    <?php
                                                                    if (!in_array($value->status, [1, 3])) {
                                                                        ?>
                                                                        <li>
                                                                            <a href="<?php echo base_url("transaction/upload?id=") . $value->_id->{'$oid'} ?>"
                                                                               class="dropdown-item">
                                                                                Tải lên chứng từ
                                                                            </a></li>
                                                                    <?php } ?>
                                                                    <li>
                                                                        <a href="<?php echo base_url("transaction/viewImg?id=") . $value->_id->{'$oid'} ?>"
                                                                           class="dropdown-item ">
                                                                            Xem chứng từ
                                                                        </a></li>

                                                                </ul>

                                                        </td>
                                                        <td style="text-align: center"><?= !empty($value->code) ? $value->code : "" ?><br>
                                                            <?php
                                                            if ($value->status == 11) { ?>
                                                                <a class="btn btn-primary" href="<?php echo base_url('transaction/sendApprove?id='.$value->_id->{'$oid'});?>">
                                                                    Gửi duyệt lại
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                        <td style="text-align: center"><?= !empty($value->created_by) ? $value->created_by : "" ?><br>
                                                            <?php
                                                            if (!in_array($value->status, [1,3,11]) ) {
                                                                ?>
                                                                <a href="<?php echo base_url("transaction/upload?id=") . $value->_id->{'$oid'} ?>"
                                                                   class="btn btn-primary">
                                                                    Tải lên chứng từ
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>
                                                        <td><?php echo !empty($value->total) ? number_format($value->total) . " VND" : 0 ?></td>
                                                        <td>
                                                            <?php if ($value->status == 2): ?>
                                                                <span
                                                                        class="label label-default">Chờ kế toán xác nhận</span>
                                                            <?php elseif ($value->status == 1): ?>
                                                                <span class="label label-success">Kế toán đã duyệt</span>
                                                            <?php elseif ($value->status == 11): ?>
                                                                <span class="label label-warning">Kế toán trả về</span>
                                                            <?php elseif ($value->status == 3): ?>
                                                                <span class="label label-danger">Kế toán hủy</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo !empty($value->approve_note) ? $value->approve_note : "" ?></td>

                                                    </tr>
                                                <?php } ?>
                                            <?php else : ?>
                                                <tr style="text-align: center">
                                                    <td colspan="10">Không có dữ liệu</td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <nav class="text-right">
                                            <?php echo $pagination ?>
                                        </nav>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<script>
    const $menu = $('.dropdown');
    $(document).mouseup(e => {
        if (!$menu.is(e.target)
                && $menu.has(e.target).length === 0) {
            $menu.removeClass('is-active');
            $('.dropdown-menu').removeClass('show');
        }
    });
    $('.dropdown-toggle').on('click', () => {
        $menu.toggleClass('is-active');
    });
</script>
<script src="<?php echo base_url() ?>assets/js/pti_vta/index.js"></script>
