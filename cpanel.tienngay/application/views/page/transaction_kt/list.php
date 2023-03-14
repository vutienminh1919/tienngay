<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$code = !empty($_GET['code']) ? $_GET['code'] : "";
	$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
	$allocation = !empty($_GET['allocation']) ? $_GET['allocation'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$code_transaction_bank = !empty($_GET['code_transaction_bank']) ? $_GET['code_transaction_bank'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
	$tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
	?>
	<div class="theloading" style="display:none">
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
						<h3><?php echo $this->lang->line('receipts_list') ?> (Kế toán)
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>"><?php echo $this->lang->line('receipts_list') ?> (Kế toán)</a>
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
								<form action="<?php echo base_url('transaction/list_kt') ?>"
									  method="get" style="width: 100%">
									<div class="col-xs-12">
										<div class="row">
											<input type="hidden" name="tab" value="<?= $tab ?>">

											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label> Từ	</label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label> Đến	</label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">

												</div>
											</div>
											<div class="col-xs-12 col-lg-2">

												<div class="form-group">
													<label> Tên khách hàng	</label>
													<input type="text" name="full_name" class="form-control"
														   value="<?= $full_name ?>" placeholder="Nhập tên khách hàng">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">

												<div class="form-group">
													<label> Mã phiếu ghi	</label>
													<input type="text" name="code_contract"
														   class="form-control" value="<?= $code_contract ?>"
														   placeholder="Nhập mã phiếu ghi">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">

												<div class="form-group">
													<label> Mã hợp đồng	</label>
													<input type="text" name="code_contract_disbursement"
														   class="form-control" value="<?= $code_contract_disbursement ?>"
														   placeholder="Nhập mã hợp đồng">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">

												<div class="form-group">
													<label> Mã GD ngân hàng	</label>
													<input type="text" name="code_transaction_bank" class="form-control"
														   value="<?= $code_transaction_bank ?>"
														   placeholder="Nhập mã giao dịch ngân hàng">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">

												<div class="form-group">
													<label> Mã code	</label>
													<input type="text" name="code" class="form-control"
														   value="<?= $code ?>"
														   placeholder="Nhập mã code">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label> Phòng giao dịch	</label>
												<select id="province" class="form-control" name="store">
													<option value=""><?= $this->lang->line('All') ?></option>
													<?php foreach ($storeData as $p) { ?>
														<option <?php echo $store == $p->id ? 'selected' : '' ?>
																value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Trạng thái phiếu thu</label>
												<select class="form-control" name="status">
													<option value=""><?= $this->lang->line('All')?></option>
													<?php    foreach ( status_transaction() as $key => $item) { ?>
														<option <?php echo $status == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Loại thanh toán</label>
												<select class="form-control" name="type_transaction">
													<option value=""><?= $this->lang->line('All')?></option>
													<?php    foreach ( type_transaction() as $key => $item) { ?>
														<option <?php echo $type_transaction == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Phân bổ</label>
												<select class="form-control" name="allocation">
													<option value=""><?= $this->lang->line('All')?></option>
													<option <?php echo $allocation == 'done' ? 'selected' : ''?>  value="done">Đã phân bổ</option>
													<option <?php echo $allocation == 'not_done' ? 'selected' : ''?>  value="not_done">Chưa phân bổ</option>
												</select>
											</div>
											<div class="col-xs-12 col-lg-1">
												<label>&nbsp;</label>
												<button class="btn btn-primary w-100"><i class="fa fa-search"
																						 aria-hidden="true"></i> &nbsp;
												</button>
											</div>
											<div class="col-xs-12 col-lg-1">
												<label>&nbsp;</label>
												<a style="background-color: #18d102;"
												   href="<?= base_url() ?>excel/exportList_kt?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store. '&code_contract=' . $code_contract  . '&tab=' . $tab. '&status=' . $status. '&type_transaction=' . $type_transaction . '&allocation=' . $allocation?>"
												   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;</a>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-xs-12">
							<br>
							<div class="row">
								<div class="col-xs-12 col-lg-2">
									<div class="input-group">
										<select class="form-control" id="combox_check">
											<option  selected disabled>Chọn thao tác</option>
											<option value="duyet">Duyệt</option>
											<option value="huyduyet">Hủy thanh toán</option>
										</select>
										<a class="btn btn-info input-group-addon"
										   onclick="check_all_kt(this)" data-tab="1">
											Chọn
										</a>
									</div>
								</div>
								<div class="col-xs-12 col-lg-10">

								</div>
							</div>
							<div class="group-tabs" style="width: 100%;">
								<ul class="nav nav-tabs">
									<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'all') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>/transaction/list_kt?tab=all<?= '&fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&code_transaction_bank=' . $code_transaction_bank . '&code_contract=' . $code_contract . '&status=' . $status . '&type_transaction=' . $type_transaction . '&allocation=' . $allocation . '&code=' . $code ?>">Tất
											cả</a></li>
									<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'wait') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>/transaction/list_kt?tab=wait<?= '&fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&code_transaction_bank=' . $code_transaction_bank . '&code_contract=' . $code_contract . '&status=' . $status . '&type_transaction=' . $type_transaction . '&allocation=' . $allocation . '&code=' . $code ?>">Chờ
											xác nhận</a></li>
									<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'import') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>/transaction/list_kt?tab=import<?= '&fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&code_transaction_bank=' . $code_transaction_bank . '&code_contract=' . $code_contract . '&status=' . $status . '&type_transaction=' . $type_transaction . '&allocation=' . $allocation . '&code=' . $code ?>">Import</a>
									</li>
									<li class="<?= (isset($_GET['tab']) && $_GET['tab'] == 'contract_ksnb') ? 'active' : '' ?>"><a
												href="<?php echo base_url(); ?>/transaction/list_kt?tab=contract_ksnb<?= '&fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&code_transaction_bank=' . $code_transaction_bank . '&code_contract=' . $code_contract . '&status=' . $status . '&type_transaction=' . $type_transaction . '&allocation=' . $allocation . '&code=' . $code ?>">Phiếu thu cần theo dõi</a>
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
												<table id="datatable-button" class="table table-striped datatablebutton">
													<thead>
													<tr>
														<th>#</th>
														<th>CHECK</th>
														<th>Chọn</th>
														<th>Thao tác</th>
														<th>Mã HĐ</th>
														<th>Mã Phiếu ghi</th>
														<th>Tên khách hàng</th>
														<th>Số tiền phải thanh toán</th>
														<th>Hạn thanh toán</th>
														<th>Phòng giao dịch</th>
														<th>Tổng tiền thanh toán</th>
														<th>Ngày thanh toán</th>
														<th>Phương thức thanh toán</th>
														<th>Ngân hàng</th>
														<th>Mã giao dịch ngân hàng</th>
														<th>Số tiền thực nhận</th>
														<th>Ngày thanh toán</th>
														<th>Ngày bank nhận</th>
														<th>Phí giảm trừ</th>
														<th>Phí khác</th>
														<th>Phí ngân hàng</th>
														<th>Loại thanh toán</th>
														<th></th>
														<th>Tiến trình xử lý</th>
														<th>Nội dung thu tiền</th>
														<th>Ghi chú kế toán</th>
														<th>Ngày tạo</th>
													</tr>
													</thead>

													<tbody>
													<?php
													if (!empty($transactionData)) {
														foreach ($transactionData as $key => $tran) {
															if (in_array($tran->type, [7,8])) continue;
															?>
															<tr attr-id="<?=$tran->id ?>" class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																<td><?php echo $key + 1 ?></td>
																<td><?= !empty($tran->check) ? $tran->check : "" ?>
																	<br>
																	<a attr-action="check-transaction" target="_blank" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																	   class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Click để xem chi tiết">
																		<?= !empty($tran->code) ? $tran->code : "" ?>
																	</a>
																</td>
																<td>
																	<?php if (intval($tran->status) == 2) { ?>
																		<input type="checkbox"
																			   value="<?= $tran->_id->{'$oid'} ?>"
																			   class="checkbox_tran_kt"/>
																	<?php } ?>
																</td>
																<td>
																	<div class="dropdown">
																		<button class="btn btn-secondary dropdown-toggle"
																				type="button" id="dropdownMenuButton"
																				data-toggle="dropdown" aria-haspopup="true"
																				aria-expanded="false">
																			Chức năng
																			<span class="caret"></span></button>
																		<ul class="dropdown-menu" style="z-index: 99999">
																			<?php
																			if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																				<!-- <li>  <a class="dropdown-item" href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
										  <?php echo $this->lang->line('detail') ?>
									  </a>
									</li> -->
																				<?php
																				if ($tran->status == 2 && in_array($tran->type, [3, 4])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kttrave(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item travepgd">
																								Trả về PGD
																							</a>
																						</li>
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
																							   class="dropdown-item duyet">
																								Duyệt giao dịch gia hạn </a>
																						</li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<?php
																					}
																				}

																				?>


																			<?php } else { ?>
																				<!-- <li>  <a class="dropdown-item" href="<?php echo base_url('transaction/view/' . $tran->id) ?>">
									  <i class="fa fa-eye"></i> <?php echo $this->lang->line('detail') ?>
									  </a></li> -->
																			<?php }

																			?>
																			<li>
																				<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																				   class="dropdown-item">
																					Tải lên chứng từ
																				</a></li>
																			<li>
																				<a attr-action="check-transaction" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																				   class="dropdown-item ">
																					Xem chứng từ
																				</a></li>

																			<li>
																				<a attr-action="check-transaction" href="<?php echo base_url("accountant/view_v2?id=") . $tran->id_contract ?>"
																				   class="dropdown-item ">
																					Chi tiết thanh toán/ lịch sử trả tiền
																				</a></li>
																		</ul>

																</td>


																<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>

																<td><?= !empty($tran->code_contract) ? $tran->code_contract : "" ?></td>
																<td><?= !empty($tran->customer_name) ? $tran->customer_name : $tran->full_name?></td>
																<td><?= !empty($tran->detail->total_paid) ? number_format($tran->detail->total_paid, 0, ',', ',') : "" ?></td>

																<td><?= !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "" ?></td>
																<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
																<td><?= (!empty($tran->total) && $tran->total > 0) ? number_format((int)$tran->total, 0, ',', ',') : "" ?></td>
																<td><?= !empty($tran->date_pay) ? date('d/m/Y H:i:s', intval($tran->date_pay)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
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
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->bank) ? $tran->bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->bank) ? $tran->bank : "" ?>'
																		   id='bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?>'
																		   id='code_transaction_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->amount_actually_received) ? number_format($tran->amount_actually_received) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->amount_actually_received) ? $tran->amount_actually_received : "" ?>'
																		   id='amount_actually_received-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?>'
																		   id='date_pay-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?>'
																		   id='date_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->discounted_fee) ? number_format($tran->discounted_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->discounted_fee) ? $tran->discounted_fee : "" ?>'
																		   id='discounted_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->other_fee) ? number_format($tran->other_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->other_fee) ? $tran->other_fee : "" ?>'
																		   id='other_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->reduced_fee) ? number_format($tran->reduced_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->reduced_fee) ? $tran->reduced_fee : "" ?>'
																		   id='reduced_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->type) ? type_transaction($tran->type) : "" ?></div>
																	<select  class='txtedit'
																			 value='<?= !empty($tran->type) ? $tran->type : "" ?>'
																			 id='type_t-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'>

																		<?php    foreach ( type_transaction() as $key => $item) { ?>
																			<option <?php echo $tran->type == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
																		<?php } ?>
																	</select>


																</td>
																<td><?php if($tran->type==4) 
																echo !empty($tran->type_payment) ? type_payment($tran->type_payment) : ""; ?></td> 
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->status) ? status_transaction($tran->status) : "" ?></div>
																	<select  class='txtedit'
																			 value='<?= !empty($tran->type) ? $tran->type : "" ?>'
																			 id='status-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'>

																		<?php    foreach ( status_transaction() as $key => $item) { ?>
																			<option <?php echo $tran->status == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
																		<?php } ?>
																	</select>


																</td>
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
																<td><?= !empty($tran->approve_note) ? $tran->approve_note : ""; ?></td>
																<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : "" ?></td>

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
												<table id="datatable-button" class="table table-striped datatablebutton">
													<thead>
													<tr>
														<th>#</th>

														<th>CHECK</th>
														<th>Chọn</th>
														<th>Thao tác</th>
														<th>Mã HĐ</th>
														<th>Mã Phiếu ghi</th>
														<th>Tên khách hàng</th>

														<th>Hạn thanh toán</th>
														<th>Phòng giao dịch</th>
														<th>Tổng tiền thanh toán</th>
														<th>Ngày thanh toán</th>
														<th>Phương thức thanh toán</th>
														<th>Ngân hàng</th>
														<th>Mã giao dịch ngân hàng</th>
														<th>Số tiền thực nhận</th>
														<th>Ngày thanh toán</th>
														<th>Ngày bank nhận</th>
														<th>Phí giảm trừ</th>
														<th>Phí khác</th>
														<th>Phí ngân hàng</th>
														<th>Loại thanh toán</th>
														<th></th>
														<th>Tiến trình xử lý</th>
														<th>Nội dung thu tiền</th>
														<th>Ghi chú kế toán (mới)</th>
														<th>Ngày tạo</th>
													</tr>
													</thead>

													<tbody>
													<?php
													if (!empty($transactionData)) {
														foreach ($transactionData as $key => $tran) {
															if (in_array($tran->type, [7,8])) continue;
															// if(isset($_GET['status']) )
															// {
															// 	if($_GET['status']==2 && $tran->progress!= 'Đang chờ')
															// 		continue;
															// }
															?>
															<tr attr-id="<?=$tran->id ?>" class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																<td><?php echo $key + 1 ?></td>
																<td><?= !empty($tran->check) ? $tran->check : "" ?>
																	<br>
																	<a attr-action="check-transaction" target="_blank" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																	   class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Click để xem chi tiết">
																		<?= !empty($tran->code) ? $tran->code : "" ?>
																	</a>
																</td>
																<td>
																	<?php if (intval($tran->status) == 2) { ?>
																		<input type="checkbox"
																			   value="<?= $tran->_id->{'$oid'} ?>"
																			   class="checkbox_tran_kt"/>
																	<?php } ?>
																</td>
																<td>
																	<div class="dropdown">
																		<button class="btn btn-secondary dropdown-toggle"
																				type="button" id="dropdownMenuButton"
																				data-toggle="dropdown" aria-haspopup="true"
																				aria-expanded="false">
																			Chức năng
																			<span class="caret"></span></button>
																		<ul class="dropdown-menu" style="z-index: 99999">

																			<?php
																			if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																				<li><a class="dropdown-item"
																					   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																						<?php echo $this->lang->line('detail') ?>
																					</a>
																				</li>
																				<?php
																				if ($tran->status == 2 && in_array($tran->type, [3, 4])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kttrave(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item travepgd">
																								Trả về PGD
																							</a>
																						</li>
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
																							   class="dropdown-item duyet">
																								Duyệt giao dịch gia hạn </a>
																						</li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
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
																			<li>
																				<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																				   class="dropdown-item">
																					Tải lên chứng từ
																				</a></li>
																			<li>
																				<a attr-action="check-transaction" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																				   class="dropdown-item ">
																					Xem chứng từ
																				</a></li>

																			<li>
																				<a attr-action="check-transaction" href="<?php echo base_url("accountant/view_v2?id=") . $tran->id_contract ?>"
																				   class="dropdown-item ">
																					Chi tiết thanh toán/ lịch sử trả tiền
																				</a></li>
																		</ul>

																</td>
																<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>


																<td><?= !empty($tran->code_contract) ? $tran->code_contract : "" ?></td>

																<td><?= !empty($tran->customer_bill_name) ? $tran->customer_bill_name : $tran->full_name ?></td>

																<td><?= !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "" ?></td>
																<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
																<!-- <td><?= (!empty($tran->total) && $tran->total > 0) ? number_format((int)$tran->total, 0, ',', ',') : "" ?></td> -->
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->total) ? number_format($tran->total) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->total) ? $tran->total : "" ?>'
																		   id='total-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td><?= !empty($tran->date_pay) ? date('d/m/Y H:i:s', intval($tran->date_pay)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
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
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->bank) ? $tran->bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->bank) ? $tran->bank : "" ?>'
																		   id='bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?>'
																		   id='code_transaction_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->amount_actually_received) ? number_format($tran->amount_actually_received) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->amount_actually_received) ? $tran->amount_actually_received : "" ?>'
																		   id='amount_actually_received-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?>'
																		   id='date_pay-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?>'
																		   id='date_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->discounted_fee) ? number_format($tran->discounted_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->discounted_fee) ? $tran->discounted_fee : "" ?>'
																		   id='discounted_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->other_fee) ? number_format($tran->other_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->other_fee) ? $tran->other_fee : "" ?>'
																		   id='other_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->reduced_fee) ? number_format($tran->reduced_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->reduced_fee) ? $tran->reduced_fee : "" ?>'
																		   id='reduced_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->type) ? type_transaction($tran->type) : "" ?></div>
																	<select  class='txtedit'
																			 value='<?= !empty($tran->type) ? $tran->type : "" ?>'
																			 id='type_t-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'>

																		<?php    foreach ( type_transaction() as $key => $item) { ?>
																			<option <?php echo $tran->type == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
																		<?php } ?>
																	</select>


																</td>
																<td><?php if($tran->type==4) 
																echo !empty($tran->type_payment) ? type_payment($tran->type_payment) : ""; ?></td> 
																<td><?= !empty($tran->status) ? status_transaction($tran->status) : ""; ?></td>

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
																	<input type='hidden'
																		   value='<?= !empty($tran->note) ? $tran->note : "" ?>'
																		   id='note-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
																</td>
																<td><?= !empty($tran->approve_note) ? $tran->approve_note : ""; ?></td>
																<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : "" ?></td>
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
										 class="tab-pane <?= (isset($_GET['tab']) && $_GET['tab'] == 'import') ? 'active' : '' ?>"
										 id="en">
										<br/>
										<?php if (isset($_GET['tab']) && $_GET['tab'] == 'import') { ?>
											<div class="table-responsive">
												<div><?php echo $result_count; ?></div>
												<table id="datatable-button" class="table table-striped datatablebutton">
													<thead>
													<tr>
														<th>#</th>
														<th>CHECK</th>
														<th>Chọn</th>
														<th>Thao tác</th>
														<th>Mã HĐ</th>
														<th>Mã Phiếu ghi</th>
														<th>Tên khách hàng</th>
														<th>Phòng giao dịch</th>
														<th>Tổng tiền thanh toán</th>
														<th>Ngày thanh toán</th>
														<th>Phương thức thanh toán</th>
														<th>Ngân hàng</th>
														<th>Mã giao dịch ngân hàng</th>
														<th>Số tiền thực nhận</th>
														<th>Ngày thanh toán</th>
														<th>Ngày bank nhận</th>
														<th>Phí giảm trừ</th>
														<th>Phí khác</th>
														<th>Phí ngân hàng</th>
														<th>Loại thanh toán</th>
														<th>Tiến trình xử lý</th>
														<th>Nội dung thu tiền</th>
														<th>Ghi chú kế toán (mới)</th>
														<th>Ngày tạo</th>
													</tr>
													</thead>

													<tbody>
													<?php
													if (!empty($transactionData)) {
														foreach ($transactionData as $key => $tran) {
															if (in_array($tran->type, [7,8])) continue;
															// if(isset($_GET['status']) )
															// {
															// 	if($_GET['status']==2 && $tran->progress!= 'Đang chờ')
															// 		continue;
															// }
															?>
															<tr attr-id="<?=$tran->id ?>" class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																<td><?php echo $key + 1 ?></td>
																<td><?= !empty($tran->check) ? $tran->check : "" ?></td>
																<td>
																	<?php if (intval($tran->status) == 2) { ?>
																		<input type="checkbox"
																			   value="<?= $tran->_id->{'$oid'} ?>"
																			   class="checkbox_tran_kt"/>
																	<?php } ?>
																</td>
																<td>
																	<div class="dropdown">
																		<button class="btn btn-secondary dropdown-toggle"
																				type="button" id="dropdownMenuButton"
																				data-toggle="dropdown" aria-haspopup="true"
																				aria-expanded="false">
																			Chức năng
																			<span class="caret"></span></button>
																		<ul class="dropdown-menu" style="z-index: 99999">

																			<?php
																			if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																				<li><a class="dropdown-item"
																					   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																						<?php echo $this->lang->line('detail') ?>
																					</a>
																				</li>
																				<?php
																				if ($tran->status == 2 && in_array($tran->type, [3, 4])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt giao dịch </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kttrave(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item travepgd">
																								Trả về PGD
																							</a>
																						</li>
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
																							   class="dropdown-item duyet">
																								Duyệt giao dịch gia hạn </a>
																						</li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kthuygiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch 
																							</a>
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
																			<li>
																				<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																				   class="dropdown-item">
																					Tải lên chứng từ
																				</a></li>
																			<li>
																				<a attr-action="check-transaction" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																				   class="dropdown-item ">
																					Xem chứng từ
																				</a></li>

																			<li>
																				<a attr-action="check-transaction" attr-action="check-transaction" href="<?php echo base_url("accountant/view_v2?id=") . $tran->id_contract ?>"
																				   class="dropdown-item ">
																					Chi tiết thanh toán/ lịch sử trả tiền
																				</a></li>
																		</ul>

																</td>
																<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>


																<td><?= !empty($tran->code_contract) ? $tran->code_contract : "" ?></td>
																<td><?= !empty($tran->customer_bill_name) ? $tran->customer_bill_name : $tran->full_name ?></td>
																<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
																<td><?= (!empty($tran->total) && $tran->total > 0) ? number_format((int)$tran->total, 0, ',', ',') : "" ?></td>
																<td><?= !empty($tran->date_pay) ? date('d/m/Y H:i:s', intval($tran->date_pay)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
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
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->bank) ? $tran->bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->bank) ? $tran->bank : "" ?>'
																		   id='bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?>'
																		   id='code_transaction_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->amount_actually_received) ? number_format($tran->amount_actually_received) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->amount_actually_received) ? $tran->amount_actually_received : "" ?>'
																		   id='amount_actually_received-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?>'
																		   id='date_pay-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?>'
																		   id='date_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->discounted_fee) ? number_format($tran->discounted_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->discounted_fee) ? $tran->discounted_fee : "" ?>'
																		   id='discounted_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->other_fee) ? number_format($tran->other_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->other_fee) ? $tran->other_fee : "" ?>'
																		   id='other_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->reduced_fee) ? number_format($tran->reduced_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->reduced_fee) ? $tran->reduced_fee : "" ?>'
																		   id='reduced_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->type) ? type_transaction($tran->type) : "" ?></div>
																	<select  class='txtedit'
																			 value='<?= !empty($tran->type) ? $tran->type : "" ?>'
																			 id='type_t-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'>

																		<?php    foreach ( type_transaction() as $key => $item) { ?>
																			<option <?php echo $tran->type == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
																		<?php } ?>
																	</select>


																</td>
																<!-- <td><?= !empty($tran->type) ? type_transaction($tran->type) : ""; ?></td> -->
																<td><?= !empty($tran->status) ? status_transaction($tran->status) : ""; ?></td>

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
																	<input type='hidden'
																		   value='<?= !empty($tran->note) ? $tran->note : "" ?>'
																		   id='note-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
																</td>
																<td><?= !empty($tran->approve_note) ? $tran->approve_note : ""; ?></td>
																<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : "" ?></td>
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
										 class="tab-pane <?= (isset($_GET['tab']) && $_GET['tab'] == 'contract_ksnb') ? 'active' : '' ?>"
										 id="en">
										<br/>
										<?php if (isset($_GET['tab']) && $_GET['tab'] == 'contract_ksnb') { ?>
											<div class="table-responsive">
												<div><?php echo $result_count; ?></div>
												<table id="datatable-button" class="table table-striped datatablebutton">
													<thead>
													<tr>
														<th>#</th>

														<th>CHECK</th>
														<th>Chọn</th>
														<th>Thao tác</th>
														<th>Mã HĐ</th>
														<th>Mã Phiếu ghi</th>
														<th>Tên khách hàng</th>

														<th>Hạn thanh toán</th>
														<th>Phòng giao dịch</th>
														<th>Tổng tiền thanh toán</th>
														<th>Ngày thanh toán</th>
														<th>Phương thức thanh toán</th>
														<th>Ngân hàng</th>
														<th>Mã giao dịch ngân hàng</th>
														<th>Số tiền thực nhận</th>
														<th>Ngày thanh toán</th>
														<th>Ngày bank nhận</th>
														<th>Phí giảm trừ</th>
														<th>Phí khác</th>
														<th>Phí ngân hàng</th>
														<th>Loại thanh toán</th>
														<th>Tiến trình xử lý</th>
														<th>Nội dung thu tiền</th>
														<th>Ghi chú kế toán (mới)</th>
														<th>Ngày tạo</th>
													</tr>
													</thead>

													<tbody>
													<?php
													if (!empty($transactionData)) {
														foreach ($transactionData as $key => $tran) {
															if (in_array($tran->type, [7,8])) continue;
															// if(isset($_GET['status']) )
															// {
															// 	if($_GET['status']==2 && $tran->progress!= 'Đang chờ')
															// 		continue;
															// }
															?>
															<tr attr-id="<?=$tran->id ?>" class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
																<td><?php echo $key + 1 ?></td>
																<td><?= !empty($tran->check) ? $tran->check : "" ?>
																	<br>
																	<a attr-action="check-transaction" target="_blank" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																	   class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Click để xem chi tiết">
																		<?= !empty($tran->code) ? $tran->code : "" ?>
																	</a>
																</td>
																<td>
																	<?php if (intval($tran->status) == 2 || intval($tran->status) == 5) { ?>
																		<input type="checkbox"
																			   value="<?= $tran->_id->{'$oid'} ?>"
																			   class="checkbox_tran_kt"/>
																	<?php } ?>
																</td>
																<td>
																	<div class="dropdown">
																		<button class="btn btn-secondary dropdown-toggle"
																				type="button" id="dropdownMenuButton"
																				data-toggle="dropdown" aria-haspopup="true"
																				aria-expanded="false">
																			Chức năng
																			<span class="caret"></span></button>
																		<ul class="dropdown-menu" style="z-index: 99999">

																			<?php
																			if (!empty($tran->type) && in_array($tran->type, [3, 4, 5])) { ?>
																				<li><a class="dropdown-item"
																					   href="<?php echo base_url('transaction/viewContract/' . $tran->id) ?>">
																						<?php echo $this->lang->line('detail') ?>
																					</a>
																				</li>
																				<?php
																				if ($tran->status == 5 && in_array($tran->type, [3, 4])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetgiaodich(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Xác nhận đã nhận đc tiền </a></li>
																						<?php
																					}
																				}
																				?>

																				<?php
																				if ($tran->status == 2 && in_array($tran->type, [3, 4])) {
																					if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
																						<li><a href="javascript:void(0)"
																							   onclick="ktduyetphieuthu(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Duyệt phiếu thu </a></li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodich_ksnb(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
																						<li>
																							<a href="javascript:void(0)"
																							   onclick="kttrave(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item travepgd">
																								Trả về
																							</a>
																						</li>
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
																							   class="dropdown-item duyet">
																								Duyệt giao dịch gia hạn </a>
																						</li>
																						<li><a href="javascript:void(0)"
																							   onclick="kthuygiaodichgiahan(this)"
																							   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																							   class="dropdown-item duyet">
																								Hủy giao dịch </a></li>
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
																			<li>
																				<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																				   class="dropdown-item">
																					Tải lên chứng từ
																				</a></li>
																			<li>
																				<a attr-action="check-transaction" href="<?php echo base_url("transaction/viewImg_kt?id=") . $tran->id ?>"
																				   class="dropdown-item ">
																					Xem chứng từ
																				</a></li>

																			<li>
																				<a attr-action="check-transaction" attr-action="check-transaction" href="<?php echo base_url("accountant/view_v2?id=") . $tran->id_contract ?>"
																				   class="dropdown-item ">
																					Chi tiết thanh toán/ lịch sử trả tiền
																				</a></li>
																		</ul>

																</td>
																<td><?= !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "" ?></td>


																<td><?= !empty($tran->code_contract) ? $tran->code_contract : "" ?></td>

																<td><?= !empty($tran->customer_bill_name) ? $tran->customer_bill_name : $tran->full_name ?></td>

																<td><?= !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "" ?></td>
																<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
																<!-- <td><?= (!empty($tran->total) && $tran->total > 0) ? number_format((int)$tran->total, 0, ',', ',') : "" ?></td> -->
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->total) ? number_format($tran->total) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->total) ? $tran->total : "" ?>'
																		   id='total-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td><?= !empty($tran->date_pay) ? date('d/m/Y H:i:s', intval($tran->date_pay)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
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
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->bank) ? $tran->bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->bank) ? $tran->bank : "" ?>'
																		   id='bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?></div>

																	<input type='text' class='txtedit'
																		   value='<?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "" ?>'
																		   id='code_transaction_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->amount_actually_received) ? number_format($tran->amount_actually_received) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->amount_actually_received) ? $tran->amount_actually_received : "" ?>'
																		   id='amount_actually_received-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_pay) ? date('Y-m-d',$tran->date_pay) : "" ?>'
																		   id='date_pay-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?></div>

																	<input type='date' class='txtedit'
																		   value='<?= !empty($tran->date_bank) ? date('Y-m-d',$tran->date_bank) : "" ?>'
																		   id='date_bank-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->discounted_fee) ? number_format($tran->discounted_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->discounted_fee) ? $tran->discounted_fee : "" ?>'
																		   id='discounted_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->other_fee) ? number_format($tran->other_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->other_fee) ? $tran->other_fee : "" ?>'
																		   id='other_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->reduced_fee) ? number_format($tran->reduced_fee) : "" ?></div>

																	<input type='number' class='txtedit'
																		   value='<?= !empty($tran->reduced_fee) ? $tran->reduced_fee : "" ?>'
																		   id='reduced_fee-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>

																</td>
																<td>
																	<div class='edit'
																		 data-status="<?= !empty($tran->status) ? $tran->status : "" ?>"> <?= !empty($tran->type) ? type_transaction($tran->type) : "" ?></div>
																	<select  class='txtedit'
																			 value='<?= !empty($tran->type) ? $tran->type : "" ?>'
																			 id='type_t-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'>

																		<?php    foreach ( type_transaction() as $key => $item) { ?>
																			<option <?php echo $tran->type == $key ? 'selected' : ''?>  value="<?= $key ?>"><?= $item ?></option>
																		<?php } ?>
																	</select>


																</td>
																<td><?= !empty($tran->status) ? status_transaction($tran->status) : ""; ?></td>

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
																	<input type='hidden'
																		   value='<?= !empty($tran->note) ? $tran->note : "" ?>'
																		   id='note-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
																</td>
																<td><?= !empty($tran->approve_note) ? $tran->approve_note : ""; ?></td>
																<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : "" ?></td>
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
<div class="modal fade" id="approve_transaction" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
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
					<input type="text" class="form-control"  name="code_transaction_bank" rows="5"/>
				</div>

				<div class="form-group" >
					<label>Ngân hàng:</label>
					<input type="text" class="form-control"  name="bank" rows="5"/>
				</div>

				<div class="form-group" >
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note" rows="5" ></textarea>
					<input type="hidden" class="form-control status_approve" value="1">
					<input type="hidden" class="form-control transaction_id_approve">
				</div>
				<p class="text-right" >
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
				<p class='msg_error'>Mã giao dịch ngân hàng đã tồn tại phiếu thu tự động gạch tiền. Bạn có muốn hủy phiếu thu tự động gạch tiền và duyệt phiếu thu này</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger gachno_approve_submit">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div id="gachnoUpdateModal" class="modal fade">
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
				<input type="hidden" id="gachno_input">
				<p class='msg_error'>Mã giao dịch ngân hàng đã tồn tại phiếu thu tự động gạch tiền. Bạn có muốn hủy phiếu thu tự động gạch tiền và duyệt phiếu thu này</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger gachno_update_submit">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="approve_transaction_ksnb" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title modal-title-approve" style="text-align: center"></h3>
				<hr>

					<input type="hidden" class="form-control status_approve" value="1">
					<input type="hidden" class="form-control transaction_id_approve">

				<p class="text-center" >
					<button class="btn btn-danger approve_submit_ksnb">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="approve_transaction1" tabindex="-1" role="dialog" aria-labelledby="TransactionModal1"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve">Duyệt giao dịch phiếu thu gia hạn</h5>
				<hr>


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
<!-- /modal return transaction  -->
<div class="modal fade" id="return_transaction" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
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
					<textarea class="form-control cancel_note" rows="5" ></textarea>
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

<script src="<?php echo base_url(); ?>assets/js/transaction/upload.js?v=20221110"></script>
<script src="<?php echo base_url(); ?>assets/js/transaction/index.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		// Show Input element
		$('.edit').click(function () {
			var status = $(this).data('status');
			console.log(status);

			$('.txtedit').hide();
			$(this).next('.txtedit').show().focus();
			$(this).hide();

		});

		// Save data
		$(".txtedit").on('focusout', function () {

			// Get edit id, field name and value
			var self = this;
			var id = this.id;
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var value = $(this).val();

			// Hide Input element
			$(this).hide();

			// Hide and Change Text of the container with input elmeent
			$(this).prev('.edit').show();
			$(this).prev('.edit').text(value);

			// Sending AJAX request
			$.ajax({
				url: _url.base_url + 'transaction/update',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id},
				success: function (response) {
					if (response.status == 200) {
						console.log('Save successfully');
					} else {
						if (response.type == "bank_transaction") {
							$("#gachnoUpdateModal").modal("show");
							$('#gachno_input').val(self.id);
						}
					}
				}
			});

		});

		$('.gachno_update_submit').on('click', function() {
			$("#gachnoUpdateModal").modal("hide");
			var id = $('#gachno_input').val();
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var value = $('#'+id).val();
			$.ajax({
				url: _url.base_url + 'transaction/update',
				type: 'post',
				data: {
					field: field_name,
					value: value,
					id: edit_id,
					gach_no: 1
				},
				success: function (response) {
					if (response.status == 200) {
						console.log('Save successfully');
					}
				}
			});
		})
	});
	detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
</script>
<style type="text/css">
	.container {
		margin: 0 auto;
	}


	.edit {
		width: 100%;
		height: 25px;
	}

	.editMode {
		/*border: 1px solid black;*/

	}

	.txtedit {
		display: none;
		width: 99%;
		height: 30px;
	}


	table tr:nth-child(1) th {
		color: white;

	}


</style>
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
