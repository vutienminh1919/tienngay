<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/heyU/validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

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
            <div>
                <div>
					<h3>Đơn mua bảo hiểm PTI WEB</h3>
				</div>
                <div>
                    <h5>Tổng giao dịch: <?=$total_web?></h5>
                    <h5>Số giao dịch đã gạch: <?=$total_web_success?></h5>
                    <h5>Số giao dịch chờ nạp tiền: <?=$total_web_wait?></h5>
                    <h5>Số giao dịch chờ kế toán xử lý: <?=$total_web_kt?></h5>
                </div>
            </div>

			<div class="dropdown" style="display:inline-block">
				<button class="btn btn-success dropdown-toggle"
						onclick="$('#lockdulieu').toggleClass('show');">
					<span class="fa fa-filter"></span>
					Lọc dữ liệu
				</button>
				<ul id="lockdulieu" class="dropdown-menu" style="padding:15px;width:430px;max-width: 85vw;">
					<div class="row">
						<form action="<?php echo base_url('pti_vta/customer_web') ?>" method="get" style="width: 100%">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label>Trạng thái</label>
									<select class="form-control"
											placeholder="Tất cả"
											name="filter_by_status">
										<option value="" selected><?= $this->lang->line('All') ?></option>
										<option value="1" selected>Thanh toán thành công</option>
										<option value="10" selected>Chưa thanh toán</option>
										<option value="2" selected>Chờ kế toán xử lý</option>
										<option value="30" selected>Kế toán hủy - Chờ hoàn tiền</option>
										<option value="31" selected>Kế toán hủy - Đã hoàn tiền</option>
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

        </div>
        <div class="col-xs-12">
            <div class="x_content">
                <div class="table-responsive" style="overflow-y: auto">
                    <table class="table table-bordered m-table table-hover table-calendar table-report ">
                        <thead style="background:#3f86c3; color: #ffffff;">
                        <tr>
                            <th style="text-align: center">Tên khách hàng</th>
                            <th style="text-align: center">Ngày mua</th>
                            <th style="text-align: center">Gói bảo hiểm</th>
                            <th style="text-align: center">Đối tượng hưởng</th>
                            <th style="text-align: center">Ngày kết thúc</th>
                            <th style="text-align: center">Số tiền giao dịch</th>
                            <th style="text-align: center">Người xử lý</th>
                            <th style="text-align: center">Mã xác nhận</th>
							<th style="text-align: center">Trạng thái thanh toán</th>
                            <th style="text-align: center">Trạng thái gạch</th>
<!--                            <th style="text-align: center">Chức năng</th>-->
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaction as $key => $value) { ?>
                                <tr style="text-align: center">
                                    <td><?php echo !empty($value->data_origin->fullname) ? $value->data_origin->fullname : '' ?></td>
                                    <td><?php echo !empty($value->created_at) ? date('d/m/Y', $value->created_at) : '' ?></td>
                                    <td><?php echo !empty($value->price) ? 'PTI - '. number_format($value->price) : '' ?></td>
                                    <td><?php echo !empty($value->data_origin->obj == 'banthan') ? "Bản thân" : 'Người thân' ?></td>
                                    <td><?php echo !empty($value->NGAY_KT) ? $value->NGAY_KT : '' ?></td>
                                    <td><?php echo !empty($value->money_tranfer) ? number_format($value->money_tranfer) : '' ?></td>
                                    <td><?php echo !empty($value->modify_user) ? $value->modify_user : 'system' ?></td>
                                    <td><?php echo !empty($value->number_item) ? 'PTI'.$value->number_item : '' ?></td>
									<td>
										<?php
											if ( !empty($value->money_tranfer) ) {
												if ($value->price < $value->money_tranfer) {
													echo "Thừa tiền";
												} else if ($value->price > $value->money_tranfer) {
													echo "Thiếu tiền";
												} else if ($value->price == $value->money_tranfer) {
													echo "Đủ tiền";
												}
											} else {
												echo "Chưa có thông tin";
											}
										?>
									</td>
                                    <td>
                                        <?php
                                            if ($value->status == 10) {
                                                echo "Chưa thanh toán";
                                            }
                                            if ($value->status == 1) {
                                                echo "Thanh toán thành công";
                                            }
                                            if ($value->status == 2) {
                                                echo "Chờ kế toán xử lý";
                                            }
                                            if ($value->status == 3) {
                                                echo "Kế toán đã hủy";
                                            }
                                        ?>
                                    </td>
                                    <!--<td>
                                        <?php /*if ($value->status == 2 || $value->status == 10) { */?>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0);" onclick="confirmPayment(<?/*=$value->number_item*/?>)">Xác nhận giao dịch</a></li>
                                                    <li><a href="javascript:void(0);" onclick="cancelPayment(<?/*=$value->number_item*/?>)">Hủy giao dịch</a></li>
                                                </ul>
                                            </div>
                                        <?php /*} else if ($value->status == 1) { */?>
                                            <a class="btn btn-success btn-sm" target="_blank" href="https://giaychungnhan.pti.com.vn/">Xem</a>
                                            <div>Mã tra cứu: <?/*=!empty($value->pti_info->chung_thuc) ? $value->pti_info->chung_thuc : ""*/?></div>
                                        <?php /*} else if ($value->status == 3) { */?>
                                            <?php /*if (empty($value->refund) || $value->refund == 0) { */?>
                                                <a class="btn btn-default btn-sm" href="javascript:void(0);" onclick="refundPayment(<?/*=$value->number_item*/?>)">Hoàn tiền</a>
                                            <?php /*} */?>
                                        <?php /*} */?>
                                    </td>-->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <nav class="text-right">
                        <?php echo $pagination ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmPayment(number_item) {
        if ( confirm("Bạn có chắc chắn muốn xác nhận thanh toán") ) {
            $('#theloading').show();
            $.ajax({
                url: "/pti_vta/confirm_payment_customer",
                type: "POST",
                data: {
                    number_item: number_item
                },
                success: function (res) {
                    data = JSON.parse(res);
                    if (data.status == 200) {
                        alert("Thành công");
                        window.location.reload();
                    } else {
                        alert("Thất bại");
                        $('#theloading').hide();
                    }
                },
                error: function (data) {
                    alert("Thất bại");
                }
            });
        }
    }

    function cancelPayment(number_item) {
        if ( confirm("Bạn có chắc chắn muốn hủy thanh toán") ) {
            $('#theloading').show();
            $.ajax({
                url: "/pti_vta/cancel_payment_customer",
                type: "POST",
                data: {
                    number_item: number_item
                },
                success: function (res) {
                    alert("Thành công");
                    window.location.reload();
                },
                error: function (data) {
                    alert("Thất bại");
                }
            });
        }
    }

    function refundPayment(number_item) {
        if ( confirm("Bạn có chắc chắn đã hoàn tiền thanh toán") ) {
            $('#theloading').show();
            $.ajax({
                url: "/pti_vta/refund_payment_customer",
                type: "POST",
                data: {
                    number_item: number_item
                },
                success: function (res) {
                    alert("Thành công");
                    window.location.reload();
                },
                error: function (data) {
                    alert("Thất bại");
                }
            });
        }
    }
</script>
