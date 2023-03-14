<div class="row">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
	$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
	?>
</div>
<div class="table-responsive">
	<div>Hiển thị <span class="text-danger">
									<?php echo $result_count > 0 ? $result_count : 0; ?> </span>Kết quả
	</div>
	<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
		<thead style="background:#3f86c3; color: #ffffff;">
		<tr class="b_align_center">
			<th>#</th>
			<th>Chức năng</th>
			<th>Chuyển NV</th>
			<th><?= $this->lang->line('Contract_code') ?></th>
			<th>Mã phiếu ghi</th>
			<th>Tên khách hàng</th>
			<th>Số điện thoại</th>
			<th>Tiền vay</th>
			<th>Thời hạn vay</th>
			<th>Trạng thái hợp đồng</th>
			<th>Trạng thái import</th>
			<th>Số ngày chậm trả</th>
			<th>Nhóm </th>
			<th>Khu vực KH</th>
			<th>Đánh giá</th>
			<th>Hoàn thành</th>
			<th>Phòng giao dịch</th>
			<th>Thời gian gán hợp đồng</th>
			<th>Người gán hợp đồng</th>
			<th>Ghi chú</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if (!empty($contractData)) {
			$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
			foreach ($contractData as $key => $contract) {
				if (!empty($contract->status_contract) && $contract->status_contract == 19) continue;
				$debt_field_email = !empty($contract->debt_field_email) ? $contract->debt_field_email : "";
				$dateReminder = getdate($contract->result_reminder[0]->created_at);
				$dateNow = getdate();
				if ($dateReminder['mon'] == $dateNow['mon']) {
					$time = time() - ($contract->result_reminder[0]->created_at);
					$day = $time / 60 / 60 / 24;
				}
				$district = !empty($contract->district) ? get_district_name_by_code($contract->district) : '';
				$province = !empty($contract->province) ? get_province_name_by_code($contract->province) : '';
				?>
				<?php if ($debt_field_email == $userInfo['email'] || in_array('supper-admin', $groupRoles) || in_array("tbp-thu-hoi-no", $groupRoles) || in_array("van-hanh", $groupRoles)) { ?>
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
											<i class="fa fa-edit blue size18" aria-hidden="true">&nbsp;&nbsp;</i>
											Chi tiết
										</a>
									</li>
									<li>
										<a href="javascript:void(0)"
										   onclick="field_for_customer('<?= !empty($contract->customer_phone_number) ? encrypt($contract->customer_phone_number) : "" ?>' , '<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>', 'customer')"
										   class="field_for_customer">
											<i class="fa fa-phone blue size18" aria-hidden="true">&nbsp;&nbsp;</i>
											Gọi cho khách hàng
										</a>
									</li>
									<li>
										<a class="dropdown-item"
										   href="javascript:void(0)"
										   onclick="history_import('<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>')">
											<i class="fa fa-history blue size18" aria-hidden="true">&nbsp;&nbsp;</i>
											Lịch sử import
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
								</ul>
						</td>
						<td>
							<?php if (in_array('tbp-thu-hoi-no', $groupRoles)) {
								?>
								<select class="form-control debt_email_field"
										id="<?= $contract->_id->{'$oid'} ?>"
										data-id="<?= $contract->_id->{'$oid'} ?>"
										onchange="change_debt_field(this)"
										style="min-width: 150px;">
									<option value="">Chọn field</option>

									<?php if (!empty($debt_field_emails)) {
										foreach ($debt_field_emails as $key => $debt_field) {
											?>
											<option <?= ($debt_field_email == $debt_field) ? "selected" : "" ?>
												value="<?= !empty($debt_field) ? $debt_field : ""; ?>"><?= !empty($debt_field) ? $debt_field : ""; ?>
											</option>
											<?php
										}
									} ?>
								</select>
							<?php } else { ?>

								<input id="<?= $contract->contract_id ?>"
									   value="<?= $debt_field_email; ?>" disabled></input>
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
						<td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?><br>
							<a class="btn btn-info"
							   href="javascript:void(0)"
							   onclick="history_import('<?= !empty($contract->contract_id) ? $contract->contract_id : "" ?>')">
								Lịch sử import
							</a>
						</td>
						<td><?= !empty($contract->customer_name) ? $contract->customer_name : "" ?></td>
						<td><?= !empty($contract->customer_phone_number) ? $contract->customer_phone_number : "" ?></td>
						<td><?= !empty($contract->amount_money) ? number_format($contract->amount_money, 0, '.', '.') : "" ?></td>
						<td><?= !empty($contract->number_day_loan) ? ($contract->number_day_loan / 30) . ' tháng' : "" ?></td>
						<td><?= !empty($contract->status_contract_realtime) ? contract_status($contract->status_contract_realtime) : "" ?></td>
						<td><?= !empty($contract->status) ? status_contract_field($contract->status) : "" ?></td>
						<td><?= !empty($contract->time_due) ? $contract->time_due : 0 ?></td>
						<td><?= !empty($contract->bucket) ? $contract->bucket : "" ?></td>
						<td><?php echo $district . '/ ' . $province; ?></td>
						<?php if (!empty($contract->debt_field_email)): ?>
							<td style="text-align: center" class="<?php if ($contract->evaluate == 1 || $contract->evaluate == 4) : ?>
							           text-success
                                       <?php elseif ($contract->evaluate == 5 || $contract->evaluate == 2) : ?>
                                       text-warning
                                       <?php else: ?>
                                       text-danger
                                       <?php endif; ?>">
								<?php echo status_debt_recovery($contract->evaluate) ?>
								<br>
								<a href="javascript:void(0)" onclick="showLogDebt('<?= $contract->contract_id ?>')"
								   class="btn btn-info btn-sm">
									Lịch sử thu hồi
								</a>
							</td>
						<?php else : ?>
							<td></td>
						<?php endif; ?>
						<?php if ($contract->complete == true) : ?>
							<td style="text-align: center" ><i class="fa fa-check-circle" style="font-size: x-large;color: #00A000"></i></td>
						<?php else : ?>
							<td style="text-align: center" ><i class="fa fa-times-circle" style="font-size: x-large;color:red"></i></td>
						<?php endif; ?>
						<td><?= !empty($contract->store_name) ? $contract->store_name : "" ?></td>
						<td><?= !empty($contract->created_at) ? date('d/m/Y H:i:s', $contract->created_at) : "" ?></td>
						<td><?= !empty($contract->created_by) ? $contract->created_by : "" ?></td>
						<td><?= !empty($contract->note) ? $contract->note : "" ?></td>
					</tr>
				<?php }
			} ?>
		<?php } else { ?>
			<tr>
				<td colspan="13"
					class="text-center text-danger"><?php echo "Hiện tại chưa có dữ liệu!"; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<div class="pagination pagination-sm">
		<?php echo $pagination ?>
	</div>
</div>

