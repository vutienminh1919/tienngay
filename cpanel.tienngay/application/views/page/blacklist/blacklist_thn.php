<div class="theloading" style="display:none">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
	<span>Đang Xử Lý...</span>
</div>

<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
	$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
	$message = $this->session->flashdata('error');
	?>
	<?php 
		if (isset($message)) {
			echo '<div class="alert alert-danger" id="hide_it">' . $message . '</div>';
			$this->session->unset_userdata($message);
		}
	?>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Danh sách hợp đồng đã được duyệt miễn giảm
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="<?php base_url('exemptions') ?>">
								Danh sách hợp đồng đã được duyệt miễn giảm</a>
							</small>
						</h3>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12 ">
							<div class="row">
								<form action="<?php echo base_url('exemptions/getContractExempted') ?>" method="get" class="getContractExempted"
									  style="width: 100%;">
									<div class="col-xs-12">
										<div class="row">
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label> Từ </label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label> Đến </label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">

												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Phòng giao dịch</label>
												<select id="province" class="form-control" name="store">
													<option value=""><?= $this->lang->line('All') ?></option>
													<?php foreach ($storeData as $p) {
														if ($p->status != 'active') continue;
														?>
														<option <?php echo $store == $p->id ? 'selected' : '' ?>
																value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Họ và tên</label>
												<input type="text" name="customer_name" class="form-control"
													   placeholder="Tên khách hàng"
													   value="<?php echo $customer_name; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Mã phiếu ghi</label>
												<input type="text" name="code_contract"
													   class="form-control" placeholder="Mã phiếu ghi"
													   value="<?php echo $code_contract; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Mã hợp đồng</label>
												<input type="text" name="code_contract_disbursement"
													   class="form-control" placeholder="Mã hợp đồng"
													   value="<?php echo $code_contract_disbursement; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Số điện thoại</label>
												<input type="text" name="customer_phone_number"
													   class="form-control" placeholder="Số điện thoại"
													   value="<?php echo $customer_phone_number; ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Số CMND/CCCD</label>
												<input type="text" name="customer_identify"
													   class="form-control" placeholder="Số cmnd/cccd"
													   value="<?php echo $customer_identify; ?>">
											</div>
											<div class="col-xs-12  col-lg-8 col-md-8">
											</div>
										</div>
										<div class="row">
											<div class="col-xs-8 col-lg-1 col-md-1 text-left">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary form-control" id="submit"><i
															class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
												</button>
											</div>
											<div class="col-xs-4 col-md-1" style="margin-left:auto; margin-right: 100px;">
												<?php if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('truong-nhom-phe-duyet', $groupRoles)) { ?>
														<a href="<?php echo base_url() ?>Exemptions/exportContractExempted?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $store .  '&customer_name=' . $customer_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&code_contract=' . $code_contract . '&customer_identify=' .$customer_identify . '&customer_phone_number=' . $customer_phone_number ?>"
														class="btn btn-success"
														target="_blank">
															<i class="fa fa-save" aria-hidden="true"></i>
															Xuất Excel
														</a>
														<a href="<?php echo base_url() ?>Exemptions/excelExempted?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $store .  '&customer_name=' . $customer_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&code_contract=' . $code_contract . '&customer_identify=' .$customer_identify . '&customer_phone_number=' . $customer_phone_number ?>"
														class="btn btn-success"
														target="_blank">
															<i class="fa fa-save" aria-hidden="true"></i>
															Xuất Excel Đơn Miễn Giảm
														</a>
													<?php } ?>
											</div>
										</div>
								</form>
							</div>
						</div>
						<!--						<div class="clearfix"></div>-->
						<div>
							<div class="row">
								<div class="col-xs-12">
									<div class="table-responsive">
										<br>
										<div>Hiển thị (<span class="text-danger"><?php echo $result_count; ?></span>)
											kết quả
										</div>

										<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th class="text-center">STT</th>
												<th class="text-center">Mã phiếu ghi</th>
												<th class="text-center">Mã hợp đồng</th>
												<th class="text-center">Tên khách hàng</th>
												<th class="text-center">Số điện thoại</th>
												<th class="text-center">Số CMNN/CCCD</th>
												<th class="text-center">Ngày xử lý</th>
												<th class="text-center">Phòng giao dịch</th>
												<th class="text-center">Xem ảnh hồ sơ</th>
											</tr>
											</thead>
											<tbody>
											<?php
											if (!empty($dataResult)) {
												foreach ($dataResult as $key => $getContractExempted) { ?>
													<tr>
														<td class="text-center"><?php echo ++$key + $page ?></td>
														<td class="text-center"><?= !empty($getContractExempted->code_contract) ? $getContractExempted->code_contract : "" ?></td>
														<td class="text-center">
															<a target="_blank"
															   href="<?php if (in_array("thu-hoi-no", $groupRoles)) {
																   echo base_url("accountant/view_v2?id=") . $getContractExempted->id_contract . "#tab_content_history_exemption_contract";
															   } else {
																   echo base_url("accountant/view?id=") . $getContractExempted->id_contract . "#tab_content_history_exemption_contract";
															   } ?>"
															   class="link" data-toggle="tooltip"
															   data-placement="top" 
															   style="color: #0ba1b5;text-decoration: underline;">
																<?= !empty($getContractExempted->code_contract_disbursement) ? $getContractExempted->code_contract_disbursement : $getContractExempted->code_contract ?>
															</a>
														</td>
														<td class="text-center"><?= !empty($getContractExempted->customer_name) ? $getContractExempted->customer_name : "" ?></td>
														<td class="text-center"><?= !empty($getContractExempted->customer_phone_number) ? substr($getContractExempted->customer_phone_number,0,3)."****". substr($getContractExempted->customer_phone_number,7,12): "" ?></td>
														<td class="text-center"><?= !empty($getContractExempted->customer_identify) ?  substr($getContractExempted->customer_identify,0,3)."***".substr($getContractExempted->customer_identify,6,12) : "" ?></td>
														<td class="text-center"><?= !empty($getContractExempted->date_suggest) ? date('d/m/Y', intval($getContractExempted->date_suggest)) : "" ?></td>
														<td class="text-center"><?= !empty($getContractExempted->store->name) ? $getContractExempted->store->name : "" ?></td>
														<td class="text-center">
															<a target="_blank"
															   href="<?php echo base_url("exemptions/viewImageExempted?id=") . $getContractExempted->_id->{'$oid'} ?>"
															   class="link" data-toggle="tooltip"
															   data-placement="top"
															   style="color: #0ba1b5;text-decoration: underline;">
																Xem ảnh miễn giảm
															</a>
														</td>
													</tr>
												<?php }
											} ?>
											</tbody>
										</table>
										<div class="">
											<?php echo $pagination ?>
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

<!--Modal Lead THN approve-->
<?php $this->load->view('page/accountant/thn/modal_leadqlhdv_approve_exemption.php'); ?>

<!--Modal TP THN approve-->
<?php $this->load->view('page/accountant/thn/modal_tpqlhdv_approve_exemption.php'); ?>

<!--Modal QLCC approve-->
<?php $this->load->view('page/accountant/thn/modal_qlcc_approve_exemption.php'); ?>

<script src="<?php echo base_url(); ?>assets/js/examptions/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script>
	$(document).ready(function () {
		$("#data_send_high").hide();
		$("#tp_send_up").click(function () {
			$("#tp_send_up").prop('disabled', true);
			$("#data_send_high").show();
		})
	});

	$(function() {
		var timeout = 3000; // in miliseconds (3*1000)
		$('#hide_it').delay(timeout).fadeOut(300);

	});
</script>
<style type="text/css">
	.checkcontainer {
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	.checkcontainer input[type="radio"] {
		display: none;
	}

	.checkcontainer input:checked ~ .radiobtn:after {
		display: block;
		left: 3px;
		top: 0px;
		width: 5px;
		height: 9px;
		border: solid white;
		border-width: 0 2px 2px 0;
		-webkit-transform: rotate(
				45deg
		);
		-ms-transform: rotate(45deg);
		transform: rotate(
				45deg
		);
	}

	.checkcontainer input:checked ~ .radiobtn {
		background-color: #0075ff;
	}

	.radiobtn {
		position: absolute;
		top: 2px;
		left: 0;
		height: 13px;
		width: 13px;
		background-color: #ffff;
		border: 1px solid #767676;
		border-radius: 3px;
	}

	.checkcontainer .radiobtn:after {
		content: "";
		position: absolute;
		display: none;
	}
</style>
