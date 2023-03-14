<div class="table-responsive">
	<div>
		<h4>Thống kê hợp đồng gán cho Field trước khi duyệt</h4>
	</div>
	<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
		<thead style="background:#3f86c3; color: #ffffff;">
		<tr class="b_align_center">
			<th>#</th>
			<th>Nhân viên</th>
			<th>B0</th>
			<th>B1</th>
			<th>B2</th>
			<th>B3</th>
			<th>B4</th>
			<th>B5</th>
			<th>B6</th>
			<th>B7</th>
			<th>B8</th>
			<th>Tổng</th>
		</tr>
		</thead>
		<tbody>
		<tr style="background: #8DEEEE; font-weight: bold">
			<td colspan="2" style="text-align: center">Tổng</td>
			<td>
				<?= !empty($total_count_b0) ? ($total_count_b0) : 0 ?> <br>
				<?= !empty($total_sum_b0) ? number_format($total_sum_b0) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b1) ? ($total_count_b1) : 0 ?> <br>
				<?= !empty($total_sum_b1) ? number_format($total_sum_b1) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b2) ? ($total_count_b2) : 0 ?> <br>
				<?= !empty($total_sum_b2) ? number_format($total_sum_b2) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b3) ? ($total_count_b3) : 0 ?> <br>
				<?= !empty($total_sum_b3) ? number_format($total_sum_b3) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b4) ? ($total_count_b4) : 0 ?> <br>
				<?= !empty($total_sum_b4) ? number_format($total_sum_b4) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b5) ? ($total_count_b5) : 0 ?> <br>
				<?= !empty($total_sum_b5) ? number_format($total_sum_b5) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b6) ? ($total_count_b6) : 0 ?> <br>
				<?= !empty($total_sum_b6) ? number_format($total_sum_b6) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b7) ? ($total_count_b7) : 0 ?> <br>
				<?= !empty($total_sum_b7) ? number_format($total_sum_b7) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_b8) ? ($total_count_b8) : 0 ?> <br>
				<?= !empty($total_sum_b8) ? number_format($total_sum_b8) . " đ" : 0 ?>
			</td>
			<td>
				<?= !empty($total_count_all) ? ($total_count_all) : 0 ?> <br>
				<?= !empty($total_sum_all) ? number_format($total_sum_all) . " đ" : 0 ?>
			</td>

		</tr>
		<?php if (!empty($data_review)) :
			foreach ($data_review as $key => $review) :
				?>
				<tr>
					<td><?php echo $key; ?></td>
					<td><?= !empty($review->email) ? $review->email : ""; ?></td>
					<td><?= !empty($review->count_b0) ? $review->count_b0 : 0; ?>
						<br> <?= !empty($review->sum_b0) ? number_format($review->sum_b0) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b1) ? $review->count_b1 : 0; ?>
						<br> <?= !empty($review->sum_b1) ? number_format($review->sum_b1) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b2) ? $review->count_b2 : 0; ?>
						<br> <?= !empty($review->sum_b2) ? number_format($review->sum_b2) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b3) ? $review->count_b3 : 0; ?>
						<br> <?= !empty($review->sum_b3) ? number_format($review->sum_b3) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b4) ? $review->count_b4 : 0; ?>
						<br> <?= !empty($review->sum_b4) ? number_format($review->sum_b4) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b5) ? $review->count_b5 : 0; ?>
						<br> <?= !empty($review->sum_b5) ? number_format($review->sum_b5) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b6) ? $review->count_b6 : 0; ?>
						<br> <?= !empty($review->sum_b6) ? number_format($review->sum_b6) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b7) ? $review->count_b7 : 0; ?>
						<br> <?= !empty($review->sum_b7) ? number_format($review->sum_b7) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_b8) ? $review->count_b8 : 0; ?>
						<br> <?= !empty($review->sum_b8) ? number_format($review->sum_b8) . ' đ' : 0; ?>
					</td>
					<td><?= !empty($review->count_all_by_email) ? $review->count_all_by_email : 0; ?>
						<br> <?= !empty($review->sum_all_by_email) ? number_format($review->sum_all_by_email) . ' đ' : 0; ?>
					</td>
				</tr>
			<?php
			endforeach;
		endif; ?>
		</tbody>
	</table>
</div>
<br>
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
				<option value="">-- Chọn chức năng duyệt --</option>
				<option value="2">Đồng ý</option>
				<option value="3">Từ chối</option>
			</select>
		</div>
		<div class="col-lg-9">
			<textarea id="approve_note" class="form-control note" rows="1" cols="2" placeholder="Nhập lý do"></textarea>
		</div>
		<div class="col-lg-1">
			<a class="btn btn-info"
			   onclick="approve_contract_to_field(this)" data-tab="1">
				Xác nhận
			</a>
		</div>
	<?php } ?>
</div>
<div class="table-responsive">
	<div>Hiển thị <span class="text-danger">
									<?php echo $result_count > 0 ? $result_count : 0; ?> </span>Kết quả
	</div>
	<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton list_field_qlkv" id="approve_contract_field_app">
		<thead style="background:#3f86c3; color: #ffffff;">
		<tr class="b_align_center">
			<th>#</th>
			<th>
				<?php if ($userSession['is_superadmin'] == 1 || in_array('tbp-thu-hoi-no', $groupRoles)) { ?>
					<input type="checkbox" name="all_contract_debt"
						   id="select_all_contract">
				<?php } ?>
			</th>
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
			<th>Nhóm</th>
			<th>Khu vực KH</th>
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
				$district = !empty($contract->district) ? get_district_name_by_code($contract->district) : '';
				$province = !empty($contract->province) ? get_province_name_by_code($contract->province) : '';
				?>
				<?php if ($debt_field_email == $userInfo['email'] || in_array('supper-admin', $groupRoles) || in_array("tbp-thu-hoi-no", $groupRoles) || in_array("van-hanh", $groupRoles)) { ?>
					<tr role="row" class="even parent">
						<td><?php echo $key + 1 ?></td>
						<td>
							<?php if (in_array($contract->status, [1])) { ?>
								<input type="checkbox"
									   name="date-field[]"
									   value="<?php echo $contract->_id->{'$oid'}; ?>"
									   class="checkbox_approve">
							<?php } ?>
						</td>
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

