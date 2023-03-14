<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$group_debt = !empty($_GET['group_debt']) ? $_GET['group_debt'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
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
						<h3>Danh sách hợp đồng vay
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>">Danh
									sách hợp đồng nhắc vay</a>
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
								<form action="<?php echo base_url('accountant/remind_debt_first') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label>Từ</label>
											<input type="date" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label>Đến</label>
											<input type="date" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>">

										</div>
									</div>
						
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
										<label>Họ và tên</label>
										<input type="text" name="customer_name" class="form-control"
											   placeholder="Tên khách hàng" value="<?php echo $customer_name; ?>">
									</div>
									</div>

									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
										<label>Mã hợp đồng</label>
										<input type="text" name="code_contract_disbursement" class="form-control"
											   placeholder="Mã hợp đồng"
											   value="<?php echo $code_contract_disbursement; ?>">
									</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
										<label>Mã phiếu ghi</label>
										<input type="text" name="code_contract" class="form-control"
											   placeholder="Mã phiếu ghi"
											   value="<?php echo $code_contract; ?>">
									</div>
									</div>
									<div class="col-xs-12 col-lg-2 text-right">
										<label>&nbsp;</label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>
									<div class="col-lg-2 text-right">
										<label>&nbsp;</label>
										<a style="background-color: #18d102;"
										   href="<?= base_url() ?>excel/remind_debt_first?fdate=<?= $fdate . '&tdate=' . $tdate ?>"
										   class="btn btn-primary w-100" target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
											Xuất excel
										</a>
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
							<div><?php echo $result_count; ?></div>
							<div class="table-responsive">
								<table id="datatable-button" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th>Thao tác</th>
										<th><?= $this->lang->line('Contract_code') ?></th>
										<th>Mã phiếu ghi</th>
										<th><?= $this->lang->line('Customer') ?></th>

										<th>Hình thức trả lãi</th>
										<th><?= $this->lang->line('Disbursement_date') ?></th>
										<th><?= $this->lang->line('Due_date_period') ?></th>
										<th>Ngày đáo hạn</th>
										<th>Số ngày trễ</th>
										<th><?= $this->lang->line('Interest_payable_period') ?></th>
										<th>Nhóm </th>
									</tr>
									</thead>

									<tbody>
									<?php
									if (!empty($contractData)) {
//										echo "<pre>";
//										print_r($contractData);
//										echo "</pre>";
//										die();
										$time = 0;
										foreach ($contractData as $key => $contract) {
                                        $time = isset($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : '-';
                                        $type_property_code = strtoupper(trim($contract->loan_infor->type_property->code));
                                        

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
															
															<li><a class="dropdown-item" target="_blank"
																   href="<?php echo base_url("accountant/view_v2?id=") . $contract->_id->{'$oid'} ?>">Chi
																	tiết</a></li>
															<li><a href="javascript:void(0)" onclick="note_thn(this)"
																   data-phone="<?= !empty($contract->customer_infor->customer_phone_number) ? $contract->customer_infor->customer_phone_number : "" ?>"
																   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																   class="dropdown-item cht_tu_choi"> Ghi chú</a></li>
															
														</ul>
													</div>

												</td>
												
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : $contract->code_contract ?></td>
											     <td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
												<td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></td>


												<td><?php
													$type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest : 1;
													if ($type_interest == 1) {
														echo "Lãi hàng tháng, gốc hàng tháng";
													} else {
														echo "Lãi hàng tháng, gốc cuối kỳ";
													}
													?></td>
												<td><?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date)) : "" ?></td>
												<td><?= !empty($contract->detail->ngay_ky_tra) ? date('d/m/Y', intval($contract->detail->ngay_ky_tra)) : "" ?></td>
												<td><?= !empty($contract->expire_date) ? date('d/m/Y', intval($contract->expire_date)) : "" ?></td>
												<td>
													<?= (!empty($contract->debt->so_ngay_cham_tra)) ? $contract->debt->so_ngay_cham_tra : 0 ?>

												</td>
												<td><?= !empty($contract->detail->total_paid) ? number_format($contract->detail->total_paid, 0, '.', '.') : "" ?></td>
												<td style="text-align: center">
																	<?php if ($contract->status == 19) {
																		echo '<span class="label" style="background-color: #5a0099">Đã tất toán</span>';
																	} elseif ($contract->status == 17) {
																		
																		if ($time === '-') {
																			echo '<span class="label label-primary">Không xác định </span>';
																		} else {
																			echo get_bucket_text($time);
																		}
																	} elseif (in_array($contract->status, [21, 25, 29])) {
																		echo '<span class="label label-warning">Chờ duyệt gia hạn</span>';
																	} elseif (in_array($contract->status, [23, 27, 31])) {
																		echo '<span class="label label-warning">Chờ duyệt cơ cấu</span>';
																	} elseif ($contract->status == 33) {
																		echo '<span class="label label-warning">Đã gia hạn</span>';
																	} elseif ($contract->status == 34) {
																		echo '<span class="label label-warning">Đã cơ cấu</span>';
																	} else {
																		echo '<span class="label label-primary">Chưa xác định</span>';
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
				<h4 class="modal-title title_modal_contract_v2"><b>Ghi chú</b></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Thoát</button>
				<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
				<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>

				<input id="number" name="phone_number" type="hidden" value=""/>
				<p id="status" style="margin-left: 125px;"></p>

				<input type="hidden" class="form-control contract_id">

				<hr>
				<div class="form-group">
					<label>Kết quả nhắc hợp đồng vay:</label>
					<select class="form-control result_reminder" name="" style="width: 70%">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>

					</select>
				</div>
				<div class="form-group">
					<label>Ngày hẹn thanh toán:</label>
					<input type="date" name="payment_date" class="form-control payment_date">
				</div>
				<div class="form-group">
					<label>Số tiền hẹn thanh toán:</label>
					<input type="text" class="form-control amount_payment_appointment">
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
