<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$code = !empty($_GET['code']) ? $_GET['code'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$code_transaction_bank = !empty($_GET['code_transaction_bank']) ? $_GET['code_transaction_bank'] : "";
	$tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
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

						<div class="page-title">
							<div class="title_left">
								<h3>DANH SÁCH DUYỆT GIAO DỊCH HEYU + BẢO HIỂM BÁN NGOÀI</h3>
							</div>
						</div>
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
							<br>
							<div class="row">
								<div class="col-xs-12 col-md-3">
										<div class="input-group">
											<select class="form-control" id="combox_check_all">
												<option selected disabled>Chọn thao tác</option>
												<option value="duyet">Duyệt</option>
											</select>
											<a class="btn btn-info input-group-addon"
											   onclick="check_all_heyu_kt(this)" data-tab="1">
												Chọn
											</a>
										</div>
								</div>
								<div class="col-xs-12 col-md-3">
								</div>
								<div class="col-xs-12 col-md-6 text-right">
									<?php
									if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
										<button class="btn btn-info">
											<a href="<?= base_url() ?>excel/exportReceiptHeyU?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&code=' . $code . '&code_transaction_bank=' . $code_transaction_bank . '&store=' . $store . '&status=' . $status ?>"
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
												<form action="<?php echo base_url('transaction/approveTransactionHeyU') ?>" method="get"
													  style="width: 100%">
													<div class="col-xs-12 col-md-6">
														<input type="hidden" name="tab" value="<?= $tab ?>">
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
															<label>
																Mã phiếu thu:
															</label>
															<input type="text" class="form-control" name="code" placeholder="Nhập mã phiếu thu">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Mã GD ngân hàng </label>
															<input type="text" name="code_transaction_bank"
																   class="form-control"
																   value="<?= $code_transaction_bank ?>"
																   placeholder="Nhập mã giao dịch ngân hàng">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>PGD:</label>
															<select class="form-control"
																	placeholder="Tất cả"
																	name="store">
																<option value="" selected><?= $this->lang->line('All') ?></option>
																<?php foreach ($storeData as $p) { ?>
																	<option <?php echo $store == $p->id ? 'selected' : '' ?>
																			value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Trạng thái:</label>
															<select class="form-control"
																	placeholder="Tất cả"
																	name="status">
																<option value="" <?php echo $status == '-' ? 'selected' : '' ?>>
																	Tất cả
																</option>
																<?php foreach (status_transaction() as $key => $value) { ?>
																	<option <?php echo $status == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"> <?= $value ?>
																	</option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Email giao dịch viên</label>
															<input type="text" name="email"
																   class="form-control"
																   placeholder="Nhập email giao dịch viên">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>&nbsp;</label> <br>
															<button class="btn btn-primary w-100">Tìm kiếm</button>
														</div>
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
							<br>
								<div class="group-tabs" style="width: 100%;">
									<ul class="nav nav-pills">
										<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'all') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>/transaction/approveTransactionHeyU?tab=all<?= '&fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $store ?>">
												Tất cả
											</a>
										</li>
										<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'wait') ? 'active' : '' ?>">
											<a href="<?php echo base_url(); ?>/transaction/approveTransactionHeyU?tab=wait<?= '&fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $store ?>">
												Chờ xác nhận
											</a>
										</li>
									</ul>
									<div class="tab-content">
										<div role="tabpanel"
											 class="tab-pane <?= (isset($_GET['tab']) && $_GET['tab'] == 'all') ? 'active' : '' ?>"
											 id="vi">
											<br/>
											<?php if (isset($_GET['tab']) && $_GET['tab'] == 'all') { ?>
												<div class="table-responsive">
													<div><?php echo $result_count; ?></div>
													<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
														<thead style="background:#3f86c3; color: #ffffff;">
														<tr>
															<th>#</th>
															<th>Mã PT</th>
															<th>Loại PT</th>
															<th style="width:32px">Chọn
															</th>
															<th>Chức năng</th>
															<th>Thời gian nộp</th>
															<th>Người giao dịch</th>
															<th>Số tiền</th>
															<th>Trạng thái</th>
															<th>Phòng giao dịch</th>
															<th>Phương thức thanh toán</th>
															<th>Ngân hàng</th>
															<th>Mã giao dịch ngân hàng</th>
															<th>Ghi chú kế toán</th>
															<th>Ngày duyệt</th>
														</tr>
														</thead>

														<tbody>
														<?php
														if (!empty($transactionData)) {
															foreach ($transactionData as $key => $tran) {
																?>
																<tr attr-id="<?=$tran->id ?>" class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																	<td><?php echo $key + 1 ?></td>
																	<td>
																		<a attr-action="check-transaction" target="_blank" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																		   class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Click để xem chi tiết">
																			<?= !empty($tran->code) ? $tran->code : "" ?>
																		</a>
																	</td>
																	<td><?= !empty($tran->type) ? type_transaction($tran->type) : "" ?></td>
																	<td>
																		<?php if (intval($tran->status) == 2) { ?>
																			<input type="checkbox" name="heyu[]"
																				   value="<?= $tran->_id->{'$oid'} ?>"
																				   class="heyUCheckBox checkbox_tran_kt">
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
																				<?php if ($tran->type == 7) {?>
																				<li>
																					<a attr-action="check-transaction" href="<?php echo base_url('transaction/viewDetailHeyU/' . $tran->id) ?>"
																					   class="dropdown-item" 
																					   target="_blank">
																						Xem chi tiết
																					</a>
																				</li>
																				<?php } elseif ($tran->type == 8) { ?>
																				<li>
																					<a href="<?php echo base_url('transaction/viewDetailMicTnds/' . $tran->id) ?>"
																					   class="dropdown-item" 
																					   target="_blank">
																						Xem chi tiết
																					</a>
																				</li>
																				<?php } elseif ($tran->type == 10) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailVbiTnds/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } elseif ($tran->type == 11) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailVbiUtv/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } elseif ($tran->type == 12) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailVbiSxh/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																			
																				<?php } elseif ($tran->type == 15) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailPtiVta/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } ?>
																				
																				<?php
																				if ($tran->status == 2) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="ktduyetgiaodichheyu(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch 
																							</a>
																						</li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kttraveheyu(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item ketoantrave">
																								Kế toán trả về 
																							</a>
																						</li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kthuyheyu(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item ketoantrave">
																								Hủy phiếu thu 
																							</a>
																						</li>
																						<?php
																					}
																				}
																				?>
																				<?php
																				if (!in_array($tran->status, [1, 3])) {
																					?>
																					<li>
																						<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																						   class="dropdown-item"
																							target="_blank">
																							Tải lên chứng từ
																						</a></li>
																				<?php } ?>
																				<li>
																					<a attr-action="check-transaction" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																					   class="dropdown-item"
																						target="_blank">
																						Xem chứng từ
																					</a></li>

																			</ul>

																	</td>
																	<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
																	<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
																	<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
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
																	<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
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
																	<td><?= !empty($tran->bank) ? $tran->bank : ""; ?></td>
																	<td><?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : ""; ?></td>
																	<td><?= !empty($tran->approve_note) ? $tran->approve_note : ""; ?></td>
																	<td>
																		<?php
																		if (!empty($tran->approved_at) && $tran->status !== 2) {
																			echo date('d/m/Y H:i:s', intval($tran->approved_at));
																		}
																		 ?>
																	</td>

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
										<div role="tabpanel"
											 class="tab-pane <?= (isset($_GET['tab']) && $_GET['tab'] == 'wait') ? 'active' : '' ?>"
											 id="en">
											<br/>
											<?php if (isset($_GET['tab']) && $_GET['tab'] == 'wait') { ?>
												<div class="table-responsive">
													<div><?php echo $result_count; ?></div>
													<table class="table table-bordered m-table table-hover table-calendar table-report ">
														<thead style="background:#3f86c3; color: #ffffff;">
														<tr>
															<th>#</th>
															<th>Mã PT</th>
															<th>Loại PT</th>
															<th style="width:32px">Chọn
															</th>
															<th>Chức năng</th>
															<th>Thời gian nộp</th>
															<th>Người giao dịch</th>
															<th>Số tiền</th>
															<th>Trạng thái</th>
															<th>Phòng giao dịch</th>
															<th>Phương thức thanh toán</th>
															<th>Ngân hàng</th>
															<th>Mã giao dịch ngân hàng</th>
															<th>Ghi chú kế toán</th>
															<th>Ngày duyệt</th>
														</tr>
														</thead>

														<tbody>
														<?php
														if (!empty($transactionData)) {
															foreach ($transactionData as $key => $tran) {
																?>
																<tr attr-id="<?=$tran->id ?>" class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																	<td><?php echo $key + 1 ?></td>
																	<td>
																		<a attr-action="check-transaction" target="_blank" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																		   class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Click để xem chi tiết">
																			<?= !empty($tran->code) ? $tran->code : "" ?>
																		</a>
																	</td>
																	<td><?= !empty($tran->type) ? type_transaction($tran->type) : "" ?></td>
																	<td>
																		<?php if (intval($tran->status) == 2) { ?>
																			<input type="checkbox" name="heyu[]"
																				   value="<?= $tran->_id->{'$oid'} ?>"
																				   class="heyUCheckBox checkbox_tran_kt">
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
																				<?php if ($tran->type == 7) {?>
																					<li>
																						<a attr-action="check-transaction" href="<?php echo base_url('transaction/viewDetailHeyU/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } elseif ($tran->type == 8) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailMicTnds/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } elseif ($tran->type == 10) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailVbiTnds/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } elseif ($tran->type == 11) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailVbiUtv/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																			
																				<?php } elseif ($tran->type == 15) { ?>
																					<li>
																						<a href="<?php echo base_url('transaction/viewDetailPtiVta/' . $tran->id) ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Xem chi tiết
																						</a>
																					</li>
																				<?php } ?>
																				<?php
																				if ($tran->status == 2) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="ktduyetgiaodichheyu(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch
																							</a>
																						</li>
																						<li><a href="javascript:void(0)"
																							   onclick="kttraveheyu(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item ketoantrave">
																								Kế toán trả về </a>
																						</li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kthuyheyu(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item ketoantrave">
																								Hủy phiếu thu
																							</a>
																						</li>
																						<?php
																					}
																				}
																				?>
																				<?php
																				if (!in_array($tran->status, [1, 3])) {
																					?>
																					<li>
																						<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																						   class="dropdown-item"
																						   target="_blank">
																							Tải lên chứng từ
																						</a>
																					</li>
																				<?php } ?>
																				<li>
																					<a attr-action="check-transaction" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																					   class="dropdown-item"
																					   target="_blank">
																						Xem chứng từ
																					</a>
																				</li>
																			</ul>
																	</td>
																	<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
																	<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
																	<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
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
																	<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
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
																	<td><?= !empty($tran->bank) ? $tran->bank : ""; ?></td>
																	<td><?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : ""; ?></td>
																	<td><?= !empty($tran->approve_note) ? $tran->approve_note : ""; ?></td>
																	<td><?= !empty($tran->approved_at) ? date('d/m/Y H:i:s', intval($tran->approved_at)) : "" ?></td>

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
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<div class="modal fade" id="approve_transaction_heyu" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve-heyu">Duyệt giao dịch</h5>
				<hr>
				<div class="form-group">
					<label>Mã GD Ngân hàng:</label>
					<input type="text" class="form-control" name="code_transaction_bank" rows="5"/>
				</div>
				<div class="form-group">
					<label>Ngân hàng:</label>
					<input type="text" class="form-control" name="bank" rows="5"/>
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note_heyu" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve_heyu" value="1">
					<input type="hidden" class="form-control transaction_id_approve_heyu">
				</div>
				<p class="text-right">
					<button class="btn btn-danger heyu_approve_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="return_transaction_heyu" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve-heyu">Trả về giao dịch</h5>
				<hr>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control return_note_heyu" rows="5"></textarea>
					<input type="hidden" class="form-control status_return_heyu" value="11">
					<input type="hidden" class="form-control transaction_id_return_heyu">
				</div>
				<p class="text-right">
					<button class="btn btn-danger heyu_return_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="cancel_transaction_heyu" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve-heyu">Hủy giao dịch</h5>
				<hr>
				<div class="form-group">
					<label>Mã GD Ngân hàng:</label>
					<input type="text" class="form-control" name="code_transaction_bank" rows="5"/>
				</div>
				<div class="form-group">
					<label>Ngân hàng:</label>
					<input type="text" class="form-control" name="bank" rows="5"/>
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control cancel_note_heyu" rows="5"></textarea>
					<input type="hidden" class="form-control status_cancel_heyu" value="3">
					<input type="hidden" class="form-control transaction_id_cancel_heyu">
				</div>
				<p class="text-right">
					<button class="btn btn-danger heyu_cancel_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/transaction/upload.js?v=20221110"></script>
<script src="<?php echo base_url(); ?>assets/js/transaction/index.js"></script>
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
<script type="text/javascript">
	var handleClick = function(e) { 
        let _tr = $(this).closest('tr');
		if ($(this).attr("attr-action") !== "check-transaction") {
			return;
		}
		let href = $(this).attr("href");
		let tranId = _tr.attr('attr-id');
		console.log(tranId);
		console.log(href);
		$.ajax({
			url: _url.base_url + 'transaction/check_transaction',
			type: 'post',
			data: {
				tranId : tranId,
				url : href,
				baseUrl: window.location.href
			},
			success: function (response) {
				console.log(response);
			}
		});
    }; 
   	$('a').mousedown(handleClick);
</script>

