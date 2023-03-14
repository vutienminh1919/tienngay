<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử Lý...</span>
	</div>
	<?php

	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$fdebt = isset($_GET['fdebt']) ? $_GET['fdebt'] : "";
	$tdebt = isset($_GET['tdebt']) ? $_GET['tdebt'] : "";
	$store_id = !empty($_GET['store']) ? $_GET['store'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$type_loan = !empty($_GET['type_loan']) ? $_GET['type_loan'] : "";
	$type_property = !empty($_GET['type_property']) ? $_GET['type_property'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : '';
	?>
	<div class="row top_tiles">

		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result" style="text-align: center">
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
						<h3>Quản lý hợp đồng vay
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url() ?>accountant">Quản
									lý hợp đồng vay</a>
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
						<div class="col-xs-12 ">
							<?php
								if ($userSession['is_superadmin'] == 1 || in_array('phat-trien-san-pham', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles) ) { ?>
							<div class="col-lg-3">
								
                                <div class="input-group">
                                    <span class="input-group-addon">Tháng</span>
                                    <input type="month" id="fdate_export" name="fdate_export" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-lg-2 text-right">
                                           	<a id="excel_export" style="background-color: #18d102;"
												   href="<?= base_url() ?>excel/exportAllContract_dng?fdate=<?= $fdate_export?>"
												   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
													Xuất excel
												</a>
                                        </div>
                                <?php } ?>
							<div class="title_right text-right">
								<div class="dropdown" style="display:inline-block">
									<a class="btn btn-info"
									   href="<?php echo base_url('accountant/index_list_contractMkt') ?>">
										DS hợp đồng KH giới thiệu KH
									</a>
									<button class="btn btn-success dropdown-toggle"
											onclick="$('#lockdulieu').toggleClass('show');">
										<span class="fa fa-filter"></span>
										Lọc dữ liệu
									</button>
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;width:430px;max-width: 85vw;">
										<div class="row">
											<form action="<?php echo base_url('accountant') ?>" method="get"
												  style="width: 100%;">
												<div class="col-xs-12 col-md-6">
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
														<label> Từ ngày T </label>
														<input type="number" name="fdebt" class="form-control"
															   value="<?= ($fdebt != '') ? $fdebt : "" ?>">
													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Đến ngày T </label>
														<input type="number" name="tdebt" class="form-control"
															   value="<?= ($tdebt != '') ? $tdebt : "" ?>">

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Mã phiếu ghi </label>
														<input type="text" name="code_contract"
															   class="form-control"
															   value="<?= !empty($code_contract) ? $code_contract : "" ?>">

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Mã hợp đồng </label>
														<input type="text" name="code_contract_disbursement"
															   class="form-control"
															   value="<?= !empty($code_contract_disbursement) ? $code_contract_disbursement : "" ?>">

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Tên khách hàng </label>
														<input type="text" name="customer_name" class="form-control"
															   value="<?= !empty($customer_name) ? $customer_name : "" ?>">

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Số điện thoại </label>
														<input type="text" name="customer_phone_number"
															   class="form-control"
															   value="<?= !empty($customer_phone_number) ? $customer_phone_number : "" ?>">

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label>Hình thức vay</label>
														<select name="type_loan"
																class="form-control" id="type_loan">
															<option value="">Tất cả</option>
															<option <?php echo $type_loan == 'CC' ? 'selected' : '' ?>
																	value="CC">Cầm cố
															</option>
															<option <?php echo $type_loan == 'DKX' ? 'selected' : '' ?>
																	value="DKX">Cho vay
															</option>
															<option <?php echo $type_loan == 'TC' ? 'selected' : '' ?>
																	value="TC">Tín chấp
															</option>
														</select>

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Sản phẩm vay </label>
														<select name="type_property"
																class="form-control" id="type_property">
															<?php if ($type_loan == 'CC' || $type_loan == 'DKX') : ?>
																<option <?php echo $type_property == 'XM' ? 'selected' : '' ?>
																		value="XM">Xe máy
																</option>
																<option <?php echo $type_property == 'OTO' ? 'selected' : '' ?>
																		value="OTO">Ô tô
																</option>
																<option <?php echo $type_property == 'NĐ' ? 'selected' : '' ?>
																		value="NĐ">Nhà đất
																</option>
															<?php elseif ($type_loan == 'TC') : ?>
																<option <?php echo $type_property == 'TC' ? 'selected' : '' ?>
																		value="TC">Tín chấp
																</option>
															<?php else: ?>
																<option
																		value="">Tất cả
																</option>
															<?php endif; ?>
															</option>
														</select>

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Phòng giao dịch </label>
														<select name="store"
																class="form-control">
															<option value="">Tất cả</option>
															<?php foreach ($stores as $key => $store) : ?>
																<option <?php echo $store_id == $key ? 'selected' : '' ?>
																		value="<?php echo $key ?>"><?php echo $store ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>

												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Trạng thái </label>
														<select name="status" class="form-control">
															<option value="">Tất cả</option>
															<option <?php echo $status == '17' ? 'selected' : '' ?>
																	value="17">Đang vay
															</option>
															<option <?php echo $status == '19' ? 'selected' : '' ?>
																	value="19">Đã tất toán
															</option>
															<option <?php echo $status == '29' ? 'selected' : '' ?>
																	value="29">Chờ GDV tạo phiếu thu gia hạn
															</option>
															<option <?php echo $status == '30' ? 'selected' : '' ?>
																	value="30">Chờ ASM duyệt gia hạn
															</option>
															<option <?php echo $status == '31' ? 'selected' : '' ?>
																	value="31">Chờ GDV tạo phiếu thu cơ cấu
															</option>
															<option <?php echo $status == '32' ? 'selected' : '' ?>
																	value="32">Chờ ASM duyệt cơ cấu
															</option>
															<option <?php echo $status == '33' ? 'selected' : '' ?>
																	value="33">Đã gia hạn
															</option>
															<option <?php echo $status == '34' ? 'selected' : '' ?>
																	value="34">Đã cơ cấu
															</option>
															<option <?php echo $status == '41' ? 'selected' : '' ?>
																	value="41">ASM không duyệt gia hạn
															</option>
															<option <?php echo $status == '42' ? 'selected' : '' ?>
																	value="42">ASM không duyệt cơ cấu
															</option>
														</select>

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
									</ul>
								</div>
							</div>
							<!--						<div class="clearfix"></div>-->
							<hr>
							<div>
								<div>
									<div class="table-responsive">
										<table class="table table-striped table-bordered">
											<tr style="text-align: center">
												<th style="text-align: center;color: blue">Tổng số hợp đồng</th>
												<td style="color: red"><?php echo $result_count ? $result_count . ' Hợp đồng' : 0; ?>
												</td>
											</tr>
											<tr style="text-align: center">
												<th style="text-align: center;color: blue">Tổng tiền cho vay</th>
												<td style="color: red"><?php echo $tong_tien_cho_vay ? number_format($tong_tien_cho_vay) . ' VND' : 0; ?> </td>
											</tr>
											<tr style="text-align: center">
												<th style="text-align: center;color: blue">Tổng gốc còn lại</th>
												<td style="color: red"><?php echo $tong_du_no_goc_con_lai ? number_format($tong_du_no_goc_con_lai) . ' VND' : 0; ?> </td>
											</tr>
											<tr style="text-align: center">
												<th style="text-align: center;color: blue">Tổng hợp đồng quá hạn</th>
												<td style="color: red"><?php echo $tong_hd_qua_han ? $tong_hd_qua_han . ' Hợp đồng' : 0; ?>
												</td>
											</tr>
											<tr style="text-align: center">
												<th style="text-align: center;color: blue">Tổng hợp đồng cần nhắc
												</th>
												<?php if ($status == 19 || $status == 33 || $status == 34) : ?>
													<td style="color: red">0</td>
												<?php else: ?>
													<td style="color: red"><?php echo $tong_hd_can_nhac_no ? $tong_hd_can_nhac_no . ' Hợp đồng' : 0; ?>
													</td>
												<?php endif; ?>
											</tr>
										</table>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="" class="table table-striped table-bordered">
												<thead>
												<tr style="background-color: #0e90d2">
													<th style="text-align: center">#</th>
													<th style="text-align: center"><?= $this->lang->line('Contract_code') ?></th>
													<th style="text-align: center">Mã phiếu ghi</th>
													<th style="text-align: center"><?= $this->lang->line('Customer') ?></th>
													<th style="text-align: center">Thời hạn vay</th>
													<th style="text-align: center"><?= $this->lang->line('Disbursement_date') ?></th>
													<th style="text-align: center"><?= $this->lang->line('Due_date_period') ?></th>
													<th style="text-align: center"><?= $this->lang->line('Money_disbursed') ?></th>
													<th style="text-align: center">Gốc còn lại</th>
													<?php if (in_array('thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles)) : ?>
														<th style="text-align: center">Tình trạng</th>
														<th style="text-align: center">Nhóm</th>
													<?php endif; ?>
													<th style="text-align: center">Ngày trễ</th>
													<th style="text-align: center">Trạng thái</th>
													<th style="text-align: center">Ghi chú</th>
												</tr>
												</thead>

												<tbody>
												<?php
												if (!empty($contractData)) {
													foreach ($contractData as $key => $contract) {
														?>

														<tr>
															<td style="text-align: center"><?php echo ++$key + $page ?></td>
															<td style="text-align: center">
																<a class="link" target="_blank" data-toggle="tooltip"
																   title="Click để xem chi tiết"
																   href="<?php echo base_url("accountant/view?id=") . $contract->_id->{'$oid'} ?>"
																   style="color: #0ba1b5;text-decoration: underline;">
																	<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : $contract->code_contract ?>
																</a>
															</td>
															<td style="text-align: center"><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
															<td style="text-align: center">
																<span data-toggle="tooltip" data-placement="right"
																	  style="text-align: center"
																	  data-html="true"
																	  data-title="

																	  <?php echo 'Số điện thoại: ' . $contract->customer_infor->customer_phone_number ?> <br>
																	  <?php echo 'CMT: ' . $contract->customer_infor->customer_identify ?> <br>
																	  <?php echo 'Ngày sinh: ' . date('d/m/Y', strtotime($contract->customer_infor->customer_BOD)) ?>">
																	<?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?>
																</span>
															</td>
															<td style="text-align: center"><?= !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan / 30 . ' tháng' : "" ?></td>
															<td style="text-align: center"><?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date)) : "" ?></td>
															<td style="text-align: center"><?= !empty($contract->tempo->ngay_ky_tra) ? date('d/m/Y', intval($contract->tempo->ngay_ky_tra)) : "-" ?></td>
															<td style="text-align: center"><?= !empty($contract->loan_infor->amount_money) ? number_format($contract->loan_infor->amount_money, 0, '.', '.') : "" ?></td>
															<td style="text-align: center"><?= !empty($contract->original_debt->du_no_goc_con_lai) ? number_format($contract->original_debt->du_no_goc_con_lai, 0, '.', '.') : "-" ?></td>

															<?php if (in_array('thu-hoi-no', $groupRoles) || in_array('van-hanh', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles)) : ?>
																<td style="text-align: center">
																	<?php if ($contract->status == 19) {
																		echo '<span class="label" style="background-color: #5a0099">Đã tất toán</span>';
																	} elseif ($contract->status == 17) {
																		$time = isset($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : '-';
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
																<?php if ($contract->status == 33 || $contract->status == 34 || $contract->statut == 19): ?>
																	<td style="text-align: center;color: green">-</td>
																<?php else: ?>
																	<?php if (!empty($contract->debt)) : ?>
																		<td style="text-align: center"><?php echo get_bucket($contract->debt->so_ngay_cham_tra) ?></td>
																	<?php else: ?>
																		<td style="text-align: center">-</td>
																	<?php endif; ?>
																<?php endif; ?>
															<?php endif; ?>
															<?php if ($contract->status == 33 || $contract->status == 34 || $contract->statut == 19): ?>
																<td style="text-align: center;color: green">0</td>
															<?php else: ?>
																<?php if (!empty($contract->debt)) : ?>
																	<?php if ($contract->debt->so_ngay_cham_tra <= 3): ?>
																		<td style="text-align: center;color: green"><?= !empty($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : '0' ?></td>
																	<?php elseif ($contract->debt->so_ngay_cham_tra > 4 && $contract->debt->so_ngay_cham_tra < 10): ?>
																		<td style="text-align: center;color: #FF9D00"><?= !empty($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : '0' ?></td>
																	<?php elseif ($contract->debt->so_ngay_cham_tra >= 10): ?>
																		<td style="text-align: center;color: red"><?= !empty($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : '0' ?></td>
																	<?php else: ?>
																		<td style="text-align: center;color: red">-</td>
																	<?php endif; ?>
																<?php else: ?>
																	<td style="text-align: center;color: red">-</td>
																<?php endif; ?>
															<?php endif; ?>

															<td style="text-align: center">
																<?php if ($contract->status == 17) : ?>
																	<span class="label label-success"><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></span>
																<?php elseif ($contract->status == 19): ?>
																	<span class="label"
																		  style="background-color: #5a0099"><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></span>
																<?php else: ?>
																	<span class="label label-warning"><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></span>
																<?php endif; ?>
															</td>
															<td style="text-align: center">
																<button class="btn btn-info" data-toggle="modal"
																		data-target="#themgiaodienModal"
																		onclick="addNoteReminder('<?php echo $contract->_id->{'$oid'} ?>','<?php echo $contract->code_contract ?>')"
																		data-code="<?php echo $contract->code_contract_disbursement ?>"
																		data-id="<?php echo $contract->_id->{'$oid'} ?>">
																	Ghi chú
																</button>
																<?php if (in_array('tbp-cskh', $groupRoles) || $userSession['is_superadmin'] == 1 || in_array('telesales', $groupRoles) || in_array('giao-dich-vien', $groupRoles) || in_array('cua-hang-truong', $groupRoles) ) { ?>
																<button class="btn btn-success" data-toggle="modal"
																		data-target="#modal_coppy_contract"
																		onclick="show_popup_coppy_contract('<?php echo $contract->_id->{'$oid'} ?>','<?php echo $contract->code_contract ?>')"
																		data-code="<?php echo $contract->code_contract_disbursement ?>"
																		data-id="<?php echo $contract->_id->{'$oid'} ?>">
																<i class="fa fa-clone" aria-hidden="true"></i>	Coppy hợp đồng
																</button>
																<?php } ?>
															</td>
														</tr>
													<?php }
												} else { ?>
													<tr style="text-align: center;color: red">
														<td colspan="30">Không có dữ liệu</td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
											<div class="text-right">
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
		</div>
	</div>
</div>

<div id="themgiaodienModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title tittle_code text-center"></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 form-label-left input_mask">
						<div class="row">
							<label class="control-label col-md-4 col-xs-12">Ngày hẹn thanh toán :</label>
							<div class="col-md-8 col-xs-12 error_messages">
								<input type="date" class="form-control"
									   name="date_pay" id="date_pay">
							</div>
							<br>
							<br>
							<label class="control-label col-md-4 col-xs-12">Số tiền thanh toán :</label>
							<div class="col-md-8 col-xs-12 error_messages">
								<input type="text" class="form-control" placeholder="Nhập số tiền" name="money_pay"
									   id="money_pay">
							</div>
							<br>
							<br>
							<label class="control-label col-md-4 col-xs-12">Ghi chú :</label>
							<div class="col-md-8 col-xs-12">
									<textarea name="note" id="note" class="form-control">
									</textarea>
							</div>
							<input type="hidden" name="id_contract">
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary not_reminder_btnSave">OK</button>
			</div>
		</div>

	</div>
</div>
<div id="modal_coppy_contract" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title tittle_code text-center"></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 form-label-left input_mask">
						<div class="row">
							<div class="form-group">
					<p id='message_coppy_contract'>Bạn có chắc chắn muốn coppy hợp đồng này thành hợp đồng mới ?</p>
				
					
				</div>
							<input type="hidden" name="code_contract_coppy">
							<input type="hidden" name="id_contract_coppy">
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary coppy_contract_btnSave">OK</button>
			</div>
		</div>

	</div>
</div>
<script>
		$('#fdate_export').change(function () {
		console.log( $(this).val());
		$("#excel_export").attr("href", "<?= base_url() ?>excel/exportAllContract_dng?fdate="+$(this).val())
 
        });
    </script>
<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>
<script>
	
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
	$('select[name="store"]').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
		select[0].selectize.setValue(<?= $store_id ?>);
	});
	$('select[name="status"]').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
		select[0].selectize.setValue(<?= $status ?>);
	});



</script>

