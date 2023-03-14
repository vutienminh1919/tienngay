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
	?>
	<div class="row top_tiles">

		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Danh sách hợp đồng xin miễn giảm
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>">
									Danh sách hợp đồng xin miễn giảm</a>
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
								<form action="<?php echo base_url('exemptions') ?>" method="get"
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
											<div class="col-xs-12  col-lg-8 col-md-8">
											</div>
											<div class="col-xs-12  col-lg-4 col-md-4 text-right">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary"><i
															class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
												</button>
												<?php if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('lead-thn', $groupRoles)) { ?>
													<a href="<?php echo base_url() ?>Exemptions/exportContractExemption?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $store . '&status=' . $status . '&status=' . $status . '&customer_name=' . $customer_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&code_contract=' . $code_contract; ?>"
													   class="btn btn-success"
													   target="_blank">
														<i class="fa fa-save" aria-hidden="true"></i>&nbsp;
														Xuất Excel
													</a>
													<a href="<?php echo base_url() ?>Exemptions/excelExemption?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&code_contract=' . $code_contract?>"
													   class="btn btn-success"
													   target="_blank">
														<i class="fa fa-save" aria-hidden="true"></i>&nbsp;
														Báo cáo miễn giảm
													</a>
												<?php } ?>
											</div>

										</div>
								</form>
							</div>
						</div>
						<!--<div class="clearfix"></div>-->
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
												<th class="text-center">Chức năng</th>
												<th class="text-center">Mã phiếu ghi</th>
												<th class="text-center">Mã hợp đồng</th>
												<th class="text-center">Tên khách hàng</th>
												<th class="text-center">Số tiền KH đề nghị miễn giảm</th>
												<th class="text-center">Số tiền TP đề xuất miễn giảm</th>
												<th class="text-center">Kỳ miễn giảm</th>
												<th class="text-center">Loại miễn giảm</th>
												<th class="text-center">Ngày làm đơn miễn giảm</th>
												<th class="text-center">Ngày xử lý</th>
												<th class="text-center">Phòng giao dịch</th>
												<th class="text-center">Trạng thái</th>
												<th class="text-center">Xem ảnh hồ sơ</th>
											</tr>
											</thead>
											<tbody>
											<?php
											if (!empty($dataExemptions)) {
												foreach ($dataExemptions as $key => $contract_exemptions) { ?>
													<tr>
														<td><?php echo ++$key + $page ?></td>
														<td style="text-align: -webkit-center;">
															<?php if ($userSession['is_superadmin'] == 1 || in_array("lead-thn", $groupRoles)) { ?>
																<?php if (!empty($contract_exemptions->status) && $contract_exemptions->status == 1 && $contract_exemptions->status_contract != 19 && $contract_exemptions->ky_tra_hien_tai == $contract_exemptions->ky_tra) { ?>
																	<a class="btn btn-info"
																	   onclick="showModal_lead_thn('<?= $contract_exemptions->_id->{'$oid'} ?>')"
																	   href="javascript:void(0)">
																		Lead QLHĐV xử lý
																	</a>
																<?php }
															} ?>
															<?php if ($userSession['is_superadmin'] == 1 || in_array("tbp-thu-hoi-no", $groupRoles)) { ?>
																<?php if (!empty($contract_exemptions->status) && in_array($contract_exemptions->status, [4, 5]) && $contract_exemptions->status_contract != 19 && $contract_exemptions->ky_tra_hien_tai == $contract_exemptions->ky_tra && $contract_exemptions->is_discount_transaction == false) { ?>
																	<a class="btn btn-info"
																	   onclick="tpthn_xu_ly('<?= $contract_exemptions->_id->{'$oid'} ?>')"
																	   href="javascript:void(0)">
																		TP QLHĐV xử lý
																	</a>
																<?php }
															} ?>
															<?php if ($userSession['is_superadmin'] == 1 || (isset($contract_exemptions->user_receive_approve) && in_array($user_id_login, $contract_exemptions->user_receive_approve))) { ?>
																<?php if (!empty($contract_exemptions->status) && in_array($contract_exemptions->status, [6]) && $contract_exemptions->status_contract != 19 && $contract_exemptions->ky_tra_hien_tai == $contract_exemptions->ky_tra) { ?>

																	<a class="btn btn-info"
																	   onclick="qlcc_xu_ly('<?= $contract_exemptions->_id->{'$oid'} ?>')"
																	   href="javascript:void(0)">
																		QLCC xử lý
																	</a>
																<?php }
															} ?>
														</td>
														<td class="text-center"><?= !empty($contract_exemptions->code_contract) ? $contract_exemptions->code_contract : "" ?></td>
														<td class="text-center">
															<a target="_blank"
															   href="<?php if (in_array("thu-hoi-no", $groupRoles)) {
																   echo base_url("accountant/view_v2?id=") . $contract_exemptions->id_contract . "#tab_content_history_exemption_contract";
															   } else {
																   echo base_url("accountant/view?id=") . $contract_exemptions->id_contract . "#tab_content_history_exemption_contract";
															   } ?>"
															   class="link" data-toggle="tooltip"
															   data-placement="top" title="Click để xem chi tiết"
															   style="color: #0ba1b5;text-decoration: underline;">
																<?= !empty($contract_exemptions->code_contract_disbursement) ? $contract_exemptions->code_contract_disbursement : $contract_exemptions->code_contract ?>
															</a>
														</td>
														<td class="text-center"><?= !empty($contract_exemptions->customer_name) ? $contract_exemptions->customer_name : "" ?></td>
														<td class="text-center"><?= !empty($contract_exemptions->amount_customer_suggest) ? number_format($contract_exemptions->amount_customer_suggest) : '' ?></td>
														<td class="text-center"><?= !empty($contract_exemptions->amount_tp_thn_suggest) ? number_format($contract_exemptions->amount_tp_thn_suggest) : 0 ?></td>
														<td class="text-center"><?= !empty($contract_exemptions->ky_tra) ? $contract_exemptions->ky_tra : "" ?></td>
														<td class="text-center"><?= (!empty($contract_exemptions->type_payment_exem) && $contract_exemptions->type_payment_exem==2) ? 'Tất toán' : "Thanh toán" ?></td>
														<td class="text-center"><?= !empty($contract_exemptions->created_profile_at) ? date('d/m/Y', intval($contract_exemptions->created_profile_at)) : "" ?></td>
														<td class="text-center"><?= !empty($contract_exemptions->date_suggest) ? date('d/m/Y', intval($contract_exemptions->date_suggest)) : "" ?></td>
														<td class="text-center"><?= !empty($contract_exemptions->store->name) ? $contract_exemptions->store->name : "" ?></td>
														<td class="text-center">
															<?php
															if ($contract_exemptions->status == 1) {
					echo '<span class="label label-default" style="font-size: 13px; padding: 7px">Chờ Lead QLHĐV xử lý đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 2) {
					echo '<span class="label label-danger" style="font-size: 13px; padding: 7px;" >Đã hủy đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 3) {
					echo '<span class="label label-warning" style="font-size: 13px; padding: 7px;" >Lead QLHĐV yêu cầu bổ sung đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 4) {
					echo '<span class="label label-default" style="font-size: 13px; padding: 7px;" >Chờ TP QLHĐV xử lý đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 5) {
					echo '<span class="label label-success" style="font-size: 13px; padding: 7px;" >TP QLHĐV đã duyệt đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 6) {
					echo '<span class="label label-default" style="font-size: 13px; padding: 7px;" >Chờ quản lý cấp cao xử lý đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 7) {
					echo '<span class="label label-success" style="font-size: 13px; padding: 7px;" >Quản lý cấp cao đã duyệt đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 8) {
					echo '<span class="label label-warning" style="font-size: 13px; padding: 7px;" >TP QLHĐV yêu cầu bổ sung đơn miễn giảm</span>';
				} elseif ($contract_exemptions->status == 9) {
					echo '<span class="label label-warning" style="font-size: 13px; padding: 7px;" >QLCC yêu cầu bổ sung đơn miễn giảm</span>';
				}
															?>
														</td>
														<td class="text-center">
															<a target="_blank"
															   href="<?php echo base_url("exemptions/viewImageExemption?id=") . $contract_exemptions->_id->{'$oid'} ?>"
															   class="link" data-toggle="tooltip"
															   data-placement="top" title="Click để xem ảnh"
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

<!--Modal Lead QLHĐV approve-->
<?php $this->load->view('page/accountant/thn/modal_leadqlhdv_approve_exemption.php'); ?>

<!--Modal TP QLHĐV approve-->
<?php $this->load->view('page/accountant/thn/modal_tpqlhdv_approve_exemption.php'); ?>

<!--Modal QLCC approve-->
<?php $this->load->view('page/accountant/thn/modal_qlcc_approve_exemption.php'); ?>

<script src="<?php echo base_url(); ?>assets/js/examptions/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script>
	$(document).ready(function () {
		$("#data_send_high").hide();
		$("#tp_send_up").click(function () {
			$("#tp_send_up").prop('disabled', true);
			$("#data_send_high").show();
		})
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
