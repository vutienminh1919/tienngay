<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
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
		}
	}

	?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-xs-12 col-lg-1">
						<h2><?php echo $this->lang->line('receipts_list') ?></h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<form class="form-inline" action="<?php echo base_url('transaction/transaction_v2') ?>" method="get"
								  style="width: 100%">
								<div class="col-xs-12">
									<div class="row">
										<!-- 	  <div class="col-lg-2">
								  <div class="input-group">

									  <select class="form-control" name="status">
										  <option value=""><?= $this->lang->line('All_status') ?></option>
										  <option <?php echo $status == 1 ? 'selected' : '' ?> value="1" >Thành công</option>
										  <option <?php echo $status == 2 ? 'selected' : '' ?> value="2" >Chờ xác nhận</option>
										  <option <?php echo $status == 3 ? 'selected' : '' ?> value="3" >Đã hủy</option>

									  </select>
								  </div>
							  </div> -->
										<div class="col-lg-2">
											<div class="input-group">
												<span
													class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
												<input type="date" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="input-group">
												<span
													class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
												<input type="date" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="input-group">
												<input type="text" name="sdt" class="form-control"
													   value="<?= isset($_GET['sdt']) ? $_GET['sdt'] : "" ?>"
													   placeholder="Nhập số điện thoại">
											</div>
										</div>
										<div class="col-lg-2">
											<select id="province" class="form-control" name="store">
												<option value=""><?= $this->lang->line('All') ?></option>
												<?php foreach ($storeData as $p) { ?>
													<option <?php echo $store == $p->id ? 'selected' : '' ?>
														value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-2 text-right">
											<button class="btn btn-primary w-100"><i class="fa fa-search"
																					 aria-hidden="true"></i> <?php echo $this->lang->line('search') ?>
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-xs-12">

						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped">
								<thead>
								<tr>
									<th>#</th>
									<th><?php echo $this->lang->line('receipt_code') ?></th>
									<th><?php echo $this->lang->line('time') ?></th>
									<th><?php echo $this->lang->line('employees') ?></th>
									<th><?php echo $this->lang->line('total_money') ?></th>
									<th><?php echo $this->lang->line('payment_method') ?></th>
									<th><?php echo $this->lang->line('progress') ?></th>
									<!--  <th><?php echo $this->lang->line('status') ?></th> -->
									<th><?php echo $this->lang->line('phone_customer') ?></th>
									<th><?php echo $this->lang->line('store') ?></th>
									<th></th>
								</tr>
								</thead>

								<tbody>
								<?php
								if (!empty($transactionData)) {
									foreach ($transactionData as $key => $tran) {
										if (isset($_GET['status'])) {
											if ($_GET['status'] == 2 && $tran->progress != 'Đang chờ')
												continue;
										}
										?>
										<tr class="<?php echo $tran->progress === 'Error' ? 'warning-transaction' : '' ?>">
											<td><?php echo $key + 1 ?></td>
											<td><?= !empty($tran->code) ? $tran->code : "" ?></td>
											<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : "" ?></td>
											<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
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
											<td><?= !empty($tran->progress) ? $tran->progress : "" ?></td>
											<!--  <td><?= !empty($tran->status) ? get_tt_tran($tran->status) : "" ?></td> -->
											<td><?= !empty($tran->customer_bill_phone) ? $tran->customer_bill_phone : "" ?></td>
											<td><?= !empty($tran->store) ? $tran->store->name : "" ?></td>
											<td>
												<div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button"
															id="dropdownMenuButton" data-toggle="dropdown"
															aria-haspopup="true" aria-expanded="false">
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
																		   class="dropdown-item duyet"> Duyệt giao
																			dịch </a></li>
																	<li><a href="javascript:void(0)"
																		   onclick="kthuygiaodich(this)"
																		   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item duyet"> Hủy giao
																			dịch </a></li>
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
																		   class="dropdown-item duyet"> Duyệt giao dịch
																			gia hạn </a></li>
																	<li><a href="javascript:void(0)"
																		   onclick="kthuygiaodichgiahan(this)"
																		   data-id="<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item duyet"> Hủy giao
																			dịch </a></li>
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
														if (intval($tran->payment_method) == 2) {
															?>
															<li>
																<a href="<?php echo base_url("transaction/upload?id=") . $tran->id ?>"
																   class="dropdown-item">
																	Tải lên chứng từ
																</a></li>
															<li>
																<a href="<?php echo base_url("transaction/viewImg?id=") . $tran->id ?>"
																   class="dropdown-item ">
																	Xem chứng từ
																</a></li>
														<?php } ?>
													</ul>
											</td>
										</tr>
									<?php }
								} ?>
								</tbody>
							</table>
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
<script src="<?php echo base_url(); ?>assets/js/transaction/upload.js"></script>
