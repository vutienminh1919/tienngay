<div class="row">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
	$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
	?>
	<?php if (in_array('tbp-thu-hoi-no', $groupRoles) || in_array('supper-admin', $groupRoles) || in_array('van-hanh', $groupRoles)) {
		?>
		<div class="col-lg-2">
			<select class="form-control" id="choose_status">
				<option value="">-- Chọn chức năng xóa HĐ --</option>
				<option value="4">Xóa hợp đồng</option>
			</select>
		</div>
		<div class="col-lg-7">
			<textarea id="approve_note" class="form-control note" rows="1" cols="2" placeholder="Nhập lý do"></textarea>
		</div>
		<div class="col-lg-1">
			<a class="btn btn-info"
			   onclick="approve_contract_to_call(this)" data-tab="1">
				Xác nhận
			</a>
		</div>
	<?php } ?>
	<div class="col-lg-2 text-right">
	</div>
</div>
<div class="table-responsive">
	<div>Hiển thị <span class="text-danger">
									<?php echo $result_count > 0 ? $result_count : 0; ?> </span>Kết quả
	</div>
	<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
		<thead style="background:#3f86c3; color: #ffffff;">
		<tr>
			<th>#</th>
			<?php if ($userSession['is_superadmin'] == 1 || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles)) { ?>
				<th>
					<input type="checkbox" name="all_contract_debt"
						   id="select_all_contract">
				</th>
			<?php } ?>
			<th>Chức năng</th>
			<th>Chuyển NV</th>
			<th><?= $this->lang->line('Contract_code') ?></th>
			<th>Mã phiếu ghi</th>
			<th>Tên khách hàng</th>
			<th>Tiền vay</th>
			<th>Thời hạn vay</th>
			<th>Trạng thái hợp đồng</th>
			<th>Trạng thái gán Call</th>
			<th>Số ngày chậm trả</th>
			<th>Nhóm </th>
			<th>Phòng giao dịch</th>
			<th>Thời gian gán hợp đồng</th>
			<th>Người gán hợp đồng</th>
			<th>Ghi chú</th>
			<th>Trạng thái gọi</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if (!empty($contractData)) {
			$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
			foreach ($contractData as $key => $contract) {
//				if (!empty($contract->status_contract) && $contract->status_contract == 19) continue;
				$debt_caller_email = !empty($contract->debt_caller_email) ? $contract->debt_caller_email : "";
				?>
				<?php if ($debt_caller_email == $userInfo['email'] || in_array('supper-admin', $groupRoles) || in_array("tbp-thu-hoi-no", $groupRoles) || in_array("van-hanh", $groupRoles) || in_array("lead-thn", $groupRoles)) { ?>
					<tr role="row" class="even parent">
						<td><?php echo $key + 1 ?></td>
						<?php if ($userSession['is_superadmin'] == 1 || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles)) { ?>
							<td>
								<input type="checkbox"
									   name="date-call[]"
									   value="<?php echo $contract->_id->{'$oid'}; ?>"
									   class="checkbox_approve">
							</td>
						<?php } ?>
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
											<i class="fa fa-edit blue size18" aria-hidden="true">&nbsp;&nbsp;</i>
											Chi tiết
										</a>
									</li>
									<li>
										<a href="javascript:void(0)"
										   onclick="call_for_customer('<?= !empty($contract->customer_phone_number) ? encrypt($contract->customer_phone_number) : "" ?>' , '<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>', 'customer')"
										   class="call_for_customer">
											<i class="fa fa-phone blue size18" aria-hidden="true">&nbsp;&nbsp;</i>
											Gọi cho khách hàng
										</a>
									</li>
									<li>
										<a class="dropdown-item"
										   href="javascript:void(0)"
										   onclick="history_processing('<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>')">
											<i class="fa fa-history blue size18" aria-hidden="true">&nbsp;&nbsp;</i>
											Lịch sử xử lý
										</a>
									</li>
									<li>
										<a class="dropdown-item"
										   target="_blank"
										   href="<?php echo base_url("accountant/view_v2?id=") . $contract->contract_id . '#tab_content10' ?>">
											<i class="fa fa-history blue size18" aria-hidden="true">&nbsp;&nbsp;</i>
											Lịch sử tác động KH
										</a>
									</li>
									<?php if (!empty($contract->time_range_to_field) && !isset($contract->update_range_time) && in_array('tbp-thu-hoi-no', $groupRoles)) {
										?>
										<li>
											<a class="dropdown-item"
											   href="javascript:void(0)"
											   onclick="update_time_field(this)"
											   data-id="<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>">
												Chỉnh sửa time chuyển Field
											</a>
										</li>
									<?php } ?>
								</ul>
						</td>
						<td>
							<?php if (in_array('tbp-thu-hoi-no', $groupRoles)) {
								?>
								<select class="form-control debt_email_caller"
										id="<?= $contract->_id->{'$oid'} ?>"
										data-id="<?= $contract->_id->{'$oid'} ?>"
										onchange="change_debt_caller(this)"
										style="min-width: 150px;">
									<option value="">Chọn Caller</option>

									<?php if (!empty($debt_caller_emails)) {
										foreach ($debt_caller_emails as $key => $debt_call) {
											?>
											<option <?= ($debt_caller_email == $debt_call) ? "selected" : "" ?>
													value="<?= !empty($debt_call) ? $debt_call : ""; ?>"><?= !empty($debt_call) ? $debt_call : ""; ?>
											</option>
											<?php
										}
									} ?>
								</select>
							<?php } else { ?>

								<input id="<?= $contract->contract_id ?>"
									   value="<?= $debt_caller_email; ?>" disabled></input>
							<?php } ?>
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
						<td style="text-align: center">
							<?= !empty($contract->code_contract) ? $contract->code_contract : "" ?><br>
							<a class="btn btn-info"
							   href="javascript:void(0)"
							   onclick="history_processing('<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>')">
								Lịch sử xử lý
							</a>
						</td>
						<td><?= !empty($contract->customer_name) ? $contract->customer_name : "" ?></td>
						<td><?= !empty($contract->amount_money) ? number_format($contract->amount_money, 0, '.', '.') : "" ?></td>
						<td><?= !empty($contract->number_day_loan) ? ($contract->number_day_loan / 30) . ' tháng' : "" ?></td>
						<td><?= !empty($contract->status_contract_realtime) ? contract_status($contract->status_contract_realtime) : "" ?></td>
						<td><?= !empty($contract->status) ? status_contract_debt_to_field($contract->status) : "" ?></td>
						<td><?= !empty($contract->so_ngay_cham_tra) ? $contract->so_ngay_cham_tra : 0 ?></td>
						<td><?= !empty($contract->bucket) ? $contract->bucket : "" ?></td>
						<td><?= !empty($contract->store_name) ? $contract->store_name : "" ?></td>
						<td><?= !empty($contract->created_at) ? date('d/m/Y H:i:s', $contract->created_at) : "" ?></td>
						<td><?= !empty($contract->created_by) ? $contract->created_by : "" ?></td>
						<td><?= !empty($contract->note) ? $contract->note : "" ?></td>
						<td><?= !empty($contract->evaluate) ? note_renewal($contract->evaluate) : "" ?></td>
					</tr>
				<?php }
			} ?>
		<?php } else { ?>
			<tr>
				<td colspan="13" class="text-center text-danger"><?php echo "Hiện tại chưa có dữ liệu!"; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
