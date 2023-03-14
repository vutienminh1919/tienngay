<style>

	.bell .layer-1 {
		color: red;
		z-index: 9;
		animation: animation-layer-1 5000ms infinite;
		opacity: 0;
	}

	.bell .layer-2 {
		color: red;
		z-index: 8;
		position: absolute;
		top: 0;
		left: 0;
		animation: animation-layer-2 5000ms infinite;
	}

	.bell .layer-3 {
		color: red;
		z-index: 7;
		position: absolute;
		top: 0;
		left: 0;
		animation: animation-layer-3 5000ms infinite;
	}

	@keyframes animation-layer-1 {
		0% {
			transform: rotate(0deg);
			opacity: 0;
		}
		8.0% {
			transform: rotate(0deg);
			opacity: 0;
		}
		12.0% {
			transform: rotate(42deg);
			opacity: .5;
		}
		16.0% {
			transform: rotate(-35deg);
			opacity: .4;
		}
		20.0% {
			transform: rotate(0deg);
			opacity: .1;
		}
		23.0% {
			transform: rotate(28deg);
			opacity: .3;
		}
		26.0% {
			transform: rotate(-20deg);
			opacity: .2;
		}
		29.0% {
			transform: rotate(0deg);
			opacity: .1;
		}
		31.0% {
			transform: rotate(16deg);
			opacity: 0;
		}
		33.0% {
			transform: rotate(-12deg);
			opacity: 0;
		}
		35.0% {
			transform: rotate(0deg);
			opacity: 0;
		}
		37.0% {
			transform: rotate(-6deg);
			opacity: 0;
		}
		39.0% {
			transform: rotate(0deg);
			opacity: 0;
		}
	}

	@keyframes animation-layer-2 {
		0% {
			transform: rotate(0deg);
		}
		8.0% {
			transform: rotate(0deg);
		}
		12.0% {
			transform: rotate(42deg);
		}
		16.0% {
			transform: rotate(-35deg);
		}
		20.0% {
			transform: rotate(0deg);
		}
		23.0% {
			transform: rotate(28deg);
		}
		26.0% {
			transform: rotate(-20deg);
		}
		29.0% {
			transform: rotate(0deg);
		}
		31.0% {
			transform: rotate(16deg);
		}
		33.0% {
			transform: rotate(-12deg);
		}
		35.0% {
			transform: rotate(0deg);
		}
		37.0% {
			transform: rotate(-6deg);
		}
		39.0% {
			transform: rotate(0deg);
		}
		40.0% {
			transform: rotate(6deg);
		}
		44.0% {
			transform: rotate(-3deg);
		}
		49.0% {
			transform: rotate(2deg);
		}
		55.0% {
			transform: rotate(0deg);
		}
		62.0% {
			transform: rotate(1deg);
		}
		70.0% {
			transform: rotate(0deg);
		}
	}

	@keyframes animation-layer-3 {
		0% {
			transform: rotate(0deg);
			opacity: 1;
		}
		8.0% {
			transform: rotate(0deg);
			opacity: 1;
		}
		12.0% {
			transform: rotate(52deg);
			opacity: .5;
		}
		16.0% {
			transform: rotate(-48deg);
			opacity: .4;
		}
		20.0% {
			transform: rotate(0deg);
			opacity: 1;
		}
		23.0% {
			transform: rotate(42deg);
			opacity: .3;
		}
		26.0% {
			transform: rotate(-30deg);
			opacity: .2;
		}
		29.0% {
			transform: rotate(0deg);
			opacity: 1;
		}
		31.0% {
			transform: rotate(26deg);
			opacity: .15;
		}
		33.0% {
			transform: rotate(-18deg);
			opacity: .1;
		}
		35.0% {
			transform: rotate(0deg);
			opacity: 1;
		}
		37.0% {
			transform: rotate(-12deg);
			opacity: .8;
		}
		40.0% {
			transform: rotate(6deg);
			opacity: 1;
		}
		44.0% {
			transform: rotate(-3deg);
			opacity: .8;
		}
		49.0% {
			transform: rotate(2deg);
			opacity: 1;
		}
		55.0% {
			transform: rotate(0deg);
			opacity: 1;
		}
		62.0% {
			transform: rotate(1deg);
			opacity: 1;
		}
		70.0% {
			transform: rotate(0deg);
			opacity: 1;
		}
	}

	.btn-bell {
		position: relative;
		padding-left: 40px !important;
		box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
		border-radius: 5px;
		border: none !important;
	}

	.btn-bell .wrapper {
		position: absolute;
		left: 11px;
		top: 11px;
	}

	.stright-through {
		text-decoration:line-through;
	}
</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons" media="all">


<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$groupRoles_store_search = !empty($_GET['groupRoles_store_search']) ? $_GET['groupRoles_store_search'] : "";
	$id_user = $userSession['id'];
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
				<div class="title_left">
					<h3>QUẢN LÝ HỒ SƠ / MƯỢN TRẢ HỒ SƠ</h3>
				</div>
				<?php
				if (in_array("quan-ly-ho-so", $groupRoles)) { ?>
					<div class="title_right text-right">
						<div class="btn-group">
							<a class="btn btn-primary btn-bell"
							   style="color: red; background-color: white; padding: 15px; font-weight: bold;font-size: 15px"
							   href="<?php echo base_url('file_manager/index_quahan') ?>">
								<div class="wrapper">
									<div class="bell" id="bell-1">
										<div class="anchor material-icons layer-1">notifications_active</div>
									</div>
								</div>
								Danh sách quá hạn</a>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách hồ sơ</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right dropdown-filter">
							<?php
							if (in_array("giao-dich-vien", $groupRoles) || in_array("an-ninh-dieu-tra", $groupRoles) || in_array("thu-hoi-no", $groupRoles) || in_array("cua-hang-truong", $groupRoles) || in_array("kiem-soat-noi-bo", $groupRoles)) { ?>
								<button style="background-color: #5A738E" class="btn btn-info show-hide-total-top-ten"
										data-toggle="modal"
										data-target="#addnewModal_muonhoso">
									Thêm mới
								</button>
							<?php } ?>
							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<a style="    float: revert;width: 170px !important;"
							   href="<?= base_url() ?>excel/muontrahoso?fdate=<?= $fdate . '&tdate=' . $tdate . '&code_contract_disbursement_search=' . $code_contract_disbursement_search . '&status=' . $status. '&store=' . $store  ?>"
							   class="btn btn-primary w-100" target="_blank"><i
										class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
								Xuất excel
							</a>

							<form action="<?php echo base_url('file_manager/search_borrowed') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
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
										</div>
									</li>

									<li class="form-group">
										<label>Mã hợp đồng: </label>
										<input type="text" name="code_contract_disbursement_search" class="form-control"
											   value="<?= !empty($code_contract_disbursement_search) ? $code_contract_disbursement_search : "" ?>">
									</li>

									<?php
									if (in_array("quan-ly-ho-so", $groupRoles)) { ?>
										<li class="form-group">
											<label>Phòng giao dịch: </label>
											<select class="form-control" name="store">
												<option value="">-- Tất cả --</option>
												<?php foreach ($stores as $key => $item): ?>
													<?php if ($item->status != "active") {
														continue;
													}
													$check = $item->_id->{'$oid'};
													?>
													<option
														value="<?= $item->_id->{'$oid'} ?>" <?= (!empty($store) && $store == "$check") ? "selected" : "" ?>><?= $item->name ?></option>
												<?php endforeach; ?>
											</select>
										</li>
									<?php } ?>

									<li class="form-group">
										<label>Trạng thái: </label>
										<select class="form-control" name="status">
											<option value="">-- Tất cả --</option>
											<option value="1" <?= ($status == 1) ? "selected" : "" ?> >Mới</option>
											<option value="2" <?= ($status == 2) ? "selected" : "" ?>>Hủy yêu cầu
											</option>
											<option value="3" <?= ($status == 3) ? "selected" : "" ?>>PGD YC mượn HS
												giải ngân
											</option>
											<option value="4" <?= ($status == 4) ? "selected" : "" ?>>Yêu cầu mượn HS
											</option>
											<option value="5" <?= ($status == 5) ? "selected" : "" ?>>QLHS trả về yêu
												cầu mượn
											</option>
											<option value="6" <?= ($status == 6) ? "selected" : "" ?>>Chờ nhận hồ sơ
											</option>
											<option value="7" <?= ($status == 7) ? "selected" : "" ?>>Đang mượn hồ sơ
											</option>
											<option value="8" <?= ($status == 8) ? "selected" : "" ?>>Chưa nhận đủ HS
												mượn
											</option>
											<option value="9" <?= ($status == 9) ? "selected" : "" ?>>Trả HS mượn về
												HO
											</option>
											<option value="10" <?= ($status == 10) ? "selected" : "" ?>>Lưu kho</option>
											<option value="11" <?= ($status == 11) ? "selected" : "" ?>>Chưa trả đủ HS
												đã mượn
											</option>
											<option value="12" <?= ($status == 12) ? "selected" : "" ?>>Quá hạn mượn
												HS
											</option>
											<option value="13" <?= ($status == 13) ? "selected" : "" ?>>Trả hồ sơ cho KH tất toán
											</option>
											<option value="14" <?= ($status == 14) ? "selected" : "" ?>>QLHS xác nhận KH đã tất toán
											</option>
											<option value="15" <?= ($status == 15) ? "selected" : "" ?>>Yêu cầu gia hạn mượn hồ sơ
											</option>

										</select>
									</li>

									<li class="form-group">
										<label>Phòng ban: </label>
										<select class="form-control" name="groupRoles_store_search">
											<option value="">-- Tất cả --</option>
											<option value="Thu hồi nợ" <?= ($groupRoles_store_search == "Thu hồi nợ") ? "selected" : "" ?> >Quản lý HĐ khoản vay</option>
											<option value="Cửa hàng trưởng" <?= ($groupRoles_store_search == "Cửa hàng trưởng") ? "selected" : "" ?>>Cửa hàng trưởng</option>
											<option value="An ninh điều tra" <?= ($groupRoles_store_search == "An ninh điều tra") ? "selected" : "" ?>>An ninh điều tra</option>
											<option value="Kiểm soát nội bộ" <?= ($groupRoles_store_search == "Kiểm soát nội bộ") ? "selected" : "" ?>>Kiểm soát nội bộ</option>
										</select>
									</li>

									<li class="text-right">
										<button class="btn btn-info" type="submit">
											<i class="fa fa-search" aria-hidden="true"></i>
											Tìm Kiếm
										</button>
									</li>

								</ul>
							</form>

						</div>

						<div class="col-xs-12 col-md-6">
							<h2>Tổng số: <?= !empty($count) ? $count : 0 ?></h2>
						</div>

					</div>
					<div class="clearfix">

					<div class="x_content">
						<div class="table-responsive">
							<table id="summary-total"
								   class="table table-bordered m-table table-hover table-calendar table-report"
								   style="font-size: 14px;font-weight: 400;">
								<thead style="background:#5A738E; color: #ffffff;">
								<tr>
									<th style="width: 1%">#</th>
									<th style="text-align: center">Chức năng</th>
									<th style="text-align: center">Mã hợp đồng</th>
									<th style="width: 1%">Tên KH</th>
									<th style="text-align: center">Phòng giao dịch</th>
									<th style="text-align: center">Thời gian mượn dự kiến</th>
									<th style="text-align: center">Phòng ban mượn</th>
									<th width="400" style="text-align: center">Hồ sơ mượn</th>
									<th style="text-align: center">Tình trạng ĐKX</th>
									<th style="text-align: center">Trạng thái</th>
									<th style="text-align: center">Trạng thái hợp đồng</th>
									<th style="text-align: center">Tạo bởi</th>
									<th style="text-align: center">Ngày tạo</th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($borrowed)): ?>
									<?php foreach ($borrowed as $key => $value): ?>
										<tr>
											<td style="text-align: center"><?= ++$key ?></td>
											<td class="text-center">
												<div class="dropdown" style="display:inline-block">
													<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
															data-toggle="dropdown">
														<i class="fa fa-cogs"></i>
														<span class="caret"></span></button>
													<ul class="dropdown-menu dropdown-menu-left">

														<li>
															<a href="
											<?php echo base_url("file_manager/detail_borrowed?id=") . $value->_id->{'$oid'} ?>"
															   class="dropdown-item">
																Xem chi tiết hồ sơ
															</a>
														</li>
														<?php
														if (in_array("giao-dich-vien", $groupRoles) || in_array("cua-hang-truong", $groupRoles)) { ?>
															<?php
															if ($value->status == 1) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="gui_yc_len_asm(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Gửi YC lên ASM
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="sua_yeu_cau_muon_hs('<?= $value->_id->{'$oid'} ?>')">
																		Sửa yêu cầu
																	</a>
																</li>

																<li>
																	<a href="javascript:void(0)"
																	   onclick="huy_yc_muon_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Hủy yêu cầu
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 5) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="gui_yc_len_asm(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Gửi YC lên ASM
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="sua_yeu_cau_muon_hs('<?= $value->_id->{'$oid'} ?>')">
																		Sửa yêu cầu
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="huy_yc_muon_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Hủy yêu cầu
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 6) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="user_da_nhan_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Đã nhận hồ sơ
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="chua_nhan_du_ho_so('<?= $value->_id->{'$oid'} ?>')">
																		Chưa nhận đủ hồ sơ mượn
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 8) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="user_da_nhan_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Đã nhận hồ sơ
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 7 || $value->status == 12) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="tra_hs_da_muon(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Trả HS đã mượn
																	</a>
																</li>
																<?php if ($value->status_hd == 19) : ?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="tra_hs_cho_kh_tat_toan(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																		>
																			Trả HS cho KH tất toán
																		</a>
																	</li>
																<?php endif; ?>

															<?php } ?>
														<?php } ?>

														<?php
														if (in_array("quan-ly-khu-vuc", $groupRoles)) { ?>
															<?php
															if ($value->status == 3) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="gui_yc_len_qlhs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Gửi YC lên QLHS
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="huy_yc_muon_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Hủy yêu cầu
																	</a>
																</li>
															<?php } ?>
														<?php } ?>

														<?php
														if (in_array("an-ninh-dieu-tra", $groupRoles) || in_array("kiem-soat-noi-bo", $groupRoles) || in_array("thu-hoi-no", $groupRoles)) { ?>
															<?php
															if ($value->status == 1) { ?>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="sua_yeu_cau_muon_hs('<?= $value->_id->{'$oid'} ?>')">
																		Sửa yêu cầu
																	</a>
																</li>
																<!--Nếu là nhân sự phòng quản lý khoản vay thì phải gửi yêu cầu tới trưởng phòng để duyệt-->
																<?php if (in_array($id_user, $role_nv_qlkv)) : ;?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="gui_yc_len_tp_qlkv(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																			Gửi trưởng phòng duyệt
																		</a>
																	</li>
																<?php else: ;?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="gui_yc_len_qlhs(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																			Gửi YC lên QLHS
																		</a>
																	</li>
																<?php endif;?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="huy_yc_muon_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Hủy yêu cầu
																	</a>
																</li>
															<?php } ?>

															<?php
															if ($value->status == 5) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="gui_yc_len_qlhs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Gửi YC lên QLHS
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="sua_yeu_cau_muon_hs('<?= $value->_id->{'$oid'} ?>')">
																		Sửa yêu cầu
																	</a>
																</li>
															<?php } ?>

															<?php
															if ($value->status == 6) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="user_da_nhan_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Đã nhận hồ sơ
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="chua_nhan_du_ho_so('<?= $value->_id->{'$oid'} ?>')">
																		Chưa nhận đủ hồ sơ mượn
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 8) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="user_da_nhan_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Đã nhận hồ sơ
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 7 || $value->status == 12) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="tra_hs_da_muon(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Trả HS đã mượn
																	</a>
																</li>
																<?php if ($value->status_hd == 19) : ?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="tra_hs_cho_kh_tat_toan(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																		>
																			Trả HS cho KH tất toán
																		</a>
																	</li>
																<?php endif; ?>
															<?php } ?>

															<?php
															if ($value->status == 12) { ?>
																<?php if (in_array($id_user, $role_nv_qlkv)) : ;?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="send_request_approve_extend(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																		>
																			Gửi YC duyệt gia hạn mượn hồ sơ
																		</a>
																	</li>
																<?php else:;?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="gia_han_thoi_gian_muon(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																		>
																			Gia hạn thời gian mượn
																		</a>
																	</li>
																<?php endif;?>

															<?php } ?>
															<!--TP QLKV duyet YC muon HS-->
															<?php if ($value->status == 16) { ?>
																<?php if (in_array('tbp-thu-hoi-no', $groupRoles)) : ?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="tp_qlkv_duyet_yeu_cau(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																		   data-note="<?= !empty($value->ghichu) ? $value->ghichu : ""; ?>">
																			Gửi yêu cầu lên quản lý hồ sơ
																		</a>
																	</li>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="huy_yc_muon_hs(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																			Hủy yêu cầu
																		</a>
																	</li>
																<?php endif;?>
															<?php } ?>
															<!--TP QLKV duyêt YC gia hạn thời gian mượn HS-->
															<?php if ($value->status == 17) { ?>
																<?php if (in_array('tbp-thu-hoi-no', $groupRoles)) : ?>
																	<li>
																		<a href="javascript:void(0)"
																		   onclick="tp_qlkv_duyet_yeu_cau_gh_muon(this)"
																		   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																		   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																		   data-note="<?= !empty($value->ghichu) ? $value->ghichu : ""; ?>"
																		   data-extend="<?= !empty($value->time_extend_suggest) ? date('d-m-Y', $value->time_extend_suggest) : ""; ?>">
																			Gửi yêu cầu gia hạn mượn lên QLHS
																		</a>
																	</li>
																<?php endif;?>
															<?php } ?>

														<?php } ?>

														<?php
														if (in_array("quan-ly-ho-so", $groupRoles)) { ?>
															<?php
															if ($value->status == 4) { ?>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="xac_nhan_yeu_cau_qlhs('<?= $value->_id->{'$oid'} ?>')">
																		Xác nhận yêu cầu
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="tra_yc_muon_qlhs('<?= $value->_id->{'$oid'} ?>')">
																		Trả yêu cầu
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="huy_yc_muon_hs(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Hủy yêu cầu
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 9 || $value->status == 12) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="luu_kho(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Hoàn tất lưu kho
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="chua_tra_du_hs('<?= $value->_id->{'$oid'} ?>')">
																		Chưa trả đủ hs đã mượn
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 11) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="luu_kho(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		Hoàn tất lưu kho
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 13) { ?>
																<li>
																	<a href="javascript:void(0)"
																	   onclick="qlhs_xac_nhan_kh_da_tat_toan(this)"
																	   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																	   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																	>
																		QLHS xác nhận KH đã tất toán
																	</a>
																</li>
															<?php } ?>
															<?php
															if ($value->status == 15) { ?>
																<li>
																	<a href="javascript:void(0)" data-toggle="modal"
																	   onclick="qlhs_xac_nhan_gia_han_muon_hs('<?= $value->_id->{'$oid'} ?>')">
																		QLHS xác nhận gia hạn mượn HS
																	</a>
																</li>
															<?php } ?>
														<?php } ?>


														<li>
															<a href="
											<?php echo base_url("pawn/detail?id=") . $value->id_contract->{'$oid'} ?>"
															   class="dropdown-item">
																Xem chi tiết hợp đồng
															</a>
														</li>

													</ul>
												</div>
											</td>
											<td>
												<a class="link" target="_blank" data-toggle="tooltip" data-placement="right"
												   title="Chi tiết hợp đồng"
												   href="<?php echo base_url("pawn/detail?id=") . $value->id_contract->{'$oid'} ?>"
												   style="color: #0ba1b5;text-decoration: underline;">
													<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : "" ?>
												</a>
											</td>
											<td>
												<a class="link" target="_blank" data-toggle="tooltip" data-placement="right"
												   title="Chi tiết hồ sơ"
												   href="<?php echo base_url("file_manager/detail_borrowed?id=") . $value->_id->{'$oid'} ?>"
												   style="color: #0ba1b5;text-decoration: underline;">
													<?= !empty($value->customer_name) ? $value->customer_name : "" ?>
												</a>
											</td>
											<td><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
											<td><?= !empty($value->borrowed_start) ? date("d/m/y", $value->borrowed_start) : "" ?>
												- <?= !empty($value->borrowed_end) ? date("d/m/y", $value->borrowed_end) : "" ?></td>
											<td><?= !empty($value->groupRoles_store) ? $value->groupRoles_store : "" ?></td>
											<td width="400" style=" white-space: nowrap">
												<?php if (!empty($value->file)) { ?>
													<?php foreach ($value->file as $key1 => $item) { ?>
														<?php if ($key1 == 0) { ?>
															<p href="#"><?php echo $item ?></p>
														<?php } ?>
														<?php if ($key1 > 0) { ?>
															<p href="#"><?php echo $item ?></p>
														<?php } ?>

													<?php } ?>
													<?php if (!empty($value->giay_to_khac)) { ?>
														<p href="#"><?php echo $value->giay_to_khac ?></p>
													<?php } ?>
												<?php } else { ?>
													<?php if (!empty($value->giay_to_khac)) { ?>
														<p href="#"><?php echo $value->giay_to_khac ?></p>
													<?php } ?>
												<?php } ?>
											</td>
											<td style="text-align: center">
												<?php if (!empty($value->status_dkx) && $value->status_dkx == 1) : ; ?>
													<span class="label label-primary" style="color: white; ">Lưu kho</span>
												<?php elseif (!empty($value->status_dkx) && $value->status_dkx == 2) : ; ?>
													<span class="label label-success" style="color: white; ">Đã trả</span>
												<?php elseif (!empty($value->status_dkx) && $value->status_dkx == 3) : ; ?>
													<span class="label label-danger" style="color: white; ">Đang lưu ở HĐ khác</span>
												<?php else: ?>
													<span class="label label-warning" style="color: white; ">Chưa cập nhật</span>
												<?php endif; ?>
											</td>
											<td>
												<?php if ($value->status == 1) : ?>
													<span class="label label-success"
														  style="font-size: 15px; background-color: #2A3F54; padding: 7px; color: white">Mới</span>
												<?php elseif ($value->status == 2) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #f2f2f2; padding: 7px; color: #828282">Hủy yêu cầu</span>
												<?php elseif ($value->status == 3) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">PGD YC mượn HS giải ngân</span>
												<?php elseif ($value->status == 4) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">Yêu cầu mượn HS</span>
												<?php elseif ($value->status == 5) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #eaca4a; padding: 7px; color: #ffffff">QLHS trả về yêu cầu mượn</span>
												<?php elseif ($value->status == 6) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #eaca4a; padding: 7px; color: #ffffff">Chờ nhận hồ sơ</span>
												<?php elseif ($value->status == 7) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #4fbe87; padding: 7px; color: #ffffff">Đang mượn hồ sơ</span>
												<?php elseif ($value->status == 8) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #eaca4a; padding: 7px; color: #ffffff">Chưa nhận đủ HS mượn</span>
												<?php elseif ($value->status == 9) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #4fbe87; padding: 7px; color: #ffffff">Trả HS mượn về HO</span>
												<?php elseif ($value->status == 10) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #e88df2; padding: 7px; color: #ffffff">Lưu kho</span>
												<?php elseif ($value->status == 11) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #eaca4a; padding: 7px; color: #ffffff">Chưa trả đủ HS đã mượn</span>
												<?php elseif ($value->status == 12) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #f3616d; padding: 7px; color: #ffffff">Quá hạn mượn HS</span>
												<?php elseif ($value->status == 13) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #035927; padding: 7px; color: #ffffff">Trả hồ sơ cho KH tất toán</span>
												<?php elseif ($value->status == 14) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #7070d7; padding: 7px; color: #ffffff">QLHS xác nhận KH đã tất toán</span>
												<?php elseif ($value->status == 15) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">Yêu cầu gia hạn mượn hồ sơ</span>
												<?php elseif ($value->status == 16) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">Chờ TP QLKV duyệt YC mượn hồ sơ</span>
												<?php elseif ($value->status == 17) : ?>
													<span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">Chờ TP QLKV duyệt YC gia hạn mượn hồ sơ</span>
												<?php endif; ?>
											</td>
											<?php if ($value->status_hd == 19): ?>
											<td style="font-weight: bold; color: red">
												<?= !empty($value->status_hd) ? contract_status($value->status_hd) : "" ?>
											</td>
											<?php else: ?>
												<td style="font-weight: bold; color: green">
													<?= !empty($value->status_hd) ? contract_status($value->status_hd) : "" ?>
												</td>
											<?php endif; ?>
											<td><?= !empty($value->created_by->email) ? ($value->created_by->email) : "" ?></td>
											<td><?= !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>

										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
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

<!--Modal-->
<div id="addnewModal_muonhoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Yêu cầu mượn hồ sơ</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Mã hợp đồng
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="code_contract_disbursement"
								name="code_contract_disbursement[]"
								multiple="multiple">
							<?php if (!empty($code_contract_disbursement)) {
								foreach ($code_contract_disbursement as $key => $obj) { ?>
									<option class="form-control"
											value="<?= $key ?>"><?= $obj ?></option>
								<?php }
							} ?>
						</select>
						<input id="code_contract_disbursement_value" style="display: none">
						<input id="code_contract_disbursement_text" style="display: none">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Phòng ban
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="groupRoles_store" name="groupRoles_store"
								data-placeholder="">
							<?php
							if (!empty($groupRoles_store)) {
								foreach ($groupRoles_store as $key => $role) {
									if ($role->status == "deactive") {
										continue;
									}
									?>
									<?php if ($role->name == "Cửa hàng trưởng" || $role->name == "Thu hồi nợ" || $role->name == "Kiểm soát nội bộ" ||  $role->name == "An ninh điều tra"): ?>

										<?php if ($role->name == "Thu hồi nợ" ): ?>
											<option
												value="<?= !empty($role->name) ? $role->name : ""; ?>">Quản lý hợp đồng vay</option>
										<?php else: ?>
											<option
												value="<?= !empty($role->name) ? $role->name : ""; ?>"><?= !empty($role->name) ? $role->name : ""; ?></option>
										<?php endif; ?>

									<?php endif; ?>
								<?php }
							} ?>
						</select>
					</div>
				</div>


				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file" name="all_file"> Tất cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file[]"
										   class="fileCheckBox" id="file6_1">
									<span class="file6_1">Thỏa thuận 3 bên</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file[]"
										   class="fileCheckBox" id="file6_2">
									<span class="file6_2">Văn bản bàn giao tài sản</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file[]" class="fileCheckBox" id="file6_3">
									<span class="file6_3">Thông báo</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file[]"
										   class="fileCheckBox" id="file6_4">
									<span class="file6_4">Đăng ký xe/Cà vẹt</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file[]"
										   class="fileCheckBox" id="file6_5">
									<span class="file6_5">Hợp đồng mua bán</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file[]" class="fileCheckBox" id="file6_6">
									<span class="file6_6">Đăng kiểm</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file[]" class="fileCheckBox" id="file6_7">
									<span class="file6_7">Giấy cam kết</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file[]" class="fileCheckBox" id="file6_8">
									<span class="file6_8">Ủy quyền</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file[]" class="fileCheckBox" id="file6_9">
									<span class="file6_9">Chìa khóa</span>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file[]" class="fileCheckBox" id="file6_10">
									<span class="file6_10">Sổ đỏ</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Lý do mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="lydomuon">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_start">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian trả: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu"></textarea>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div id="editModal_muonhoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Sửa yêu cầu</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_2">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Mã hợp đồng
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="code_contract_disbursement_1"
								name="code_contract_disbursement_1[]"
								multiple="multiple" disabled>
							<?php if (!empty($code_contract_disbursement)) {
								foreach ($code_contract_disbursement as $key => $obj) { ?>
									<option class="form-control"
											value="<?= $key ?>"><?= $obj ?></option>
								<?php }
							} ?>
						</select>
						<input id="code_contract_disbursement_value_1" style="display: none">
						<input id="code_contract_disbursement_text_1" style="display: none">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Phòng ban
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="groupRoles_store_1" name="groupRoles_store_1"
								data-placeholder="" disabled>
							<?php
							if (!empty($groupRoles_store)) {
								foreach ($groupRoles_store as $key => $role) {
									if ($role->status == "deactive") {
										continue;
									}
									?>
									<?php if ($role->name == "Cửa hàng trưởng" || $role->name == "Thu hồi nợ" || $role->name == "Kiểm soát nội bộ" ||  $role->name == "An ninh điều tra"): ?>

									<option
										value="<?= !empty($role->name) ? $role->name : ""; ?>"><?= !empty($role->name) ? $role->name : ""; ?></option>
									<?php endif; ?>
								<?php }
							} ?>
						</select>
					</div>
				</div>


				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_1" name="all_file_1"> Tất cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_1[]"
										   class="fileCheckBox_1" id="file_1">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_1[]"
										   class="fileCheckBox_1" id="file_2"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_1[]" class="fileCheckBox_1"
										   id="file_3"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_1[]"
										   class="fileCheckBox_1" id="file_4">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_1[]"
										   class="fileCheckBox_1" id="file_5">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_1[]" class="fileCheckBox_1"
										   id="file_6"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_1[]"
										   class="fileCheckBox_1"
										   id="file_7">
									Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_1[]" class="fileCheckBox_1"
										   id="file_8"> Ủy
									quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_1[]" class="fileCheckBox_1"
										   id="file_9"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_1[]" class="fileCheckBox_1"
										   id="file_10"> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_1" name="giay_to_khac_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Lý do mượn:  <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="lydomuon_1" name="lydomuon_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_start_1" name="borrowed_start_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian trả: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end_1" name="borrowed_end_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_1" name="ghichu_1"></textarea>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_edit_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

	<div id="approve_extend_borrowed" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title">Xác nhận yêu cầu gia hạn hồ sơ</h3>
				</div>
				<div class="theloading" style="display:none;">
					<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
					<span><?= $this->lang->line('Loading') ?>...</span>
				</div>
				<div class="alert alert-danger alert-dismissible text-center" style="display:none"
					 id="div_errorCreate_2">
					<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
					<span class='div_errorCreate'></span>
				</div>
				<input type="hidden" id="fileReturn_id_25" value="" name="fileReturn_id_25">
				<div class="modal-body">

					<div class="form-group row">
						<label class="control-label col-md-3 col-xs-12">Thời gian gia hạn mượn: <span
								class="text-danger">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="" class="form-control" placeholder="dd/mm/yyyy" id="update_time_borrowed_approve" name="update_time_borrowed_approve" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 col-xs-12">Lý do mượn: <span
								class="text-danger">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" id="lydomuon_25" name="lydomuon_25" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 col-xs-12">Hình ảnh: <span
								class="text-danger">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div id="" class="simpleUploader">
								<div class="uploads" id="">
									<div id="file_img_approve"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
					<button type="button" class="btn btn-primary" id="approveExtendBorrowed">Xác nhận</button>
				</div>
			</div>
		</div>
	</div>


<div class="modal fade" id="cancel_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_cancel_borrowed"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="borrowed_cancel" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
									aria-label="Close">
								Bỏ qua
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="asm_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_asm_borrowed"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="borrowed_asm_borrowed" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
									aria-label="Close">
								Bỏ qua
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="qlhs_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_qlhs_borrowed"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_1"
										  name="ghichu_approve_1"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_11"></div>
									<label for="uploadinput_11">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_11" type="file" name="file"
										   data-contain="uploads_fileReturn_11" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_qlhs_borrowed" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
									aria-label="Close">
								Bỏ qua
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="qlhs_trahoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Yêu cầu trả</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_3">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_3"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_qlhs_trahoso">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div id="approve_borrowed" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Xác nhận cho mượn hồ sơ</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_4">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_4"></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_borrowed"></div>
							<label for="uploadinput_1">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_1" type="file" name="file"
								   data-contain="uploads_borrowed" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_approve_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="danhanhoso" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_danhanhoso"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_2"
										  name="ghichu_approve_2"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_12"></div>
									<label for="uploadinput_12">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_12" type="file" name="file"
										   data-contain="uploads_fileReturn_12" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_danhanhoso" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
									aria-label="Close">
								Bỏ qua
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="return_borrowed" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Chưa nhận đủ hồ sơ mượn</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_5">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_5"></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_borrowed_1"></div>
							<label for="uploadinput_2">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_2" type="file" name="file"
								   data-contain="uploads_borrowed_1" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_return_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="trahsdamuon" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_trahsdamuon"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_3"
										  name="ghichu_approve_3"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_13"></div>
									<label for="uploadinput_13">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_13" type="file" name="file"
										   data-contain="uploads_fileReturn_13" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_trahsdamuon" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
									aria-label="Close">
								Bỏ qua
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<div class="modal fade" id="trahskhachhangtattoan" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="text-align: center" id="title_trahskhachhangtattoan"></h3>
				</div>
				<div class="theloading" style="display:none;">
					<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
					<span><?= $this->lang->line('Loading') ?>...</span>
				</div>
				<div class="alert alert-danger alert-dismissible text-center" style="display:none"
					 id="div_errorCreate_20">
					<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
					<span class='div_errorCreate'></span>
				</div>
				<div class="modal-body ">
					<div class="row">
						<div class="col-xs-12">
							<input type="hidden" id="fileReturn_id">

							<div class="form-group row">
								<label class="control-label col-md-3 col-xs-12">Ghi chú <span
										class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_20"
										  name="ghichu_approve_20"></textarea>
								</div>
							</div>

							<div class="form-group row">
								<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
										class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div id="SomeThing" class="simpleUploader">
										<div class="uploads" id="uploads_fileReturn_20"></div>
										<label for="uploadinput_20">
											<div class="block uploader">
												<span>+</span>
											</div>
										</label>
										<input id="uploadinput_20" type="file" name="file"
											   data-contain="uploads_fileReturn_20" data-title="Hồ sơ nhân thân" multiple
											   data-type="fileReturn" class="focus">
									</div>
								</div>
							</div>

							<div style="text-align: right">
								<button type="button" id="borrowed_trahskhachhangtattoan" class="btn btn-info">Xác nhận</button>
								<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
										aria-label="Close">
									Bỏ qua
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="giahanthoigianmuon" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="text-align: center" id="title_giahanthoigianmuon"></h3>
				</div>
				<div class="theloading" style="display:none;">
					<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
					<span><?= $this->lang->line('Loading') ?>...</span>
				</div>
				<div class="alert alert-danger alert-dismissible text-center" style="display:none"
					 id="div_errorCreate_25">
					<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
					<span class='div_errorCreate'></span>
				</div>
				<div class="modal-body ">
					<div class="row">
						<div class="col-xs-12">
							<input type="hidden" id="fileReturn_id">

							<div class="form-group row">
								<label class="control-label col-md-3 col-xs-12">Thời gian trả:<span
										class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="" class="form-control" placeholder="dd/mm/yyyy" id="update_time_borrowed">
								</div>
							</div>

							<div class="form-group row">
								<label class="control-label col-md-3 col-xs-12">Lý do mượn <span
										class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_25"
										  name="ghichu_approve_25"></textarea>
								</div>
							</div>

							<div class="form-group row">
								<label class="control-label col-md-3 col-xs-12">Upload ảnh tình trạng ĐKX hiện tại <span
										class="text-danger">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div id="SomeThing" class="simpleUploader">
										<div class="uploads" id="uploads_fileReturn_25"></div>
										<label for="uploadinput_25">
											<div class="block uploader">
												<span>+</span>
											</div>
										</label>
										<input id="uploadinput_25" type="file" name="file"
											   data-contain="uploads_fileReturn_25" data-title="Hồ sơ nhân thân" multiple
											   data-type="fileReturn" class="focus">
									</div>
								</div>
							</div>

							<div style="text-align: right">
								<button type="button" id="borrowed_giahanthoigianmuon" class="btn btn-info">Xác nhận</button>
								<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
										aria-label="Close">
									Bỏ qua
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<!--Start Template input document-->
	<?php $this->load->view('page/file_manager/records_modal/confirm_customer_finish_modal.php') ; ?>
<!--End Template input document-->

<div class="modal fade" id="luukho" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_luukho"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_4"
										  name="ghichu_approve_4"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_14"></div>
									<label for="uploadinput_14">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_14" type="file" name="file"
										   data-contain="uploads_fileReturn_14" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>
						<div style="text-align: right">

							<button type="button" id="borrowed_luukho" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-dark close-hs" data-dismiss="modal"
									aria-label="Close">
								Bỏ qua
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="chua_tra_hs_da_muon" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Chưa nhận đủ hồ sơ mượn</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_6">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_6"></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_borrowed_2"></div>
							<label for="uploadinput_3">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_3" type="file" name="file"
								   data-contain="uploads_borrowed_2" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_chua_tra_hs_da_muon">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<!--Start modal gửi yêu cầu mượn lên TP quản lý khoản vay-->
	<?php $this->load->view('page/file_manager/borrowed_modal/send_request_borrow_to_tp_qlkv_modal.php') ; ?>
<!--End modal gửi yêu cầu mượn lên TP quản lý khoản vay-->

<!--Start modal TP QLKV gửi yêu cầu mượn lên QLHS-->
	<?php $this->load->view('page/file_manager/borrowed_modal/send_request_borrow_to_qlhs_modal.php') ; ?>
<!--End modal TP QLKV gửi yêu cầu mượn lên QLHS-->

<!--Start modal gửi yêu cầu duyệt gia hạn mượn-->
	<?php $this->load->view('page/file_manager/borrowed_modal/send_request_approve_extend_time_borrow_modal.php') ; ?>
<!--End modal gửi yêu cầu duyệt gia hạn mượn-->
<!--Start modal gửi yêu cầu duyệt gia hạn mượn lên QLHS-->
	<?php $this->load->view('page/file_manager/borrowed_modal/send_request_extend_borrow_to_qlhs_modal.php') ; ?>
<!--End modal gửi yêu cầu duyệt gia hạn mượn lên QLHS-->
<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url("assets/js/File_manager/borrowed.js?v=20230210") ;?>"></script>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<style>
		/*css tooltip current view*/
		.ui-widget-shadow {
			font-size: 12px;
			margin: -8px 0 0 -8px;
			padding: 5px;
			background: #4d4b4b;
			opacity: 1;
			filter: Alpha(Opacity=30);
			border-radius: 8px;
			color: white;
		}
	</style>
<script>
	$(document).ready(function () {
		const $menu = $('.dropdown-filter');
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







