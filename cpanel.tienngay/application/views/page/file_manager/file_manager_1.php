<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
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
					<h3>QUẢN LÝ HỒ SƠ GỬI VỀ HO</h3>
				</div>
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
							if (in_array("giao-dich-vien", $groupRoles) || in_array("cua-hang-truong", $groupRoles)) { ?>
								<button style="background-color: #5A738E" class="btn btn-info show-hide-total-top-ten"
										data-toggle="modal"
										data-target="#addnewModal_guihoso">
									Thêm mới
								</button>
							<?php } ?>

							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<?php
							if ($userSession['is_superadmin'] == 1 || in_array("quan-ly-ho-so", $groupRoles) || in_array("van-hanh", $groupRoles)) : ?>
								<a target="_blank" href="<?php echo base_url("File_manager/ExportRecordsDisbursement?") ?>
									<?=
										  'fdate=' . $fdate
										. '&tdate=' . $tdate
										. '&store=' . $store
										. '&status=' . $status
										. '&code_contract_disbursement_search=' . $code_contract_disbursement_search
									?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Xuất dữ liệu
								</a>
							<?php endif; ?>
							<form action="<?php echo base_url('file_manager/search') ?>" method="get">
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
										<label>Mã hợp đồng: </label>
										<input type="text" name="code_contract_disbursement_search" class="form-control"
											   value="<?= !empty($code_contract_disbursement_search) ? $code_contract_disbursement_search : "" ?>">
									</li>

									<li class="form-group">
										<label>Trạng thái: </label>
										<select class="form-control" name="status">
											<option value="">-- Tất cả --</option>
											<?php
											foreach (file_manager_status() as $key => $value) {
												?>
												<option
													value="<?= $key ?>" <?= ($key == $status) ? "selected" : "" ?>><?= $value ?></option>
											<?php } ?>
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
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Chức năng</th>
								<th style="text-align: center">Mã hợp đồng</th>
								<th style="text-align: center">Tên KH</th>
								<th width="300" style="text-align: center">Hồ sơ gửi lên</th>
								<th width="300" style="text-align: center">Hồ sơ thực nhận</th>
								<th width="300" style="text-align: center">Hồ sơ trả về</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center">Trạng thái hợp đồng</th>
								<th style="text-align: center">Trạng thái ĐKX</th>
								<th style="text-align: center">PGD</th>
								<th style="text-align: center">Thời gian tạo yêu cầu</th>
								<th style="text-align: center">Loại hợp đồng</th>
								<th style="text-align: center">Mã lưu trữ (HS lưu ĐKX bản cứng)</th>

							</tr>
							</thead>
							<tbody>
							<?php if (!empty($sendFile)): ?>
								<?php foreach ($sendFile as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td class="text-center">
											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													<i class="fa fa-cogs"></i>
													<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right" style="right: auto;">

													<li>
														<a href="<?php echo base_url("file_manager/detail?id=") . $value->_id->{'$oid'} ?>"
														   class="dropdown-item">
															Xem chi tiết hồ sơ
														</a>
													</li>
													<li>
														<a href="<?php echo base_url("pawn/detail?id=") . $value->id_contract->{'$oid'} ?>"
														   class="dropdown-item">
															Xem chi tiết hợp đồng
														</a>
													</li>

													<?php
													if (in_array("giao-dich-vien", $groupRoles) || in_array("cua-hang-truong", $groupRoles) || in_array("hoi-so", $groupRoles)) { ?>

														<?php
														if ($value->status == 1) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="gui_ho_so(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Gửi hồ sơ lên HO
																</a>
															</li>

															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="sua_yeu_cau('<?= $value->_id->{'$oid'} ?>')">
																	Sửa yêu cầu
																</a>
															</li>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_ho_so_gui(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Hủy yêu cầu
																</a>
															</li>
														<?php } ?>
														<?php
														if ($value->status == 4) { ?>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="gui_bo_sung_ho_so('<?= $value->_id->{'$oid'} ?>')">
																	Gửi bổ sung hồ sơ
																</a>
															</li>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_ho_so_gui(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																	Hủy yêu cầu
																</a>
															</li>
														<?php } ?>

														<?php
														if ($value->status == 6 && $value->status_hd == 19 && $value->is_dkx_origin == true) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="yc_tra_hs_sau_tat_toan(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																	Yêu cầu trả HS sau tất toán
																</a>
															</li>
														<?php } ?>
														<?php
														if ($value->status == 9) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="da_tra_hs_sau_tat_toan(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																	Đã nhận hồ sơ
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="yeu_cau_bo_sung_ho_so('<?= $value->_id->{'$oid'} ?>')">
																	Yêu cầu bổ sung HS
																</a>
															</li>
														<?php } ?>
														<?php
														if ($value->status == 10) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="da_tra_hs_sau_tat_toan(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																	Đã nhận hồ sơ
																</a>
															</li>
														<?php } ?>
														<?php
														if ($value->status == 13) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="yc_tra_hs_sau_tat_toan(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																	Yêu cầu trả HS sau tất toán
																</a>
															</li>
														<?php } ?>
													<?php } ?>

													<?php
													if (in_array("quan-ly-ho-so", $groupRoles)) { ?>
														<?php
														if ($value->status == 3) { ?>

															<li>
																<a href="javascript:void(0)"
																   onclick="hoan_tat_luu_kho(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Hoàn tất lưu kho
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="yeu_cau_bo_sung('<?= $value->_id->{'$oid'} ?>')">
																	Yêu cầu bổ sung
																</a>
															</li>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_ho_so_gui(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Hủy yêu cầu
																</a>
															</li>
														<?php } ?>
														<?php
														if ($value->status == 4) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="hoan_tat_luu_kho(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Hoàn tất lưu kho
																</a>
															</li>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_ho_so_gui(this)"
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
																   onclick="hoan_tat_luu_kho(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Hoàn tất lưu kho
																</a>
															</li>
															<li>
																<a href="javascript:void(0)"
																   onclick="qlhs_chua_nhan_hs(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	QLHS chưa nhận HS
																</a>
															</li>
														<?php } ?>
														<?php
														if ($value->status == 7) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="hoan_tat_luu_kho(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Hoàn tất lưu kho
																</a>
															</li>
														<?php } ?>
														<?php
														if ($value->status == 8) { ?>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="xac_nhan_yeu_cau_tra('<?= $value->_id->{'$oid'} ?>')">
																	Xác nhận yêu cầu trả
																</a>
															</li>
															<li>
																<a href="javascript:void(0)"
																   onclick="tra_ve_yeu_cau_qlhs(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	Trả về yêu cầu
																</a>
															</li>

														<?php } ?>

														<?php if ($value->status == 6) : ?>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="update_quantity_records('<?= $value->_id->{'$oid'} ?>')">
																	Cật nhật số lượng hồ sơ
																</a>
															</li>
														<?php endif; ?>

														<?php if ($value->status != 2 && $value->is_dkx_origin == false) : ?>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="update_records_origin('<?= $value->_id->{'$oid'} ?>')">
																	Chuyển hồ sơ về HĐ này
																</a>
															</li>
														<?php endif; ?>

													<?php } ?>



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
										<td style="right: auto;">
											<a class="link" target="_blank" data-toggle="tooltip" data-placement="right"
											   title="Chi tiết hồ sơ"
											   href="<?php echo base_url("file_manager/detail?id=") . $value->_id->{'$oid'} ?>"
											   style="color: #0ba1b5;text-decoration: underline;">
												<?= !empty($value->customer_name) ? $value->customer_name : "" ?>
											</a>
										</td>
										<td style="white-space: nowrap">
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
										<td style="white-space: nowrap">
											<?php if (!empty($value->records_receive)) : ?>
												<?php foreach ($value->records_receive as $key => $record) : ?>
													<?php
														if ($record->quantity == 0) continue;
														$quantity = 0;
														if ($record->quantity > 0 && $record->quantity < 10) {
															$quantity = '0' . $record->quantity;
														} else {
															$quantity = $record->quantity;
														}
														print '- ' . $record->text . ': ' . '<span style="color: red; font-weight: 700;">' . $quantity . '</span>' . ' bản.' . '<br>';
													?>
												<?php endforeach;?>
											<?php endif; ?>
											<?php if (!empty($value->giay_to_khac)) { ?>
												<p href="#"><?php echo $value->giay_to_khac ?></p>
											<?php } ?>
										</td>
										<td width="300" style="white-space: nowrap">

											<?php if ($value->status == 11): ?>
												<?php if (!empty($value->file)) { ?>
<!--														start V2-->
													<?php if (!empty($value->records_return)) : ?>
														<?php foreach ($value->records_return as $key => $record) : ?>
															<?php
															if ($record->quantity == 0) continue;
															$quantity = 0;
															if ($record->quantity > 0 && $record->quantity < 10) {
																$quantity = '0' . $record->quantity;
															} else {
																$quantity = $record->quantity;
															}
															print '- ' . $record->text . ': ' . '<span style="color: blue; font-weight: 700;">' . $quantity . '</span>' . ' bản.' . '<br>';
															?>
														<?php endforeach;?>
													<?php endif; ?>
<!--														end V2-->
													<?php if (!empty($value->giay_to_khac)) { ?>
														<p href="#"><?php echo $value->giay_to_khac ?></p>
													<?php } ?>
												<?php } else { ?>
													<?php if (!empty($value->giay_to_khac)) { ?>
														<p href="#"><?php echo $value->giay_to_khac ?></p>
													<?php } ?>
												<?php } ?>
											<?php else: ?>
												<?php if (!empty($value->file_v2)) { ?>
													<?php foreach ($value->file_v2 as $key2 => $item) { ?>
														<?php if ($key2 == 0) { ?>
															<p href="#"><?php echo $item ?></p>
														<?php } ?>
														<?php if ($key2 > 0) { ?>
															<p href="#"><?php echo $item ?></p>
														<?php } ?>

													<?php } ?>
													<?php if (!empty($value->giay_to_khac_v2)) { ?>
														<p href="#"><?php echo $value->giay_to_khac_v2 ?></p>
													<?php } ?>
												<?php } else { ?>
													<?php if (!empty($value->giay_to_khac_v2)) { ?>
														<p href="#"><?php echo $value->giay_to_khac_v2 ?></p>
													<?php } ?>
												<?php } ?>
											<?php endif; ?>
										</td>
										<td>
											<?php if ($value->status == 1) : ?>
												<span class="label label-success"
													  style="font-size: 15px; background-color: #2A3F54; padding: 7px;color: white">Mới</span>
											<?php elseif ($value->status == 2) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #f2f2f2; padding: 7px; color: #828282">Hủy yêu cầu</span>
											<?php elseif ($value->status == 3) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">YC gửi HS giải ngân</span>
											<?php elseif ($value->status == 4) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #fff2b5; padding: 7px; color: #f08532">QLHS YC bổ sung</span>
											<?php elseif ($value->status == 5) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #4fbe87; padding: 7px; color: #ffffff">Đã XN YC gửi HS</span>
											<?php elseif ($value->status == 6) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #e88df2; padding: 7px; color: #ffffff">Hoàn tất lưu kho</span>
											<?php elseif ($value->status == 7) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #f3616d; padding: 7px; color: #ffffff">QLHS chưa nhận HS</span>
											<?php elseif ($value->status == 8) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">YC trả HS sau tất toán</span>
											<?php elseif ($value->status == 9) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #4fbe87; padding: 7px; color: #ffffff">QLHS đã xác nhận YC trả HS</span>
											<?php elseif ($value->status == 10) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #fff2b5; padding: 7px; color: #f08532">YC bổ sung HS</span>
											<?php elseif ($value->status == 11) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #4fbe87; padding: 7px; color: #ffffff">Đã trả HS sau tất toán</span>
											<?php elseif ($value->status == 13) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #eaca4a; padding: 7px; color: #ffffff">Trả về yêu cầu</span>
											<?php endif; ?>
										</td>
										<td>
											<?php if ($value->status_hd == 19): ?>
												<span style="font-weight: bold; color: red"><?= !empty($value->status_hd) ? contract_status($value->status_hd) : "" ?></span>
											<?php else : ?>
												<span style="font-weight: bold; color: green"><?= !empty($value->status_hd) ? contract_status($value->status_hd) : "" ?></span>
											<?php endif; ?>
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
										<td><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
										<td><?= !empty($value->created_at) ? date("d/m/y H:i:s", $value->created_at) : "" ?></td>
										<td><?php
											if ($value->type_contract == 1) {
												echo '<span class="text-danger">Hợp đồng điện tử</span>' ;
											} else {
												echo '<span>Hợp đồng giấy</span>';
											}
											?>
										</td>
										<td><?= !empty($value->code_store_rc) ? $value->code_store_rc : '' ?></td>
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
<div id="addnewModal_guihoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">CVKD yêu cầu gửi hồ sơ về HO</h3>
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
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn"></div>
							<label for="uploadinput">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput" type="file" name="file"
								   data-contain="uploads_fileReturn" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_fileReturn">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div id="bosunghoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">QLHS yêu cầu bổ sung hồ sơ</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_2" name="all_file_2"
										   disabled> Tất
									cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_2[]"
										   class="fileCheckBox_2" id="file1_1" disabled>
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_2[]"
										   id="file1_2"
										   class="fileCheckBox_2" disabled> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_3" disabled> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_2[]"
										   class="fileCheckBox_2" id="file1_4" disabled>
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_2[]"
										   class="fileCheckBox_2" id="file1_5" disabled>
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_6" disabled> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_7" disabled> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_8" disabled> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_9" disabled> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_2[]" class="fileCheckBox_2"
										   id="file1_10" disabled> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_2" name="giay_to_khac_2" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_2" name="taisandikem_2" disabled>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_qlhs" name="ghichu_qlhs"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_bosunghoso">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div id="guibosunghoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">QLHS yêu cầu bổ sung hồ sơ</h4>
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
			<div class="modal-body">

				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_3" name="all_file_3"
										   disabled> Tất
									cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_3[]"
										   class="fileCheckBox_3" id="file3_1">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_3[]"
										   id="file3_2"
										   class="fileCheckBox_3"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_3"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_3[]"
										   class="fileCheckBox_3" id="file3_4">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_3[]"
										   class="fileCheckBox_3" id="file3_5">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_6"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_7"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_8"> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_9"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_3[]" class="fileCheckBox_3"
										   id="file3_10"> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_3" name="giay_to_khac_3">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_3" name="taisandikem_3">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_3" name="ghichu_3"></textarea>
					</div>
				</div>


				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn_3"></div>
							<label for="uploadinput_2">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_2" type="file" name="file"
								   data-contain="uploads_fileReturn_3" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_guibosunghoso">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div id="yeucaubosunghs" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">CVKD yêu cầu bổ sung hồ sơ</h4>
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
			<div class="modal-body">

				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_4" name="all_file_4"
										   disabled> Tất
									cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_4[]"
										   class="fileCheckBox_4" id="file4_1">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_4[]"
										   id="file4_2"
										   class="fileCheckBox_4"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_3"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_4[]"
										   class="fileCheckBox_4" id="file4_4">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_4[]"
										   class="fileCheckBox_4" id="file4_5">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_6"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_7"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_8"> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_9"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_4[]" class="fileCheckBox_4"
										   id="file4_10"> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_4" name="giay_to_khac_4">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_4" name="taisandikem_4">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_4" name="ghichu_4"></textarea>
					</div>
				</div>


				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn_4"></div>
							<label for="uploadinput_3">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_3" type="file" name="file"
								   data-contain="uploads_fileReturn_4" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_yeucaubosunghs">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="cancel_fileReturn" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_cancel"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="fileReturn_cancel" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="manager_send_file" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_send_file"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="fileReturn_send_file" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="approve_file" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_approve_file"></h3>
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
									<div class="uploads" id="uploads_fileReturn_10"></div>
									<label for="uploadinput_10">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_10" type="file" name="file"
										   data-contain="uploads_fileReturn_10" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="fileReturn_approve_file" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
							</button>
							<div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="save_file" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_save_file"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
					<!--Start Template input document-->
						<?php $this->load->view('page/file_manager/list_input_document.php') ; ?>
					<!--End Template input document-->
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Mã lưu trữ hồ sơ</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" id="code_store_rc" class="form-control" placeholder="Nhập mã lưu trữ hồ sơ">
							</div>
						</div>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
							<button type="button" id="fileReturn_save_file" class="btn btn-success">Xác nhận</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="not_received_file" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_not_received_file"></h3>
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
							<button type="button" id="fileReturn_not_received_file"
									class="btn btn-info">Xác nhận
							</button>
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

<div class="modal fade" id="return_file_v2" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_return_file_v2"></h3>
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
							<button type="button" id="fileReturn_return_file_v2" class="btn btn-info">
								Xác nhận
							</button>
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

<!--Start Modal return records finish records-->
<?php $this->load->view('page/file_manager/records_modal/return_records_finish_modal.php') ; ?>
<!--End Modal return records finish -->

<div id="editFileReturn" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Sửa</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_100">
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
				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Hồ sơ <span
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
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_1[]" id="file_2"
										   class="fileCheckBox_1"> Văn bản bàn giao tài sản
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
										   id="file_7"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_1[]" class="fileCheckBox_1"
										   id="file_8"> Ủy quyền
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
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_1" name="taisandikem_1">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_1" name="ghichu_1"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn_edit"></div>
							<label for="uploadinput_1">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_1" type="file" name="file"
								   data-contain="uploads_fileReturn_edit" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="edit_fileReturn">Sửa</button>
			</div>
		</div>
	</div>
</div>

<!--Start Modal Request return records-->
<?php $this->load->view('page/file_manager/records_modal/request_return_modal.php') ; ?>
<!--End Template input document-->


<div class="modal fade" id="traveyeucautattoan" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_traveyeucautattoan"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_5"
										  name="ghichu_approve_5"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_15"></div>
									<label for="uploadinput_15">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_15" type="file" name="file"
										   data-contain="uploads_fileReturn_15" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="fileReturn_traveyeucautattoan"
									class="btn btn-info">Xác nhận
							</button>
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

<!-- Start Template input document-->
<?php $this->load->view('page/file_manager/records_modal/update_quantity_records_modal.php') ; ?>
<!-- End Template input document-->

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url("assets/") ?>js/File_manager/file_manager.js?v=16022023"></script>
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








