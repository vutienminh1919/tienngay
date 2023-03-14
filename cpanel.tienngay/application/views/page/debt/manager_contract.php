<?php
$getId = !empty($_GET['userId']) ? $_GET['userId'] : "";
$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý hợp đồng nhân viên THN
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('debt_manager_app/view_manager_contract') ?>">Quản lý hợp đồng
							nhân
							viên THN</a>
					</small>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<!--Xuất excel-->
						<div class="row">
							<div class="col-xs-12">
								<?php if ($this->session->flashdata('error')) { ?>
									<div class="alert alert-danger alert-result">
										<?= $this->session->flashdata('error') ?>
									</div>
								<?php } ?>
								<?php if ($this->session->flashdata('success')) { ?>
									<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
								<?php } ?>
								<div class="row">
									<form action="<?php echo base_url('debt_manager_app/view_manager_contract') ?>"
										  method="get"
										  style="width: 100%;">
										<div class="col-lg-2">
											<label>Nhân viên</label>
											<div class="">
												<select type="email" name="userId" class="form-control"
														id="idUserDebtAssign">
													<option value="">Chọn nhân viên</option>
													<?php foreach ($debtEmploy as $value) { ?>
														<option <?php echo $getId === $value->id ? 'selected' : '' ?>
																value="<?php echo $value->id; ?>"><?php echo $value->email; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-2">
											<label>Họ và tên</label>
											<input type="text" name="customer_name" class="form-control"
												   placeholder="Tên khách hàng" value="<?php echo $customer_name; ?>">
										</div>

										<div class="col-lg-2">
											<label>Mã hợp đồng</label>
											<input type="text" name="code_contract_disbursement" class="form-control"
												   placeholder="Mã hợp đồng"
												   value="<?php echo $code_contract_disbursement; ?>">
										</div>
										<div class="col-lg-2">
											<label>Số điện thoại</label>
											<input type="text" name="phone_number" class="form-control"
												   placeholder="số điện thoại" value="<?php echo $phone_number; ?>">
										</div>
										<div class="col-lg-2">
											<label>CMND</label>
											<input type="text" name="id_card" class="form-control"
												   placeholder="CMND" value="<?php echo $id_card; ?>">
										</div>
										<div class="col-lg-2 text-right">
											<label></label>
											<button type="submit"
													class="btn btn-primary w-100"><i
														aria-hidden="true"></i>&nbsp; Tìm kiếm
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<div class="title_right text-right">
				<a style="background-color: #18d102;"
				   href="<?= base_url() ?>asDebtContract/excelContractDebt?code_contract_disbursement=<?= $code_contract_disbursement . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&id_card=' . $id_card . '&userId=' . $getId ?>"
				   class="btn btn-primary" target="_blank"><i
							class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Xuất excel
				</a>
				<?php if (!empty($getId)): ?>
					<button class="btn btn-success modal_area overViewUserDebt"
							data-toggle="modal"
							data-target="#overViewUserDebtModal">
						<i class="fa fa-pie-chart" aria-hidden="true"></i>
						Thống kê
					</button>
					<button class="btn btn-info modal_area"
							data-toggle="modal"
							data-target="#addAssignUserDebtModal">
						<i class="fa fa-plus" aria-hidden="true"></i>
						Thêm mới
					</button>
				<?php endif; ?>
				<a class="btn btn-primary" href="<?php echo base_url('debt_manager_app/view_manager_contract') ?>">
					Quay lại
				</a>
			</div>
			<div>Hiển thị
				<span class="text-danger"><?php echo $total_rows > 0 ? $total_rows : 0; ?> </span>
				Kết quả
			</div>
			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th style="text-align: center">#</th>
					<th style="text-align: center">Mã phiếu ghi</th>
					<th style="text-align: center">Mã hợp đồng</th>
					<th style="text-align: center">Khách hàng</th>
					<th style="text-align: center">Số điện thoại</th>
					<th style="text-align: center">Số tiền vay</th>
					<th style="text-align: center">Trạng thái</th>
					<th style="text-align: center">Nhóm </th>
					<th style="text-align: center">Khu vực</th>
					<th style="text-align: center">Nhân viên</th>
					<th style="text-align: center">Đánh giá</th>
					<th style="text-align: center">Hoàn thành</th>
					<th style="text-align: center">Thao tác</th>
				</tr>
				</thead>
				<tbody>
				<?php if (!empty($contract)) : ?>
					<?php foreach ($contract as $key => $value) : ?>
						<?php
						$dateReminder = getdate($value->result_reminder[0]->created_at);
						$dateNow = getdate();
						if ($dateReminder['mon'] == $dateNow['mon']) {
							$time = time() - ($value->result_reminder[0]->created_at);
							$day = $time / 60 / 60 / 24;
						}
						$district = !empty($value->current_address->district) ? get_district_name_by_code($value->current_address->district) : '';
						$province = !empty($value->current_address->province) ? get_province_name_by_code($value->current_address->province) : '';
						?>
						<tr id="contract-user-<?php echo $value->_id->{'$oid'} ?>" style="text-align: center">
							<td><?php echo ++$key ?></td>
							<td>
								<?php echo !empty($value->code_contract) ? $value->code_contract : '' ?>
								<br>
								<a class="btn btn-success btn-sm" target="_blank"
								   href="<?php echo base_url("accountant/view_v2?id=") . $value->_id->{'$oid'} ?>">Chi
									tiết</a>
							</td>
							<td>
								<?php echo !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : '' ?>
							</td>
							<td><?php echo !empty($value->customer_infor->customer_name) ? $value->customer_infor->customer_name : '' ?></td>
							<td><?php echo !empty($value->customer_infor->customer_phone_number) ? $value->customer_infor->customer_phone_number : '' ?></td>
							<td><?php echo !empty($value->loan_infor->amount_money) ? number_format($value->loan_infor->amount_money) : '' ?></td>
							<td><?php echo !empty($value->status) ? contract_status($value->status) : '' ?></td>
							<td><?php echo !empty($value->bucket) ? ($value->bucket) : '' ?></td>
							<td><?php echo $district . '/ ' . $province ?></td>
							<td>
								<?php echo !empty($value->user_debt) ? ($value->user_debt) : '' ?>
								<br>
								<?php if (!empty($value->user_debt)) : ?>
									<?php if ($day > 5 && $day <= 10 && empty($value->debt)): ?>
										<button class="btn btn-danger btn-sm push_noti"
												data-id="<?php echo $value->_id->{'$oid'} ?>"
												data-date="<?php echo round($day) ?>"><i class="fa fa-bolt"></i>
										</button>
									<?php elseif ($day > 10 && empty($value->debt)): ?>
										<button class="btn btn-danger btn-sm push_noti"
												data-id="<?php echo $value->_id->{'$oid'} ?>"
												data-date="<?php echo round($day) ?>"><i class="fa fa-bolt"></i><i
													class="fa fa-bolt"></i>
										</button>
									<?php endif; ?>
								<?php endif; ?>
							</td>
							<?php if (!empty($value->user_debt)): ?>
								<?php
									if (!empty($value->debt_log) && is_array($value->debt_log)) {
										$evaluate = $value->debt_log;
										$result_evaluate = (int)$evaluate[count($evaluate) - 1]->evaluate;
									} else {
										$result_evaluate = 3; // Chưa tác động.
									}
								;?>
								<td class="<?php if ($result_evaluate == 1 || $result_evaluate == 4) : ?>
							           text-success
                                       <?php elseif ($result_evaluate == 5 || $result_evaluate == 2) : ?>
                                       text-warning
                                       <?php else: ?>
                                       text-danger
                                       <?php endif; ?>">
									<?php echo status_debt_recovery($result_evaluate) ?>
									<br>
									<a href="javascript:void(0)" onclick="showLogDebt('<?= $value->_id->{'$oid'} ?>')"
									   class="btn btn-info btn-sm">
										Lịch sử
									</a>
								</td>
							<?php else : ?>
								<td></td>
							<?php endif; ?>
							<?php if ($value->complete == true) : ?>
								<td><i class="fa fa-check-circle" style="font-size: x-large;color: #00A000"></i></td>
							<?php else : ?>
								<td><i class="fa fa-times-circle" style="font-size: x-large;color:red"></i></td>
							<?php endif; ?>
							<td>
								<button class="btn btn-primary assignUserDebt "
										data-toggle="modal" data-target="#assignUserDebtModal"
										data-id="<?php echo $value->_id->{'$oid'} ?>"
										onclick="showContractId('<?php echo $value->_id->{'$oid'} ?>')">
									Chuyển NV
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="20" class="text-center">Không có dữ liệu</td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
			<div class="">
				<?php echo $pagination; ?>
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
							<input type="button" id="contract_debt_btnSave" class="btn btn-info" value="Lưu" data-dismiss="modal">
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
							<input type="button" id="addAssignUserDebtModal_btnSave" class="btn btn-info" value="Lưu" data-dismiss="modal">
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
<script src="<?php echo base_url(); ?>assets/js/debt/contract.js"></script>



