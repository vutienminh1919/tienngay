<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$payment_method = !empty($_GET['payment_method']) ? $_GET['payment_method'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$code = !empty($_GET['code']) ? $_GET['code'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$tab = !empty($_GET['tab']) ? $_GET['tab'] : "all";
	function get_tt_tran($id)
	{
		switch ($id) {
			case 'new':
				return "Mới";
				break;
			case '1':
				return "Thành công";
				break;
			case '2':
				return "Chờ xác nhận";
				break;
			case '3':
				return "Đã hủy";
				break;
			case '11':
				return "Kế toán trả về";
				break;
		}
	}

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
						<h3><?php echo $this->lang->line('receipts_list') ?> hợp đồng PGD
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="#>"><?php echo $this->lang->line('receipts_list') ?> PGD</a>
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
							<div class="row">
								<div class="col-xs-12 col-md-3"></div>
								<div class="col-xs-12 col-md-3"></div>
								<div class="col-xs-12 col-md-6 text-right">
<!--									61bc4bf4dc911d4073448964 = access_right xuất excel phiếu thu HĐ PGD-->
									<?php if (in_array("61bc4bf4dc911d4073448964", $userRoles->role_access_rights)) { ?>
										<button class="btn btn-info">
											<a href="<?= base_url() ?>excel/exportTransactionStore?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&code=' . $code . '&store=' . $store . '&type_transaction=' . $type_transaction . '&status=' . $status . '&code_contract_disbursement=' . $code_contract_disbursement . '&sdt=' . $sdt . '&payment_method=' . $payment_method ;?>"
											   class="w-100" target="_blank"
											   style="color: white; font-family: Roboto, Helvetica Neue, Helvetica, Arial">
												Xuất Excel
											</a>
										</button>
									<?php } ?>
									<div class="dropdown" style="display:inline-block">
										<button class="btn btn-success dropdown-toggle"
												onclick="$('#lockdulieu').toggleClass('show');">
											<span class="fa fa-filter"></span>
											Lọc dữ liệu
										</button>
										<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
											style="padding:15px;width:550px;max-width: 85vw;">
											<div class="row">
												<form action="<?php echo base_url('transaction') ?>" method="get"
													  style="width: 100%">
													<div class="col-xs-12 col-md-6">
														<input type="hidden" name="tab" class="form-control"
															   value="<?= !empty($tab) ? $tab : "all" ?>">
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
														<div class="form-group">
															<label> Mã Phiếu thu </label>
															<input type="text" name="code" class="form-control"
																   value="<?= $code ?>"
																   placeholder="Nhập đầy đủ mã phiếu thu">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Mã hợp đồng </label>
															<input type="text" name="code_contract_disbursement"
																   class="form-control"
																   value="<?= $code_contract_disbursement ?>"
																   placeholder="Nhập đầy đủ mã hợp đồng">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Loại thanh toán</label>
															<select class="form-control" name="type_transaction">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach (type_transaction() as $key => $item) {
																	if (!in_array($key, [3, 4])) continue;
																	?>
																	<option <?php echo $type_transaction == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Trạng thái phiếu thu</label>
															<select class="form-control" name="status">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach (status_transaction() as $key => $item) {
																	if ($key == 10) continue;
																	?>
																	<option <?php echo $status == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Số điện thoại </label>
															<input type="text" name="sdt" class="form-control"
																   value="<?= isset($_GET['sdt']) ? $_GET['sdt'] : "" ?>"
																   placeholder="Nhập số điện thoại">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Phòng giao dịch </label>
															<select id="province" class="form-control" name="store">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach ($storeData as $p) { ?>
																	<option <?php echo $store == $p->store_id ? 'selected' : '' ?>
																			value="<?php echo $p->store_id; ?>"><?php echo $p->store_name; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Phương thức thanh toán</label>
															<select class="form-control" name="payment_method">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach (payment_method() as $key => $item) {
																	?>
																	<option <?php echo $payment_method == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<label>&nbsp;</label>
														<button class="btn btn-primary w-100"><i class="fa fa-search"
																								 aria-hidden="true"></i>
															Tìm kiếm
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
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="group-tabs" style="width: 100%;">
								<ul class="nav nav-pills">
									<li class="<?= ($tab == 'all') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>transaction?tab=all">Tất cả</a></li>
									<li class="<?= ($tab == 'not-yet-send') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>transaction?tab=not-yet-send">Chưa gửi KT duyệt</a></li>
									<li class="<?= ($tab == 'wait') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>transaction?tab=wait">KT chưa duyệt</a>
									</li>
									<li class="<?= ($tab == 'approval') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>/transaction?tab=approval">KT đã
											duyệt</a></li>
									<li class="<?= ($tab == 'return') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>/transaction?tab=return">KT trả về</a>
									</li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane <?= ($tab == 'all') ? 'active' : '' ?>"
										 id="vi">
										<br/>
										<?php if ($tab == 'all') { ?>
											<div class="table-responsive" style="overflow-y: auto">
												<div><?php echo $result_count; ?></div>
												<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
													<thead style="background:#3f86c3; color: #ffffff;">
													<tr class="th-tab-all">
														<th>#</th>
														<th>Thao tác</th>
														<th>Thời gian tạo phiếu thu</th>
														<th>Ngày thanh toán</th>
														<th><?php echo $this->lang->line('receipt_code') ?></th>
														<th>Mã Hợp đồng</th>
														<th><?php echo $this->lang->line('employees') ?></th>
														<th>Khách hàng</th>
														<th><?php echo $this->lang->line('total_money') ?></th>
														<th><?php echo $this->lang->line('payment_method') ?></th>
														<th><?php echo $this->lang->line('status') ?></th>
														<th><?php echo $this->lang->line('progress') ?></th>
														<th>Nội dung thu tiền</th>
														<th>Kế toán ghi chú</th>
														<th><?php echo $this->lang->line('phone_customer') ?></th>
														<th><?php echo $this->lang->line('store') ?></th>
													</tr>
													</thead>

													<tbody>
													<?php
													if (!empty($transactionData)) {
														foreach ($transactionData as $key => $tran) {
															if (in_array($tran->type, [7, 8])) continue;
															if (isset($_GET['status'])) {
																if ($_GET['status'] == 2 && $tran->progress != 'Đang chờ')
																	continue;
															}
															?>
															<tr class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																<td><?php echo $key + 1 ?></td>
																<td>
																	<div class="dropdown">
																		<button class="btn btn-secondary dropdown-toggle"
																				type="button" id="dropdownMenuButton"
																				data-toggle="dropdown"
																				aria-haspopup="true"
																				aria-expanded="false"
																				style="background-color: #5bc0de; color: white">
																			Chức năng
																			<span class="caret"></span></button>
																		<ul class="dropdown-menu"
																			style="z-index: 99999">
																			<?php
																			if (
																				!empty($tran->type) && 
																				in_array($tran->type, [3, 4]) && //thanh toan, tat toan
																				!empty($tran->status) &&
																				$tran->status == 2 && // cho ke toan duyet
																				!empty($tran->payment_method) &&
																				$tran->payment_method == 1 // thanh toan tien mat
																			) {
																			?>
																			<li><a class="dropdown-item" target="_blank"
																				   href="<?php echo base_url('transaction/bankPayment?id=' . $tran->id) ?>">
																					<?php echo "Hướng dẫn chuyển khoản" ?>
																				</a>
																			</li>
																			<?php
																			}
																			?>
																			<?php
																			if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																				<li><a class="dropdown-item"
																					   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																						<?php echo $this->lang->line('detail') ?>
																					</a>
																				</li>
																				<?php
																				if (in_array($tran->status, [4, 11]) && in_array($tran->type, [3, 4, 5])) { ?>
																					<li><a class="dropdown-item"
																						   href="<?php echo base_url('transaction/sendApprove?id=' . $tran->id) . '&view=QLHDV'; ?>">
																							<?php echo "Gửi duyệt" ?>
																						</a>
																					</li>
																				<?php } ?>
																				<?php
																				if (in_array($tran->status, [2, 4]) && in_array($tran->type, [3, 4, 5]) && $tran->payment_method == 1) { ?>
																					<li><a class="dropdown-item"
																						   target="_blank"
																						   href="<?php echo base_url('transaction/printed_billing_contract/' . $tran->id); ?>">
																							<?php echo "In Biên nhận" ?>
																						</a>
																					</li>
																				<?php } ?>
																				<?php
																				if (in_array($tran->status, [2]) && in_array($tran->type, [3, 4])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   data-bank="<?= !empty($tran->bank) ? $tran->bank : '' ?>"
																							   data-code="<?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch </a>
																						</li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kttrave(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item travepgd">
																								Trả về PGD </a></li>
																						<?php
																					}
																				}
																				?>
																				<?php
																				if ($tran->status == 2 && in_array($tran->type, [5])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   data-codecontract="<?= !empty($tran->code_contract) ? $tran->code_contract : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch gia
																								hạn </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<?php
																					}
																				}
																				?>
																			<?php } elseif ($tran->type == 7) { ?>
																				<li>
																					<a href="<?php echo base_url('transaction/viewDetailHeyU/' . $tran->id) ?>"
																					   class="dropdown-item ">
																						Xem chi tiết
																					</a>
																				</li>
																			<?php } else { ?>
																				<li>
																					<a class="dropdown-item"
																					   href="<?php echo base_url('transaction/view/' . $tran->id) ?>">
																						<i class="fa fa-eye"></i> <?php echo $this->lang->line('detail') ?>
																					</a>
																				</li>
																			<?php } ?>
																			<?php
																			if (!in_array($tran->status, [1, 3])) {
																				?>
																				<li>
																					<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																					   class="dropdown-item">
																						Tải lên chứng từ
																					</a></li>
																			<?php } ?>
																			<li>
																				<a href="<?php echo base_url("transaction/viewImg?id=") . $tran->id ?>"
																				   class="dropdown-item ">
																					Xem chứng từ
																				</a></li>

																		</ul>

																</td>
																<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
																<td style="text-align: center"><?= !empty($tran->date_pay) ? date('d/m/Y', intval($tran->date_pay)) : date('d/m/Y', intval($tran->created_at)) ?>
																	<br>
																	<?php
																	if (in_array($tran->status, [2, 4]) && in_array($tran->type, [3, 4, 5]) && $tran->payment_method == 1) { ?>
																		<a class="btn btn-primary"
																		   target="_blank"
																		   href="<?php echo base_url('transaction/printed_billing_contract/' . $tran->id); ?>">
																			<?php echo "In Biên nhận" ?>
																		</a>
																	<?php } ?>
																</td>
																<td style="text-align: center"><?= !empty($tran->code) ? $tran->code : "" ?>
																	<br>
																	<?php
																	if (in_array($tran->status, [4, 11]) && in_array($tran->type, [3, 4, 5])) { ?>
																		<a class="btn btn-primary"
																		   href="<?php echo base_url('transaction/sendApprove?id=' . $tran->id) . '&view=QLHDV'; ?>">
																			<?php echo "Gửi duyệt";?>
																		</a>
																	<?php } ?>
																</td>
																<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>
																<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
																<td><?= !empty($tran->customer_name) ? $tran->customer_name : "" ?></td>
																<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
																<td>
																	<?php
																	$method = '';
																	if (intval($tran->payment_method) == 0) {
																		$method = $tran->payment_method;
																	} else {
																		if (intval($tran->payment_method) == 1) {
																			$method = $this->lang->line('Cash');
																		} else if (intval($tran->payment_method) == 2) {
																			$method = 'Chuyển khoản';
																		}
																	}
																	echo $method;
																	?>
																</td>
																<td>
																	<?php if ($tran->status == 1) : ?>
																		<span class="label label-success">Kế toán đã duyệt</span>
																	<?php elseif ($tran->status == 2): ?>
																		<span class="label label-default">Chờ Kế toán xác nhận</span>
																	<?php elseif ($tran->status == 3): ?>
																		<span class="label label-danger">Kế toán Hủy</span>
																	<?php elseif ($tran->status == 4): ?>
																		<span class="label label-warning">Chưa gửi duyệt</span>
																	<?php elseif ($tran->status == 11): ?>
																		<span class="label label-primary">Kế toán trả lại</span>
																	<?php endif; ?>
																</td>
																<td><?= !empty($tran->progress) ? $tran->progress : "" ?></td>
																<td>
																	<?php
																	$content_billing = '';
																	$notes = !empty($tran->note) ? $tran->note : "";
																	if (is_array($notes)) {
																		foreach ($notes as $note) {
																			$content_billing .= billing_content($note);
																		}
																		echo $content_billing;
																	} else {
																		echo $tran->note;
																	}
																	?>
																</td>
																<td><?= !empty($tran->approve_note) ? ($tran->approve_note) : "" ?></td>
																<td><?= !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : "" ?></td>
																<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
															</tr>
														<?php }
													} ?>
													</tbody>
												</table>
												<div class="pagination pagination-sm">
													<?php echo $pagination ?>
												</div>
											</div>
										<?php } ?>
									</div>
									<div role="tabpanel" class="tab-pane <?= ($tab == 'not-yet-send') ? 'active' : '' ?>"
										 id="vi">
										<br/>
										<?php if ($tab == 'not-yet-send') { ?>
											<div class="table-responsive" style="overflow-y: auto">
												<div><p><i>"Phòng giao dịch cần gửi duyệt hết tất cả phiếu thu, nếu phiếu thu nào tạo trùng, tạo sai thì liên hệ Kế toán báo Hủy phiếu thu. Tránh gốc còn lại ảo của PGD tăng lên."</i></p></div>
												<div><?php echo $result_count; ?></div>
												<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
													<thead style="background:#3f86c3; color: #ffffff;">
													<tr class="th-tab-all">
														<th>#</th>
														<th>Thao tác</th>
														<th>Thời gian tạo phiếu thu</th>
														<th>Ngày thanh toán</th>
														<th><?php echo $this->lang->line('receipt_code') ?></th>
														<th>Mã Hợp đồng</th>
														<th><?php echo $this->lang->line('employees') ?></th>
														<th>Khách hàng</th>
														<th><?php echo $this->lang->line('total_money') ?></th>
														<th><?php echo $this->lang->line('payment_method') ?></th>
														<th><?php echo $this->lang->line('status') ?></th>
														<th><?php echo $this->lang->line('progress') ?></th>
														<th>Nội dung thu tiền</th>
														<th>Kế toán ghi chú</th>
														<th><?php echo $this->lang->line('phone_customer') ?></th>
														<th><?php echo $this->lang->line('store') ?></th>
													</tr>
													</thead>

													<tbody>
													<?php
													if (!empty($transactionData)) {
														foreach ($transactionData as $key => $tran) {
															if (in_array($tran->type, [7, 8])) continue;
															if (isset($_GET['status'])) {
																if ($_GET['status'] == 2 && $tran->progress != 'Đang chờ')
																	continue;
															}
															?>
															<tr class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																<td><?php echo $key + 1 ?></td>
																<td>
																	<div class="dropdown">
																		<button class="btn btn-secondary dropdown-toggle"
																				type="button" id="dropdownMenuButton"
																				data-toggle="dropdown"
																				aria-haspopup="true"
																				aria-expanded="false"
																				style="background-color: #5bc0de; color: white">
																			Chức năng
																			<span class="caret"></span></button>
																		<ul class="dropdown-menu"
																			style="z-index: 99999">
																			<?php
																			if (
																				!empty($tran->type) && 
																				in_array($tran->type, [3, 4]) && //thanh toan, tat toan
																				!empty($tran->status) &&
																				$tran->status == 2 && // cho ke toan duyet
																				!empty($tran->payment_method) &&
																				$tran->payment_method == 1 // thanh toan tien mat
																			) {
																			?>
																			<li><a class="dropdown-item" target="_blank"
																				   href="<?php echo base_url('transaction/bankPayment?id=' . $tran->id) ?>">
																					<?php echo "Hướng dẫn chuyển khoản" ?>
																				</a>
																			</li>
																			<?php
																			}
																			?>

																			<?php
																			if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																				<li><a class="dropdown-item"
																					   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																						<?php echo $this->lang->line('detail') ?>
																					</a>
																				</li>
																				<?php
																				if (in_array($tran->status, [4, 11]) && in_array($tran->type, [3, 4, 5])) { ?>
																					<li><a class="dropdown-item"
																						   href="<?php echo base_url('transaction/sendApprove?id=' . $tran->id) . '&view=QLHDV'; ?>">
																							<?php echo "Gửi duyệt" ?>
																						</a>
																					</li>
																				<?php } ?>
																				<?php
																				if (in_array($tran->status, [2, 4]) && in_array($tran->type, [3, 4, 5]) && $tran->payment_method == 1) { ?>
																					<li><a class="dropdown-item"
																						   target="_blank"
																						   href="<?php echo base_url('transaction/printed_billing_contract/' . $tran->id); ?>">
																							<?php echo "In Biên nhận" ?>
																						</a>
																					</li>
																				<?php } ?>
																				<?php
																				if (in_array($tran->status, [2]) && in_array($tran->type, [3, 4])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   data-bank="<?= !empty($tran->bank) ? $tran->bank : '' ?>"
																							   data-code="<?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch </a>
																						</li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kttrave(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item travepgd">
																								Trả về PGD </a></li>
																						<?php
																					}
																				}
																				?>
																				<?php
																				if ($tran->status == 2 && in_array($tran->type, [5])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   data-codecontract="<?= !empty($tran->code_contract) ? $tran->code_contract : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch gia
																								hạn </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<?php
																					}
																				}
																				?>
																			<?php } elseif ($tran->type == 7) { ?>
																				<li>
																					<a href="<?php echo base_url('transaction/viewDetailHeyU/' . $tran->id) ?>"
																					   class="dropdown-item ">
																						Xem chi tiết
																					</a>
																				</li>
																			<?php } else { ?>
																				<li>
																					<a class="dropdown-item"
																					   href="<?php echo base_url('transaction/view/' . $tran->id) ?>">
																						<i class="fa fa-eye"></i> <?php echo $this->lang->line('detail') ?>
																					</a>
																				</li>
																			<?php } ?>
																			<?php
																			if (!in_array($tran->status, [1, 3])) {
																				?>
																				<li>
																					<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																					   class="dropdown-item">
																						Tải lên chứng từ
																					</a></li>
																			<?php } ?>
																			<li>
																				<a href="<?php echo base_url("transaction/viewImg?id=") . $tran->id ?>"
																				   class="dropdown-item ">
																					Xem chứng từ
																				</a></li>

																		</ul>

																</td>
																<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
																<td style="text-align: center"><?= !empty($tran->date_pay) ? date('d/m/Y', intval($tran->date_pay)) : date('d/m/Y', intval($tran->created_at)) ?>
																	<br>
																	<?php
																	if (in_array($tran->status, [2, 4]) && in_array($tran->type, [3, 4, 5]) && $tran->payment_method == 1) { ?>
																		<a class="btn btn-primary"
																		   target="_blank"
																		   href="<?php echo base_url('transaction/printed_billing_contract/' . $tran->id); ?>">
																			<?php echo "In Biên nhận" ?>
																		</a>
																	<?php } ?>
																</td>
																<td style="text-align: center"><?= !empty($tran->code) ? $tran->code : "" ?>
																	<br>
																	<?php
																	if (in_array($tran->status, [4, 11]) && in_array($tran->type, [3, 4, 5])) { ?>
																		<a class="btn btn-primary"
																		   href="<?php echo base_url('transaction/sendApprove?id=' . $tran->id) . '&view=QLHDV'; ?>">
																			<?php echo "Gửi duyệt" ?>
																		</a>
																	<?php } ?>
																</td>
																<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>
																<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
																<td><?= !empty($tran->customer_name) ? $tran->customer_name : "" ?></td>
																<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
																<td>
																	<?php
																	$method = '';
																	if (intval($tran->payment_method) == 0) {
																		$method = $tran->payment_method;
																	} else {
																		if (intval($tran->payment_method) == 1) {
																			$method = $this->lang->line('Cash');
																		} else if (intval($tran->payment_method) == 2) {
																			$method = 'Chuyển khoản';
																		}
																	}
																	echo $method;
																	?>
																</td>
																<td>
																	<?php if ($tran->status == 1) : ?>
																		<span class="label label-success">Kế toán đã duyệt</span>
																	<?php elseif ($tran->status == 2): ?>
																		<span class="label label-default">Chờ Kế toán xác nhận</span>
																	<?php elseif ($tran->status == 3): ?>
																		<span class="label label-danger">Kế toán Hủy</span>
																	<?php elseif ($tran->status == 4): ?>
																		<span class="label label-warning">Chưa gửi duyệt</span>
																	<?php elseif ($tran->status == 11): ?>
																		<span class="label label-primary">Kế toán trả lại</span>
																	<?php endif; ?>
																</td>
																<td><?= !empty($tran->progress) ? $tran->progress : "" ?></td>
																<td>
																	<?php
																	$content_billing = '';
																	$notes = !empty($tran->note) ? $tran->note : "";
																	if (is_array($notes)) {
																		foreach ($notes as $note) {
																			$content_billing .= billing_content($note);
																		}
																		echo $content_billing;
																	} else {
																		echo $tran->note;
																	}
																	?>
																</td>
																<td><?= !empty($tran->approve_note) ? ($tran->approve_note) : "" ?></td>
																<td><?= !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : "" ?></td>
																<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
															</tr>
														<?php }
													} ?>
													</tbody>
												</table>
												<div class="pagination pagination-sm">
													<?php echo $pagination ?>
												</div>
											</div>
										<?php } ?>
									</div>
									<div role="tabpanel" class="tab-pane <?= ($tab == 'wait') ? 'active' : '' ?>"
										 id="en">
										<br/>
										<?php if ($tab == 'wait') { ?>
											<div class="col-xs-12">

												<div class="table-responsive" style="overflow-y: auto">
													<div><?php echo $result_count; ?></div>
													<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
														<thead style="background:#3f86c3; color: #ffffff;">
														<tr class="th-tab-all">
															<th>#</th>
															<th>Thao tác</th>
															<th>Thời gian tạo phiếu thu</th>
															<th>Ngày thanh toán</th>
															<th><?php echo $this->lang->line('receipt_code') ?></th>
															<th>Mã Hợp đồng</th>
															<th><?php echo $this->lang->line('employees') ?></th>
															<th>Khách hàng</th>
															<th><?php echo $this->lang->line('total_money') ?></th>
															<th><?php echo $this->lang->line('payment_method') ?></th>
															<th><?php echo $this->lang->line('status') ?></th>
															<th><?php echo $this->lang->line('progress') ?></th>
															<th>Nội dung thu tiền</th>
															<th>Kế toán ghi chú</th>
															<th><?php echo $this->lang->line('phone_customer') ?></th>
															<th><?php echo $this->lang->line('store') ?></th>
														</tr>
														</thead>

														<tbody>
														<?php
														if (!empty($transactionData)) {
															foreach ($transactionData as $key => $tran) {
																if (in_array($tran->type, [7, 8])) continue;
																if (isset($_GET['status'])) {
																	if ($_GET['status'] == 2 && $tran->progress != 'Đang chờ')
																		continue;
																}
																?>
																<tr class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
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
																				<?php
																				if (
																					!empty($tran->type) && 
																					in_array($tran->type, [3, 4]) && //thanh toan, tat toan
																					!empty($tran->status) &&
																					$tran->status == 2 && // cho ke toan duyet
																					!empty($tran->payment_method) &&
																					$tran->payment_method == 1 // thanh toan tien mat
																				) {
																				?>
																				<li><a class="dropdown-item" target="_blank"
																					   href="<?php echo base_url('transaction/bankPayment?id=' . $tran->id) ?>">
																						<?php echo "Hướng dẫn chuyển khoản" ?>
																					</a>
																				</li>
																				<?php
																				}
																				?>
																				<?php
																				if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																					<li><a class="dropdown-item"
																						   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																							<?php echo $this->lang->line('detail') ?>
																						</a>
																					</li>
																					<?php
																					if (in_array($tran->status, [2]) && in_array($tran->type, [3, 4])) {
																						if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="ktduyetgiaodich(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   data-bank="<?= !empty($tran->bank) ? $tran->bank : '' ?>"
																								   data-code="<?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : '' ?>"
																								   class="dropdown-item duyet">
																									Duyệt giao dịch </a>
																							</li>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="kthuygiaodich(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   class="dropdown-item duyet">
																									Hủy giao dịch </a>
																							</li>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="kttrave(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   class="dropdown-item travepgd">
																									Trả về PGD </a></li>
																							<?php
																						}
																					}
																					?>
																					<?php
																					if ($tran->status == 2 && in_array($tran->type, [5])) {
																						if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="ktduyetgiaodichgiahan(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   data-codecontract="<?= !empty($tran->code_contract) ? $tran->code_contract : '' ?>"
																								   class="dropdown-item duyet">
																									Duyệt giao dịch gia
																									hạn </a></li>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="kthuygiaodichgiahan(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   class="dropdown-item duyet">
																									Hủy giao dịch </a>
																							</li>
																							<?php
																						}
																					}
																					?>
																				<?php } elseif ($tran->type == 7) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailHeyU/' . $tran->id) ?>"
																						   class="dropdown-item ">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } else { ?>
																					<li>
																						<a class="dropdown-item"
																						   href="<?php echo base_url('transaction/view/' . $tran->id) ?>">
																							<i class="fa fa-eye"></i> <?php echo $this->lang->line('detail') ?>
																						</a>
																					</li>
																				<?php } ?>
																				<?php
																				if (!in_array($tran->status, [1, 3])) {
																					?>
																					<li>
																						<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																						   class="dropdown-item">
																							Tải lên chứng từ
																						</a></li>
																				<?php } ?>
																				<li>
																					<a href="<?php echo base_url("transaction/viewImg?id=") . $tran->id ?>"
																					   class="dropdown-item ">
																						Xem chứng từ
																					</a></li>
																			</ul>
																	</td>
																	<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
																	<td><?= !empty($tran->date_pay) ? date('d/m/Y', intval($tran->date_pay)) : date('d/m/Y', intval($tran->created_at)) ?></td>
																	<td><?= !empty($tran->code) ? $tran->code : "" ?></td>
																	<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>
																	<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
																	<td><?= !empty($tran->customer_name) ? $tran->customer_name : "" ?></td>
																	<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
																	<td>
																		<?php
																		$method = '';
																		if (intval($tran->payment_method) == 0) {
																			$method = $tran->payment_method;
																		} else {
																			if (intval($tran->payment_method) == 1) {
																				$method = $this->lang->line('Cash');
																			} else if (intval($tran->payment_method) == 2) {
																				$method = 'Chuyển khoản';
																			}
																		}
																		echo $method;
																		?>
																	</td>
																	<td>
																		<?php if ($tran->status == 1) : ?>
																			<span class="label label-success">Kế toán đã duyệt</span>
																		<?php elseif ($tran->status == 2): ?>
																			<span class="label label-default">Chờ Kế toán xác nhận</span>
																		<?php elseif ($tran->status == 3): ?>
																			<span class="label label-danger">Kế toán Hủy</span>
																		<?php elseif ($tran->status == 4): ?>
																			<span class="label label-warning">Chưa gửi duyệt</span>
																		<?php elseif ($tran->status == 11): ?>
																			<span class="label label-primary">Kế toán trả lại</span>
																		<?php endif; ?>
																	</td>
																	<td><?= !empty($tran->progress) ? $tran->progress : "" ?></td>
																	<td>
																		<?php
																		$content_billing = '';
																		$notes = !empty($tran->note) ? $tran->note : "";
																		if (is_array($notes)) {
																			foreach ($notes as $note) {
																				$content_billing .= billing_content($note);
																			}
																			echo $content_billing;
																		} else {
																			echo $tran->note;
																		}
																		?>
																	</td>
																	<td><?= !empty($tran->approve_note) ? ($tran->approve_note) : "" ?></td>
																	<td><?= !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : "" ?></td>
																	<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
																</tr>
															<?php }
														} ?>
														</tbody>
													</table>
													<div class="pagination pagination-sm">
														<?php echo $pagination ?>
													</div>
												</div>

											</div>
										<?php } ?>
									</div>
									<div role="tabpanel" class="tab-pane <?= ($tab == 'approval') ? 'active' : '' ?>"
										 id="en">
										<br/>
										<?php if ($tab == 'approval') { ?>
											<div class="col-xs-12">

												<div class="table-responsive" style="overflow-y: auto">
													<div><?php echo $result_count; ?></div>
													<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
														<thead style="background:#3f86c3; color: #ffffff;">
														<tr class="th-tab-all">
															<th>#</th>
															<th>Thao tác</th>
															<th>Thời gian tạo phiếu thu</th>
															<th>Ngày thanh toán</th>
															<th><?php echo $this->lang->line('receipt_code') ?></th>
															<th>Mã Hợp đồng</th>
															<th><?php echo $this->lang->line('employees') ?></th>
															<th>Khách hàng</th>
															<th><?php echo $this->lang->line('total_money') ?></th>
															<th><?php echo $this->lang->line('payment_method') ?></th>
															<th><?php echo $this->lang->line('status') ?></th>
															<th><?php echo $this->lang->line('progress') ?></th>
															<th>Nội dung thu tiền</th>
															<th>Kế toán ghi chú</th>
															<th><?php echo $this->lang->line('phone_customer') ?></th>
															<th><?php echo $this->lang->line('store') ?></th>
															<th></th>
														</tr>
														</thead>

														<tbody>
														<?php
														if (!empty($transactionData)) {
															foreach ($transactionData as $key => $tran) {
																if (in_array($tran->type, [7, 8])) continue;
																if (isset($_GET['status'])) {
																	if ($_GET['status'] == 2 && $tran->progress != 'Đang chờ')
																		continue;
																}
																?>
																<tr class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
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
																				<?php
																				if (
																					!empty($tran->type) && 
																					in_array($tran->type, [3, 4]) && //thanh toan, tat toan
																					!empty($tran->status) &&
																					$tran->status == 2 && // cho ke toan duyet
																					!empty($tran->payment_method) &&
																					$tran->payment_method == 1 // thanh toan tien mat
																				) {
																				?>
																				<li><a class="dropdown-item" target="_blank"
																					   href="<?php echo base_url('transaction/bankPayment?id=' . $tran->id) ?>">
																						<?php echo "Hướng dẫn chuyển khoản" ?>
																					</a>
																				</li>
																				<?php
																				}
																				?>
																				<?php
																				if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																					<li><a class="dropdown-item"
																						   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																							<?php echo $this->lang->line('detail') ?>
																						</a>
																					</li>
																					<?php
																					if (in_array($tran->status, [2]) && in_array($tran->type, [3, 4])) {
																						if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="ktduyetgiaodich(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   class="dropdown-item duyet">
																									Duyệt giao dịch </a>
																							</li>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="kthuygiaodich(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   class="dropdown-item duyet">
																									Hủy giao dịch </a>
																							</li>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="kttrave(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   class="dropdown-item travepgd">
																									Trả về PGD </a></li>
																							<?php
																						}
																					}
																					?>
																					<?php
																					if ($tran->status == 2 && in_array($tran->type, [5])) {
																						if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="ktduyetgiaodichgiahan(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   data-codecontract="<?= !empty($tran->code_contract) ? $tran->code_contract : '' ?>"
																								   class="dropdown-item duyet">
																									Duyệt giao dịch gia
																									hạn </a></li>
																							<li>
																								<a href="javascript:void(0)"
																								   onclick="kthuygiaodichgiahan(this)"
																								   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																								   class="dropdown-item duyet">
																									Hủy giao dịch </a>
																							</li>
																							<?php
																						}
																					}

																					?>


																				<?php } else { ?>
																					<li><a class="dropdown-item"
																						   href="<?php echo base_url('transaction/view/' . $tran->id) ?>">
																							<i class="fa fa-eye"></i> <?php echo $this->lang->line('detail') ?>
																						</a></li>
																				<?php }
																				?>
																				<?php
																				if (!in_array($tran->status, [1, 3])) {
																					?>
																					<li>
																						<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																						   class="dropdown-item">
																							Tải lên chứng từ
																						</a>
																					</li>
																				<?php } ?>
																				<li>
																					<a href="<?php echo base_url("transaction/viewImg?id=") . $tran->id ?>"
																					   class="dropdown-item ">
																						Xem chứng từ
																					</a></li>


																			</ul>

																	</td>
																	<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
																	<td><?= !empty($tran->date_pay) ? date('d/m/Y', intval($tran->date_pay)) : date('d/m/Y', intval($tran->created_at)) ?></td>
																	<td><?= !empty($tran->code) ? $tran->code : "" ?></td>
																	<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>
																	<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
																	<td><?= !empty($tran->customer_name) ? $tran->customer_name : "" ?></td>
																	<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
																	<td>
																		<?php
																		$method = '';
																		if (intval($tran->payment_method) == 0) {
																			$method = $tran->payment_method;
																		} else {
																			if (intval($tran->payment_method) == 1) {
																				$method = $this->lang->line('Cash');
																			} else if (intval($tran->payment_method) == 2) {
																				$method = 'Chuyển khoản';
																			}
																		}
																		echo $method;
																		?>
																	</td>
																	<td>
																		<?php if ($tran->status == 1) : ?>
																			<span class="label label-success">Kế toán đã duyệt</span>
																		<?php elseif ($tran->status == 2): ?>
																			<span class="label label-default">Chờ Kế toán xác nhận</span>
																		<?php elseif ($tran->status == 3): ?>
																			<span class="label label-danger">Kế toán Hủy</span>
																		<?php elseif ($tran->status == 4): ?>
																			<span class="label label-warning">Chưa gửi duyệt</span>
																		<?php elseif ($tran->status == 11): ?>
																			<span class="label label-primary">Kế toán trả lại</span>
																		<?php endif; ?>
																	</td>
																	<td><?= !empty($tran->progress) ? $tran->progress : "" ?></td>
																	<td>
																		<?php
																		$content_billing = '';
																		$notes = !empty($tran->note) ? $tran->note : "";
																		if (is_array($notes)) {
																			foreach ($notes as $note) {
																				$content_billing .= billing_content($note);
																			}
																			echo $content_billing;
																		} else {
																			echo $tran->note;
																		}
																		?>
																	</td>
																	<td><?= !empty($tran->approve_note) ? ($tran->approve_note) : "" ?></td>
																	<td><?= !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : "" ?></td>
																	<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
																</tr>
															<?php }
														} ?>
														</tbody>
													</table>
													<div class="pagination pagination-sm">
														<?php echo $pagination ?>
													</div>
												</div>

											</div>
										<?php } ?>
									</div>
									<div role="tabpanel" class="tab-pane <?= ($tab == 'return') ? 'active' : '' ?>"
										 id="en">
										<br/>
										<?php if ($tab == 'return') { ?>
											<div class="col-xs-12">
												<div><p><i>"Phòng giao dịch chọn Gửi duyệt và upload đúng ảnh chứng từ hợp lệ và gửi Kế toán duyệt lại phiếu thu. Không cần tạo lại phiếu thu thanh toán, gây trùng lặp phiếu thu."</i></p></div>
												<div class="table-responsive" style="overflow-y: auto">
													<div><?php echo $result_count; ?></div>
													<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
														<thead style="background:#3f86c3; color: #ffffff;">
														<tr class="th-tab-all">
															<th>#</th>
															<th>Thao tác</th>
															<th>Thời gian tạo phiếu thu</th>
															<th>Ngày thanh toán</th>
															<th><?php echo $this->lang->line('receipt_code') ?></th>
															<th>Mã Hợp đồng</th>
															<th><?php echo $this->lang->line('employees') ?></th>
															<th>Khách hàng</th>
															<th><?php echo $this->lang->line('total_money') ?></th>
															<th><?php echo $this->lang->line('payment_method') ?></th>
															<th><?php echo $this->lang->line('status') ?></th>
															<th><?php echo $this->lang->line('progress') ?></th>
															<th>Nội dung thu tiền</th>
															<th>Kế toán ghi chú</th>
															<th><?php echo $this->lang->line('phone_customer') ?></th>
															<th><?php echo $this->lang->line('store') ?></th>
															<th></th>
														</tr>
														</thead>

														<tbody>
														<?php
														if (!empty($transactionData)) {
															foreach ($transactionData as $key => $tran) {
																if (in_array($tran->type, [7, 8])) continue;
																if (in_array($tran->status, [4, 11])) {
																	?>
																	<tr class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
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
																					<?php
																					if (
																						!empty($tran->type) && 
																						in_array($tran->type, [3, 4]) && //thanh toan, tat toan
																						!empty($tran->status) &&
																						$tran->status == 2 && // cho ke toan duyet
																						!empty($tran->payment_method) &&
																						$tran->payment_method == 1 // thanh toan tien mat
																					) {
																					?>
																					<li><a class="dropdown-item" target="_blank"
																						   href="<?php echo base_url('transaction/bankPayment?id=' . $tran->id) ?>">
																							<?php echo "Hướng dẫn chuyển khoản" ?>
																						</a>
																					</li>
																					<?php
																					}
																					?>
																					<?php
																					if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																						<li><a class="dropdown-item"
																							   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																								<?php echo $this->lang->line('detail') ?>
																							</a>
																						</li>
																						<?php
																						if (in_array($tran->status, [4, 11]) && in_array($tran->type, [3, 4, 5])) { ?>
																							<li><a class="dropdown-item"
																								   href="<?php echo base_url('transaction/sendApprove?id=' . $tran->id) . '&view=QLHDV'; ?>">
																									<?php echo "Gửi duyệt" ?>
																								</a>
																							</li>
																						<?php } ?>
																						<?php
																						if (in_array($tran->status, [2, 11]) && in_array($tran->type, [3, 4])) {
																							if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																								<li>
																									<a href="javascript:void(0)"
																									   onclick="kthuygiaodich(this)"
																									   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																									   class="dropdown-item duyet">
																										Hủy giao
																										dịch </a></li>
																								<?php
																							}
																						}
																						?>
																						<?php
																						if ($tran->status == 2 && in_array($tran->type, [5])) {
																							if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																								<li>
																									<a href="javascript:void(0)"
																									   onclick="kthuygiaodichgiahan(this)"
																									   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																									   class="dropdown-item duyet">
																										Hủy giao
																										dịch </a></li>
																								<?php
																							}
																						}
																						?>
																					<?php } elseif ($tran->type == 7) { ?>
																						<li>
																							<a href="<?php echo base_url('transaction/viewDetailHeyU/' . $tran->id) ?>"
																							   class="dropdown-item"
																							   target="_blank">
																								Xem chi tiết
																							</a>
																						</li>
																					<?php } else { ?>
																						<li>
																							<a class="dropdown-item"
																							   href="<?php echo base_url('transaction/view/' . $tran->id) ?>">
																								<i class="fa fa-eye"></i> <?php echo $this->lang->line('detail') ?>
																							</a>
																						</li>
																					<?php } ?>
																					<?php
																					if (!in_array($tran->status, [1, 3])) {
																						?>
																						<li>
																							<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																							   class="dropdown-item">
																								Tải lên chứng từ
																							</a></li>
																					<?php } ?>
																					<li>
																						<a href="<?php echo base_url("transaction/viewImg?id=") . $tran->id ?>"
																						   class="dropdown-item ">
																							Xem chứng từ
																						</a></li>
																				</ul>
																		</td>
																		<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
																		<td><?= !empty($tran->date_pay) ? date('d/m/Y', intval($tran->date_pay)) : date('d/m/Y', intval($tran->created_at)) ?></td>
																		<td style="text-align: center"><?= !empty($tran->code) ? $tran->code : "" ?>
																			<br>
																			<?php
																			if (in_array($tran->status, [4, 11]) && in_array($tran->type, [3, 4, 5])) { ?>
																				<a class="btn btn-primary"
																					   href="<?php echo base_url('transaction/sendApprove?id=' . $tran->id) . '&view=QLHDV'; ?>">
																						<?php echo "Gửi duyệt" ?>
																				</a>
																			<?php } ?>
																		</td>
																		<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>
																		<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
																		<td><?= !empty($tran->customer_name) ? $tran->customer_name : "" ?></td>
																		<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
																		<td>
																			<?php
																			$method = '';
																			if (intval($tran->payment_method) == 0) {
																				$method = $tran->payment_method;
																			} else {
																				if (intval($tran->payment_method) == 1) {
																					$method = $this->lang->line('Cash');
																				} else if (intval($tran->payment_method) == 2) {
																					$method = 'Chuyển khoản';
																				}
																			}
																			echo $method;
																			?>
																		</td>
																		<td>
																			<?php if ($tran->status == 1) : ?>
																				<span class="label label-success">Kế toán đã duyệt</span>
																			<?php elseif ($tran->status == 2): ?>
																				<span class="label label-default">Chờ Kế toán xác nhận</span>
																			<?php elseif ($tran->status == 3): ?>
																				<span class="label label-danger">Kế toán Hủy</span>
																			<?php elseif ($tran->status == 4): ?>
																				<span class="label label-warning">Chưa gửi duyệt</span>
																			<?php elseif ($tran->status == 11): ?>
																				<span class="label label-primary">Kế toán trả lại</span>
																			<?php endif; ?>
																		</td>
																		<td><?= !empty($tran->progress) ? $tran->progress : "" ?></td>
																		<td>
																			<?php
																			$content_billing = '';
																			$notes = !empty($tran->note) ? $tran->note : "";
																			if (is_array($notes)) {
																				foreach ($notes as $note) {
																					$content_billing .= billing_content($note);
																				}
																				echo $content_billing;
																			} else {
																				echo $tran->note;
																			}
																			?>
																		</td>
																		<td><?= !empty($tran->approve_note) ? ($tran->approve_note) : "" ?></td>
																		<td><?= !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : "" ?></td>
																		<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
																	</tr>
																<?php }
															}
														} ?>
														</tbody>
													</table>
													<div class="pagination pagination-sm">
														<?php echo $pagination ?>
													</div>
												</div>

											</div>
										<?php } ?>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<!-- /page content -->
				<div class="modal fade" id="approve_transaction" tabindex="-1" role="dialog"
					 aria-labelledby="TransactionModal" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title modal-title-approve">Duyệt giao dịch</h5>
								<hr>

								<div class="form-group">
									<label>Mã GD Ngân hàng:</label>
									<input type="text" class="form-control" id="code_transaction_bank_input" name="code_transaction_bank" rows="5"/>
								</div>

								<div class="form-group">
									<label>Ngân hàng:</label>
									<input type="text" class="form-control" id="bank_input" name="bank" rows="5"/>
								</div>

								<div class="form-group">
									<label>Ghi chú:</label>
									<textarea class="form-control approve_note" rows="5"></textarea>
									<input type="hidden" class="form-control status_approve" value="1">
									<input type="hidden" class="form-control transaction_id_approve">
								</div>
								<p class="text-right">
									<button class="btn btn-danger approve_submit">Xác nhận</button>
								</p>
							</div>

						</div>
					</div>
				</div>

				<div id="gachnoModal" class="modal fade">
					<div class="modal-dialog modal-confirm">
						<div class="modal-content">
							<div class="modal-header">
								<div class="icon-box danger">
									<i class="fa fa-times"></i>
								</div>
								<h4 class="modal-title">Error</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body">
								<p class='msg_error'>Mã giao dịch ngân hàng đã tồn tại phiếu thu tự động thanh toán. Bạn có muốn hủy phiếu thu tự động thanh toán và duyệt phiếu thu này</p>
							</div>
							<div class="modal-footer">
								<button class="btn btn-danger gachno_approve_submit">Xác nhận</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="approve_transaction1" tabindex="-1" role="dialog"
					 aria-labelledby="TransactionModal1" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title modal-title-approve">Duyệt giao dịch phiếu thu gia hạn</h5>
								<hr>
								<div class="form-group">
									<label>Nhà đầu tư:</label>
									<select class="form-control" id='investor'>
										<option value=''>Choose option</option>
										<?php
										if (!empty($listInvestor)) {
											foreach ($listInvestor as $key => $investor) {
												// if(!in_array($investor->code,array('vimo','vfc'))){
												?>
												<option value='<?= !empty($investor->_id->{'$oid'}) ? $investor->_id->{'$oid'} : ""; ?>'><?= !empty($investor->name) ? $investor->name : ""; ?></option>
											<?php }
										} ?>
									</select>
								</div>


								<div class="form-group">
									<label>Ghi chú:</label>
									<textarea class="form-control approve_note1" rows="5"></textarea>
									<input type="hidden" class="form-control status_approve1" value="1">
									<input type="hidden" class="form-control transaction_id_approve1">
								</div>
								<p class="text-right">
									<button class="btn btn-danger approve_submit1">Xác nhận</button>
								</p>
							</div>

						</div>
					</div>
				</div>
				<!--return transaction-->
				<div class="modal fade" id="return_transaction" tabindex="-1" role="dialog"
					 aria-labelledby="TransactionModal"
					 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title modal-title-approve">Trả về phòng giao dịch</h5>
								<hr>

								<div class="form-group">
									<label>Ghi chú:</label>
									<textarea class="form-control return_note" rows="5"></textarea>
									<input type="hidden" class="form-control status_return" value="11">
									<input type="hidden" class="form-control transaction_id_return">
								</div>
								<p class="text-right">
									<button class="btn btn-danger return_transaction_submit">Xác nhận</button>
								</p>
							</div>

						</div>
					</div>
				</div>

				<!--Modal hủy duyệt phiếu thu-->
				<div class="modal fade" id="cancel_transaction" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
					 aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title modal-title-approve">Duyệt giao dịch</h5>
								<hr>

								<div class="form-group" >
									<label>Mã GD Ngân hàng:</label>
									<input type="text" class="form-control" name="code_transaction_bank" rows="5"/>
								</div>

								<div class="form-group" >
									<label>Ngân hàng:</label>
									<input type="text" class="form-control" name="bank" rows="5"/>
								</div>
								<div class="form-group" >
									<label>Ghi chú:</label>
									<textarea class="form-control approve_note" rows="5" ></textarea>
									<input type="hidden" class="form-control status_approve" value="3">
									<input type="hidden" class="form-control transaction_id_approve">
								</div>
								<p class="text-right" >
									<button class="btn btn-danger cancel_trans_submit">Xác nhận</button>
								</p>
							</div>

						</div>
					</div>
				</div>
				<script src="<?php echo base_url(); ?>assets/js/transaction/upload.js?v=20221110"></script>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	const cancelReason = `<div class="form-group reason-list">
					<label>Lý do:</label>
					<?php foreach ($reasons_cancel as $key => $value): ?>
						<div class="form-check">
	  					  <input class="form-check-input" type="checkbox" name="reason" value="<?=$key?>" id="reason<?=$key?>">
						  <label class="form-check-label" for="reason<?=$key?>">
						    <?=$value?>
						  </label>
						</div>
					<?php endforeach ?>
				</div>`;

	const returnReason = `<div class="form-group reason-list">
						<label>Lý do:</label>
						<?php foreach ($reasons_return as $key => $value): ?>
							<div class="form-check">
		  					  <input class="form-check-input" type="checkbox" name="reason" value="<?=$key?>" id="reason<?=$key?>">
							  <label class="form-check-label" for="reason<?=$key?>">
							    <?=$value?>
							  </label>
							</div>
						<?php endforeach ?>
					</div>`;

	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			const $menu = $('.dropdown');
			$(document).mouseup(e => {
				if (!$menu.is(e.target)
						&& $menu.has(e.target).length === 0) {
					$menu.removeClass('is-active');
					$('.dropdown-menu').removeClass('show');
				}
			});
			$('.dropdown-toggle').on('click', () => {
				$menu.toggleClass('is-active');
			});
		});

	</script>

	<style rel="stylesheet">
		.th-tab-all th {
			text-align: center;
		}
	</style>
