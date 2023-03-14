<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$loan = !empty($_GET['loan']) ? $_GET['loan'] : "";


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
						<h3>Hợp đồng chuyển thực địa
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>">Hợp
									đồng chuyển thực địa</a>
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
						<div class="col-xs-12 col-lg-12">
							<div class="row">
								<form action="<?php echo base_url('accountant/reminder_ctd') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12 col-lg-3">
										<div class="form-group">
											<label>Từ</label>
											<input type="date" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-3">
										<div class="form-group">
											<label>Đến</label>
											<input type="date" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>Hình thức vay</label>
										<select class="form-control" name="loan">
											<option value="">Chọn hình thức vay</option>
											<?php foreach (lead_type_finance() as $key => $value) { ?>
												<option <?php echo $loan == $key ? 'selected' : '' ?>
														value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-lg-2 text-right">
										<label>&nbsp;</label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">

							<div class="table-responsive">
								<div><?php echo $result_count; ?></div>
								<table id="datatable-button" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th><?= $this->lang->line('See_details') ?></th>
										<th><?= $this->lang->line('Contract_code') ?></th>

										<th><?= $this->lang->line('Customer') ?></th>
										<th>Hình thức vay</th>
										<th>Địa chỉ</th>
										<th>Số tiền vay</th>
										<th>Tổng phí + lãi</th>
										<th>Tiền gốc</th>
										<th>Tiền phạt</th>
										<th>Tổng tiền</th>
										<th>Tiền thu được</th>
										<th>Số ngày trễ</th>

									</tr>
									</thead>

									<tbody>
									<?php
									if (!empty($contractData)) {
										foreach ($contractData as $key => $contract) {
											if ($loan == 3 || $loan == 4) {
												if ($contract->loan_infor->type_loan->code != "DKX") {
													continue;
												}
											} else if ($loan == 1 || $loan == 2) {
												if ($contract->loan_infor->type_loan->code != "CC") {
													continue;
												}

											}
											?>

											<tr>
												<td><?php echo $key + 1 ?></td>

												<td style="text-align: -webkit-center;">
													<div class="dropdown">
														<button class="btn btn-secondary dropdown-toggle" type="button"
																id="dropdownMenuButton" data-toggle="dropdown"
																aria-haspopup="true" aria-expanded="false">
															Chức năng
															<span class="caret"></span></button>
														<ul class="dropdown-menu" style="z-index: 99999">

															<li><a target="_blank" class="dropdown-item"
																   href="<?php echo base_url("accountant/view_v2?id=") . $contract->_id->{'$oid'} ?>">
																	Chi tiết
																</a></li>

															<li><a href="javascript:void(0)" onclick="note_thn(this)"
																   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																   class="dropdown-item"> Ghi chú</a>
															</li>
														</ul>

												</td>
												<!-- <td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td> -->
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : $contract->code_contract ?></td>
												<td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></td>
												<td><?= !empty($contract->loan_infor->type_loan->text) ? $contract->loan_infor->type_loan->text : "" ?>
													<br>
													<?= !empty($contract->loan_infor->type_property->text) ? $contract->loan_infor->type_property->text : "" ?>
												</td>
												<td>Đang
													ở:<?= $contract->current_address->ward_name . "-" . $contract->current_address->district_name . "-" . $contract->current_address->province_name ?>
													<br>
													Hộ
													khẩu:<?= $contract->houseHold_address->ward_name . "-" . $contract->houseHold_address->district_name . "-" . $contract->houseHold_address->province_name ?>

												</td>
												<td><?= !empty($contract->loan_infor->amount_money) ? number_format($contract->loan_infor->amount_money) : "0" ?></td>
												<td><?= number_format($contract->tong_phi_lai) ?></td>
												<td><?= !empty($contract->tong_goc) ? number_format($contract->tong_goc) : "0" ?></td>
												<td><?= !empty($contract->detail->total_phi_phat_cham_tra) ? number_format($contract->detail->total_phi_phat_cham_tra) : "0" ?></td>

												<td><?= !empty($contract->detail->total_paid) ? number_format($contract->detail->total_paid) : "0" ?></td>
												<td><?= !empty($contract->detail->total_da_thanh_toan) ? number_format($contract->detail->total_da_thanh_toan) : "0" ?></td>

												<td>
													<?php
													if ($contract->status == 17) {
														// if (!empty($contract->detail) && $contract->detail->status == 1) {
														$current_day = strtotime(date('m/d/Y'));
														$datetime = !empty($contract->ban_ghi_lai_ky_qua_han[0]->ngay_ky_tra) ? intval($contract->ban_ghi_lai_ky_qua_han[0]->ngay_ky_tra) : $current_day;
														$time = intval(($current_day - $datetime) / (24 * 60 * 60));
														echo $time;
													}
													?>
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

<div class="modal fade" id="note_contract_v2" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_contract_v2">Ghi chú</h5>
				<hr>
				<div class="form-group">
					<label>Kết quả nhắc HĐ vay:</label>
					<select class="form-control result_reminder" name="note_renewal">
						<option value=""></option>
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
				</table>
				<p class="text-right">
					<button class="btn btn-danger note_contract_v2_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>
<script type="text/javascript">
	$('#gdv').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		},
		dropdownParent: 'body'
	});
</script>
