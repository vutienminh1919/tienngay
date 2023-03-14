<!-- page content -->
<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$property = !empty($_GET['property']) ? $_GET['property'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
	$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : array();
	$createBy = !empty($_GET['createBy']) ? $_GET['createBy'] : "";
	$asset_name = !empty($_GET['asset_name']) ? $_GET['asset_name'] : "";
	$search_htv = !empty($_GET['search_htv']) ? $_GET['search_htv'] : "";
	$phone_number_relative = !empty($_GET['phone_number_relative']) ? $_GET['phone_number_relative'] : "";
	$fullname_relative = !empty($_GET['fullname_relative']) ? $_GET['fullname_relative'] : "";
	$type_contract_digital = !empty($_GET['type_contract_digital']) ? $_GET['type_contract_digital'] : "";
	$region_get = !empty($_GET['region']) ? $_GET['region'] : '';
	?>


	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3><?= $this->lang->line('Contract_management') ?> - QLHS
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url() ?>File_manager/contract_all"><?php echo $this->lang->line('Contract_management') ?></a>
							</small>
						</h3>
					</div>
					<div class="clearfix"></div>
				</div>

			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<?php if ($this->session->flashdata('error')) { ?>
								<div class="alert alert-danger alert-result">
									<?= $this->session->flashdata('error') ?>
								</div>
							<?php } ?>
							<?php if ($this->session->flashdata('success')) { ?>
								<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
							<?php } ?>
							<div class="row">
								<form action="<?php echo base_url('File_manager/search_contract') ?>" method="get" style="width: 100%;">
									<div class="col-xs-12">
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
													<label> Mã phiếu ghi </label>
													<input type="text" name="code_contract" class="form-control"
														   placeholder="Mã phiếu ghi"
														   value="<?= !empty($code_contract) ? $code_contract : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Mã hợp đồng</label>
													<input type="text" name="code_contract_disbursement"
														   class="form-control"
														   placeholder="Mã hợp đồng"
														   value="<?= !empty($code_contract_disbursement) ? $code_contract_disbursement : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Họ và tên</label>
													<input type="text" name="customer_name" class="form-control"
														   placeholder="Họ và tên"
														   value="<?= !empty($customer_name) ? $customer_name : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Số điện thoại</label>
													<input type="text" name="customer_phone_number" class="form-control"
														   placeholder="Số điện thoại"
														   value="<?= !empty($customer_phone_number) ? $customer_phone_number : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">CMND/CCCD</label>
													<input type="text" name="customer_identify" class="form-control"
														   placeholder="CMND"
														   value="<?= !empty($customer_identify) ? $customer_identify : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2 ">
												<label for="">Chọn khu vực</label>
												<select class="form-control" name="region" id="region_contract">
													<option value="">-- Chọn khu vực --</option>
													<?php foreach ($region_records as $region) : ?>
														<option <?php echo $region_get == $region->value_region ? 'selected' : '' ?>
																value="<?= $region->value_region ?? ''; ?>"><?= $region->name_region ?? ''; ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>
											<?php if (isset($stores_list) && count($stores_list) > 0) : ?>
											<div class="col-xs-12 col-lg-2">
												<label for="">Chọn PGD</label>
												<select id="store_list" class="form-control" name="code_store[]" multiple="multiple" >
													<option value="">Chọn PGD</option>
													<?php foreach ($stores_list as $store) { ?>
														<option <?php if (is_array($code_store)) {
															echo in_array($store->store_id, $code_store) ? 'selected' : '' ;
														} ?>
															value="<?php echo $store->store_id; ?>"><?php echo $store->store_name ; ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<?php else : ?>
												<div class="col-xs-12 col-lg-2">
													<label for="">Chọn PGD</label>
													<select id="store_list" class="form-control" name="code_store[]" multiple="multiple" >
														<option value="">Chọn PGD</option>
														<?php foreach ($stores as $store) { ?>
															<option <?php if (is_array($code_store)) {
																echo in_array($store->_id->{'$oid'}, $code_store) ? 'selected' : '' ;
															} ?>
																	value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											<?php endif; ?>
											<div class="col-xs-12 col-lg-2">
												<label>Tất cả tài sản</label>
												<select class="form-control" name="property">
													<option value=""><?= $this->lang->line('All_property') ?></option>
													<?php foreach ($mainPropertyData as $p) { ?>
														<option <?php echo $property == $p->code ? 'selected' : '' ?>
															value="<?php echo $p->code; ?>"><?php echo $p->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>Trạng thái HĐ</label>
												<select class="form-control" name="status">
													<option value="" <?php echo $status == '-' ? 'selected' : '' ?>><?= $this->lang->line('All_status') ?></option>
													<?php foreach (contract_status() as $key => $value) { ?>
														<option <?php echo $status == $key ? 'selected' : '' ?>
															value="<?= $key ?>"> <?= $value ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label>Tên Tài Sản</label>
													<input type="text" name="asset_name" class="form-control"
														   placeholder="Tên Tài Sản"
														   value="<?= !empty($asset_name) ? $asset_name : "" ?>">
												</div>
											</div>

											<div class="col-xs-12 col-lg-2">
												<label>Hình thức vay</label>
												<select class="form-control" name="search_htv">
													<option value="">Tất cả hình thức vay</option>
													<option value="DKX" <?php echo $search_htv == 'DKX' ? 'selected' : '' ?>>
														Cho vay
													</option>
													<option value="CC" <?php echo $search_htv == 'CC' ? 'selected' : '' ?>>
														Cầm cố
													</option>
													<option value="TC" <?php echo $search_htv == 'TC' ? 'selected' : '' ?>>
														Tín chấp
													</option>
												</select>
											</div>

											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Số điện thoại(Tham chiếu)</label>
													<input type="text" name="phone_number_relative" class="form-control"
														   placeholder="Số điện thoại"
														   value="<?= !empty($phone_number_relative) ? $phone_number_relative : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Họ và tên(Tham chiếu)</label>
													<input type="text" name="fullname_relative" class="form-control"
														   placeholder="Họ tên"
														   value="<?= !empty($fullname_relative) ? $fullname_relative : "" ?>">
												</div>
											</div>

											<div class="col-xs-12 col-lg-2">
												<label>Loại hợp đồng</label>
												<select class="form-control" name="type_contract_digital">
													<option value="">-- Tất cả --</option>
													<option value="1" <?php echo $type_contract_digital == '1' ? 'selected' : '' ?>>
														Hợp đồng điện tử (từ khi có Megadoc)
													</option>
													<option value="2" <?php echo $type_contract_digital == '2' ? 'selected' : '' ?>>
														Hợp đồng giấy (từ khi có Megadoc)
													</option>
													<option value="3" <?php echo $type_contract_digital == '3' ? 'selected' : '' ?>>
														Hợp đồng cũ
													</option>
												</select>
											</div>

											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary w-100"><i
														class="fa fa-search"
														aria-hidden="true"></i> <?= $this->lang->line('search') ?>
												</button>
											</div>
										</div>
									</div>
								</form>
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-12 col-lg-2">
											<label>&nbsp;</label>
											<?php
											if ($userSession['is_superadmin'] == 1 || in_array('phat-trien-san-pham', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('tpb-ke-toan', $groupRoles)  || in_array('quan-ly-ho-so', $groupRoles)) { ?>
												<a style="background-color: #18d102;"
												   href="<?= base_url() ?>File_manager/exportAllContract?fdate=<?=$fdate
												   . '&tdate=' . $tdate
												   . '&code_contract=' . $code_contract
												   . '&code_contract_disbursement=' . $code_contract_disbursement
												   . '&customer_name=' .$customer_name
												   . '&customer_phone_number=' . $customer_phone_number
												   . '&customer_identify=' . $customer_identify
												   . '&'. http_build_query($code_store,'code_store[]')
												   . '&property=' . $property
												   . '&status=' . $status
												   . '&region=' . $region_get
												   . '&search_htv=' . $search_htv ?>"
												   class="btn btn-primary w-100" target="_blank"><i
														class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
													Xuất excel
												</a>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row"></div>
						</div>
						<div class="col-xs-12">
							<div>
								<h4>
									<?php if ($countContract != 0) : ?>
										<?php echo "Hiển thị (" . "<span class='text-danger'>$countContract</span>" . ") kết quả." ?>
									<?php endif; ?>
								</h4>
							</div>
							<div class="table-responsive" style="min-height: 500px; overflow-y: auto">
								<table class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th><?= $this->lang->line('Function') ?></th>
										<th>Loại hợp đồng</th>
										<th><?= $this->lang->line('Contract_Code') ?></th>
										<th>Mã phiếu ghi</th>
										<th><?= $this->lang->line('Customer') ?></th>
										<th><?= $this->lang->line('phone_number') ?></th>
										<th><?= $this->lang->line('CMT1') ?></th>
										<th><?= $this->lang->line('Asset') ?></th>
										<th><?= $this->lang->line('amount_loan') ?></th>
										<th><?= $this->lang->line('status') ?></th>
										<th> <?= $this->lang->line('interest_payment') ?></th>
										<th><?= $this->lang->line('Number_loan_days') ?></th>
										<th>Blacklist</th>
										<th>Phòng giao dịch</th>
										<th>Người tạo</th>
										<th>Ngày tạo</th>
										<th>Ngày giải ngân</th>
										<th>Ngày tất toán thực tế</th>
										<th>Ngày gia hạn/cơ cấu</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if (!empty($contractData)) {
										foreach ($contractData as $key => $contract) {
											$printed = "";
											$contract_status = !empty($contract->status) ? $contract->status : "";
											$contract_id = !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "";
											$type_property_code = strtoupper(trim($contract->loan_infor->type_property->code));
											if ($contract->loan_infor->type_property->code == "NĐ") {
												$printed .= '<li><a href="javascript:void(0)" onclick="show_popup_print_contract_estate(this)" data-id="' . $contract_id . '" data-status_contract="' . $contract_status . '"   class="dropdown-item"> In hợp đồng</a></li>';
											} elseif ($contract->loan_infor->type_property->code == "TC") {
												$printed .= '<li><a href="javascript:void(0)" onclick="show_popup_print_contract_mortgage(this)" data-id="' . $contract_id . '" data-status_contract="' . $contract_status . '"   class="dropdown-item"> In hợp đồng</a></li>';
											} elseif ($contract->loan_infor->type_loan->code == "CC" && $contract->loan_infor->type_property->code != "TC") {
												$printed .= '<li><a href="javascript:void(0)" onclick="show_popup_print_contract_pledge(this)" data-type_property_code="' . $type_property_code . '" data-id="' . $contract_id . '" data-status_contract="' . $contract_status . '"  class="dropdown-item"> In hợp đồng</a></li>';
											} elseif ($contract->loan_infor->type_loan->code == "DKX" && $contract->loan_infor->type_property->code != "TC") {
												$printed .= '<li><a href="javascript:void(0)" onclick="show_popup_print_contract_loan(this)" data-type_property_code="' . $type_property_code . '" data-id="' . $contract_id . '" data-status_contract="' . $contract_status . '" class="dropdown-item"> In hợp đồng</a></li>';

											}
											?>
											<tr>
												<td><?php echo $key + 1 ?></td>
												<td>
													<div class="dropdown">
														<button class="btn btn-secondary dropdown-toggle" type="button"
																id="dropdownMenuButton" data-toggle="dropdown"
																aria-haspopup="true" aria-expanded="false">
															Chức năng
															<span class="caret"></span></button>
														<ul class="dropdown-menu" style="z-index: 99999">
															<?php
															if ($contract->status != 0) { ?>

																<?php if (!empty($contract->data_hs)): ?>
																	<?php

																	$customer_name_hs = ($contract->data_hs[count($contract->data_hs) - 1]->user->email);
																	$check_customer_hs = $contract->data_hs[count($contract->data_hs) - 1]->check;
																	?>
																<?php endif; ?>

																<?php
																if (($customer_name_hs == "") && ($contract->status == 5) && ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "DKX")))) {
																	?>

																	<li>
																		<a onclick="hoi_so_bat_dau_duyet(this)"
																		   href="javascript:void(0)"
																		   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
																		   data-id="<?php echo $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">Chi tiết</a>
																	</li>
																<?php } elseif (($customer_name_hs == $userSession['email']) && ($contract->status == 5) && ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "DKX")))) { ?>
																	<li>
																		<a onclick="hoi_so_bat_dau_duyet(this)"
																		   href="javascript:void(0)"
																		   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
																		   data-id="<?php echo $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">Chi tiết</a>
																	</li>
																<?php } elseif (($check_customer_hs == 2) && ($contract->status == 5) && ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "DKX")))) { ?>
																	<li>
																		<a onclick="hoi_so_bat_dau_duyet(this)"
																		   href="javascript:void(0)"
																		   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
																		   data-id="<?php echo $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">Chi tiết</a>
																	</li>


																<?php } elseif (($customer_name_hs == "") && ($contract->status == 5) && (in_array('quan-ly-khu-vuc', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC"))) {
																	?>

																	<li>
																		<a onclick="hoi_so_bat_dau_duyet(this)"
																		   href="javascript:void(0)"
																		   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
																		   data-id="<?php echo $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">Chi tiết</a>
																	</li>
																<?php } elseif (($customer_name_hs == $userSession['email']) && ($contract->status == 5) && (in_array('quan-ly-khu-vuc', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC"))) { ?>
																	<li>
																		<a onclick="hoi_so_bat_dau_duyet(this)"
																		   href="javascript:void(0)"
																		   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
																		   data-id="<?php echo $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">Chi tiết</a>
																	</li>
																<?php } elseif (($check_customer_hs == 2) && ($contract->status == 5) && (in_array('quan-ly-khu-vuc', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC"))) { ?>
																	<li>
																		<a onclick="hoi_so_bat_dau_duyet(this)"
																		   href="javascript:void(0)"
																		   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
																		   data-id="<?php echo $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">Chi tiết</a>
																	</li>
																<?php } else { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/detail?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			Chi tiết
																		</a>
																	</li>
																	<?php
																	unset($customer_name_hs);
																	unset($check_customer_hs);
																	?>
																<?php } ?>


																<li>
																	<a href="<?php echo base_url("pawn/viewImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
																	   class="dropdown-item">
																		Xem chứng từ
																</li>
																<?php
																if ($userSession['is_superadmin'] == 1 || in_array("tbp-thu-hoi-no", $groupRoles)) { ?>
																	<li>

																		<a href="<?php echo base_url("pawn/downloadImage?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			Tải chứng từ

																		</a>
																	</li>
																	<!-- gia hạn	 -->
																	<?php
																	// buttom gửi hội sở duyệt gia hạn
																	if (in_array($contract->status, array(11)) ) { ?>
																		<li><a href="javascript:void(0)"
																			   onclick="tp_thn_duyet_gia_han(this)"
																			   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																			   class="dropdown-item ">
																				Gửi duyệt gia hạn</a>
																		</li>
																	<?php } ?>

																	<!-- 	cơ cấu		 -->
																	<?php
																	// buttom gửi hội sở duyệt gia hạn
																	if (in_array($contract->status, array(12)) ) { ?>
																		<li><a href="javascript:void(0)"
																			   onclick="tp_thn_duyet_co_cau(this)"
																			   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																			   class="dropdown-item ">
																				Gửi duyệt cơ cấu</a>
																		</li>
																	<?php } ?>


																<?php } ?>
															<?php } ?>
															<?php if (in_array('thu-hoi-no', $groupRoles)): ?>
																<?php
																// buttom gửi hội sở duyệt gia hạn
																if (in_array($contract->status, array(17,13)) && $contract->debt->check_gia_han == 1) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="thn_duyet_gia_han(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Gửi duyệt gia hạn</a>
																	</li>
																<?php } ?>

																<!-- 	cơ cấu		 -->
																<?php
																// buttom gửi hội sở duyệt gia hạn
																if (in_array($contract->status, array(17,14)) ) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="thn_duyet_co_cau(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Gửi duyệt cơ cấu</a>
																	</li>
																<?php } ?>

																<?php if (empty($contract->customer_infor->type_contract_sign) || $contract->customer_infor->type_contract_sign == 2) : ?>
																	<?php
																	// buttom in hợp đồng
																	if (!in_array($contract->status, array(0))) { ?>
																		<?= $printed ?>
																	<?php } ?>
																<?php endif; ?>
															<?php endif; ?>

															<?php if (in_array('quan-ly-khu-vuc', $groupRoles)): ?>
																<?php if (in_array($contract->status, array(35))) : ?>
																	<li><a href="javascript:void(0)"
																		   onclick="asm_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item asm_duyet"> Gửi hội sở duyệt</a></li>
																<?php endif; ?>
																<?php if (in_array($contract->status, array(35))) : ?>
																	<li><a href="javascript:void(0)"
																		   onclick="asm_khong_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item asm_khong_duyet"> ASM không duyệt</a></li>
																<?php endif; ?>

																<?php

																if (in_array($contract->status, array(30)) ) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="asm_duyet_gia_han(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item">
																			Gửi duyệt gia hạn</a>
																	</li>
																<?php } ?>
																<?php

																if (in_array($contract->status, array(32))  ) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="asm_duyet_co_cau(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item">
																			Gửi duyệt cơ cấu</a>
																	</li>
																<?php } ?>

															<?php endif; ?>
															<!--check accessright  vận hành theo trạng thái  -->
															<?php
															// check accessright của vận hành theo trạng thái
															if (in_array('giao-dich-vien', $groupRoles) || in_array('hoi-so', $groupRoles)) {
																?>
																<?php
																// buttom duyet gia hạn hợp đồng
																if (in_array($contract->status, array(41))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_asm_duyet_gia_han(this,true)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item">
																			Gửi ASM duyệt gia hạn
																		</a></li>
																<?php } ?>
																<?php
																// buttom duyet gia hạn hợp đồng
																if (in_array($contract->status, array(42))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_asm_duyet_co_cau(this,true)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item">
																			Gửi ASM duyệt cơ cấu
																		</a></li>
																<?php } ?>
																<!-- gia hạn -->
																<?php if (in_array($contract->status, array(13))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_thn_duyet_gia_han(this,true)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item duyet">Gửi TP THN duyệt
																			gia hạn</a>
																	</li>
																<?php } ?>


																<?php
																// buttom duyet gia hạn hợp đồng
																if (in_array($contract->status, array(26))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_hs_duyet_gia_han(this,true)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Gửi HS duyệt gia hạn
																	</li>
																<?php } ?>

																<?php
																// buttom gửi hội sở duyệt gia hạn
																if (in_array($contract->status, array(17, 22))  && $contract->debt->check_gia_han == 1) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_tpgd_duyet_gia_han(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Gửi TPGD duyệt gia hạn
																	</li>
																<?php } ?>

																<!--     cơ cấu  -->
																<?php if (in_array($contract->status, array(14))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_thn_duyet_co_cau(this,true)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item duyet">Gửi TP THN duyệt
																			cơ cấu</a>
																	</li>
																<?php } ?>


																<?php
																// buttom duyet gia hạn hợp đồng
																if (in_array($contract->status, array(28))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_hs_duyet_co_cau(this,true)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Gửi HS duyệt cơ cấu
																	</li>
																<?php } ?>

																<?php
																// buttom gửi hội sở duyệt gia hạn
																if (in_array($contract->status, array(17, 24)) && (strtotime(date('Y-m-d') . ' 00:00:00') >= $contract->disbursement_date)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_tpgd_duyet_co_cau(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Gửi TPGD duyệt cơ cấu
																	</li>
																<?php } ?>
																<!-- 		--------end cơ cấu---- -->
																<?php
																// buttom edit fee
																if (in_array($contract->status, array(1, 4, 7, 8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
																	<!-- <li><a  href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"  class="dropdown-item yeu_cau_giai_ngan" > Xem Phí Thực Tính</li> -->
																<?php } ?>

																<?php
																// buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
																if (in_array($contract->status, array(7)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/updateDisbursement?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Edit') ?>
																	</li>
																<?php } ?>

																<?php
																// buttom edit tiếp tục tạo hợp đồng = 0
																if ($contract->status == 0) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/continueCreate?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			Tạo lại
																	</li>
																<?php } ?>
																<?php
																// buttom edit status = 1,4,8,36
																if (in_array($contract->status, array(1, 4, 8, 36)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>"
																		   class="btdropdown-item">
																			<?= $this->lang->line('Edit') ?>
																	</li>
																<?php } ?>

																<?php
																if (in_array($contract->status, array(17)) && $contract->loan_infor->type_loan == "CC") { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Upload_documents') ?>
																	</li>
																<?php } ?>
																<?php
																// buttom upload
																if (in_array($contract->status, array(1, 4, 6, 7, 8, 17, 19, 36))
																	&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Upload_documents') ?>
																	</li>
																<?php } ?>
																<?php
																// buttom gửi cht duyệt
																if (in_array($contract->status, array(1, 4, 36))
																	&& in_array("5dedd24f68a3ff3100003649", $userRoles->role_access_rights)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_cht_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item gui_cht_duyet">
																			Gửi Trưởng PGD Duyệt
																	</li>
																<?php } ?>

																<!-- <?php
																// buttom tạo lại hợp đồng
																if (in_array($contract->status, array(3))
																	&& in_array("5da98b8568a3ff2f10001b06", $userRoles->role_access_rights)) { ?>
<li><a href="#" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info "> Tạo lại </li>
<?php } ?> -->

																<?php
																// buttom tạo yêu cầu giải ngân
																if (in_array($contract->status, array(6, 7))
																	&& in_array("5dedd32468a3ff310000364d", $userRoles->role_access_rights)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="yeu_cau_giai_ngan(this)"
																		   data-codecontract="<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : '' ?>"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item yeu_cau_giai_ngan"> Yêu
																			cầu giải ngân</li>
																<?php } ?>
																<?php if (empty($contract->customer_infor->type_contract_sign) || $contract->customer_infor->type_contract_sign == 2) : ?>
																	<?php
																	// buttom in hợp đồng
																	if (!in_array($contract->status, array(0)) && in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
																		<?= $printed ?>
																	<?php } ?>
																<?php endif; ?>
																<?php
																// buttom hủy hợp đồng
																if (in_array($contract->status, array(1, 4, 6, 7, 8)) && in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="huy_hop_dong(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""; ?>"
																		   class="dropdown-item huy_hop_dong">Hủy hợp
																			đồng</li>
																<?php } ?>

																<?php
																if ($contract->status >= 17 && $contract->status != 19) { ?>
																	<li><a href="<?php echo base_url("file_manager/index_file_manager") ?>">Gửi HS về HO</li>
																<?php } ?>
																<?php
																if ($contract->status == 19) { ?>
																	<li><a href="<?php echo base_url("file_manager/index_file_manager") ?>">Trả HS sau tất toán</li>
																<?php } ?>


															<?php } ?>
															<!--check accessright hàng trưởng theo trạng thái  -->
															<?php
															// check accessright của của hàng trưởng theo trạng thái
															if (in_array('cua-hang-truong', $groupRoles)) {
																?>
																<?php if (empty($contract->customer_infor->type_contract_sign) || $contract->customer_infor->type_contract_sign == 2) : ?>
																	<?php
																	// buttom in hợp đồng
																	if (!in_array($contract->status, array(0))) { ?>
																		<?= $printed ?>
																	<?php } ?>
																<?php endif; ?>
																<!-- 		gia hạn -->
																<?php
																// buttom duyet gia hạn hợp đồng
																if (in_array($contract->status, array(21,17,41,13,26))  && $contract->debt->check_gia_han == 1) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="tpgd_gui_duyet_gia_han(this,false)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item">
																			Gửi duyệt gia hạn
																		</a></li>
																<?php } ?>
																<?php
																// buttom duyet gia hạn hợp đồng
																if (in_array($contract->status, array(23,17,42,14,28))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="tpgd_gui_duyet_co_cau(this,false)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item">
																			Gửi duyệt cơ cấu
																		</a></li>
																<?php } ?>

																<!-- --------------------------------- -->
																<li><a href="javascript:void(0)"
																	   onclick="edit_fee(this)"
																	   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																	   class="dropdown-item yeu_cau_giai_ngan"> Xem Phí
																		Thực Tính</li>


																<?php
																// buttom edit status = 8
																if (in_array($contract->status, array(8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Edit') ?>
																	</li>
																<?php } ?>

																<?php
																// buttom upload
																if (in_array($contract->status, array(8, 17, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36))
																	&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Upload_documents') ?>
																	</li>
																<?php } ?>
																<?php
																// buttom chuyển lên hội sở
																if ( in_array( $contract->status, array(2, 8) ) ) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="chuyen_hoiso_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item chuyen_hoi_so"> Gửi Hội sở duyệt
																	</li>
																<?php } ?>
																<?php
																// buttom Của hàng trưởng từ chối hợp đồng
																if (in_array($contract->status, array(2))
																	&& in_array("5dedd2c868a3ff310000364a", $userRoles->role_access_rights)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="cht_tu_choi(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item cht_tu_choi"> Trưởng PGD Không duyệt</li>
																<?php } ?>

																<!-- <?php
																// buttom tạo lại hợp đồng
																if (in_array($contract->status, array(3))
																	&& in_array("5da98b8568a3ff2f10001b06", $userRoles->role_access_rights)) { ?>
<li><a href="#" class="btn btn-info "> Tạo lại </li>
<?php } ?> -->
																<?php if (empty($contract->customer_infor->type_contract_sign) || $contract->customer_infor->type_contract_sign == 2) : ?>
																	<?php
																	// buttom in hợp đồng
																	if (!in_array($contract->status, array(0))
																		&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
																		<?= $printed ?>
																	<?php } ?>
																<?php endif; ?>
																<?php
																// buttom hủy hợp đồng
																if (in_array($contract->status, array(1, 2, 4, 6, 7, 8))
																	&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="huy_hop_dong(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item huy_hop_dong">Hủy hợp
																			đồng</li>
																<?php } ?>
																<?php
																// buttom in hợp đồng
																if (in_array($contract->status, array(17))) { ?>
																	<li>
																		<a href="<?php echo base_url("file_manager/index_borrowed") ?>"
																		   class="dropdown-item">
																			Mượn hồ sơ</a></li>
																<?php } ?>
															<?php } ?>

															<!--check accessright của hội sở theo trạng thái -->
															<?php
															// check accessright của hội sở theo trạng thái
															if ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "DKX"))) {
																?>

																<li><a href="javascript:void(0)"
																	   onclick="edit_fee(this)"
																	   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																	   class="dropdown-item yeu_cau_giai_ngan"> Xem Phí
																		Thực Tính</li>

																<?php
																// buttom edit status = 8 7 6
																if (in_array($contract->status, array(6, 8, 7))) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Edit') ?>
																	</li>
																<?php } ?>


															<?php } ?>

															<?php
															// check accessright của asm theo trạng thái và điều kiện
															if (in_array('quan-ly-khu-vuc', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC")) {
																?>

																<li><a href="javascript:void(0)"
																	   onclick="edit_fee(this)"
																	   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																	   class="dropdown-item yeu_cau_giai_ngan"> Xem Phí
																		Thực Tính</li>

																<?php
																// buttom edit status = 8 7 6
																if (in_array($contract->status, array(6, 8, 7))) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Edit') ?>
																	</li>
																<?php } ?>


															<?php } ?>
															<!--								// button asm duyet va khong duyet -->
															<?php if (in_array('quan-ly-khu-vuc', $groupRoles)): ?>
																<?php if (in_array($contract->status, array(35))) : ?>
																	<li><a href="javascript:void(0)"
																		   onclick="asm_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item asm_duyet"> Gửi hội sở
																			duyệt</li>
																<?php endif; ?>
																<?php if (in_array($contract->status, array(35))) : ?>
																	<li><a href="javascript:void(0)"
																		   onclick="asm_khong_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item asm_khong_duyet"> ASM
																			không duyệt</li>
																<?php endif; ?>
															<?php endif; ?>
															<?php if (in_array('hoi-so', $groupRoles)) { ?>
																<?php

																if (in_array($contract->status, array(29))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="ke_toan_duyet_gia_han(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Duyệt gia hạn
																	</li>
																<?php } ?>
																<?php

																if (in_array($contract->status, array(31))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="ke_toan_duyet_co_cau(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
																		   class="dropdown-item ">
																			Duyệt cơ cấu
																	</li>
																<?php } ?>



															<?php } ?>
															<!--check accessright của kế toán theo trạng thái -->

															<?php if (in_array('ke-toan', $groupRoles)) { ?>


																<?php if (in_array('tpb-ke-toan', $groupRoles)) { ?>
																	<li class="d-none"><a href="javascript:void(0)"
																						  onclick="capnhatmahopdong(this)"
																						  data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																						  data-code="<?= !empty($contract->code_contract) ? $contract->code_contract : "" ?>"
																						  class="dropdown-item duyet"> Sửa mã hợp
																			đồng </a>
																	</li>
																	<li>
																		<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			Sửa chứng từ
																	</li>
																<?php } ?>


																<?php
																// buttom upload
																if (in_array($contract->status, array(17))
																	&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/accountantUpload?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Upload_documents') ?></a>
																	</li>
																<?php } ?>
																<?php
																if (in_array($contract->status, array(17))) { ?>
																	<?php if ($contract->loan_infor->amount_money > 300000000) { ?>
																		<li>
																			<a href="<?php echo base_url("pawn/disbursement_nl_max/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																			   class="btn btn-info "> Xử lý lỗi giải
																				ngân max</a>
																		</li>
																	<?php }
																} ?>
																<?php
																if (in_array($contract->status, array(15, 10))
																	&& in_array("5def15a268a3ff1204003ad6", $userRoles->role_access_rights)) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/disbursement/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="btn btn-info "> Giải ngân</a></li>
																	<?php if ($contract->loan_infor->amount_money <= 300000000) { ?>
																		<li>
																			<a href="<?php echo base_url("pawn/disbursement_nl/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																			   class="btn btn-info "> Giải ngân ngân
																				lượng</a>
																		</li>
																	<?php } ?>
																	<?php if ($contract->loan_infor->amount_money > 300000000) { ?>
																		<li>
																			<a href="<?php echo base_url("pawn/disbursement_nl_max/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																			   class="btn btn-info "> Giải ngân ngân
																				lượng > 300tr</a>
																		</li>
																	<?php }
																} ?>

																<?php
																// buttom kế toán ko duyệt hợp đồng
																if (in_array($contract->status, array(15, 10))
																	&& in_array("5def401b68a3ff1204003adb", $userRoles->role_access_rights)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="ketoan_tu_choi(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item ketoan_tu_choi"> Không
																			duyệt</a></li>
																<?php } ?>
																<?php if (empty($contract->customer_infor->type_contract_sign) || $contract->customer_infor->type_contract_sign == 2) : ?>
																	<?php
																	// buttom in hợp đồng
																	if (!in_array($contract->status, array(0))
																		&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
																		<?= $printed ?>
																	<?php } ?>
																<?php endif; ?>
																<?php
																// buttom hủy hợp đồng
																if (in_array($contract->status, array(15, 10))
																	&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="huy_hop_dong(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item huy_hop_dong">Hủy hợp
																			đồng</li>
																<?php } ?>

															<?php } ?>
															<!--check accessright  supper admin  và vận hành theo trạng thái  -->
															<!-- gdv -->


															<!-- 	<?php if (in_array($contract->status, array(23)) && $contract->debt->so_ngay_cham_tra < 4) { ?>
									<li><a href="javascript:void(0)"
										   onclick="gui_hs_duyet_co_cau(this)"
										   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
										   class="dropdown-item ">
											Gửi HS duyệt cơ cấu
									</li>
								<?php } ?> -->


															<?php
															//check accessright của  supper admin theo trạng thái
															if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles)) { ?>


																<?php
																// buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
																if (in_array($contract->status, array(7))) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/updateDisbursement?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item ">
																			<?= $this->lang->line('Edit') ?>
																	</li>
																<?php } ?>
																<li><a  href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"  class="dropdown-item yeu_cau_giai_ngan" > Xem Phí Thực Tính</li>
																<?php
																// buttom upload
																if (in_array($contract->status, array(17))) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/accountantUpload?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item ">
																			<?= $this->lang->line('Upload_documents') ?>
																	</li>
																<?php } ?>
																<?php
																// buttom edit tiếp tục tạo hợp đồng = 0
																if ($contract->status == 0) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/continueCreate?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			Tạo lại
																	</li>
																<?php } ?>
																<?php
																// buttom edit status = 1,4,7
																if (in_array($contract->status, array(1, 4, 8))) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Edit') ?>
																	</li>
																<?php } ?>

																<?php
																// buttom upload
																if (in_array($contract->status, array(1, 4, 6, 7, 8))) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
																		   class="dropdown-item">
																			<?= $this->lang->line('Upload_documents') ?>
																	</li>
																<?php } ?>
																<?php
																// buttom gửi cht duyệt
																if (in_array($contract->status, array(1, 4))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="gui_cht_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item gui_cht_duyet">
																			Gửi Trưởng PGD Duyệt
																	</li>
																<?php } ?>

																<!-- <?php
																// buttom tạo lại hợp đồng
																if (in_array($contract->status, array(3))) { ?>
<li><a href="#" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info "> Tạo lại </li>
<?php } ?> -->

																<?php
																// buttom tạo yêu cầu giải ngân
																if (in_array($contract->status, array(6, 7))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="yeu_cau_giai_ngan(this)"
																		   data-codecontract="<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : '' ?>"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item yeu_cau_giai_ngan"> Yêu
																			cầu giải ngân</li>
																<?php } ?>
																<?php if (empty($contract->customer_infor->type_contract_sign) || $contract->customer_infor->type_contract_sign == 2) : ?>
																	<?php
																	// buttom in hợp đồng
																	if (!in_array($contract->status, array(0))) { ?>
																		<?= $printed ?>
																	<?php } ?>
																<?php endif; ?>
																<!-- Cht -->
																<?php
																// buttom chuyển lên hội sở
																if ( in_array( $contract->status, array(2, 8) ) ) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="chuyen_hoiso_duyet(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item chuyen_hoi_so"> Gửi Hội sở duyệt
																	</li>
																<?php } ?>
																<?php
																// buttom Của hàng trưởng từ chối hợp đồng
																if (in_array($contract->status, array(2, 8))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="cht_tu_choi(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item cht_tu_choi"> Trưởng PGD Không
																			duyệt</li>
																<?php } ?>


																<!-- kế toán -->
																<?php
																// buttom giải ngân gọi lệnh giải ngân sang vimo
																if (in_array($contract->status, array(15, 10))) { ?>
																	<li>
																		<a href="<?php echo base_url("pawn/disbursement/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item"> Giải ngân</li>
																	<li>
																		<a href="<?php echo base_url("pawn/disbursement_nl/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item"> Giải ngân ngân lượng
																	</li>
																<?php } ?>

																<?php
																// buttom kế toán ko duyệt hợp đồng
																if (in_array($contract->status, array(15, 10))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="ketoan_tu_choi(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item ketoan_tu_choi">KT Không
																			duyệt</li>
																<?php } ?>

																<?php
																// buttom kế toán ko duyệt hợp đồng
																if (in_array($contract->status, array(1, 2, 4, 5, 6, 7, 8, 10, 15))) { ?>
																	<li><a href="javascript:void(0)"
																		   onclick="huy_hop_dong(this)"
																		   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
																		   class="dropdown-item huy_hop_dong">Hủy hợp
																			đồng</li>
																<?php } ?>
															<?php } ?>
															<?php
															if($userSession['email'] == "hongtx@tienngay.vn" ){   ?>
																<li>
																	<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>"
																	   class="btdropdown-item">
																		<?= $this->lang->line('Edit') ?>
																</li>
															<?php } ?>
															<!--BP Định giá, định giá tài sản thanh lý (TSTL) => START-->
															<?php if (in_array('bo-phan-dinh-gia', $groupRoles)) { ?>
																<?php if (in_array($contract->status, array(44))) : ?>
																	<li>
																		<a href="javascript:void(0)" onclick="bp_dinh_gia_xu_ly('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id='<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>'
																		   class="dropdown-item">BPĐG Xử lý
																		</a>
																	</li>
																<?php endif; ?>
																<?php if (in_array($contract->status, array(49))) : ?>
																	<li>
																		<a href="javascript:void(0)" onclick="bp_dinh_gia_lai('<?= $contract->_id->{'$oid'} ?>')"
																		   data-id='<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>'
																		   class="dropdown-item">BPĐG định giá lại
																		</a>
																	</li>

																<?php endif; ?>
															<?php } ?>
															<!--BP Định giá, định giá tài sản thanh lý => END-->
														</ul>
													</div>
												</td>
												<td>
													<?php
													if (!empty($contract->customer_infor->type_contract_sign) && $contract->customer_infor->type_contract_sign == 1) {
														echo '<span class="text-danger">Hợp đồng điện tử</span>' ;
													} else {
														echo '<span>Hợp đồng giấy</span>';
													} ?>
												</td>
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : "" ?></td>
												<td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
												<td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></td>
												<td><?= !empty($contract->customer_infor->customer_phone_number) ? hide_phone($contract->customer_infor->customer_phone_number) : "" ?></td>
												<td><?= !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "" ?></td>
												<td><?= !empty($contract->loan_infor->name_property->text) ? $contract->loan_infor->name_property->text : "" ?></td>
												<?php
												$amount_money = !empty($contract->loan_infor->amount_money) ? number_format((float)$contract->loan_infor->amount_money) : 0;
												?>
												<td><?= !empty($amount_money) ? $amount_money : "" ?></td>

												<td>
													<?php
													$status = !empty($contract->status) ? $contract->status : "";
													foreach (contract_status() as $key => $value) {
														if ($status == $key) {
															echo $value;
														}
													}

													?>
												</td>

												<td>
													<?php
													$type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest : "";
													if ($type_interest == 1) {
														echo "Lãi hàng tháng, gốc hàng tháng";
													} else {
														echo "Lãi hàng tháng, gốc cuối kỳ";
													}
													?>
												</td>
												<td><?= !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan : "" ?></td>
												<td><?= !empty($contract->customer_infor->is_blacklist) && $contract->customer_infor->is_blacklist == 1 ? "Có" : "" ?></td>
												<td><?= !empty($contract->store->name) ? $contract->store->name : "" ?></td>

												<td><?= !empty($contract->created_by) ? $contract->created_by : "" ?></td>
												<td><?= !empty($contract->created_at) ? date('d/m/Y', $contract->created_at) : "" ?></td>

												<td><?= (!empty($contract->disbursement_date) && empty($contract->type_gh) && empty($contract->type_cc))   ? date('d/m/Y', $contract->disbursement_date) : "" ?></td>
												<td><?= (!empty($contract->date_payment_finish)) ? date('d/m/Y', $contract->date_payment_finish) : "" ?></td>
												<td><?= (!empty($contract->disbursement_date) && (!empty($contract->type_gh) || !empty($contract->type_cc)))   ? date('d/m/Y', $contract->disbursement_date) : "" ?></td>


											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="20">
												<h4>Không có dữ liệu</h4>
											</td>
										</tr>
									<?php } ?>
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


<div class="modal fade" id="update_code_contract_disbursement" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve"></h5>
				<hr>

				<div class="form-group code_contract_approve">
					<label>Mã hợp đồng:</label>
					<input type="text" class="form-control " placeholder="Bạn nhập mã hợp đồng mới"
						   name="code_contract_disbursement_update" value="">
				</div>
				<p class="text-right">
					<input type="hidden" class="form-control contract_id_update">
					<button class="btn btn-danger update_code_contract_submit">Cập nhật</button>
				</p>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve"></h5>
				<hr>
				<div class="form-group code_contract_approve" style="display:none">
					<label>Mã hợp đồng:</label>
					<input type="text" class="form-control " name="code_contract_disbursement_approve" value="">
				</div>
				<div class="form-group so_tien_vay_asm_de_xuat" style="display: none">
					<label>Số tiền vay: <span class="text-danger">*</span></label>
					<input type="text" id="so_tien_vay_asm_de_xuat" placeholder="Số tiền được vay ASM đề xuất"
						   class="form-control"
						   name="so_tien_vay_asm_de_xuat">
				</div>
				<div class="form-group ki_han_vay_asm_de_xuat" style="display: none">
					<label>Kì hạn vay: <span class="text-danger">*</span></label>
					<input type="number" id="ki_han_vay_asm_de_xuat" placeholder="Kì hạn vay ASM đề xuất"
						   class="form-control"
						   name="ki_han_vay_asm_de_xuat">
				</div>

				<?php if (in_array('ke-toan', $groupRoles)): ?>
					<div class="form-group error_code_contract_kt" style="display:none">
						<label>Mã lỗi kế toán:</label>
						<select class="form-control " name="error_code[]" style="width: 75%" id="error_code"
								multiple="multiple" data-placeholder="Choose option">
							<?php foreach (return_kt() as $key => $value) { ?>
								<option value="<?= $value ?>"><?= $key ?></option>
							<?php } ?>
						</select>
					</div>
				<?php else: ?>
					<div class="form-group error_code_contract" style="display:none">
						<label>Trường hợp vi phạm:</label>
						<select class="form-control " name="error_code[]" style="width: 75%" id="error_code"
								multiple="multiple" data-placeholder="Choose option">
							<?php foreach (lead_return() as $key => $value) { ?>
								<option value="<?= $key ?>"><?= $key . ' - ' . $value ?></option>
							<?php } ?>
						</select>
					</div>
				<?php endif; ?>

				<input id="error_code1" style="display: none">


				<div class="form-group img_return_file">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ảnh hồ sơ bổ sung/trả
						về<span class="red"></span></label>
					<div class="col-md-9 col-sm-6 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_img_file">

							</div>
							<label for="uploadinput">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput" type="file" name="file" data-contain="uploads_img_file"
								   data-title="Hồ sơ trả về" multiple data-type="img_file" class="focus">
						</div>
					</div>
				</div>

				<div class="form-group">

					<label class="cancel-B" style="display: none">Lý do từ chối,hủy:</label>
					<div class="row cancel-B" style="display: none">
						<div class="col-md-6">
							<select class="form-control" id="change_cancel"
									data-placeholder="Các lý do từ chối, hủy">
								<option value="">-- Các lý do từ chối, hủy --</option>
								<option value="C1">C1: Lý do về hồ sơ nhân thân</option>
								<option value="C2">C2: Lý do về thông tin nơi ở</option>
								<option value="C3">C3: Lý do về thông tin thu nhập</option>
								<option value="C4">C4: Lý do về thông tin tài sản</option>
								<option value="C5">C5: Lý do về thông tin tham chiếu</option>
								<option value="C6">C6: Lý do về thông tin lịch sử tín dụng</option>
								<option value="C7">C7: Lý do khác</option>
							</select>
						</div>
						<div class="col-md-6">
							<div style="display: none" id="cancel1">
								<select id="lead_cancel_C1" class="form-control" name="lead_cancel_C1[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C1">
									<?php foreach (lead_cancel_C1() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_cancel_C1 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel2">
								<select id="lead_cancel_C2" class="form-control" name="lead_cancel_C2[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C2">
									<?php foreach (lead_cancel_C2() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_cancel_C2 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel3">
								<select id="lead_cancel_C3" class="form-control" name="lead_cancel_C3[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C3">
									<?php foreach (lead_cancel_C3() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_cancel_C3 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel4">
								<select id="lead_cancel_C4" class="form-control" name="lead_cancel_C4[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C4">
									<?php foreach (lead_cancel_C4() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_cancel_C4 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel5">
								<select id="lead_cancel_C5" class="form-control" name="lead_cancel_C5[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C5">
									<?php foreach (lead_cancel_C5() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_cancel_C5 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel6">
								<select id="lead_cancel_C6" class="form-control" name="lead_cancel_C6[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C6">
									<?php foreach (lead_cancel_C6() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_cancel_C6 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="display: none" id="cancel7">
								<select id="lead_cancel_C7" class="form-control" name="lead_cancel_C7[]"
										multiple="multiple" data-placeholder="Các lý do từ chối, hủy C7">
									<?php foreach (lead_cancel_C7() as $key => $item) { ?>
										<option value="<?= $key ?>" <?= ($lead_cancel_C7 == $key) ? 'selected' : '' ?>><?= $item ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<input id="lead_cancel1_C1" style="display: none">
					<input id="lead_cancel1_C2" style="display: none">
					<input id="lead_cancel1_C3" style="display: none">
					<input id="lead_cancel1_C4" style="display: none">
					<input id="lead_cancel1_C5" style="display: none">
					<input id="lead_cancel1_C6" style="display: none">
					<input id="lead_cancel1_C7" style="display: none">
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve">
					<input type="hidden" class="form-control code_contract_disbursement_type" value="0">

					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger approve_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="hsduyet" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve"></h5>
				<hr>
				<div class="form-group d-none">
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">PTI Phí BHTN</label>
					<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
						<?php
						$ptiBhtnGoi =  isset($contract->loan_infor->pti_bhtn->goi) ? $contract->loan_infor->pti_bhtn->goi: '';
						$ptiBhtnGoi =  isset($contract->loan_infor->pti_bhtn->goi) ? $contract->loan_infor->pti_bhtn->goi: '';
						$ptiBhtnPhi =  isset($contract->loan_infor->pti_bhtn->phi) ? number_format($contract->loan_infor->pti_bhtn->phi): '';
						$ptiBhtnPrice =  isset($contract->loan_infor->pti_bhtn->price) ? number_format($contract->loan_infor->pti_bhtn->price): '';
						if ($ptiBhtnGoi && $ptiBhtnPhi && $ptiBhtnPrice) {
							?>
							<input type="text" id="pti_bhtn_fee" class="form-control number"
								   value="<?= $ptiBhtnPhi; ?>" disabled>
						<?php } else { ?>
							<input type="text" id="pti_bhtn_fee" class="form-control number" value="0" disabled>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label>Số tiền được vay:</label>
					<input type="text" class="form-control amount_money_max" disabled>
					<label>Số tiền vay:</label>
					<input type="text" class="form-control "
						   value="<?= $contract->loan_infor->amount_money ? number_format($contract->loan_infor->amount_money) : "" ?>"
						   disabled>
					<label>Kỳ hạn:</label>
					<input type="text" class="form-control"
						   value="<?= $contract->loan_infor->number_day_loan ? $contract->loan_infor->number_day_loan : "" ?>"
						   disabled>
					<label>Hình thức vay:</label>
					<input type="text" class="form-control"
						   value="<?= $contract->loan_infor->type_loan->text ? $contract->loan_infor->type_loan->text : "" ?>"
						   disabled>
					<label>Số tiền được phê duyệt:</label>
					<input type="text" class="form-control amount_money" disabled>

					<label>Lý do xử lý:</label>
					<select class="form-control approve_reason_hs">
						<option value="">- Chọn lý do xử lý -</option>
						<option value="1">Đầy đủ điều kiện theo quy định</option>
						<option value="2">Đáp ứng được điều kiện ngoại lệ</option>
					</select>


					<label>Thêm ngoại lệ hồ sơ bổ sung:</label>
					<div class="row">
						<div class="col-md-6">
							<select id="change_exception_detail" class="form-control"
									name="change_exception_detail"
									data-placeholder="Các lý do ngoại lệ">
								<option value="">-- Các lý do ngoại lệ --</option>
								<option value="E1">E1: Ngoại lệ về hồ sơ nhân thân</option>
								<option value="E2">E2: Ngoại lệ về thông tin nơi ở</option>
								<option value="E3">E3: Ngoại lệ về thông tin thu nhập</option>
								<option value="E4">E4: Ngoại lệ về thông tin sản phẩm</option>
								<option value="E5">E5: Ngoại lệ về thông tin tham chiếu</option>
								<option value="E6">E6: Ngoại lệ về thông tin lịch sử tín dụng</option>
								<option value="E7">E7: Ngoại lệ tăng giá trị khoản vay</option>
							</select>
						</div>
						<div class="col-md-6">
							<div style="display: none" id="exception1_detail">
								<div class="row">
									<div class="col-md-10">
										<select id="lead_exception_E1_detail" class="form-control"
												name="lead_exception_E1_detail[]"
												multiple="multiple" data-placeholder="Các lý do ngoại lệ E1">
											<?php foreach (lead_exception_E1() as $key => $item) { ?>
												<option value="<?= $key ?>" <?= ($lead_exception_E1 == $key) ? 'selected' : '' ?>><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<i id="exception1_del_detail" class="fa fa-ban text-danger"
										   aria-hidden="true"></i>
									</div>
								</div>
							</div>
							<div style="display: none" id="exception2_detail">
								<div class="row">
									<div class="col-md-10">
										<select id="lead_exception_E2_detail" class="form-control"
												name="lead_exception_E2_detail[]"
												multiple="multiple" data-placeholder="Các lý do ngoại lệ E2">
											<?php foreach (lead_exception_E2() as $key => $item) { ?>
												<option value="<?= $key ?>" <?= ($lead_exception_E2 == $key) ? 'selected' : '' ?>><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<i id="exception2_del_detail" class="fa fa-ban text-danger"
										   aria-hidden="true"></i>
									</div>
								</div>
							</div>
							<div style="display: none" id="exception3_detail">
								<div class="row">
									<div class="col-md-10">
										<select id="lead_exception_E3_detail" class="form-control"
												name="lead_exception_E3_detail[]"
												multiple="multiple" data-placeholder="Các lý do ngoại lệ E3">
											<?php foreach (lead_exception_E3() as $key => $item) { ?>
												<option value="<?= $key ?>" <?= ($lead_exception_E3 == $key) ? 'selected' : '' ?>><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<i id="exception3_del_detail" class="fa fa-ban text-danger"
										   aria-hidden="true"></i>
									</div>
								</div>
							</div>
							<div style="display: none" id="exception4_detail">
								<div class="row">
									<div class="col-md-10">
										<select id="lead_exception_E4_detail" class="form-control"
												name="lead_exception_E4_detail[]"
												multiple="multiple" data-placeholder="Các lý do ngoại lệ E4">
											<?php foreach (lead_exception_E4() as $key => $item) { ?>
												<option value="<?= $key ?>" <?= ($lead_exception_E4 == $key) ? 'selected' : '' ?>><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<i id="exception4_del_detail" class="fa fa-ban text-danger"
										   aria-hidden="true"></i>
									</div>
								</div>
							</div>
							<div style="display: none" id="exception5_detail">
								<div class="row">
									<div class="col-md-10">
										<select id="lead_exception_E5_detail" class="form-control"
												name="lead_exception_E5_detail[]"
												multiple="multiple" data-placeholder="Các lý do ngoại lệ E5">
											<?php foreach (lead_exception_E5() as $key => $item) { ?>
												<option value="<?= $key ?>" <?= ($lead_exception_E5 == $key) ? 'selected' : '' ?>><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<i id="exception5_del_detail" class="fa fa-ban text-danger"
										   aria-hidden="true"></i>
									</div>
								</div>
							</div>
							<div style="display: none" id="exception6_detail">
								<div class="row">
									<div class="col-md-10">
										<select id="lead_exception_E6_detail" class="form-control"
												name="lead_exception_E6_detail[]"
												multiple="multiple" data-placeholder="Các lý do ngoại lệ E6">
											<?php foreach (lead_exception_E6() as $key => $item) { ?>
												<option value="<?= $key ?>" <?= ($lead_exception_E6 == $key) ? 'selected' : '' ?>><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<i id="exception6_del_detail" class="fa fa-ban text-danger"
										   aria-hidden="true"></i>
									</div>
								</div>
							</div>
							<div style="display: none" id="exception7_detail">
								<div class="row">
									<div class="col-md-10">
										<select id="lead_exception_E7_detail" class="form-control"
												name="lead_exception_E7_detail[]"
												multiple="multiple" data-placeholder="Các lý do ngoại lệ E7">
											<?php foreach (lead_exception_E7() as $key => $item) { ?>
												<option value="<?= $key ?>" <?= ($lead_exception_E7 == $key) ? 'selected' : '' ?>><?= $item ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<i id="exception7_del_detail" class="fa fa-ban text-danger"
										   aria-hidden="true"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<input id="exception1_value_detail" style="display: none">
					<input id="exception2_value_detail" style="display: none">
					<input id="exception3_value_detail" style="display: none">
					<input id="exception4_value_detail" style="display: none">
					<input id="exception5_value_detail" style="display: none">
					<input id="exception6_value_detail" style="display: none">
					<input id="exception7_value_detail" style="display: none">

					<label hidden>Phí bảo hiểm khoản vay:</label>
					<input style="display: none" type="text" class="form-control fee_gic" disabled>
					<label hidden>Phí bảo hiểm xe:</label>
					<input style="display: none" type="text" class="form-control fee_gic_easy" disabled>
					<label hidden>Phí bảo hiểm phúc lộc thọ:</label>
					<input style="display: none" type="text" class="form-control fee_gic_plt" disabled>
					<label hidden>Phí bảo hiểm Vbi:</label>
					<input style="display: none" type="text" class="form-control fee_vbi" disabled>
					<label hidden>Phí bảo hiểm TNDS:</label>
					<input style="display: none" type="text" class="form-control phi_tnds" disabled>
					<label hidden>Phí bảo hiểm PTI VTA:</label>
					<input style="display: none" type="text" class="form-control phi_pti_vta" disabled>
					<label>Số tiền giải ngân:</label>
					<input type="text" class="form-control amount_loan" disabled>
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note_hs" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve">
					<input type="hidden" class="form-control contract_id">
					<input type="hidden" class="form-control" name="number_month_loan">
					<input type="hidden" id="insurrance_contract" name="insurrance_contract">
					<input type="hidden" class="tilekhoanvay" value="<?= $tilekhoanvay ?>">
					<input type="hidden" id="loan_insurance" name="loan_insurance">
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-primary edit_amount_money">Sửa</button>
					<button class="btn btn-danger approve_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="editFee" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve">Xem phí thực tính</h5>
				<hr>
				<div class="form-group row">
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
						Coupon <span class="text-danger">*</span>
					</label>
					<div class="col-lg-6 col-sm-12 col-12">
						<input type="text" class="form-control code_coupon" value="" disabled>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" class="form-control contract_id_fee">
					<input type="hidden" class="form-control" id="number_day_loan">
					<div class="row">
						<div class="col-lg-6">
							<label>Lãi suất phải thu của người vay:</label>
							<input type="text" class="form-control percent_interest_customer" value="" disabled>

							<label>Phí tư vấn quản lý:</label>
							<input type="text" class="form-control percent_advisory" value="" disabled>

							<label>Phí thẩm định và lưu trữ tài sản đảm bảo:</label>
							<input type="text" class="form-control percent_expertise" value="" disabled>

							<label>Phần trăm phí quản lý số tiền vay chậm trả:</label>
							<input type="text" class="form-control penalty_percent" value="" disabled>
							<label>Số tiền quản lý số tiền vay chậm trả:</label>
							<input type="text" class="form-control penalty_amount" value="" disabled>
						</div>
						<div class="col-lg-6">
							<label>Phí tư vấn gia hạn:</label>
							<input type="text" class="form-control extend" value="" disabled>

							<label>Phí tất toán(trước 1/3):</label>
							<input type="text" class="form-control percent_prepay_phase_1" value="" disabled>

							<label>Phí tất toán(trước 2/3):</label>
							<input type="text" class="form-control percent_prepay_phase_2" value="" disabled>

							<label>Phí tất toán(sau 2/3):</label>
							<input type="text" class="form-control percent_prepay_phase_3" value="" disabled>
							<label>% phí tư vấn gia hạn từ 6 tháng trở lên:</label>
							<input type="text" class="form-control extend_new_five" value="" disabled>
							<label>% phí tư vấn gia hạn 6 tháng trở xuống:</label>
							<input type="text" class="form-control extend_new_three" value="" disabled>
						</div>
					</div>
					<!-- <label>Ghi chú:</label>
					<textarea class="form-control fee_note" rows="5" ></textarea>
				 -->
				</div>
				</table>
				<p class="text-right">
					<!--   <button class="btn btn-danger submit_edit_fee">Xác nhận</button> -->
				</p>
			</div>

		</div>
	</div>
</div>


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
						<a href="" target="_blank" class="btn btn-primary printed_contract w-100">
							<i class="fa fa-print"></i>
							Hợp đồng
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-info printed_notification w-100">
							<i class="fa fa-print"></i>
							Thông báo
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-warning printed_receipt_after_sign_contract w-100">
							<i class="fa fa-print"></i>
							BBBG tài sản 1
						</a>
						<a href="" target="_blank" class="btn btn-danger printed_final_settlement w-100">
							<i class="fa fa-print"></i>
							BBBG tài sản 2
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_commitment_car w-100">
							<i class="fa fa-print"></i>
							Cam kết xe
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_phu_luc w-100">
							<i class="fa fa-print"></i>
							<span class="text_title_ghcc">Phụ lục gia hạn/ cơ cấu</span>
						</a>
					</div>
				</div>
				<br>
				<div class="row">
					<span class="sample-receipt-one">- Biên bản bàn giao tài sản mẫu (1): áp dụng sau khi khách hàng kí Thỏa thuận ba bên</span>
					<br>
					<span class="sample-receipt-two">- Biên bản bàn giao tài sản mẫu (2): áp dụng sau khi khách hàng thanh lý Thỏa thuận ba bên</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="print_contract_pledge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
						<a href="" target="_blank" class="btn btn-primary printed_contract w-100">
							<i class="fa fa-print"></i>
							Hợp đồng
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-info printed_notification w-100">
							<i class="fa fa-print"></i>
							Thông báo
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-warning printed_receipt_after_sign_contract w-100">
							<i class="fa fa-print"></i>
							BBBG tài sản 1
						</a>
						<a href="" target="_blank" class="btn btn-danger printed_final_settlement w-100">
							<i class="fa fa-print"></i>
							BBBG tài sản 2
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_commitment_car w-100">
							<i class="fa fa-print"></i>
							Cam kết xe
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_phu_luc w-100">
							<i class="fa fa-print"></i>
							<span class="text_title_ghcc">Phụ lục gia hạn/ cơ cấu</span>
						</a>
					</div>

				</div>
				<br>
				<div class="row">
					<span class="sample-receipt-one">- Biên bản bàn giao tài sản mẫu (1): áp dụng sau khi khách hàng kí Thỏa thuận ba bên</span>
					<br>
					<span class="sample-receipt-two">- Biên bản bàn giao tài sản mẫu (2): áp dụng sau khi khách hàng thanh lý thỏa Thuận ba bên</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="print_contract_mortgage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
					<div class="col-xs-12 col-xs-3" style="margin-left: 60px">
						<a href="" target="_blank" class="btn btn-primary printed_contract_mortgage"><i
								class="fa fa-print"></i>
							Hợp đồng</a>
					</div>
					<div class="col-xs-12 col-xs-3">
						<a href="" target="_blank" class="btn btn-info printed_commitment_policy"><i
								class="fa fa-print"></i>
							Cam kết ưu đãi</a>
					</div>

					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_bbbg_ky w-100">
							<i class="fa fa-print"></i>
							<span class="text_title_bbbg_ky">BBBG Ký TT</span>
						</a>
					</div>
					<div class="col-xs-12 col-md-3" style="margin-left: 60px">
						<a href="" target="_blank" class="btn btn-success printed_bbbg_thanhly w-100">
							<i class="fa fa-print"></i>
							<span class="text_title_bbbg_thanhly">BBBG Thanh Ly</span>
						</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_phu_luc w-100">
							<i class="fa fa-print"></i>
							<span class="text_title_ghcc">Phụ lục gia hạn/ cơ cấu</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="checkmodal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Bạn có chắc chắn xử lý hợp đồng này?</h3>
			</div>
			<div class="modal-body ">
				<input type="hidden" value="" name="_id"/>
				<div class="row">
					<div class="col-xs-12">
						<input id="check_app_hs" style="display: none">
						<div class="form-group">
							<label class="control-label col-md-3">Người xử lý:</label>
							<div class="col-md-9">
								<input id="check_contract_name" class="form-control"
									   type="text" disabled>
								<span class="help-block"></span>
							</div>
						</div>
						<div style="text-align: center">
							<button type="button" id="customer_hs" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!--Modal-->
<div id="addnewModal_themhopdong" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="text-align: center">Nhập số chứng minh thư khách hàng</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_errorCreate'></span>
			</div>
			<br>
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" style="font-size: 15px">
						Nhập số CMT
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input class="form-control" id="customer_identify_check">
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="submit_customer_identify_check">Thêm</button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('page/pawn/modal_contract', isset($this->data) ? $this->data : NULL); ?>
<!-- /page content -->
<?php $this->load->view('page/modal/create_pawn'); ?>

<!--Modal bộ phận định giá tài sản xử lý B02-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_xu_ly.php'); ?>

<!--Modal BP Định giá xử lý lại  B04-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_approve_again.php'); ?>

<script src="<?php echo base_url(); ?>assets/js/pawn/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pawn/accountant_index_part.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pawn/contract.js?rev=<?php echo time(); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<!--<script src="--><?php //echo base_url();?><!--assets/js/simpleUpload.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<script>
	// $(document).ready(function(){
	$('#reservation').change(function (event) {
		var date_range = $('#reservation').val();
		var dates = date_range.split(" - ");
		var start = dates[0];
		var end = dates[1];
		var start = moment(dates[0], 'D MMMM YY');
		var end = moment(dates[1], 'D MMMM YY');
	});




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

	$(".magnifyitem").magnify({
		initMaximized: true
	});


$('#region_contract').change(function () {
	let code_region = $('#region_contract').val();
	console.log(code_region)
	var $select = $('#store_list').selectize({
		create: false,
		valueField: 'code_store',
		labelField: 'name_store',
		searchField: 'name_store',
		maxItems: 200,
		sortField: {
			field: 'name_store',
			direction: 'asc'
		}
	});
	var selectize = $select[0].selectize;
	$.ajax({
		url: _url.base_url + '/File_manager/get_stores_by_code_region',
		method: "POST",
		data: {
			code_region: code_region
		},
		success: function (response) {
			let stores_list = response.data ? response.data : {};
			console.log(stores_list)
			selectize.clearOptions();
			$.each(stores_list, function (key, value) {
				// console.log(value.id_store)
				// console.log(value.name_store)
				selectize.addOption({
					code_store: value.store_id,
					name_store: value.store_name,
				});
				selectize.refreshOptions();
			});
		}
	});
});

$('#store_list').selectize({
	create: false,
	valueField: 'code_store',
	labelField: 'name_store',
	searchField: 'name_store',
	maxItems: 200,
	sortField: {
		field: 'name_store',
		direction: 'asc'
	}
});





</script>



