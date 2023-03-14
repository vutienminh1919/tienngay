<div class="theloading" style="display:none">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
	<span>Đang Xử Lý...</span>
</div>

<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
	$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
	//	$investor_code = !empty($_GET['investor']) ? $_GET['investor'] : "";
	$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	//	$customer_phone_number= !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";


	?>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Danh sách hợp đồng yêu cầu chuyển Field
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url('DebtCall/list_contract_debt_to_field') ?>">Danh sách
									hợp đồng yêu cầu chuyển Field
								</a>
							</small>
						</h3>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">

					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-12 col-md-3">
							</div>
							<div class="col-xs-12 col-md-3"></div>
							<div class="col-xs-12 col-md-6 text-right">
								<div class="dropdown" style="display:inline-block">
									<button class="btn btn-success dropdown-toggle"
											onclick="$('#lockdulieu').toggleClass('show');">
										<span class="fa fa-filter"></span>
										Lọc dữ liệu
									</button>
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;width:550px;max-width: 85vw;">
										<div class="row">
											<form action="<?php echo base_url('DebtCall/list_contract_debt_to_field') ?>"
												  method="get"
												  style="width: 100%;">
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Từ </label>
															<input type="date" name="fdate" class="form-control"
																   value="<?= !empty($fdate) ? $fdate : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Đến </label>
															<input type="date" name="tdate" class="form-control"
																   value="<?= !empty($tdate) ? $tdate : "" ?>">
														</div>
													</div>

													<div class="col-xs-12 col-md-6 ">
														<label>Phòng giao dịch</label>
														<select class="form-control" name="store">
															<option value="">Chọn PGD</option>
															<?php foreach ($stores as $store) { ?>
																<option <?php echo $getStore === $store->_id->{'$oid'} ? 'selected' : '' ?>
																		value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Họ và tên</label>
															<input type="text" name="customer_name"
																   class="form-control"
																   placeholder="Tên khách hàng"
																   value="<?php echo $customer_name; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Mã phiếu ghi</label>
															<input type="text" name="code_contract"
																   class="form-control"
																   placeholder="Mã phiếu ghi"
																   value="<?php echo $code_contract; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Mã hợp đồng</label>
															<input type="text" name="code_contract_disbursement"
																   class="form-control"
																   placeholder="Mã hợp đồng"
																   value="<?php echo $code_contract_disbursement; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<label>Trạng thái hợp đồng</label>
														<select class="form-control" name="status_contract">
															<option value=""><?= $this->lang->line('All') ?></option>
															<?php foreach (contract_status() as $key => $item) {
																if (!in_array($key, [17, 20]))
																	continue;
																?>

																<option <?php echo $status_contract == $key ? 'selected' : '' ?>
																		value="<?= $key ?>"><?= $item ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-xs-12 col-md-6">
														<label>Trạng thái call</label>
														<select class="form-control" name="status">
															<option value=""><?= $this->lang->line('All') ?></option>
															<?php foreach (status_contract_debt_to_field() as $key1 => $item1) {
																?>
																<option <?php echo $status == $key1 ? 'selected' : '' ?>
																		value="<?= $key1 ?>"><?= $item1 ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-xs-12 col-md-6">
														<label>&nbsp;</label>
														<button type="submit" class="btn btn-primary w-100"><i
																	class="fa fa-search"
																	aria-hidden="true"></i> <?= $this->lang->line('search') ?>
														</button>
													</div>
											</form>
										</div>
										<script>
											$('.selectize').selectize({
												// sortField: 'text'
											});
										</script>
									</ul>
								</div>
								<?php
								if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles)) { ?>
									<a href="<?php echo base_url() ?>excel/exportContractToField?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $getStore . '&status_contract=' . $status_contract . '&status=' . $status . '&customer_name=' . $customer_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&code_contract=' . $code_contract ?>" class="btn btn-success"
									   target="_blank">
										<i class="fa fa-save" aria-hidden="true"></i>
										Xuất Excel
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div>Hiển thị <span class="text-danger">
									<?php echo $result_count > 0 ? $result_count : 0; ?> </span>Kết quả
							</div>
							<div class="table-responsive">
								<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
									<thead style="background:#3f86c3; color: #ffffff;">
									<tr>
										<th>#</th>
										<th>Chức năng</th>
										<th><?= $this->lang->line('Contract_code') ?></th>
										<th>Mã phiếu ghi</th>
										<th>Tên khách hàng</th>
										<th>Tiền vay</th>
										<th>Thời hạn vay</th>
										<th>Trạng thái hợp đồng</th>
										<th>Trạng thái xử lý</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if (!empty($contractData)) {
										$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
										foreach ($contractData as $key => $contract) {
											$debt_caller_email = !empty($contract->debt_caller_email) ? $contract->debt_caller_email : "";
											?>
											<?php if ($debt_caller_email == $userInfo['email'] || in_array('supper-admin', $groupRoles) || in_array("tbp-thu-hoi-no", $groupRoles) || in_array("van-hanh", $groupRoles)) { ?>
												<tr role="row" class="even parent">
													<td><?php echo $key + 1 ?></td>
													<td>
														<div class="dropdown">
															<button class="btn btn-secondary dropdown-toggle"
																	type="button"
																	id="dropdownMenuButton"
																	data-toggle="dropdown"
																	aria-haspopup="true"
																	aria-expanded="false"
																	style="background-color: #5bc0de; color: white">
																Chức năng
																<span class="caret"></span></button>
															<ul class="dropdown-menu"
																style="z-index: 99999">
																<li>
																	<a class="dropdown-item"
																	   target="_blank"
																	   href="<?php echo base_url("accountant/view_v2?id=") . $contract->contract_id ?>">
																		Chi tiết
																	</a>
																</li>
																<?php if (($userSession['is_superadmin'] == 1 || in_array('tbp-thu-hoi-no', $groupRoles)) && $contract->status == 37) {?>
																<li>
																	<a class="dropdown-item"
																	   href="javascript:void(0)"
																	   onclick="tp_thn_process_field(this)"
																	   data-id="<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>">
																		TP QLHĐV xử lý yêu cầu chuyển Field
																	</a>
																</li>
																<?php } ?>
															</ul>
													</td>
													<td>
														<a class="link"
														   target="_blank"
														   data-toggle="tooltip"
														   title="Click để xem chi tiết"
														   href="<?php echo base_url("accountant/view_v2?id=") . $contract->contract_id ?>"
														   style="color: #0ba1b5;text-decoration: underline;">
															<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : $contract->code_contract ?>
														</a>
													</td>
													<td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
													<td><?= !empty($contract->customer_name) ? $contract->customer_name : "" ?></td>
													<td><?= !empty($contract->amount_money) ? number_format($contract->amount_money, 0, '.', '.') : "" ?></td>
													<td><?= !empty($contract->number_day_loan) ? ($contract->number_day_loan / 30) . ' tháng' : "" ?></td>
													<td><?= !empty($contract->status_contract) ? contract_status($contract->status_contract) : "" ?></td>
													<td><?= !empty($contract->status) ? status_contract_debt_to_field($contract->status) : "" ?></td>
												</tr>
											<?php }
										} ?>
									<?php } else { ?>
										<tr>
											<td colspan="9" class="text-center text-danger"><?php echo "Hiện tại chưa có dữ liệu!";?></td>
										</tr>
									<?php } ?>
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

<div class="modal fade" id="note_contract_v2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<input type="hidden" name="contract_id" class="contract_id" value="">
				<h5 class="modal-title title_modal_contract_v2">Ghi chú</h5>
				<hr>
				<div class="form-group">
					<label>Kết quả nhắc HĐ vay:</label>
					<select class="form-control result_reminder" name="note_renewal" style="width: 75%">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control contract_v2_note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger note_contract_v2_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<!--Modal TP QLHĐV xử lý yêu cầu chuyển Field-->
<div class="modal fade" id="approve_to_field">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<input type="hidden" name="contract_id" class="contract_id" value="">
				<h5 class="modal-title title_modal_contract_v2" style="color: black">TP QLHĐV xử lý yêu cầu chuyển
					Field</h5>
				<hr>
				<div class="row">
					<div class="col-md-6 col-xs-12" style="padding-left: 110px;">
						<label class="control-label" style="color: black; font-weight: unset">
							Đồng ý <span class="text-danger">*</span>
						</label>
						<input type="radio"
							   name="confirm_call_to_field"
							   id="confirm_liquidation_event"
							   value="279"
							   checked="checked"
							   required>
						<p class="messages"></p>
					</div>

					<div class="col-md-6 col-xs-12" style="padding-left: 79px;">
						<label class="control-label" style="color: black; font-weight: unset">
							Không đồng ý <span class="text-danger">*</span>
						</label>
						<input type="radio"
							   name="confirm_call_to_field"
							   id="disagree"
							   value="278"
							   required>
						<p class="messages"></p>
					</div>

				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control contract_debt_call_note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_debt_id">
				</div>
				<p class="text-right">
					<button id="confirm_to_field" class="btn btn-danger">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/debt/debt_call.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script type="text/javascript">
	$('.result_reminder').select2();


	$('select[name="store"]').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
</script>


