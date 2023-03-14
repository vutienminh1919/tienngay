<script src="https://cdnjs.cloudflare.com/ajax/libs/stacktable.js/1.0.2/stacktable.min.js"></script>

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
	$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
	$createBy = !empty($_GET['createBy']) ? $_GET['createBy'] : "";
	$asset_name = !empty($_GET['asset_name']) ? $_GET['asset_name'] : "";
	?>
	<div class="page-title">
		<div class="title_left">
			<h3 class="d-inline-block">Quản lý hợp đồng</h3>
		</div>

		<?php
		if ($userSession['is_superadmin'] == 1 || in_array("5da98b8568a3ff2f10001b06", $userRoles->role_access_rights) || in_array('van-hanh', $groupRoles)) { ?>
			<div class="title_right text-right">
				<a href="<?php echo base_url("New_contract/quanlyhopdong_addnew") ?>" class="btn btn-primary ">
					<i class="fa fa-plus"></i>
					Thêm mới
				</a>
			</div>
		<?php } ?>
		<div class="">
			<a href="<?php echo base_url("pawn/contract") ?>" class="btn btn-dark">
				Chọn giao diện cũ
			</a>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Danh sách hợp đồng</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li class=" top_search">
							<form action="<?php echo base_url('new_contract/search') ?>" method="get">
								<div class="input-group m-0">
									<input type="text" class="form-control" placeholder="Tìm kiếm"
										   name="customer_name"
										   value="<?= !empty($customer_name) ? $customer_name : "" ?>">
									<span class="input-group-btn">
                  <button class="btn btn-default" type="submit">
                    <i class="fa fa-search"></i>
                  </button>

                </span>
							</form>
				</div>

				</li>
				<?php
				if ($userSession['is_superadmin'] == 1 || in_array('phat-trien-san-pham', $groupRoles)) { ?>
					<a style="color: white;padding: 6px" class="btn btn-success" target="_blank"
					   href="<?= base_url() ?>excel/exportAllContract?fdate=<?= $fdate . '&tdate=' . $tdate . '&code_contract=' . $code_contract . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name . '&customer_phone_number=' . $customer_phone_number . '&customer_identify=' . $customer_identify . '&store=' . $getStore . '&property=' . $property . '&status=' . $status ?>&ngaygiaingan=1">
						<i class="fa fa-file-excel-o" aria-hidden="true"></i>
						Xuất file XLS
					</a>
				<?php } ?>

				<li>
					<div class="dropdown" style="display:inline-block">
						<button class="btn btn-info dropdown-toggle"
								onclick="$('#lockdulieu').toggleClass('show');">
							<span class="fa fa-filter"></span>
							Lọc dữ liệu
						</button>
						<form action="<?php echo base_url('new_contract/search') ?>" method="get">
							<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right quanlyhopdongfilter"
								style="padding:15px;">
								<li>
									<div class="row">

										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Từ:</label>
												<input type="date" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Đến:</label>
												<input type="date" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">
											</div>
										</div>

										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Phòng giao dịch:</label>
												<select class="form-control" name="store">
													<option value="">Chọn PGD</option>
													<?php foreach ($stores as $store) { ?>
														<option <?php echo $getStore === $store->_id->{'$oid'} ? 'selected' : '' ?>
																value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?></option>
													<?php } ?>
												</select>
												<script>
													$('#PGDfilter').selectize({
														// sortField: 'text'
													});
												</script>
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Loại tài sản:</label>
												<select class="form-control" name="property">
													<option value=""><?= $this->lang->line('All_property') ?></option>
													<?php foreach ($mainPropertyData as $p) { ?>
														<option <?php echo $property == $p->code ? 'selected' : '' ?>
																value="<?php echo $p->code; ?>"><?php echo $p->name; ?></option>
													<?php } ?>
												</select>

												<script>
													$('#loaitaisanfilter').selectize({
														sortField: 'text'
													});
												</script>
											</div>
										</div>

										<div class="col-xs-12">
											<h5 class="mt-0">Thông tin hợp đồng:</h5>
										</div>

										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Mã phiếu ghi:</label>
												<input type="text" name="code_contract" class="form-control"
													   value="<?= !empty($code_contract) ? $code_contract : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Mã hợp đồng:</label>
												<input type="text" name="code_contract_disbursement"
													   class="form-control"
													   value="<?= !empty($code_contract_disbursement) ? $code_contract_disbursement : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Tên tài sản:</label>
												<input type="text" name="asset_name" class="form-control"
													   value="<?= !empty($asset_name) ? $asset_name : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Trạng thái hợp đồng:</label>
												<select class="form-control" name="status">
													<option value="" <?php echo $status == '-' ? 'selected' : '' ?>><?= $this->lang->line('All_status') ?></option>
													<?php foreach (contract_status() as $key => $value) { ?>
														<option <?php echo $status == $key ? 'selected' : '' ?>
																value="<?= $key ?>"> <?= $value ?>
														</option>
													<?php } ?>
												</select>

												<script>
													$('#thoigianvayfilter').selectize({});
												</script>
											</div>
										</div>
										<div class="col-xs-12">
											<h5 class="mt-0">Thông tin cá nhân:</h5>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Họ và tên:</label>
												<input type="text" name="customer_name" class="form-control"
													   value="<?= !empty($customer_name) ? $customer_name : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Số điện thoại:</label>
												<input type="text" name="customer_phone_number"
													   class="form-control"
													   value="<?= !empty($customer_phone_number) ? $customer_phone_number : "" ?>">
											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Chứng minh thư:</label>
												<input type="text" name="customer_identify" class="form-control"
													   value="<?= !empty($customer_identify) ? $customer_identify : "" ?>">
											</div>
										</div>
									</div>

								</li>
								<li>
								</li>


								<li class="text-right"><br>&nbsp;
									<button class="btn btn-secondary"
											onclick="$('#lockdulieu').toggleClass('show');">
										Hủy
									</button>
									<button class="btn btn-info" type="submit">
										<i class="fa fa-search" aria-hidden="true"></i>
										Tìm Kiếm
									</button>

								</li>

							</ul>
						</form>
					</div>
				</li>

				</ul>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">

				<!-- start project list -->
				<table class="table stacktable table-quanlytaisan">
					<thead>
					<tr>
						<th style="width: 1%">#</th>
						<th>Mã hợp đồng</th>
						<th>Mã phiếu ghi</th>
						<th>Tên KH</th>
						<th>Tiền vay</th>
						<th>Thời hạn vay</th>
						<th>Trạng thái</th>
						<th class="text-right">Chức năng</th>
					</tr>
					</thead>
					<tbody>
					<tr>

					</tr>

					<?php if (!empty($contractData)) ?>
					<?php foreach ($contractData as $key => $contract): ?>

						<tr>
							<td>
								<?php echo ++$key ?>
							</td>
							<td>
								<div onclick="$('.quanlytaisan_detail_<?php echo $contract->_id->{'$oid'} ?>').toggleClass('d-none');"
									 style="cursor:pointer;"
									 title="Xem Nhanh">
									<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : '' ?>
								</div>
							</td>
							<td>
								<?= !empty($contract->code_contract) ? $contract->code_contract : '' ?>
							</td>
							<td>
								<?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : '' ?>
							</td>
							<td>
								<?= !empty($contract->loan_infor->amount_loan) ? number_format($contract->loan_infor->amount_loan) : '' ?>
							</td>
							<td>
								<?= !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan / 30 . " Tháng" : "" ?>
							</td>
							<td>
								<?php
								$status = !empty($contract->status) ? $contract->status : "";
								if ($status == 0) {
									echo "<span class='btn btn-sm btn-primary'>Nháp</span>";
								} else if ($status == 1) {
									echo "<span class='btn btn-sm btn-info'>Mới</span>";
								} else if ($status == 2) {
									echo "<span class='btn btn-sm btn-warning'>Chờ trưởng PGD duyệt</span>";
								} else if ($status == 3) {
									echo "<span class='btn btn-sm btn-primary'>Đã hủy</span>";
								} else if ($status == 4) {
									echo "<span class='btn btn-sm btn-primary'>Trưởng PGD không duyệt</span>";
								} else if (($status == 5) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC")) {
									echo "<span class='btn btn-sm btn-primary'>Chờ asm duyệt</span>";
								} else if ($status == 5) {
									echo "<span class='btn btn-sm btn-danger'>Chờ hội sở duyệt</span>";
								} else if ($status == 6) {
									echo "<span class='btn btn-sm btn-primary'>Đã duyệt</span>";
								} else if ($status == 7) {
									echo "<span class='btn btn-sm btn-primary'>Kế toán không duyệt</span>";
								} else if (($status == 8) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC")) {
									echo "<span class='btn btn-sm btn-primary'>Asm không duyệt</span>";
								} else if ($status == 8) {
									echo "<span class='btn btn-sm btn-primary'>Hội sở không duyệt</span>";
								} else if ($status == 9) {
									echo "<span class='btn btn-sm btn-primary'>Chờ ngân lượng xử lý</span>";
								} else if ($status == 10) {
									echo "<span class='btn btn-sm btn-primary'>Ngân lượng giải ngân thất bại</span>";
								} else if ($status == 15) {
									echo "<span class='btn btn-sm btn-primary'>Chờ giải ngân</span>";
								} else if ($status == 16) {
									echo "<span class='btn btn-sm btn-primary'>Tạo lệnh giải ngân thành công</span>";
								} else if ($status == 17) {
									echo "<span class='btn btn-sm btn-success'>Đang vay</span>";
								} else if ($status == 18) {
									echo "<span class='btn btn-sm btn-primary'>Giải ngân thất bại</span>";
								} else if ($status == 19) {
									echo "<span class='btn btn-sm btn-primary'>Đã tất toán</span>";
								} else if ($status == 20) {
									echo "<span class='btn btn-sm btn-primary'>Đã quá hạn</span>";
								} else if ($status == 21) {
									echo "<span class='btn btn-sm btn-primary'>Chờ hội sở duyệt gia hạn</span>";
								} else if ($status == 22) {
									echo "<span class='btn btn-sm btn-primary'>Chờ kế toán duyệt gia hạn</span>";
								} else if ($status == 23) {
									echo "<span class='btn btn-sm btn-primary'>Đã gia hạn</span>";
								} else if ($status == 24) {
									echo "<span class='btn btn-sm btn-primary'>Chờ kế toán xác nhận phiếu thu gia hạn</span>";
								} else if ($status == 25) {
									echo "<span class='btn btn-sm btn-primary'>Hội sở đã duyệt gia hạn</span>";
								} else if ($status == 26) {
									echo "<span class='btn btn-sm btn-primary'>Chờ hội sở duyệt cơ cấu</span>";
								} else if ($status == 27) {
									echo "<span class='btn btn-sm btn-primary'>Chờ kế toán duyệt cơ cấu</span>";
								} else if ($status == 28) {
									echo "<span class='btn btn-sm btn-primary'>Đã gia hạn</span>";
								} else if ($status == 29) {
									echo "<span class='btn btn-sm btn-primary'>Chờ kế toán xác nhận cơ cấu</span>";
								} else if ($status == 30) {
									echo "<span class='btn btn-sm btn-primary'>Đã duyệt cơ cấu</span>";
								}
								?>
							</td>

							<td class="text-right">

								<div class="dropdown" style="display:inline-block">
									<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
											data-toggle="dropdown" title="Chức năng">
										<i class="fa fa-cogs"></i>

										<span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li>
											<a href="<?php echo base_url("pawn/viewImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"><i
														class="fa fa-eye"></i> Xem chứng từ</a></li>

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
													   data-id="<?php echo $contract->_id->{'$oid'} ?>">
														<i class="fa fa-upload"></i> Chi tiết hồ sơ</a>
												</li>
											<?php } elseif (($customer_name_hs == $userSession['email']) && ($contract->status == 5) && ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "DKX")))) { ?>
												<li>
													<a onclick="hoi_so_bat_dau_duyet(this)"
													   href="javascript:void(0)"
													   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
													   data-id="<?php echo $contract->_id->{'$oid'} ?>">
														<i class="fa fa-upload"></i> Chi tiết hồ sơ</a>
												</li>
											<?php } elseif (($check_customer_hs == 2) && ($contract->status == 5) && ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "DKX")))) { ?>
												<li>
													<a onclick="hoi_so_bat_dau_duyet(this)"
													   href="javascript:void(0)"
													   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
													   data-id="<?php echo $contract->_id->{'$oid'} ?>">
														<i class="fa fa-upload"></i> Chi tiết hồ sơ</a>
												</li>
											<?php } elseif (($customer_name_hs == "") && ($contract->status == 5) && (in_array('quan-ly-khu-vuc', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC"))) {
												?>
												<li>
													<a onclick="hoi_so_bat_dau_duyet(this)"
													   href="javascript:void(0)"
													   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
													   data-id="<?php echo $contract->_id->{'$oid'} ?>">
														<i class="fa fa-upload"></i> Chi tiết hồ sơ</a>
												</li>
											<?php } elseif (($customer_name_hs == $userSession['email']) && ($contract->status == 5) && (in_array('quan-ly-khu-vuc', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC"))) { ?>
												<li>
													<a onclick="hoi_so_bat_dau_duyet(this)"
													   href="javascript:void(0)"
													   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
													   data-id="<?php echo $contract->_id->{'$oid'} ?>">
														<i class="fa fa-upload"></i> Chi tiết hồ sơ</a>
												</li>
											<?php } elseif (($check_customer_hs == 2) && ($contract->status == 5) && (in_array('quan-ly-khu-vuc', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "CC"))) { ?>
												<li>
													<a onclick="hoi_so_bat_dau_duyet(this)"
													   href="javascript:void(0)"
													   data-customerhs="<?= !empty($customer_name_hs) ? $customer_name_hs : '' ?>"
													   data-id="<?php echo $contract->_id->{'$oid'} ?>">
														<i class="fa fa-upload"></i> Chi tiết hồ sơ</a>
												</li>
											<?php } else { ?>
												<li>
													<a href="<?php echo base_url("pawn/detail?id=") . $contract->_id->{'$oid'} ?>"><i
																class="fa fa-upload"></i> Chi tiết hồ sơ</a>
												</li>
												<?php
												unset($customer_name_hs);
												unset($check_customer_hs);
												?>
											<?php } ?>
										<?php } ?>





										<?php
										$printed = "";
										$contract_id = !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "";
										$type_property_code = strtoupper(trim($contract->loan_infor->type_property->code));
										if ($contract->loan_infor->type_property->code == "TC") {
											$printed .= '<li><a href="javascript:void(0)" onclick="show_popup_print_contract_mortgage(this)" data-id="' . $contract_id . '" class="fa fa-print"> In hợp đồng</a></li>';
										} elseif ($contract->loan_infor->type_loan->code == "CC" && $contract->loan_infor->type_property->code != "TC") {
											$printed .= '<li><a href="javascript:void(0)" onclick="show_popup_print_contract_pledge(this)" data-type_property_code="' . $type_property_code . '" data-id="' . $contract_id . '"  class="fa fa-print"> In hợp đồng</a></li>';
										} elseif ($contract->loan_infor->type_loan->code == "DKX" && $contract->loan_infor->type_property->code != "TC") {
											$printed .= '<li><a href="javascript:void(0)" onclick="show_popup_print_contract_loan(this)" data-type_property_code="' . $type_property_code . '" data-id="' . $contract_id . '" class=" fa fa-print"> In hợp đồng</a></li>';

										}
										?>

										<?php
										if (in_array('giao-dich-vien', $groupRoles)) {
											?>

											<?php
											if (in_array($contract->status, array(1, 6, 4, 8, 7, 17)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
												<li>
													<a href="<?php echo base_url("New_contract/update?id=") . $contract->_id->{'$oid'} ?>"><i
																class="fa fa-edit"></i> Sửa hợp đồng</a></li>
											<?php } ?>


											<?php if (in_array($contract->status, array(13))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_thn_duyet_gia_han(this,true)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
													><i class="fa fa-reply-all"></i> Gửi TP THN duyệt gia hạn</a></li>

											<?php } ?>
											<?php if (in_array($contract->status, array(30))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_gia_han(this,true)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt gia hạn</a>
												</li>

											<?php } ?>

											<?php

											if (in_array($contract->status, array(26))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_hs_duyet_gia_han(this,true)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi HS duyệt gia hạn</a></li>

											<?php } ?>

											<?php

											if ((in_array($contract->status, array(17, 22)) && $contract->loan_infor->type_interest == 2) && $contract->debt->check_gia_han == 1 && ($contract->count_extension < 3 || empty($contract->count_extension))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_tpgd_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi TPGD duyệt gia hạn</a></li>

											<?php } ?>

											<?php if (in_array($contract->status, array(14))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_thn_duyet_co_cau(this,true)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
													><i class="fa fa-reply-all"></i> Gửi TP THN duyệt cơ cấu</a></li>

											<?php } ?>
											<?php if (in_array($contract->status, array(32))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_co_cau(this,true)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt cơ cấu</a>
												</li>

											<?php } ?>

											<?php
											if (in_array($contract->status, array(28))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_hs_duyet_co_cau(this,true)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi HS duyệt cơ cấu</a></li>

											<?php } ?>

											<?php
											if ((in_array($contract->status, array(17, 24)))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_tpgd_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi TPGD duyệt cơ cấu</a></li>

											<?php } ?>

											<?php
											if (in_array($contract->status, array(6, 7))
													&& in_array("5dedd32468a3ff310000364d", $userRoles->role_access_rights)) { ?>
												<li><a href="javascript:void(0)"
													   onclick="yeu_cau_giai_ngan(this)"
													   data-codecontract="<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : '' ?>"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													> <i class="fa fa-reply-all"></i> Yêu cầu giải ngân</a></li>
											<?php } ?>

											<?php
											if (in_array($contract->status, array(1, 4))
													&& in_array("5dedd24f68a3ff3100003649", $userRoles->role_access_rights)) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_cht_duyet(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													> <i class="fa fa-reply-all"></i> Gửi duyệt</a>
												</li>
											<?php } ?>

											<?php

											if (in_array($contract->status, array(1, 4, 6, 7, 8)) && in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
												<li><a href="javascript:void(0)"
													   onclick="huy_hop_dong(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""; ?>"
													><i class="fa fa-window-close"></i> Hủy hợp đồng</a></li>
											<?php } ?>

											<?php
											if (in_array($contract->status, array(17)) && $contract->loan_infor->type_loan == "CC") { ?>
												<li>
													<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
													>
														<i class="fa fa-code-fork"></i> <?= $this->lang->line('Upload_documents') ?>
													</a>
												</li>
											<?php } ?>
											<?php

											if (in_array($contract->status, array(1, 4, 6, 7, 8, 17))
													&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
												<li>
													<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
													>
														<i class="fa fa-code-fork"></i> <?= $this->lang->line('Upload_documents') ?>
													</a>
												</li>
											<?php } ?>


											<?php
											if (!in_array($contract->status, array(0))
													&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
												<?= $printed ?>
											<?php } ?>

										<?php } ?>


										<?php
										if (in_array('cua-hang-truong', $groupRoles)) {
											?>
											<?php

											if (in_array($contract->status, array(8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
												<li>
													<a href="<?php echo base_url("New_contract/update?id=") . $contract->_id->{'$oid'} ?>"><i
																class="fa fa-edit"></i> Sửa hợp đồng</a></li>
											<?php } ?>

											<?php
											if (in_array($contract->status, array(21)) && $contract->debt->so_ngay_cham_tra < 4 && ($contract->count_extension >= 2 || $contract->loan_infor->number_day_loan > 30)) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_hs_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi HS duyệt gia hạn</a>
												</li>
											<?php } ?>
											<?php if (in_array($contract->status, array(21)) && $contract->debt->so_ngay_cham_tra < 4 && $contract->loan_infor->number_day_loan == 30 && $contract->count_extension < 2) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt gia hạn</a>
												</li>
											<?php } ?>
											<?php if (in_array($contract->status, array(21)) && $contract->debt->so_ngay_cham_tra >= 4) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_thn_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
													><i class="fa fa-reply-all"></i> Gửi TP THN duyệt gia hạn</a>
												</li>
											<?php } ?>

											<?php

											if (in_array($contract->status, array(23)) && $contract->debt->so_ngay_cham_tra < 4 && ($contract->count_structure >= 2 || $contract->loan_infor->number_day_loan > 30)) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_hs_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi HS duyệt cơ cấu</a>
												</li>
											<?php } ?>
											<?php if (in_array($contract->status, array(23)) && $contract->debt->so_ngay_cham_tra < 4 && $contract->loan_infor->number_day_loan == 30 && $contract->count_structure < 2) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt cơ cấu</a>
												</li>
											<?php } ?>
											<?php if (in_array($contract->status, array(23)) && $contract->debt->so_ngay_cham_tra >= 4) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_thn_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
													><i class="fa fa-reply-all"></i> Gửi TP THN duyệt cơ cấu</a>
												</li>
											<?php } ?>


											<?php
											if (!in_array($contract->status, array(0))
													&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
												<?= $printed ?>
											<?php } ?>
										<?php } ?>

										<?php

										if ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contract->loan_infor->amount_loan < 50000000) && ($contract->loan_infor->type_property->code == "XM") && ($contract->loan_infor->type_loan->code == "DKX"))) {
											?>
											<?php

											if (in_array($contract->status, array(6, 8, 7))) { ?>
												<li>
													<a href="<?php echo base_url("New_contract/update?id=") . $contract->_id->{'$oid'} ?>"><i
																class="fa fa-edit"></i> Sửa hợp đồng</a></li>
											<?php } ?>

										<?php } ?>
										<?php if (in_array('hoi-so', $groupRoles)) { ?>
											<?php
											if (in_array($contract->status, array(25))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt gia hạn</a>
												</li>
											<?php } ?>
											<?php

											if (in_array($contract->status, array(27))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													>
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt cơ cấu</a>
												</li>
											<?php } ?>
										<?php } ?>

										<?php
										if (in_array('ke-toan', $groupRoles)) {
											?>

											<?php

											if (in_array($contract->status, array(29))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="ke_toan_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													   >
														<i class="fa fa-reply-all"></i> Duyệt gia hạn</a>
												</li>
											<?php } ?>
											<?php

											if (in_array($contract->status, array(31))) { ?>
												<li><a href="javascript:void(0)"
													   onclick="ke_toan_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
													   >
														<i class="fa fa-reply-all"></i> Duyệt cơ cấu</a>
												</li>
											<?php } ?>


											<?php
											if (!in_array($contract->status, array(0))
													&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
												<?= $printed ?>
											<?php } ?>
										<?php } ?>

										<?php
										if ($userSession['is_superadmin'] == 1 || in_array("tbp-thu-hoi-no", $groupRoles)) { ?>
											<li>
												<a href="<?php echo base_url("pawn/downloadImage?id=") . $contract->_id->{'$oid'} ?>">
													<i class="fa fa-download"></i> Tải chứng từ</a></li>

											<?php
											if (in_array($contract->status, array(11)) && $contract->debt->so_ngay_cham_tra >= 4 && ($contract->count_extension >= 2 || $contract->loan_infor->number_day_loan > 30)) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_hs_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>">
														<i class="fa fa-reply-all"></i> Gửi HS duyệt gia hạn</a></li>

											<?php } ?>
											<?php if (in_array($contract->status, array(11)) && $contract->debt->so_ngay_cham_tra >= 4 && $contract->loan_infor->number_day_loan == 30 && $contract->count_extension < 2) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_gia_han(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>">
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt gia hạn</a>
												</li>

											<?php } ?>
											<?php
											if (in_array($contract->status, array(12)) && $contract->debt->so_ngay_cham_tra >= 4 && ($contract->count_structure >= 2 || $contract->loan_infor->number_day_loan > 30)) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_hs_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>">
														<i class="fa fa-reply-all"></i> Gửi HS duyệt cơ cấu</a></li>

											<?php } ?>
											<?php if (in_array($contract->status, array(12)) && $contract->debt->so_ngay_cham_tra >= 4 && $contract->loan_infor->number_day_loan == 30 && $contract->count_structure < 2) { ?>
												<li><a href="javascript:void(0)"
													   onclick="gui_ke_toan_duyet_co_cau(this)"
													   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>">
														<i class="fa fa-reply-all"></i> Gửi kế toán duyệt cơ cấu</a>
												</li>

											<?php } ?>
										<?php } ?>


										<?php
										if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles)) { ?>
											<?php
											if (in_array($contract->status, array(1, 4, 8))) { ?>
												<li>
													<a href="<?php echo base_url("New_contract/update?id=") . $contract->_id->{'$oid'} ?>"><i
																class="fa fa-edit"></i> Sửa hợp đồng</a></li>
											<?php } ?>
											<?php
											if (!in_array($contract->status, array(0))) { ?>
												<?= $printed ?>
											<?php } ?>
										<?php } ?>

										<li><a href="javascript:void(0)"
											   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
											   class="showModal"
											><i class="fa fa-history"></i> Xem lịch sử</a></li>

										<li><a href="javascript:void(0)"
											   onclick="call_for_customer('<?= !empty($contract->customer_infor->customer_phone_number) ? encrypt($contract->customer_infor->customer_phone_number) : "" ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'customer')"><i
														class="fa fa-phone"></i> Gọi điện</a></li>

										<li><a href="javascript:void(0)"
											   onclick="show_history('<?= !empty($contract->customer_infor->customer_phone_number) ? encrypt($contract->customer_infor->customer_phone_number) : "" ?>' )"><i
														class="fa fa-list"></i> Danh sách cuộc gọi</a></li>

										<li><a href="javascript:void(0)" data-toggle="modal"
											   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
											   class="contract_involve"><i
														class="fa fa-pencil-square"></i> Hợp đồng liên quan</a>
										</li>

									</ul>
								</div>
							</td>
						</tr>
						<tr id="quanlytaisan_detail_<?php echo $contract->_id->{'$oid'} ?>"
							class="d-none quanlytaisan_detail quanlytaisan_detail_<?php echo $contract->_id->{'$oid'} ?>">
							<td colspan="7">
								<div class="hidden-xs ">

									<?php $this->load->view('page/pawn/new_contract/list/quanlyhopdong_detail_pc', ["groupRoles" => $groupRoles, "contractInfor" => $contract, "configuration_formality" => $configuration_formality, "mainPropertyData" => $mainPropertyData]); ?>
								</div>
								<!--								<div class="hidden-md hidden-lg">-->
								<!--									--><?php //$this->load->view('page/pawn/new_contract/list/quanlyhopdong_detail_mb', ["groupRoles" => $groupRoles, "contractInfor" => $contract, "configuration_formality" => $configuration_formality, "mainPropertyData" => $mainPropertyData]); ?>
								<!--								</div>-->
							</td>
						</tr>

					<?php endforeach; ?>
					</tbody>
				</table>
				<div class="">
					<?php echo $pagination ?>
				</div>
				<!-- end project list -->

			</div>

		</div>
	</div>
</div>
</div>
<!-- /page content -->


<?php $this->load->view('template/quanlytaisan/addnew_xemay_Modal'); ?>
<?php $this->load->view('template/quanlytaisan/addnew_oto_Modal'); ?>
<?php $this->load->view('template/quanlytaisan/addnew_sodo_Modal'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		$('.stacktable').stacktable();
	});

</script>


<div id="quanlyduyetModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					Trưởng PGD
					Xác nhận xử lý</h4>
			</div>
			<div class="modal-body tpgd" style="display: none">
				<p> Nhiệm vụ của Phòng giao dịch trường:</p>

				<ol>
					<li> Đảm bảo việc giám sát, duyệt hợp đồng là đúng</li>
					<li> Cam kết việc xử lý là đúng và không có gian lận</li>
					<li> Chịu hoàn toàn trách nhiệm khi có vấn đề xảy ra</li>

				</ol>

				<p>Nếu bạn chắc chắn, hãy click vào: Tôi đồng ý, để xác nhận xử lý:</p>
				<div class="checkbox">
					<label><input type="checkbox"> Tôi đồng ý và sẵn sàng chịu hoàn toàn trách nhiệm pháp lý với
						VFC</label>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Duyệt</button>
			</div>
		</div>

	</div>
</div>


<!--Modal quanlyhopđong-->
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
						<a href="" target="_blank" class="btn btn-primary printed_contract"><i class="fa fa-print"></i>
							In hợp đồng</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-info printedNotification"><i class="fa fa-print"></i>
							In thông báo</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-warning printedReceipt"><i class="fa fa-print"></i>
							In biên nhận</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_commitment_car"><i
									class="fa fa-print"></i>
							In cam kết xe</a>
					</div>
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
						<a href="" target="_blank" class="btn btn-primary printed_contract"><i class="fa fa-print"></i>
							In hợp đồng</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-info printedNotification"><i class="fa fa-print"></i>
							In thông báo</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-warning printedReceipt"><i class="fa fa-print"></i>
							In biên nhận</a>
					</div>
					<div class="col-xs-12 col-md-3">
						<a href="" target="_blank" class="btn btn-success printed_commitment_car"><i
									class="fa fa-print"></i>
							In cam kết xe</a>
					</div>
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
					<div class="col-xs-12 col-xs-6" style="margin-left: 60px">
						<a href="" target="_blank" class="btn btn-primary printed_contract_mortgage"><i
									class="fa fa-print"></i>
							In hợp đồng</a>
					</div>
					<div class="col-xs-12 col-xs-4">
						<a href="" target="_blank" class="btn btn-info printed_commitment_policy"><i
									class="fa fa-print"></i>
							In cam kết ưu đãi</a>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
				<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
				<input id="number" name="phone_number" type="hidden" value=""/>
				<p id="status" style="margin-left: 125px;"></p>
				<h3 class="modal-title title_modal_approve"></h3>
				<hr>
				<div class="form-group">
					<input type="text" value="<?php echo $this->input->get('id') ?>" class="hidden"
						   class="form-control " id="contract_id">
				</div>
				<div class="form-group">
					<label>Kết quả nhắc HĐ vay:</label>
					<select class="form-control " style="width: 70%" id="result_reminder">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Ngày hẹn thanh toán:</label>
					<input type="date" name="payment_date" class="form-control " id="payment_date" required>
				</div>
				<div class="form-group">
					<label>Số tiền hẹn thanh toán:</label>
					<input type="text" class="form-control " id="amount_payment_appointment" required>
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control " id="contract_v2_note" rows="5" required></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger " id="approve_call_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="showhistory" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: max-content;margin: auto">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_history"></h5>
				<div class="x_panel">
					<div class="x_content">
						<table id="" class="table table-striped">
							<thead>
							<tr>
								<th>#</th>
								<th>Nhân viên</th>
								<th>Số gọi</th>
								<th>Trạng thái cuộc gọi</th>
								<th>Chi tiết</th>
								<th>Thời lượng</th>
								<th>File ghi âm</th>
							</tr>
							</thead>
							<tbody name="list_lead" id="list_lead">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ContractHistoryModal" tabindex="-1" role="dialog" aria-labelledby="ContractHistoryModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title" id="title_lshd"></h3>
				<hr>
				<div class="table-responsive">
					<table class="table table-fixed table-striped hide-show-column" id="datatable-button"
						   style="white-space:initial">
						<thead>
						<tr>

							<th style="text-align: center">Người thực hiện</th>
							<th style="text-align: center">Thời gian</th>
							<th style="text-align: center" colspan="2">Ghi chú</th>

						</tr>
						</thead>
						<tbody id="historyContract">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="contract_involve" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Hợp đồng liên quan</h3>
			</div>
			<div class="modal-body">

				<div class="table-responsive">
					<table class="table table-striped hide-show-column" id="datatable-button">
						<thead>
						<tr>
							<th>Mã Hợp Đồng</th>
							<th>Mã Phiếu ghi</th>
							<th>Số Tiền Vay</th>
							<th>Thời Hạn</th>
							<th>Phòng Giao Dịch</th>
							<th>Trạng Thái</th>
						</tr>
						</thead>
						<tbody id="contract_involve_show">

						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
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

				<div class="form-group error_code_contract" style="display:none">
					<label>Trường hợp vi phạm:</label>
					<select class="form-control " name="error_code[]" style="width: 75%" id="error_code"
							multiple="multiple" data-placeholder="Choose option">
						<?php foreach (lead_return() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $key . ' - ' . $value ?></option>
						<?php } ?>
					</select>
				</div>
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

					<div class="modal-body tpgd" id="" style="display: none">
						<p> Nhiệm vụ của Phòng giao dịch trường:</p>

						<ol>
							<li> Đảm bảo việc giám sát, duyệt hợp đồng là đúng</li>
							<li> Cam kết việc xử lý là đúng và không có gian lận</li>
							<li> Chịu hoàn toàn trách nhiệm khi có vấn đề xảy ra</li>

						</ol>

						<p>Nếu bạn chắc chắn, hãy click vào: Tôi đồng ý, để xác nhận xử lý:</p>
						<div class="checkbox">
							<label><input type="checkbox"> Tôi đồng ý và sẵn sàng chịu hoàn toàn trách nhiệm pháp lý với
								VFC</label>
						</div>


					</div>

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


<!-- Modal yêu cầu cơ cấu -->
<div id="cocauhopdongModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title title_modal_approve_cc">Yêu cầu cơ cấu</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="alert alert-warning" role="alert" style="display: none;">
						<p>Khách hàng chưa thanh toán đủ số tiền: </p>
						<p>- Tiền còn thiếu. </p>
						<p>- Tiền chậm trả. </p>
						<p>- Tiền lãi phí kỳ cuối. </p>
						<b>Bạn cần cân nhắc trước khi duyệt! </b>
					</div>
					<div class="col-xs-12 col-md-6">
						<h4>
							<i class="fa fa-files-o"></i>
							Chi tiết giao dịch
						</h4>
						<hr class="mt-0">

						<table class="table table-borderless">
							<tbody>
							<tr>
								<td>
									Mã hợp đồng gốc:
								</td>
								<td>
									<span id="cc_ma_hop_dong"></span>
								</td>
							</tr>
							<tr>
								<td>
									Hình thức vay:
								</td>
								<td>
									<span id="cc_hinh_thuc_vay"></span>
								</td>
							</tr>
							<tr>
								<td>
									Loại tài sản:
								</td>
								<td>
									<span id="cc_loai_tai_san"></span>
								</td>
							</tr>
							<tr>
								<td>
									Số tiền được vay
								</td>
								<td>
									<span id="cc_so_tien_duoc_vay"></span>
								</td>
							</tr>
							<tr>
								<td>
									Hình thức trả lãi
								</td>
								<td>
									<span id="cc_hinh_thuc_tra_lai"></span>
								</td>
							</tr>
							<tr>
								<td>
									Thời gian vay
								</td>
								<td>
									<span id="cc_thoi_gian_vay"></span>
								</td>
							</tr>
							<tr>
								<td>
									Tài liệu xác thực:
								</td>
								<td>

									<div class="col-md-12 col-xs-12">
										<div id="SomeThing" class="simpleUploader">
											<div class="uploads" id="uploads_img_file_cc">

											</div>
											<label for="uploadinput_cc" id="addup_cc">
												<div class="block uploader">
													<span>+</span>
												</div>
											</label>
											<input id="uploadinput_cc" type="file" name="file"
												   data-contain="uploads_img_file_cc"
												   data-title="Hồ sơ trả về" multiple data-type="img_file"
												   class="focus">
										</div>
									</div>


								</td>
							</tr>
							</tbody>
						</table>

					</div>


					<div class="col-xs-12 col-md-6">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<h4>
									<i class="fa fa-files-o"></i>
									THÔNG TIN CƠ CẤU

								</h4>

							</div>
							<div class="col-xs-12 col-md-6 text-right">
								<a href="#" id="xem_chi_tiet_co_cau" target="_blank">
									Xem chi tiết |
								</a>
								<a href="#" id="ds_hop_dong_cc">
									DS Hợp đồng cơ cấu
								</a>
							</div>
						</div>
						<hr class="mt-0">

						<table class="table table-borderless">
							<tbody>

							<tr>
								<td>
									Hình thức cho vay
								</td>
								<td>
									<select id="type_loan_cc" class="form-control" name="">

										<option value="DKX">Cho vay</option>
										<!-- <option value="CC">Cầm cố</option>
										<option value="TC">Tín chấp</option> -->

									</select>
								</td>
							</tr>
							<tr>
								<td>
									Thời gian vay
								</td>
								<td>
									<select class="form-control w-100" id="number_day_loan_cc">
										<option value="">-- Chọn thời gian vay --</option>
										<option value="1">
											1 tháng
										</option>
										<option value="3">
											3 tháng
										</option>
										<option value="6">
											6 tháng
										</option>
										<option value="9">
											9 tháng
										</option>
										<option value="12">
											12 tháng
										</option>
										<option value="18">
											18 tháng
										</option>
										<option value="24">
											24 tháng
										</option>
									</select>

								</td>
							</tr>
							<tr>
								<td>
									Số tiền được vay
								</td>
								<td>
									<input type="text" id="amount_money_cc" class="form-control">
								</td>
							</tr>
							<tr>
								<td>
									Ngoại lệ
								</td>
								<td>
									<select id="exception_cc" class="form-control" name=""
									>
										<?php foreach (gh_cc_exception() as $key => $item) { ?>
											<option value="<?= $key ?>"><?= $item ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>


							<tr>
								<td style="vertical-align:top !important;">
									Ghi chú/Note
								</td>
								<td>
									<textarea class="form-control" id="approve_note_cc" rows="4"
											  placeholder="Nhập lưu ý"></textarea>


								</td>
							</tr>
							</tbody>
						</table>

					</div>
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" class="form-control contract_id_cc">
				<input type="hidden" class="form-control status_approve_cc">
				<input type="hidden" class="form-control status_contract_cc">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-danger cancel_submit_cc" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-info return_submit_cc" data-dismiss="modal">Trả về CVKD</button>
				<button type="button" class="btn btn-primary approve_submit_cc">Gửi</button>
			</div>
		</div>

	</div>
</div>
<!-- Modal yêu cầu gia hạn -->
<div id="giahanhopdongModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title title_modal_approve_gh">Yêu cầu gia hạn</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="alert alert-warning" role="alert" style="display: none;">
						<p>Khách hàng chưa thanh toán đủ số tiền: </p>
						<p>- Tiền còn thiếu. </p>
						<p>- Tiền chậm trả. </p>
						<p>- Tiền lãi phí kỳ cuối. </p>
						<b>Bạn cần cân nhắc trước khi duyệt </b>
					</div>
					<div class="col-xs-12 col-md-6">
						<h4>
							<i class="fa fa-files-o"></i>
							Chi tiết giao dịch
						</h4>
						<hr class="mt-0">

						<table class="table table-borderless">
							<tbody>
							<tr>
								<td>
									Mã hợp đồng gốc:
								</td>
								<td>
									<span id="gh_ma_hop_dong"></span>
								</td>
							</tr>
							<tr>
								<td>
									Hình thức vay:
								</td>
								<td>
									<span id="gh_hinh_thuc_vay"></span>
								</td>
							</tr>
							<tr>
								<td>
									Loại tài sản:
								</td>
								<td>
									<span id="gh_loai_tai_san"></span>
								</td>
							</tr>
							<tr>
								<td>
									Số tiền được vay
								</td>
								<td>
									<span id="gh_so_tien_duoc_vay"></span>
								</td>
							</tr>
							<tr>
								<td>
									Hình thức trả lãi
								</td>
								<td>
									<span id="gh_hinh_thuc_tra_lai"></span>
								</td>
							</tr>
							<tr>
								<td>
									Thời gian vay
								</td>
								<td>
									<span id="gh_thoi_gian_vay"></span>
								</td>
							</tr>
							<tr>
								<td>
									Tài liệu xác thực:
								</td>
								<td>

									<div class="col-md-12 col-xs-12">
										<div id="SomeThing" class="simpleUploader">
											<div class="uploads" id="uploads_img_file_gh">

											</div>
											<label for="uploadinput_gh" id="addup_gh">
												<div class="block uploader">
													<span>+</span>
												</div>
											</label>
											<input id="uploadinput_gh" type="file" name="file"
												   data-contain="uploads_img_file_gh"
												   data-title="Hồ sơ trả về" multiple data-type="img_file"
												   class="focus">
										</div>
									</div>


								</td>
							</tr>
							</tbody>
						</table>

					</div>


					<div class="col-xs-12 col-md-6">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<h4>
									<i class="fa fa-files-o"></i>
									THÔNG TIN GIA HẠN

								</h4>

							</div>
							<div class="col-xs-12 col-md-6 text-right">
								<a href="#" id="xem_chi_tiet_gia_han" target="_blank">
									Xem chi tiết |
								</a>
								<a href="#" id="ds_hop_dong_gh">
									DS Hợp đồng gia hạn
								</a>
							</div>
						</div>
						<hr class="mt-0">

						<table class="table table-borderless">
							<tbody>
							<tr>
								<td>
									Thời gian vay
								</td>
								<td>
									<select class="form-control w-100" id="number_day_loan_gh">
										<option value="">-- Chọn thời gian vay --</option>
										<option value="1">1
											tháng
										</option>
										<option value="3">3
											tháng
										</option>
										<option value="6">6
											tháng
										</option>
										<option value="9">9
											tháng
										</option>
										<option value="12">
											12 tháng
										</option>
										<option value="18">18 tháng
										</option>
										<option value="24">
											24 tháng
										</option>
									</select>

								</td>
							</tr>

							<tr>
								<td>
									Ngoại lệ
								</td>
								<td>
									<select id="exception_gh" class="form-control" name="">
										<?php foreach (gh_cc_exception() as $key => $item) { ?>
											<option value="<?= $key ?>"><?= $item ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:top !important;">
									Ghi chú/Note
								</td>
								<td>
									<textarea class="form-control" id="approve_note_gh" rows="4"
											  placeholder="Nhập lưu ý"></textarea>
								</td>
							</tr>
							</tbody>
						</table>

					</div>
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" class="form-control status_approve_gh">
				<input type="hidden" class="form-control status_contract_gh">
				<input type="hidden" class="form-control contract_id_gh">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-danger cancel_submit_gh" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-info return_submit_gh" data-dismiss="modal">Trả về CVKD</button>
				<button type="button" class="btn btn-primary approve_submit_gh">Gửi</button>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="list_giahan_cc" tabindex="-1" role="dialog" aria-labelledby="ContractHistoryModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title " id="title_list_cc_gh">DANH SÁCH HỢP ĐỒNG GIA HẠN</h5>
				<hr>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped" style="width: 100%">
						<thead>
						<tr>
							<th>#</th>
							<th>Mã hợp đồng</th>
							<th>Mã phiếu ghi</th>
							<th>Loại</th>
							<th>Ngày</th>
							<th>Trạng thái</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody id='list_contract_gh_cc'>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!--script-->
<!--<script type="text/javascript">-->
<!--	$(window).on('load', function () {-->
<!--		$('#quanlyduyetModal').modal('show');-->
<!--	});-->
<!--</script>-->

<!--<script src="--><?php //echo base_url(); ?><!--assets/js/template/create_contract.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/template/quanlyhopdong.js?rev=<?php echo time(); ?>"></script>
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
	});

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
<!--<script>-->
<!--	$(".magnifyitem").magnify({-->
<!--		initMaximized: true-->
<!--	});-->
<!--</script>-->
<script type="text/javascript">
	$('.showModal').click(function () {
		$("#historyContract").html("");
		$("#title_lshd").html("");

		var id = $(this).attr("data-id");
		console.log("xxx")
		console.log(id)
		$.ajax({
			url: _url.base_url + 'new_contract/showHistoryContract/' + id,
			type: "GET",
			dateType: "JSON",
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {

				$("#loading").hide();


				if (data.code == 200) {
					let html = "";
					let title_lshd = "";
					let content = data.data;
					console.log(content)

					title_lshd = "Lịch sử hợp đồng - " + content[0].old.code_contract_disbursement

					for (var i = 0; i < content.length; i++) {
						if (content[i].old_status == undefined) {
							content[i].old_status = "";
						}
						if (content[i].new_status == undefined) {
							content[i].new_status = "";
						}
						if (content[i].new.note == undefined) {
							content[i].new.note = "";
						}
						html += "<tr><td>" + content[i].created_by + "</td>";
						html += "<td>" + content[i].created_at;
						if (content[i].old_status != "" && content[i].new_status != "") {
							html += "<br>(" + content[i].old_status + " -> " + content[i].new_status + ")";
						}
						html += "</td>";
						html += "<td colspan='2'><div>" + content[i].new.note + "</div></td>"
						html += "</tr>";

					}
					$("#historyContract").append(html);
					$("#title_lshd").append(title_lshd);
				}

				$('#ContractHistoryModal').modal('show');
			}
		});
	})

	$('.contract_involve').click(function () {
		$("#contract_involve_show").html("");
		var id = $(this).attr("data-id");
		console.log("xxx")
		console.log(id)
		$.ajax({
			url: _url.base_url + 'new_contract/showContractInvolveShow/' + id,
			type: "GET",
			dateType: "JSON",
			success: function (data) {
				console.log(data);
				if (data.code == 200) {
					let html = "";
					let content = data.data;
					console.log(content)

					if (content.contractInfor_data_phone != undefined) {
						html += "<tr style='background-color: yellow'><th colspan='6'>Số điện thoại: " + content.contractInfor_data_phone + "</th>";
					}
					for (var i = 0; i < content.contract_involve_phone.length; i++) {
						if (content.contract_involve_phone[i].code_contract_disbursement == undefined) {
							content.contract_involve_phone[i].code_contract_disbursement = "";
						}
						html += "<tr>";
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_phone[i]._id.$oid + "'>" + content.contract_involve_phone[i].code_contract_disbursement + "</a></td>"
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_phone[i]._id.$oid + "'>" + content.contract_involve_phone[i].code_contract + "</a></td>"
						html += "<td>" + content.contract_involve_phone[i].loan_infor.amount_money + " vnđ</td>"
						html += "<td>" + content.contract_involve_phone[i].loan_infor.number_day_loan / 30 + " tháng</td>"
						html += "<td>" + content.contract_involve_phone[i].store.name + " </td>"
						html += "<td>" + content.contract_involve_phone[i].status + " </td>"
						html += "</tr>";

					}
					if (content.data_identify != undefined) {
						html += "<tr style='background-color: yellow'><th colspan='6'>Số chứng minh thư: " + content.data_identify + "</th>";
					}
					for (var i = 0; i < content.contract_involve_identify.length; i++) {
						if (content.contract_involve_identify[i].code_contract_disbursement == undefined) {
							content.contract_involve_identify[i].code_contract_disbursement = "";
						}
						html += "<tr>";
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_identify[i]._id.$oid + "'>" + content.contract_involve_identify[i].code_contract_disbursement + "</a></td>"
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_identify[i]._id.$oid + "'>" + content.contract_involve_identify[i].code_contract + "</a></td>"
						html += "<td>" + content.contract_involve_identify[i].loan_infor.amount_money + " vnđ</td>"
						html += "<td>" + content.contract_involve_identify[i].loan_infor.number_day_loan / 30 + " tháng</td>"
						html += "<td>" + content.contract_involve_identify[i].store.name + " </td>"
						html += "<td>" + content.contract_involve_identify[i].status + " </td>"
						html += "</tr>";

					}
					if (content.customer_identify_old != undefined) {
						html += "<tr style='background-color: yellow'><th colspan='6'>Số CCCD: " + content.customer_identify_old + "</th>";
					}
					for (var i = 0; i < content.contract_involve_identify_old.length; i++) {
						if (content.contract_involve_identify_old[i].code_contract_disbursement == undefined) {
							content.contract_involve_identify_old[i].code_contract_disbursement = "";
						}
						html += "<tr>";
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_identify_old[i]._id.$oid + "'>" + content.contract_involve_identify_old[i].code_contract_disbursement + "</a></td>"
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_identify_old[i]._id.$oid + "'>" + content.contract_involve_identify_old[i].code_contract + "</a></td>"
						html += "<td>" + content.contract_involve_identify_old[i].loan_infor.amount_money + " vnđ</td>"
						html += "<td>" + content.contract_involve_identify_old[i].loan_infor.number_day_loan / 30 + " tháng</td>"
						html += "<td>" + content.contract_involve_identify_old[i].store.name + " </td>"
						html += "<td>" + content.contract_involve_identify_old[i].status + " </td>"
						html += "</tr>";

					}
					if (content.phone_number_relative_1 != undefined) {
						html += "<tr style='background-color: yellow'><th colspan='6'>Số tham chiếu 1: " + content.phone_number_relative_1 + "</th>";
					}
					for (var i = 0; i < content.contract_involve_relative_1.length; i++) {
						if (content.contract_involve_relative_1[i].code_contract_disbursement == undefined) {
							content.contract_involve_relative_1[i].code_contract_disbursement = "";
						}
						html += "<tr>";
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_relative_1[i]._id.$oid + "'>" + content.contract_involve_relative_1[i].code_contract_disbursement + "</a></td>"
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_relative_1[i]._id.$oid + "'>" + content.contract_involve_relative_1[i].code_contract + "</a></td>"
						html += "<td>" + content.contract_involve_relative_1[i].loan_infor.amount_money + " vnđ</td>"
						html += "<td>" + content.contract_involve_relative_1[i].loan_infor.number_day_loan / 30 + " tháng</td>"
						html += "<td>" + content.contract_involve_relative_1[i].store.name + " </td>"
						html += "<td>" + content.contract_involve_relative_1[i].status + " </td>"
						html += "</tr>";

					}


					if (content.phone_number_relative_2 != undefined) {
						html += "<tr style='background-color: yellow'><th colspan='6'>Số tham chiếu 2: " + content.phone_number_relative_1 + "</th>";
					}
					for (var i = 0; i < content.contract_involve_relative_2.length; i++) {
						if (content.contract_involve_relative_2[i].code_contract_disbursement == undefined) {
							content.contract_involve_relative_2[i].code_contract_disbursement = "";
						}
						html += "<tr>";
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_relative_2[i]._id.$oid + "'>" + content.contract_involve_relative_2[i].code_contract_disbursement + "</a></td>"
						html += "<td><a target='_blank' href='" + _url.base_url + "accountant/view?id=" + content.contract_involve_relative_2[i]._id.$oid + "'>" + content.contract_involve_relative_2[i].code_contract + "</a></td>"
						html += "<td>" + content.contract_involve_relative_2[i].loan_infor.amount_money + " vnđ</td>"
						html += "<td>" + content.contract_involve_relative_2[i].loan_infor.number_day_loan / 30 + " tháng</td>"
						html += "<td>" + content.contract_involve_relative_2[i].store.name + " </td>"
						html += "<td>" + content.contract_involve_relative_2[i].status + " </td>"
						html += "</tr>";

					}
					$("#contract_involve_show").append(html);
				}


				$('#contract_involve').modal('show');
			}
		});


	})


</script>
