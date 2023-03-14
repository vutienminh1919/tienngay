<!-- page content -->
<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
$status = !empty($_GET['status']) ? $_GET['status'] : "";
$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
$email = !empty($_GET['email_call']) ? $_GET['email_call'] : "";
$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "assigned";
?>
<div class="right_col" role="main">
	<div class="theloading" id="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>

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
						<h3>Danh sách hợp đồng nhắc HĐV đã gán cho Call
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url('DebtCall/list_contract_call') ?>">Danh sách hợp đồng
									nhắc HĐV đã gán cho Call
								</a>
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
					<div class="row" >
						<div class="col-xs-12">
							<div class="row" style="justify-content: flex-end;">
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
												<form action="<?php echo base_url('DebtCall/list_contract_call') ?>"
													  method="get"
													  style="width: 100%;">
													<div class="col-xs-12 col-md-6">
														<input type="hidden" name="tab" class="form-control"
															   value="<?= !empty($tab) ? $tab : "" ?>">
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
														<label>Email nhân viên</label>
														<select class="form-control" name="email_call">
															<option value=""><?= $this->lang->line('All') ?></option>
															<?php foreach ($debt_caller_emails as $key2 => $item2) {
																?>
																<option <?php echo $email == $item2 ? 'selected' : '' ?>
																		value="<?= $item2 ?>"><?= $item2 ?></option>
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
									<?php if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles)) { ?>
										<a href="<?php echo base_url() ?>excel/exportContractAssignCall?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $getStore . '&status_contract=' . $status_contract . '&status=' . $status . '&customer_name=' . $customer_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&code_contract=' . $code_contract . '&tab=' . $tab ?>"
										   class="btn btn-success"
										   target="_blank">
											<i class="fa fa-save" aria-hidden="true"></i>
											Xuất Excel
										</a>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="group-tabs" style="width: 100%;">
								<ul class="nav nav-pills">
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $groupRoles)) { ?>
										<li class="<?= ($tab == 'all') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>DebtCall/list_contract_call?tab=all">Tất
												cả</a>
										</li>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles)) { ?>
										<li class="<?= ($tab == 'review') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>DebtCall/list_contract_call?tab=review">TP
												Review</a>
										</li>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('call-thu-hoi-no-mien-bac', $Roles) || in_array('call-thu-hoi-no-mien-nam', $Roles)) { ?>
										<li class="<?= ($tab == 'assigned') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>DebtCall/list_contract_call?tab=assigned">Đã
												phân công</a>
										</li>
										<li class="<?= ($tab == 'active') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>/DebtCall/list_contract_call?tab=active">
												Chưa
												xử lý</a>
										</li>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $Roles)) { ?>
										<li class="<?= ($tab == 'block') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>/DebtCall/list_contract_call?tab=block">TP
												từ chối</a>
										</li>
										<li class="<?= ($tab == 'cancel') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>/DebtCall/list_contract_call?tab=cancel">TP
												Hủy</a>
										</li>
										<li class="<?= ($tab == 'field') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>/DebtCall/list_contract_call?tab=field">HĐ
												chuyển Field</a>
										</li>
									<?php } ?>
								</ul>
								<div class="tab-content">
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $groupRoles)) { ?>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'all') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'all') { ?>
												<?php $this->load->view('page/debt/contract_call/debt_call_tab_all.php'); ?>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles)) { ?>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'review') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'review') { ?>
												<?php $this->load->view('page/debt/contract_call/debt_call_tab_review.php'); ?>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('call-thu-hoi-no-mien-bac', $Roles) || in_array('call-thu-hoi-no-mien-nam', $Roles)) { ?>
										<div role="tabpanel"
											 class="tab-pane <?= ($tab == 'assigned') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'assigned') { ?>
												<?php $this->load->view('page/debt/contract_call/debt_call_tab_assigned.php'); ?>
											<?php } ?>
										</div>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'active') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'active') { ?>
												<?php $this->load->view('page/debt/contract_call/debt_call_tab_active.php'); ?>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $Roles)) { ?>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'block') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'block') { ?>
												<?php $this->load->view('page/debt/contract_call/debt_call_tab_block.php'); ?>
											<?php } ?>
										</div>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'cancel') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'cancel') { ?>
												<?php $this->load->view('page/debt/contract_call/debt_call_tab_cancel.php'); ?>
											<?php } ?>
										</div>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'field') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'field') { ?>
												<?php $this->load->view('page/debt/contract_call/debt_call_tab_field.php'); ?>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">


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
					<label>Kết quả nhắc HĐV:</label>
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

<!--Modal lịch sử xử lý của call tới field-->
<div class="modal fade" id="contract_debt_call_log" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 70%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Lịch sử xử lý hợp đồng</h3>
			</div>
			<div class="modal-body ">
				<div class="x_panel">
					<div class="x_content">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
								<tr>
									<th>#</th>
									<th>Ngày tạo</th>
									<th>Người xử lý</th>
									<th>Mã hợp đồng</th>
									<th>Khách hàng</th>
									<th>Trạng thái</th>
									<th>Ghi chú</th>
								</tr>
								</thead>
								<tbody id="tbody_contract_debt_log">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!--Modal chỉnh sửa time setup chuyển Field-->
<div class="modal fade" id="update_setup_time">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<input type="hidden" name="contract_call_id" class="contract_call_id" value="">
				<h5 class="modal-title" style="color: black">Chỉnh sửa thời gian chuyển Field</h5>
				<hr>

				<div class="form-group" style="padding-left: 165px">
					<label style="color: black">Đến ngày: </label>
					<input type="date" name="update_time_field" id="update_time_field">
				</div>
				<p class="text-right">
					<button class="btn btn-danger" id="update_time_field_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<!--Modal Call THN-->
<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
				<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
				<input id="number" name="phone_number" type="hidden" value=""/>
				<p id="status" style="margin-left: 125px;"></p>
				<h3 class="modal-title title_modal_approve"></h3>
				<hr>
				<div class="form-group">
					<label>Kết quả nhắc HĐV:</label>
					<select class="form-control " style="width: 70%" id="result_reminder">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Ngày hẹn thanh toán:</label>
					<input type="date" name="payment_date" class="form-control " id="payment_date">
				</div>
				<div class="form-group">
					<label>Số tiền hẹn thanh toán:</label>
					<input type="text" class="form-control " id="amount_payment_appointment">
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control " id="contract_v2_note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-danger " id="approve_call_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

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

<style>
	table .b_align_center th {
		text-align: center;
	}

	li.active {
		background: #035927;
	}

	ul.nav.nav-pills {
		width: 100%;
		border-bottom: 1px solid;
	}

	.nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
		background: transparent
	}

	.nav-pills > li {
		float: left;
		border: 1px solid;
		border-bottom: unset;
		border-radius: 5px 5px 0 0;
		margin-right: 10px;
	}

</style>


