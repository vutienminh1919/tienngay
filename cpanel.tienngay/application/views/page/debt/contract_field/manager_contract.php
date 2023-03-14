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
$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
$email = !empty($_GET['email']) ? $_GET['email'] : "";
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
						<h3>Danh sách hợp đồng đã gán cho Field
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url('Debt_manager_app/list_contract_field') ?>">Danh
									sách hợp đồng đã gán cho Field
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
					<div class="row">
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
												<form action="<?php echo base_url('Debt_manager_app/list_contract_field') ?>"
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

													<div class="col-xs-12 col-md-6">
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
															<label>Số điện thoại</label>
															<input type="text" name="customer_phone"
																   class="form-control"
																   placeholder="Số điện thoại"
																   value="<?php echo $customer_phone; ?>">
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
														<div class="form-group">
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
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Trạng thái call</label>
															<select class="form-control" name="status">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach (status_contract_field() as $key1 => $item1) {
																	?>
																	<option <?php echo $status == $key1 ? 'selected' : '' ?>
																			value="<?= $key1 ?>"><?= $item1 ?></option>
																<?php } ?>
															</select>
														</div>
													</div>

													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Email nhân viên</label>
															<select class="form-control" name="email">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach ($debt_field_emails as $key2 => $item2) {
																	?>
																	<option <?php echo $email == $item2 ? 'selected' : '' ?>
																			value="<?= $item2 ?>"><?= $item2 ?></option>
																<?php } ?>
															</select>
														</div>
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
										<a href="<?php echo base_url() ?>Debt_manager_app/exportContractAssignField?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $getStore . '&status_contract=' . $status_contract . '&status=' . $status . '&customer_name=' . $customer_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&code_contract=' . $code_contract . '&tab=' . $tab . '&email=' . $email ?>"
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
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $Roles)) { ?>
										<li class="<?= ($tab == 'all') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>Debt_manager_app/list_contract_field?tab=all">Tất
												cả</a>
										</li>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles)) { ?>
										<li class="<?= ($tab == 'review') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>Debt_manager_app/list_contract_field?tab=review">TP
												Review</a>
										</li>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('field-thu-hoi-no-mien-bac', $Roles) || in_array('field-thu-hoi-no-mien-nam', $Roles)) { ?>
										<li class="<?= ($tab == 'assigned') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>Debt_manager_app/list_contract_field?tab=assigned">Đã
												phân công</a>
										</li>
										<li class="<?= ($tab == 'remaining') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>Debt_manager_app/list_contract_field?tab=remaining">
												Chưa
												xử lý</a>
										</li>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $Roles)) { ?>
										<li class="<?= ($tab == 'block') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>Debt_manager_app/list_contract_field?tab=block">TP
												từ chối</a>
										</li>
										<li class="<?= ($tab == 'cancel') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>Debt_manager_app/list_contract_field?tab=cancel">TP
												Hủy</a>
										</li>
									<?php } ?>
								</ul>

								<div class="tab-content">
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $Roles)) { ?>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'all') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'all') { ?>
												<?php $this->load->view('page/debt/contract_field/debt_field_all.php'); ?>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles)) { ?>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'review') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'review') { ?>
												<?php $this->load->view('page/debt/contract_field/debt_field_review.php'); ?>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('field-thu-hoi-no-mien-bac', $Roles) || in_array('field-thu-hoi-no-mien-nam', $Roles)) { ?>
										<div role="tabpanel"
											 class="tab-pane <?= ($tab == 'assigned') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'assigned') { ?>
												<?php $this->load->view('page/debt/contract_field/debt_field_assigned.php'); ?>
											<?php } ?>
										</div>
										<div role="tabpanel"
											 class="tab-pane <?= ($tab == 'remaining') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'remaining') { ?>
												<?php $this->load->view('page/debt/contract_field/debt_field_remaining.php'); ?>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if (in_array('supper-admin', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('lead-thn', $Roles)) { ?>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'block') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'block') { ?>
												<?php $this->load->view('page/debt/contract_field/debt_field_block.php'); ?>
											<?php } ?>
										</div>
										<div role="tabpanel" class="tab-pane <?= ($tab == 'cancel') ? 'active' : '' ?>"
											 id="">
											<br/>
											<?php if ($tab == 'cancel') { ?>
												<?php $this->load->view('page/debt/contract_field/debt_field_cancel.php'); ?>
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

<!--Modal lịch sử xử lý của call tới field-->
<div class="modal fade" id="contract_debt_call_log" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 70%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Lịch sử import hợp đồng cho Field</h3>
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
					<label>Kết quả nhắc HĐ vay:</label>
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
<div class="modal fade" id="assignUserDebtModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title title_contract_update text-primary" style="text-align: center"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="contractIdInput"/>
						<div class="form-group pb-5">
							<label class="control-label col-md-3">Chọn nhân viên:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<select class="form-control" name="email_user_debt" id="email_user_debt">
									<option value="">Chọn nhân viên</option>
									<?php foreach ($debtEmploy as $value) { ?>
										<option value="<?php echo $value->id; ?>"><?php echo $value->email; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<br>
						<br>
						<div style="text-align: center" id="group-button">
							<!--							<button type="button" id="company_btnSave" class="btn btn-info">Lưu</button>-->
							<input type="button" id="contract_debt_btnSave" class="btn btn-info" value="Lưu"
								   data-dismiss="modal">
							<button type="button" class="btn btn-primary company_close" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addAssignUserDebtModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<?php foreach ($debtEmploy as $value) : ?>
					<?php if ($getId === $value->id) : ?>
						<h3 class="modal-title title_user_assign text-primary" style="text-align: center">
							<?php echo "Nhân viên " . $value->email; ?>
						</h3>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="userIdAssign"/>
						<div class="form-group pb-5">
							<label class="control-label col-md-3">Hợp đồng:
								<span class="text-danger">*</span></label>
							<div class="col-md-9">
								<input class="form-control" type="text" value="" name="contractAssignUserDebt"
									   placeholder="Nhập mã hợp đồng"/>
							</div>
						</div>
						<br>
						<br>
						<div class="form-group pb-5">
							<label class="control-label col-md-3">Ghi chú:
								<span class="text-danger">*</span></label>
							<div class="col-md-9">
								<textarea class="form-control" type="text" id="noteAssignUserDebt"
										  name="noteAssignUserDebt"
										  placeholder=""></textarea>
							</div>
						</div>
						<br>
						<br>
						<br>
						<div style="text-align: center" id="group-button">
							<!--							<button type="button" id="company_btnSave" class="btn btn-info">Lưu</button>-->
							<input type="button" id="addAssignUserDebtModal_btnSave" class="btn btn-info" value="Lưu"
								   data-dismiss="modal">
							<button type="button" class="btn btn-primary company_close" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="overViewUserDebtModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<?php foreach ($debtEmploy as $value) : ?>
					<?php if ($getId === $value->id) : ?>
						<h3 class="modal-title title_user_assign text-primary" style="text-align: center">
							<?php echo "Nhân viên " . $value->email; ?>
						</h3>
					<?php endif; ?>
				<?php endforeach; ?>
				<h3 class="modal-title title_user_assign text-primary" style="text-align: center">
					Thống kê tháng <?php echo date('m') ?>
				</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">POSBOM:</label>
							<div class="col-md-6 pos text-danger">

							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Tổng tiền thu:</label>
							<div class="col-md-6 tien_da_thu" style="color: #18d102">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Chưa gặp:</label>
							<div class="col-md-6 chua_gap text-danger">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Đã gặp:</label>
							<div class="col-md-6 da_gap" style="color: #18d102">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Chưa xử lý:</label>
							<div class="col-md-6 chua_xu_ly text-danger">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Đã xử lý:</label>
							<div class="col-md-6 da_xu_ly" style="color: #18d102">
							</div>
						</div>
					</div>
					<div class="col-xs-12">
						<hr>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Chưa viếng thăm:</label>
							<div class="col-md-6 chua_vieng_tham text-danger">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Đã thu tiền:</label>
							<div class="col-md-6 da_thu_tien" style="color: #18d102">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Tiếp tục tác động:</label>
							<div class="col-md-6 tiep_tuc_tac_dong text-danger">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Hứa thanh toán:</label>
							<div class="col-md-6 hua_thanh_toan" style="color: #18d102">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Mất khả năng thanh toán:</label>
							<div class="col-md-6 mat_kha_nang_thanh_toan text-danger">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Đã thu hồi xe:</label>
							<div class="col-md-6 da_thu_hoi_xe" style="color: #18d102">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="tab_debt_log" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<?php $this->load->view('page/debt/modal_history_debt'); ?>
</div>

<!--Modal lịch sử import field-->
<div class="modal fade" id="contract_debt_call_log" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 70%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Lịch sử import hợp đồng</h3>
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
<script src="<?php echo base_url(); ?>assets/js/debt/contract.js"></script>
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


