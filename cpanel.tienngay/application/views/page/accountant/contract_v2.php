<div class="theloading" style="display:none">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
	<span>Đang Xử Lý...</span>
</div>

<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
	$vung_mien = !empty($_GET['vung_mien']) ? $_GET['vung_mien'] : "";
	$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
	$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	//	$investor_code = !empty($_GET['investor']) ? $_GET['investor'] : "";
	$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	//	$customer_phone_number= !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$vung_mien = !empty($_GET['vung_mien']) ? $_GET['vung_mien'] : "";
	$van = !empty($_GET['van']) ? $_GET['van'] : "";


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
						<h3>Hợp đồng vay
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url('accountant/contract_v2') ?>">Hợp
									đồng vay</a>
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

							<form action="<?php echo base_url('accountant/contract_v2') ?>" method="get"
								  style="width: 100%;">
								<div class="row">
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
											<label>Số điện thoại</label>
											<input type="text" name="phone_number" class="form-control"
												   placeholder="Số điện thoại" value="<?php echo $phone_number; ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label>CMND</label>
											<input type="text" name="id_card" class="form-control"
												   placeholder="CMND" value="<?php echo $id_card; ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>Vùng</label>
										<select class="form-control" name="vung_mien" id="vung_mien">
											<option value="">--Chọn Vùng--</option>
											<?php foreach ($areaData as $area) { ?>
												<option <?php echo $vung_mien === $area->code ? 'selected' : '' ?>
														value="<?php echo $area->code; ?>"><?php echo $area->title; ?></option>
											<?php } ?>	
										</select>
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
											<label>Mã phiếu ghi</label>
											<input type="text" name="code_contract" class="form-control"
												   placeholder="Mã phiếu ghi"
												   value="<?php echo $code_contract; ?>">
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
										<label>Trạng thái hợp đồng</label>
										<select class="form-control" name="status">
											<option value=""><?= $this->lang->line('All') ?></option>
											<?php foreach (contract_status() as $key => $item) {
												if ($key < 17)
													continue;
												?>

												<option <?php echo $status == $key ? 'selected' : '' ?>
														value="<?= $key ?>"><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>Bucket</label>
										<select class="form-control" name="bucket">
											<option value=""><?= $this->lang->line('All') ?></option>
											<?php foreach (bucket() as $key => $item) { ?>
												<option <?php echo $bucket == $key ? 'selected' : '' ?>
														value="<?= $key ?>"><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-lg-2 ">
										<label>Phòng giao dịch</label>
										<select class="form-control" name="store" id="store">
											<option value="">--Chọn PGD--</option>
										<?php foreach ($storeData as $store) { ?>
											<option 
												<?php if(!empty($selectedStore) && $selectedStore == $store['_id']['$oid']) { ?> selected <?php } ?>value="<?php echo $store['_id']['$oid']; ?>"><?php echo $store['name']; ?>
											</option>
										<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>Tài khoản định danh</label>
										<input type="text" name="van" class="form-control"
												   placeholder="Số tài khoản" value="<?php echo $van ?>">
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>&nbsp;</label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>
									<?php if (in_array('tbp-thu-hoi-no', $groupRoles) || in_array('ke-toan', $groupRoles)) : ?>
										<div class="col-xs-12 col-lg-2">
											<div>
												<label for="">&nbsp;</label>
												<a style="background-color: #18d102;"
												   href="<?= base_url() ?>asDebtContract/process?code_contract_disbursement=<?= $code_contract_disbursement . '&fdate=' . $fdate . '&tdate=' . $tdate . '&bucket=' . $bucket . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&id_card=' . $id_card . '&store=' . $getStore . '&status=' . $status . '&code_contract=' . $code_contract . '&vung_mien=' . $vung_mien . '&van=' . $van ?>"
												   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
													Xuất excel
												</a>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</form>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div>Hiển thị <span class="text-danger">
									<?php echo $result_count > 0 ? $result_count : 0; ?> </span>Kết quả
							</div>
							<div class="table-responsive">
								<table id="datatable-button" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th><?= $this->lang->line('See_details') ?></th>
										<th>Mã phiếu ghi</th>
										<th><?= $this->lang->line('Contract_code') ?></th>

										<th><?= $this->lang->line('Customer') ?></th>
										<th>Hình thức vay</th>
										<th>Thời hạn vay (Tháng)</th>
										<th><?= $this->lang->line('Money_disbursed') ?></th>
										<th><?= $this->lang->line('Disbursement_date') ?></th>
										<th>Ngày đáo hạn</th>
										<th>Phòng giao dịch</th>
										<th>Trạng thái</th>

										<th>Ngày đến hạn kỳ gần nhất</th>
										<th><?= $this->lang->line('Interest_payable_period') ?></th>
										<th>Số ngày trễ</th>
										<th>Nhóm Bucket</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if (!empty($contractData)) {
										foreach ($contractData as $key => $contract) {
											$is_qua_han=0;
											 $ngay_dao_han = !empty($contract->expire_date) ?  intval($contract->expire_date) : 0 ;
											 if(strtotime(date('Y-m-d').' 00:00:00') >= strtotime(date('Y-m-d',$ngay_dao_han).' 00:00:00') && in_array((int)$contract->status,  [10,11,12,13,14,17,18,20,21,22,23,24,25,26,27,28,29,30,31,32,37,38,39,41,42]))
											 {
                                               $is_qua_han=1;
											 }
											?>
											<tr role="row" class="even parent">
												<td><?php echo $key + 1 ?></td>
												<td style="text-align: -webkit-center;">
													<div class="dropdown">
														<button class="btn btn-secondary dropdown-toggle" type="button"
																id="dropdownMenuButton" data-toggle="dropdown"
																aria-haspopup="true" aria-expanded="false">
															Chức năng
															<span class="caret"></span></button>
														<ul class="dropdown-menu" style="z-index: 99999">
															<?php if($is_qua_han==1){ ?>
															<li><a href="javascript:void(0)" onclick="show_popup_print_contract_loan(this)" data-type_property_code="<?=$type_property_code?>" data-id="<?= $contract->_id->{'$oid'} ?>" data-status_contract="1" class="dropdown-item"> In thông báo</a></li>
													    	<?php } ?>
															<li><a class="dropdown-item" target="_blank"
																   href="<?php echo base_url("accountant/view_v2?id=") . $contract->_id->{'$oid'} ?>">Chi
																	tiết</a></li>
															<li><a href="javascript:void(0)" onclick="note_thn(this)"
																   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																   class="dropdown-item cht_tu_choi"> Ghi chú</a>
															</li>
															<?php if ($userSession['is_superadmin'] == 1 || in_array($userSession['email'], $role_liq) ) : ?>
																<!--THN khởi tạo YC định giá tài sản thanh lý => START-->
																<?php if (in_array($contract->status, array(17, 20))) { ?>
																	<li>
																		<a class="dropdown-item"
																		   onclick="showModal_contract('<?= $contract->_id->{'$oid'} ?>')"
																		   href="javascript:void(0)">
																			Khởi tạo thanh lý tài sản
																		</a>
																	</li>
																<?php } ?>
																<!--THN khởi tạo YC định giá tài sản thanh lý => END-->
																<!--THN tạo lại YC định giá tài sản thanh lý => START-->
																<?php if (in_array($contract->status, array(45))) { ?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="thn_tao_lai_thanh_ly('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item tp_thn_duyet">
																			QLHDV tạo lại thanh lý tài sản
																		</a>
																	</li>
																<?php } ?>
																<!--THN tạo lại YC định giá tài sản thanh lý => END-->
															<?php endif; ?>

															<?php if ($userSession['is_superadmin'] == 1 || in_array("tbp-thu-hoi-no", $groupRoles)) : ?>
																<!--TPTHN Cập nhật giá tham khảo tài sản thanh lý => START-->
																<?php if (!empty($contract->status) && $contract->status == 46) { ?>
																		<li>
																			<a href="javascript:void(0)"
																			   onclick="tpthn_update_refer('<?= $contract->_id->{'$oid'} ?>')"
																			   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																			   class="dropdown-item tp_thn_duyet">
																				TP QLHDV cập nhật giá tham khảo
																			</a>
																		</li>
																<?php } ?>
																<!--TPTHN Cập nhật giá tham khảo tài sản thanh lý => START-->
																<!--TPTHN duyệt thanh lý thay CEO  => START-->
																<?php if (!empty($contract->status) && $contract->status == 47) { ?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="tpthn_approve_rep('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item tp_thn_duyet">
																			TP QLHDV duyệt thanh lý thay CEO
																		</a>
																	</li>
																<?php } ?>
																<!-- duyệt thanh lý thay CEO  => END-->
																<!-- bán tài sản thanh lý  => START-->
																<?php if (!empty($contract->status) && $contract->status == 48) { ?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="tpthn_sell_asset_liquidation('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item tp_thn_duyet">
																			TP QLHDV bán tài sản thanh lý
																		</a>
																	</li>
																<?php } ?>
																<!-- bán tài sản thanh lý  => END-->
															<?php endif; ?>
														<!--BPĐG định giá tài sản thanh lý => START-->
														<?php if (in_array('bo-phan-dinh-gia', $groupRoles)) { ?>
															<?php if (!empty($contract->status) && $contract->status == 44) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="bp_dinh_gia_xu_ly('<?= $contract->_id->{'$oid'} ?>')"
																	   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																	   class="dropdown-item">
																		BP Định giá xử lý
																	</a>
																</li>
															<?php } ?>
															<?php if (!empty($contract->status) && $contract->status == 49) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="bp_dinh_gia_lai('<?= $contract->_id->{'$oid'} ?>')"
																	   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																	   class="dropdown-item tp_thn_duyet">
																		BPĐG định giá lại
																	</a>
																</li>
															<?php } ?>
														<?php } ?>
														<!--BPĐG định giá tài sản thanh lý => END-->
															<!-- Tạo đơn miễn giảm => START-->
															<?php if ($userSession['is_superadmin'] == 1 || in_array("thu-hoi-no", $groupRoles)) { ?>
																<?php if (in_array($contract->status, array(17, 20)) && (!isset($contract->exemption))) { ?>
																	<li>
																		<a class="dropdown-item"
																		   onclick="show_modal_exemption('<?= $contract->_id->{'$oid'} ?>')"
																		   href="javascript:void(0)">
																			Upload đơn miễn giảm
																		</a>
																	</li>
																<?php }
															} ?>
															<!--THN Tạo đơn miễn giảm => END-->
														</ul>
													</div>
												</td>
												<td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : '' ?></td>
												<td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></td>
												<td><?= !empty($contract->loan_infor->type_loan->text) ? change_type_loan($contract->loan_infor->type_loan->text) . ' - ' . $contract->loan_infor->type_property->text : " " ?></td>
												<td><?= !empty($contract->loan_infor->number_day_loan) ? ($contract->loan_infor->number_day_loan / 30) : "" ?></td>
												<td><?= !empty($contract->loan_infor->amount_money) ? number_format($contract->loan_infor->amount_money, 0, '.', '.') : "" ?></td>
												<td><?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date)) : "" ?></td>
												<td><?= !empty($contract->expire_date) ? date('d/m/Y', intval($contract->expire_date)) : "" ?></td>
												<td><?= !empty($contract->store->name) ? $contract->store->name : "" ?></td>
												<td><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></td>
												<td><?= !empty($contract->detail->ngay_ky_tra) ? date('d/m/Y', intval($contract->detail->ngay_ky_tra)) : "" ?></td>
												<td><?= number_format(((int)$contract->detail->tien_tra_1_ky + (int)$contract->detail->penalty - (int)$contract->detail->da_thanh_toan), 0, '.', '.') ?></td>
												<td>
													<?php echo !empty($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : "" ?>
												</td>
												<td>
													<?php echo !empty($contract->debt->so_ngay_cham_tra) ? get_bucket($contract->debt->so_ngay_cham_tra) : get_bucket(0) ?>
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

<div class="modal fade" id="note_contract_v2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<input type="hidden" name="contract_id" class="contract_id" value="">
				<h5 class="modal-title title_modal_contract_v2">Ghi chú</h5>
				<hr>
				<div class="form-group">
					<label>Kết quả nhắc hợp đồng vay:</label>
					<select class="form-control result_reminder" name="note_renewal" style="width: 75%">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control contract_v2_note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>

				<p class="text-right">
					<button class="btn btn-danger note_contract_v2_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<!--Modal tạo tài sản thanh lý B01-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_create_request_liquidation_asset.php'); ?>

<!--Modal bộ phận định giá tài sản xử lý B02-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_xu_ly.php'); ?>

<!--Modal BP Định giá xử lý lại  B04-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_approve_again.php'); ?>

<!--Modal THN gửi lại định giá tài sản B01a-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_thn_send_to_bpdg_again.php'); ?>

<!--Modal hủy duyệt yêu cầu tạo thanh lý tài sản-->
<div class="modal fade" id="approve_liquidations" tabindex="-1" role="dialog" aria-labelledby=""
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve" style="text-align: center;color: black"></h5>
				<hr>
				<div class="form-group">
					<input type="hidden" class="form-control" id="data_send_approve" value="cancel_approve">
					<label style="color: black; font-weight: unset">Ghi chú</label>
					<textarea class="form-control note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger cancel_approve_liquidation_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<!--Modal THN cập nhật thông tin định giá B03-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_tpthn_cap_nhat_gia_ban.php'); ?>

<!--Modal THN duyệt thay CEO  B03-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_tpthn_approve_instate_ceo.php'); ?>

<!--Modal TP THN bán tài sản thanh lý  B05-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_thn_sell_asset_liquidation.php'); ?>

<!--Modal CEO phê duyệt đề xuất bán xe-->
<div id="CEOApproveSuggestModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center" style="color: black">PHÊ DUYỆT ĐỀ XUẤT THANH LÝ XE</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="main_1" class="form-horizontal form-label-left" action="/example"
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">

							<input type="hidden" value="" name="id_contract_ceo_approve"
								   class="form-control id_contract_ceo_approve">
							<input type="hidden" class="form-control" name="code_contract_suggest">
							<input type="hidden" class="form-control data_send_approve" value="cancel_approve">
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset">
								Gốc còn lại:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="debt_remain_root_view_ceo">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin thanh lý</b></span>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset">
								Giá đề xuất:
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<div id="suggest_price_view_ceo">
									<span class="help-block"></span>
									<p class="messages"></p>
								</div>
							</div>
							<label class="control-label col-md-3" style="color: black; font-weight: unset">
								Người thu xe:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="name_person_seize_view_ceo">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin người mua</b></span>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset">
								Tên người mua:
							</label>
							<div class="col-md-3 col-xs-12" id="name_buyer_ceo">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>

							<label class="control-label col-md-3 col-xs-12" style="color: black; font-weight: unset">
								Số điện thoại:
							</label>
							<div class="col-md-3 col-xs-12"
								 id="phone_number_buyer_ceo">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" for="first-name"
								   style="color: black; font-weight: unset">
								Hình ảnh upload:
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_img_file_liquidation">

									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset"><span></span>
								Ghi chú của TP QLHDV:</label>
							<div class="col-md-9 col-xs-12 error_messages" id="note_suggest">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">XỬ LÝ CỦA CEO</b></span>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset">
								Đồng ý <span class="text-danger">*</span>
							</label>
							<div class="col-md-3 col-xs-12" style="padding-top: 7px">
								<input type="radio"
									   name="confirm_liquidation"
									   id="confirm_liquidation_event"
									   value="39"
									   checked="checked"
									   required>
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12">&nbsp;</div>
							<label class="control-label col-md-2" style="color: black; font-weight: unset">
								Không đồng ý <span class="text-danger">*</span>
							</label>
							<div class="col-md-3 col-xs-12" style="padding-top: 7px">
								<input type="radio"
									   name="confirm_liquidation"
									   id="disagree"
									   value="43"
									   required>
								<p class="messages"></p>
							</div>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset"><span></span>
								Ghi chú:</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_ceo" rows="3"></textarea>
								<input type="hidden" class="form-control contract_id">
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-9 col-xs-12"></div>
						<div class="col-md-1 col-xs-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
						</div>
						<div class="col-md-1 col-xs-12">
							<button type="button" class="btn btn-info " id="ceo_confirm">Xác nhận</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Modal xác nhận thanh lý tài sản, bước cuối-->
<div class="modal fade" id="confirm_liquidations" tabindex="-1" role="dialog" aria-labelledby=""
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve" style="text-align: center;color: black"></h5>
				<hr>
				<div class="form-group">
					<input type="hidden" class="form-control status_confirm_contract" value="40">
					<label style="color: black; font-weight: unset">Ghi chú</label>
					<textarea class="form-control note_confirm" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger confirm_liquidations_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<!--Modal TP THN gửi CEO duyệt lại thanh lý xe-->
<div id="SendCeoAgain" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black; text-align: center">GỬI CEO DUYỆT LẠI THANH LÝ XE</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal form-label-left" action="/example"
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">
							<input type="hidden" value="" name="contract_id_liquidation" class="form-control contract_id">
							<input type="hidden" class="form-control status_contract_suggest_again" value="38">
							<input type="hidden" class="form-control" name="code_contract_suggest">
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset">
								Gốc còn lại &nbsp;&nbsp;
							</label>
							<div class="col-md-3 col-xs-12">
								<input type="text"
									   name="debt_remain_root_again"
									   id="debt_remain_root_again"
									   class="form-control debt_remain_root_again text-danger"
									   value="" disabled>
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
							<div style="padding-top: 8px"><span class="text-danger">VNĐ</span></div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin thanh lý</b></span>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset">
								Giá đề xuất <span class="text-danger">*</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   name="suggest_price_again"
									   id="suggest_price_again"
									   required class="form-control number"
									   value="" placeholder="Nhập giá đề xuất">
								<p class="messages"></p>
							</div>
							<div style="padding-top: 8px"><span style="color: black">VNĐ</span></div>
						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-left: 40px; padding-bottom: 10px"><b style="color: black">Thông tin người mua</b></span>
						</div>

						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset">
								Tên người mua <span class="text-danger">*</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="name_buyer_again"
									   id="name_buyer_again"
									   placeholder="Nhập họ tên người mua">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>

							<label class="control-label col-md-3 col-xs-12" style="color: black; font-weight: unset">
								Số điện thoại <span class="text-danger">* </span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="phone_number_buyer_again"
									   id="phone_number_buyer_again"
									   minlength="10"
									   maxlength="12"
									   placeholder="Nhập số điện thoại người mua">
								<span class="help-block"></span>
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" for="first-name"
								   style="color: black; font-weight: unset">
								Upload hình ảnh <span class="text-danger">*</span>
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_img_file_send_again">
									</div>
									<label for="uploadinput_liquidations_again">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_liquidations_again"
										   type="file"
										   name="file"
										   data-contain="uploads_img_file_send_again"
										   data-title="Ảnh tài sản thanh lý"
										   data-type="image"
										   class="focus"
										   multiple>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12" style="color: black; font-weight: unset"><span></span>
								Ghi chú:</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_suggest_again" name="note_suggest_again" rows="5"></textarea>
								<input type="hidden" class="form-control contract_id">
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-9 col-xs-12"></div>
						<div class="col-md-1 col-xs-12">
							<button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: bold;">Đóng</button>
						</div>
						<div class="col-md-1 col-xs-12">
							<button type="button" class="btn btn-info " id="send_ceo_again">Gửi CEO</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--End Modal thanh lý tài sản-->

<!--Start Modal đơn miễn giảm-->
<div id="create_exemption_contract" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<div class="theloading" style="display:none">
					<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
					<span>Đang Xử Lý...</span>
				</div>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color: black; text-align: center">UPLOAD ĐƠN MIỄN GIẢM</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal form-label-left" action=""
					  method="post" novalidate>
					<div class="col-xs-12 form-horizontal form-label-left input_mask">
						<div class="row">
							<input type="hidden"
								   class="form-control input-sm"
								   name="code_contract_append"
								   value="">
							<input type="hidden"
								   class="form-control"
								   name="contract_id_append"
								   id="contract_id_append"
								   value="">
							<input type="hidden"
								   class="form-control status_exemptions"
								   name="status_exemptions"
								   value="1">
							<input type="hidden"
								   class="form-control input-sm"
								   name="store_id"
								   value="">
							<input type="hidden"
								   class="form-control input-sm"
								   name="store_name"
								   value="">
							<input type="hidden"
								   class="form-control input-sm"
								   name="store_address"
								   value="">

						</div>
						<br>
						<br>
						<div class="row">
							<span style="padding-bottom: 10px"><b style="color: black">THÔNG TIN MIỄN GIẢM</b></span>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
								Hợp đồng đề nghị &nbsp;&nbsp;
							</label>
							<div class="col-md-5 col-xs-12 error_messages" style="padding-top: 8px" id="contract_append">
							</div>
						</div>

						<br>
						<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Loại miễn giảm &nbsp;&nbsp;
			</label>
			<div class="col-md-2 col-xs-12 " >
				  <input class="form-check-input" type="radio" name="type_payment_exem" value="1" checked>
				  <label class="form-check-label" >Thanh toán</label>
            </div>
            
           <div class="col-md-2 col-xs-12 " >
            <input class="form-check-input" type="radio" name="type_payment_exem" value="2" >
            <label class="form-check-label" >Tất toán</label>
			</div>
		</div>
		<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
								Xác nhận của CEO qua email &nbsp;&nbsp;
							</label>
							<div class="col-md-2 col-xs-12 " >
								<input class="form-check-input" type="radio" name="confirm_email" value="1" checked>
								<label class="form-check-label" >Có</label>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
								Đơn miễn giảm (bản giấy) &nbsp;&nbsp;
							</label>
							<div class="col-md-2 col-xs-12 " >
								<input class="form-check-input" type="radio" name="is_exemption_paper" value="1" checked>
								<label class="form-check-label" >Có</label>
							</div>

							<div class="col-md-2 col-xs-12 " >
								<input class="form-check-input" type="radio" name="is_exemption_paper" value="2" >
								<label class="form-check-label text-danger" >Không có</label>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
								Số tiền KH đề nghị<span class="text-danger"> * </span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="text"
									   name="amount_customer_suggest"
									   id="amount_customer_suggest"
									   required class="form-control number"
									   value="" placeholder="Nhập số tiền miễn giảm">
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12">
								<label for="" class="control-label">&nbsp;</label>
								<span class="text-danger">VNĐ</span>
							</div>
							<div class="col-md-1 col-xs-12"></div>
							<label class="control-label col-md-2 col-xs-12 text-right" style="font-weight: lighter; color: black">
								Ngày đề nghị<span class="text-danger"> *</span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="date"
									   class="form-control"
									   name="date_suggest"
									   id="date_suggest">
								<p class="messages"></p>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
								Số ngày quá hạn<span class="text-danger"> * </span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="number"
									   name="number_date_late"
									   id="number_date_late"
									   required class="form-control number"
									   value="" placeholder="Nhập số ngày quá hạn">
								<p class="messages"></p>
							</div>
							<div class="col-md-1 col-xs-12">
								<label for="" class="control-label">&nbsp;</label>
								<span class="text-danger">Ngày</span>
							</div>
							<div class="col-md-1 col-xs-12"></div>
							<label class="control-label col-md-2 col-xs-12 text-left" style="font-weight: lighter; color: black">
								Ngày khách hàng ký đơn miễn giảm<span class="text-danger"> * </span>
							</label>
							<div class="col-md-3 col-xs-12 error_messages">
								<input type="date"
									   class="form-control"
									   name="date_customer_sign"
									   id="date_customer_sign">
								<p class="messages"></p>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12 text-left" for=""
								   style="color: black; font-weight: unset">
								Upload hình ảnh<span class="text-danger"> * </span>
							</label>
							<div class="col-md-10 col-xs-12 error_messages">
								<div id="SomeThing" class="simpleUploader error_messages">
									<div class="uploads" id="image_create_exemption">
									</div>
									<label for="upload_exemption">
										<div class="uploader btn btn-primary">
											<span>+</span>
										</div>
									</label>
									<input id="upload_exemption"
										   type="file"
										   name="file"
										   data-contain="image_create_exemption"
										   data-title="Ảnh hồ sơ miễn giảm"
										   multiple
										   data-type="create_img_ex"
										   class="focus">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12 text-left"
								   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
								Ghi chú/Note &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							<div class="col-md-10 col-xs-12 error_messages">
								<textarea class="form-control note_suggest_exemptions" rows="3" placeholder="Nhập lưu ý"></textarea>
								<input type="hidden" class="form-control">
								<p class="messages"></p>
							</div>
						</div>
						<br>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: bold;">Đóng</button>
					<button type="button" class="btn btn-info " id="send_exemptions">Gửi yêu cầu</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Modal đơn miễn giảm-->

<div class="modal fade" id="print_contract" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title title_modal_approve_printed"></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-primary printed_thong_bao w-100">
							<i class="fa fa-print"></i>
							THÔNG BÁO
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-info printed_thu_xac_nhan w-100">
							<i class="fa fa-print"></i>
							THƯ XÁC NHẬN
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-warning printed_quyet_dinh w-100">
							<i class="fa fa-print"></i>
							QUYẾT ĐỊNH
						</a>

					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_thong_bao_no w-100">
							<i class="fa fa-print"></i>
							THÔNG BÁO HỢP ĐỒNG VAY
						</a>
					</div>

				</div>
				<br>
				<div class="row">
					<span class="sample-receipt-one">- THÔNG BÁO (1): Chấm dứt việc sử dụng tài sản là Tài sản đảm bảo</span>
					<br>
					<span class="sample-receipt-two">- THƯ XÁC NHẬN (2): Xác nhận khách hàng hoàn thành nghĩa vụ thanh toán</span>
					<br>
					<span class="sample-receipt-two">- QUYẾT ĐỊNH (3): Thu hồi tài sản là tài sản bảo đảm nghĩa vụ thanh toán (Biện pháp cầm cố tài sản).</span>
					<br>
					<span class="sample-receipt-two">- THÔNG BÁO HỢP ĐỒNG VAY (4): Thông báo HỢP ĐỒNG VAY Trễ hạn thanh toán khoản vay</span>

				</div>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script type="text/javascript">
</script>
<script>
	var delta = 0;
	$(document).on('click', '*[data-toggle="lightbox"]', function (event) {
		//$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		return $(this).ekkoLightbox({
			onShow: function (elem) {
				var html = '<button type="button" class="rotate btn btn-link" ><i class="fa fa-repeat"></i></button>';
				console.log(html);
				$(elem.currentTarget).find('.modal-header').prepend(html);
				var delta = 0;
			},
			onNavigate: function (direction, itemIndex) {
				var delta = 0;
				if (window.console) {
					return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
				}
			}
		});
	});
	$('body').on('click', 'button.rotate', function () {
		delta = delta + 90;
		$('.ekko-lightbox-item img').css({
			'-webkit-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'-moz-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)'
		});

	});
</script>
<script>
	$(document).ready(function () {
		$("#confirm_liquidation_event").on("click", function () {
			$("#confirm_liquidation_event").prop("checked", true);
			$("#disagree").prop("checked", false);
		});
		$("#disagree").on("click", function () {
			$("#confirm_liquidation_event").prop("checked", false);
			$("#disagree").prop("checked", true);
		});

	});
	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4","pdf"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 20000000, //10MB,
			multiple: true,
			limit: 10,
			start: function (file) {
				fileType = file.type;
				fileName = file.name;
				//upload started
				this.block = $('<div class="block"></div>');
				this.progressBar = $('<div class="progressBar"></div>');
				this.block.append(this.progressBar);
				$('#' + contain).append(this.block);
			},
			data: {
				'type_img': type,
				'contract_id': contractId
			},
			progress: function (progress) {
				//received progress
				this.progressBar.width(progress + "%");
			},
			success: function (data) {
				//upload successful
				this.progressBar.remove();
				if (data.code == 200) {
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);

					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//pdf
					else if(fileType == 'application/pdf') {
						var item = "";
						item += '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_file"  data-key="'+data.key+'" src="'+data.path+'" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_file"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(content);
						this.block.append(data);
					}

				} else {
					//our application returned an error
					var error = data.msg;
					this.block.remove();
					alert(error);
				}
			},
			error: function (error) {

				var msg = error.msg;
				this.block.remove();
				alert("File không đúng định dạng");
			}
		});
	});
	$(document).ready(function() {
		$("#vung_mien").on("change", function() {
			var vung_mien = $("#vung_mien").val();
			var data={"code_area":vung_mien};
			$.ajax({
				type: "POST",
				url :  _url.base_url + '/accountant/getStoreByArea',
				datatype: "JSON",
				data: data,
				success: function(data)
				{   
					var results = data["data"];
					$("#store option").remove();
					$('#store').append($('<option>', {value: '', text: '-- Chọn PGD --'}));
					for(var i = 0; i< results.length; i++) {
						$('#store').append($('<option>', {value: results[i]["_id"]['$oid'], text: results[i]['name'] + ' - ' +results[i]['province']['name']}));
					}
				}
			});
		});
	})

</script>


