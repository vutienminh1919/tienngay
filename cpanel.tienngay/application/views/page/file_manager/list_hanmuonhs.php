<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
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
			</div>
		</div>


		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách hồ sơ quá hạn</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">
							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('file_manager/search_quahan') ?>" method="get">
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
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="width: 1%">#</th>
								<th style="text-align: center">Mã hợp đồng</th>
								<th style="text-align: center">Phòng giao dịch</th>
								<th style="text-align: center">Thời gian mượn dự kiến</th>
								<th style="text-align: center">Phòng ban mượn</th>
								<th style="text-align: center">Hồ sơ mượn</th>
								<th style="text-align: center">Số ngày quá hạn</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center"></th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($borrowed)): ?>
								<?php foreach ($borrowed as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td><?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : "" ?></td>
										<td><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
										<td><?= !empty($value->borrowed_start) ? date("d/m/y", $value->borrowed_start) : "" ?>
											- <?= !empty($value->borrowed_end) ? date("d/m/y", $value->borrowed_end) : "" ?></td>
										<td><?= !empty($value->groupRoles_store) ? $value->groupRoles_store : "" ?></td>
										<td>
											<?php if (!empty($value->file)) { ?>
												<?php foreach ($value->file as $key1 => $item) { ?>
													<?php if ($key1 == 0) { ?>
														<div href="#"><?php echo $item ?></div>
													<?php } ?>
													<?php if ($key1 > 0) { ?>
														<div href="#"><?php echo $item ?></div>
													<?php } ?>

												<?php } ?>
												<?php if (!empty($value->giay_to_khac)) { ?>
													<div href="#"><?php echo $value->giay_to_khac ?></div>
												<?php } ?>
											<?php } else { ?>
												<?php if (!empty($value->giay_to_khac)) { ?>
													<div href="#"><?php echo $value->giay_to_khac ?></div>
												<?php } ?>
											<?php } ?>
										</td>

										<td style="text-align: center">
											<?php if (!empty($value->days_duong)): ?>
												<p style="color: green; font-weight: bold;font-size: 14px">- <?= $value->days_duong ?></p>
											<?php elseif (!empty($value->days_am)): ?>
												<p style="color: red; font-weight: bold;font-size: 14px">+ <?= $value->days_am ?></p>
											<?php else:?>
												<p style="color: green; font-weight: bold;font-size: 14px">0</p>
											<?php endif; ?>
										</td>

										<td>
											<?php if ($value->status == 1) : ?>
												<span class="label label-success"
													  style="font-size: 15px; background-color: #2A3F54; padding: 7px">Mới</span>
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
											<?php endif; ?>
										</td>
										<td class="text-center">
											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													<i class="fa fa-cogs"></i>
													<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">

													<li>
														<a href="
											<?php echo base_url("file_manager/detail_borrowed?id=") . $value->_id->{'$oid'} ?>"
														   class="dropdown-item">
															Xem chi tiết hồ sơ
														</a>
													</li>
													<?php
													if ((in_array("giao-dich-vien", $groupRoles) || in_array("cua-hang-truong", $groupRoles))) { ?>
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
						<select class="form-control" id="code_contract_disbursement" name="code_contract_disbursement[]"
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
									if ($role->status == "deactive" || $role->name == "Giao dịch viên" || $role->name == "Quản lý khu vực" || $role->name == "Supper Admin" || $role->name == "Thông báo" || $role->name == "Vận hành" || $role->name == "Kế toán" || $role->name == "Hội sở" || $role->name == "Telesales" || $role->name == "Marketing" || $role->name == "TBP CSKH" || $role->name == "Phát triển sản phẩm" || $role->name == "Quản lý hồ sơ" || $role->name == "Quản lý cấp cao" || $role->name == "Hành chính") {
										continue;
									}
									?>
									<option
										value="<?= !empty($role->name) ? $role->name : ""; ?>"><?= !empty($role->name) ? $role->name : ""; ?></option>
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
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file[]" class="fileCheckBox">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file[]"
										   class="fileCheckBox"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file[]" class="fileCheckBox"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file[]" class="fileCheckBox">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file[]" class="fileCheckBox">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file[]" class="fileCheckBox"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file[]" class="fileCheckBox"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file[]" class="fileCheckBox"> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file[]" class="fileCheckBox"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file[]" class="fileCheckBox"> Sổ đỏ
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
									if ($role->status == "deactive" || $role->name == "Giao dịch viên" || $role->name == "Quản lý khu vực" || $role->name == "Supper Admin" || $role->name == "Thông báo" || $role->name == "Vận hành" || $role->name == "Kế toán" || $role->name == "Hội sở" || $role->name == "Telesales" || $role->name == "Marketing" || $role->name == "TBP CSKH" || $role->name == "Phát triển sản phẩm" || $role->name == "Quản lý hồ sơ" || $role->name == "Quản lý cấp cao" || $role->name == "Hành chính") {
										continue;
									}
									?>
									<option
										value="<?= !empty($role->name) ? $role->name : ""; ?>"><?= !empty($role->name) ? $role->name : ""; ?></option>
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
									<input type="checkbox" value="Giấy cam kết" name="file_1[]" class="fileCheckBox_1"
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
						<input type="text" class="form-control" id="giay_to_khac_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_start_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian trả: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_1"></textarea>
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
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
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
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
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
						<div style="text-align: center">
							<button type="button" id="borrowed_qlhs_borrowed" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
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
						<div style="text-align: center">
							<button type="button" id="borrowed_danhanhoso" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
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
						<div style="text-align: center">
							<button type="button" id="borrowed_trahsdamuon" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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
						<div style="text-align: center">
							<button type="button" id="borrowed_luukho" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
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









