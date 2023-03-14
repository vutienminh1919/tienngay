<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";


	$code_contract_disbursement_text = !empty($_GET['code_contract_disbursement_text']) ? $_GET['code_contract_disbursement_text'] : "";
	$status_borrowed = !empty($_GET['status_borrowed']) ? $_GET['status_borrowed'] : "";
	?>
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>DANH SÁCH HỒ SƠ MƯỢN/TRẢ</h2>
					<ul class="nav navbar-right panel_toolbox">
						<!--						<li>-->
						<!--							<div class="form-group" style="display:inline-block">-->
						<!--								<input type="text" class="form-control" placeholder="Tìm kiếm">-->
						<!--							</div>-->
						<!--							&nbsp;-->
						<!--						</li>-->
						<li>

							<div class="dropdown" style="display:inline-block">
								<button class="btn btn-success dropdown-toggle"
										onclick="$('#lockdulieu').toggleClass('show');">
									<span class="fa fa-filter"></span>
									Lọc dữ liệu
								</button>
								<form action="<?php echo base_url('borrowed/search_borrowed') ?>" method="get">
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;min-width:450px;">
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
											<input type="text" name="code_contract_disbursement_text"
												   class="form-control"
												   value="<?= !empty($code_contract_disbursement_text) ? $code_contract_disbursement_text : "" ?>"
												   placeholder="Mã hợp đồng">
										</li>
										<li class="form-group">
											<select class="form-control" name="status_borrowed">
												<option value="">Tất cả trạng thái</option>
												<option value="1" <?= (!empty($status_borrowed) && $status_borrowed == "1") ? "selected" : "" ?>>
													Chờ duyệt mượn HS
												</option>
												<option value="2" <?= (!empty($status_borrowed) && $status_borrowed == "2") ? "selected" : "" ?>>
													Chờ đến nhận HS
												</option>
												<option value="3" <?= (!empty($status_borrowed) && $status_borrowed == "3") ? "selected" : "" ?>>
													Hủy
												</option>
												<option value="4" <?= (!empty($status_borrowed) && $status_borrowed == "4") ? "selected" : "" ?>>
													Đang mượn
												</option>
												<option value="5" <?= (!empty($status_borrowed) && $status_borrowed == "5") ? "selected" : "" ?>>
													Chờ trả HS
												</option>
												<option value="6" <?= (!empty($status_borrowed) && $status_borrowed == "6") ? "selected" : "" ?>>
													Đã trả
												</option>
												<option value="7" <?= (!empty($status_borrowed) && $status_borrowed == "7") ? "selected" : "" ?>>
													Quá hạn
												</option>
												<option value="8" <?= (!empty($status_borrowed) && $status_borrowed == "8") ? "selected" : "" ?>>
													Chờ asm duyệt mượn HS
												</option>
											</select>
										</li>
										<li class="text-right">
											<button class="btn btn-info" type="submit">
												<i class="fa fa-search" aria-hidden="true"></i>
												Tìm Kiếm
											</button>
										</li>
								</form>
					</ul>
				</div>

				</li>
				<?php
				if (in_array('cua-hang-truong', $groupRoles)) {
					?>
					<li>
						<button class="btn btn-info" data-toggle="modal" data-target="#addnewModal_yeucaumuonhoso">
							<i class="fa fa-plus" aria-hidden="true"></i>
							Yêu cầu mượn hồ sơ
						</button>
					</li>
				<?php } ?>

				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<!-- start project list -->
						<table class="table table-bordered m-table table-hover table-calendar table-report stacktable table-quanlytaisan">
							<thead style="background:#3f86c3; color: #ffffff;">
							<tr>
								<th style="width: 1%">#</th>
								<th style="width: 1%">Tên KH</th>
								<th>Mã hợp đồng</th>
								<th>Phòng giao dịch</th>
								<th>Thời gian mượn dự kiến</th>
								<th>Phòng ban mượn</th>
								<th>Hồ sơ mượn</th>
								<th>Trạng thái</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							<tr>
							</tr>
							<?php if (!empty($borrowed)) { ?>
								<?php foreach ($borrowed as $key => $value) { ?>
									<tr>
										<td>
											<?php echo ++$key ?>
										</td>

										<td>

											<a href="<?php echo base_url("pawn/detail?id=") . $value->oid->_id->{'$oid'} ?>">
												<?= !empty($value->code_contract_disbursement_text) ? ($value->code_contract_disbursement_text) : "" ?>
											</a>

										</td>
										<td><?= !empty($value->created_by->stores[0]->store_name) ? ($value->created_by->stores[0]->store_name) . (!empty($value->created_by->stores[0]->code_area) ? " - " . $value->created_by->stores[0]->code_area : "") : "" ?></td>

										<td>
											<?= !empty($value->borrowed_start) ? date("d/m/y", $value->borrowed_start) : "" ?>
											- <?= !empty($value->borrowed_end) ? date("d/m/y", $value->borrowed_end) : "" ?>
										</td>
										<td>
											<?php if (!empty($value->status)) { ?>
												<?php if ($value->status == 8) { ?>
													<span class="label label-info">  Chờ ASM duyệt mượn HS</span>
												<?php } ?>
												<?php if ($value->status == 1) { ?>
													<span class="label label-info">  Chờ duyệt mượn HS</span>
												<?php } ?>
												<?php if ($value->status == 3) { ?>
													<span class="label label-danger">  Hủy</span>
												<?php } ?>
												<?php if ($value->status == 2) { ?>
													<span class="label label-primary">  Chờ đến nhận HS</span>
												<?php } ?>
												<?php if ($value->status == 4) { ?>
													<span class="label label-success">  Đang mượn</span>
												<?php } ?>
												<?php if ($value->status == 5) { ?>
													<span class="label label-default">  Chờ trả HS</span>
												<?php } ?>
												<?php if ($value->status == 6 && !empty($value->time_return)) { ?>
													<span class="label label-success">  Đã trả</span>
												<?php } ?>
												<?php if ($value->status == 7) { ?>
													<span class="label label-danger">  Quá hạn</span>
												<?php } ?>
											<?php } ?>
										</td>
										<td>
											<?= !empty($value->time_return) ? date("d/m/y", $value->time_return) : "" ?>
										</td>

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
										<td>
											<?= !empty($value->note) ? $value->note : "" ?>
										</td>
										<td class="text-right">
											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													<i class="fa fa-cogs"></i>
													<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">

													<?php
													if (in_array('cua-hang-truong', $groupRoles)) {
														?>
														<?php
														if (in_array($value->status, array(8))) { ?>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="editBorrowed('<?= $value->_id->{'$oid'} ?>')">
																	<i class="fa fa-edit"></i> Sửa yêu cầu
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(2))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xac_nhan_da_cho_muon(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-clone"></i> Xác nhận đã nhận hs
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(4))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="yeu_cau_tra_ho_so(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-address-card"></i> Yêu cầu trả
																	hồ sơ
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(8, 2))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_muon(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-window-close-o"></i> Hủy yêu cầu
																</a>
															</li>
														<?php } ?>
													<?php } ?>

													<?php
													if (in_array('quan-ly-ho-so', $groupRoles)) {
														?>

														<?php
														if (in_array($value->status, array(1))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xu_ly_cho_muon(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-check-square-o"></i> Xử lý cho
																	mượn
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(2))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xac_nhan_da_cho_muon(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-clone"></i> Xác nhận đã cho mượn
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(4, 5))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xac_nhan_da_tra(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>">
																	<i class="fa fa-handshake-o"></i> Xác nhận đã
																	trả
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(4))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="yeu_cau_tra_ho_so(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-address-card"></i> Yêu cầu trả
																	hồ sơ
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(1, 2))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_muon(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-window-close-o"></i> Hủy yêu cầu
																</a>
															</li>
														<?php } ?>

													<?php } ?>

													<?php
													if (in_array('quan-ly-khu-vuc', $groupRoles)) {
														?>
														<?php
														if (in_array($value->status, array(8))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xu_ly_cho_muon_asm(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-check-square-o"></i> Xử lý cho
																	mượn
																</a>
															</li>
														<?php } ?>
														<?php
														if (in_array($value->status, array(8, 2))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_muon(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-window-close-o"></i> Hủy yêu cầu
																</a>
															</li>
														<?php } ?>
													<?php } ?>
													<li>
														<a href="javascript:void(0)" data-toggle="modal"
														   onclick="history_borrowed('<?= $value->_id->{'$oid'} ?>')">
															<i class="fa fa-history"></i> Xem lịch sử mượn / trả
														</a>
													</li>
												</ul>
											</div>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
							</tbody>
						</table>
						<!-- end project list -->
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
<!-- /page content -->
<!-- Modal -->
<div id="addnewModal_yeucaumuonhoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">THÊM MỚI</h4>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Hồ sơ <span
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
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian dự kiến cho mượn <span
								class="text-danger">*</span>:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyy" id="borrowed_start">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian dự kiến trả <span
								class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end">
					</div>
				</div>
				<div class="row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Ghi chú:
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="form-control" name="note" id="note" rows="8" cols="80"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="submit_file">Tạo</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="history_yeucaumuonhoso" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Lịch sử</h4>
			</div>
			<div class="modal-body table-responsive" style="margin: 15px">
				<table class="table table-bordered">
					<thead>
					<tr>
						<th scope="col">Thời gian</th>
						<th scope="col">Trạng thái</th>
						<th scope="col">Ghi chú</th>
						<th scope="col">Danh sách hồ sơ</th>
						<th scope="col">Ảnh</th>
					</tr>
					</thead>
					<tbody id="history_ycmhs">
					</tbody>
				</table>
			</div>
			<div class="modal-footer ">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="trahoso_yeucaumuonhoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">TRẢ HỒ SƠ</h4>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Mã hợp đồng
						<span class="text-red">*</span>
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" value="something" readonly>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Hồ sơ</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value=""> Tất cả
								</label>
							</div>
						</div>
						<?php for ($i = 0;
								   $i < 5;
								   $i++) { ?>
							<div class="col-xs-12 col-md-6">
								<div class="checkbox">
									<label>
										<input type="checkbox" value=""> Option two. select more than one options
									</label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ngày hẹn trả: <span
								class="text-red">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="date" class="form-control" placeholder="Default Input">
					</div>
				</div>
				<div class="row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Ghi chú
						<span class="text-red">*</span>
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="form-control" name="name" rows="8" cols="80"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary">Tạo</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="editBorrowed" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="borrowed_id" value="" name="borrowed_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Sửa</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
								multiple="multiple">
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
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_1" name="giay_to_khac_1">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian dự kiến cho mượn <span
								class="text-danger">*</span>:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyy" id="borrowed_start_1"
							   name="borrowed_start_1">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian dự kiến trả <span
								class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end_1"
							   name="borrowed_end_1">
					</div>
				</div>
				<div class="row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Ghi chú:
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="form-control" name="note_1" id="note_1" rows="8" cols="80"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="edit_file">Sửa</button>
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
				<h3 class="modal-title" style="text-align: center" id="title_cancel"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="borrowed_id">
						<div style="text-align: center">
							<button type="button" id="borrowed_cancel" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="approval_borrowed_asm" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_approval_asm"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="borrowed_id_asm">
						<div style="text-align: center">
							<button type="button" id="borrowed_cancel_asm" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="confirm_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_confirm"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<input id="status_app" style="display: none">
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads " id="uploads_borrowed">

						</div>
						<label for="uploadinput">
							<div class="block uploader">
								<span>+</span>
							</div>
						</label>
						<input id="uploadinput" type="file" name="file"
							   data-contain="uploads_borrowed" data-title="Hồ sơ nhân thân" multiple
							   data-type="borrowed" class="focus">
					</div>

					<div class="col-xs-12">
						<input type="hidden" id="borrowed_id_1">
						<div style="text-align: center">

							<button type="button" id="borrowed_confirm" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary close-hs_1" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div id="xulychomuon" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<input type="hidden" id="borrowed_id_3" value="" name="borrowed_id_3">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Xử lý cho mượn</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_3">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body  large-gutter">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Mã hợp đồng
								<span class="text-danger">*</span> :
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select class="form-control" id="code_contract_disbursement_2"
										name="code_contract_disbursement_2[]"
										multiple="multiple" disabled>
									<?php if (!empty($code_contract_disbursement)) {
										foreach ($code_contract_disbursement as $key => $obj) { ?>
											<option class="form-control"
													value="<?= $key ?>"><?= $obj ?></option>
										<?php }
									} ?>
								</select>
								<input id="code_contract_disbursement_value_2" style="display: none">
								<input id="code_contract_disbursement_text_2" style="display: none">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h4>
							THÔNG TIN MƯỢN
						</h4>
						<div class="form-group">
							<div class="row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Hồ sơ <span
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
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" class="form-control" id="giay_to_khac_2" name="giay_to_khac_2"
									   disabled>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Thời gian dự kiến cho mượn <span
										class="text-danger">*</span>:</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="" class="form-control" placeholder="dd/mm/yyy" id="borrowed_start_2"
									   name="borrowed_start_2" disabled>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Thời gian dự kiến trả <span
										class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end_2"
									   name="borrowed_end_2" disabled>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Ghi chú:
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea class="form-control" name="note_2" id="note_2" rows="8" cols="80"
										  disabled></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h4>
							THÔNG TIN XÁC NHẬN
						</h4>
						<div class="form-group">
							<div class="row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Hồ sơ <span
											class="text-danger">*</span> :</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="checkbox m-0">
										<label>
											<input type="checkbox" value="" id="selectAll_file_3" name="all_file_3"> Tất
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
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" class="form-control" id="giay_to_khac_3" name="giay_to_khac_3">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Thời cần trả <span
										class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end_3"
									   name="borrowed_end_3">
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Ghi chú:
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea class="form-control" name="note_3" id="note_3" rows="8" cols="80"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
					<button type="button" class="btn btn-primary" id="xulychomuon_submit">Xác nhận</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal content-->
</div>

<div id="pay_borrowed" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">YÊU CẦU TRẢ HỒ SƠ</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<input type="hidden" id="borrowed_id_4" value="" name="borrowed_id_4">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Mã hợp đồng:
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="code_mhd" id="code_mhd" readonly>
						</div>
						<br><br><br>
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Ghi chú:
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<textarea class="form-control" name="note" id="note_4" rows="5" cols="80"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
					<button type="button" class="btn btn-primary" id="pay_borrowed_submit">Yêu Cầu</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="paid_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title5_confirm"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">

					<div id="" class="simpleUploader">
						<div class="uploads " id="uploads_borrowed_dt">

						</div>
						<label for="uploadinput_dt">
							<div class="block uploader">
								<span>+</span>
							</div>
						</label>
						<input id="uploadinput_dt" type="file" name="file"
							   data-contain="uploads_borrowed_dt" data-title="Hồ sơ nhân thân" multiple
							   data-type="borrowed" class="focus">
					</div>

					<div class="col-xs-12">
						<input type="hidden" id="borrowed_id_5">
						<div style="text-align: center">
							<button type="button" id="paid_borrowed_submit" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<script src="<?php echo base_url(); ?>assets/js/borrowed/borrowed.js"></script>
<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<!--1- Chờ duyệt mượn hồ sơ-->
<!--2- Chờ đến nhận hồ sơ-->
<!--3- Hủy-->
<!--4- Đang mượn-->
<!--5- Yêu cầu trả hồ sơ-->
<!--6- Đã tr-->
<!--7- Quá hạn-->
<!--8- Chờ asm duyệt mượn hồ sơ-->
