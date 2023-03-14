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
	$status_fileReturn = !empty($_GET['status_fileReturn']) ? $_GET['status_fileReturn'] : "";
	?>
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>DANH SÁCH HỒ SƠ</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>

							<div class="dropdown" style="display:inline-block">
								<button class="btn btn-success dropdown-toggle"
										onclick="$('#lockdulieu').toggleClass('show');">
									<span class="fa fa-filter"></span>
									Lọc dữ liệu
								</button>
								<form action="<?php echo base_url('borrowed/search_fileReturn') ?>" method="get">
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
											<select class="form-control" name="status_fileReturn">
												<option value="">Tất cả trạng thái</option>
												<option value="1" <?= (!empty($status_fileReturn) && $status_fileReturn == "1") ? "selected" : "" ?>>
													Chờ hội sở xử lý
												</option>
												<option value="2" <?= (!empty($status_fileReturn) && $status_fileReturn == "2") ? "selected" : "" ?>>
													Chờ gửi hồ sơ
												</option>
												<option value="3" <?= (!empty($status_fileReturn) && $status_fileReturn == "3") ? "selected" : "" ?>>
													Đã nhận hồ sơ
												</option>
												<option value="4" <?= (!empty($status_fileReturn) && $status_fileReturn == "4") ? "selected" : "" ?>>
													Chưa nhận được hồ sơ
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
				if (!in_array('quan-ly-ho-so', $groupRoles)) {
					?>
					<li>
						<button class="btn btn-info" data-toggle="modal" data-target="#addnewModal_yeucaumuonhoso">
							<i class="fa fa-plus" aria-hidden="true"></i>
							Thêm mới
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
								<th>Mã hợp đồng</th>
								<th>Phòng giao dịch</th>
								<th>Thời gian hẹn gửi</th>
								<th>Trạng thái</th>
								<th>Thời gian nhận HS</th>
								<th>Các hồ sơ gửi lên</th>
								<th>Ghi chú</th>
								<th>Hành động</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($file_return)) { ?>
								<?php foreach ($file_return as $key => $value) { ?>
									<tr>
										<td><?php echo ++$key ?></td>
										<td>
											<a href="<?php echo base_url("pawn/detail?id=") . $value->oid->_id->{'$oid'} ?>">
												<?= !empty($value->code_contract_disbursement_text) ? ($value->code_contract_disbursement_text) : "" ?>
											</a>
										</td>
										<td>
											<?= !empty($value->created_by->stores[0]->store_name) ? ($value->created_by->stores[0]->store_name) . (!empty($value->created_by->stores[0]->code_area) ? " - " . $value->created_by->stores[0]->code_area : "") : "" ?>
										</td>
										<td>
											<?= !empty($value->fileReturn_start) ? date("d/m/y", $value->fileReturn_start) : "" ?>
										</td>
										<td>
											<?php if (!empty($value->status)) { ?>
												<?php if ($value->status == 1) { ?>
													<span class="label label-info">  Chờ hội sở xử lý</span>
												<?php } ?>
												<?php if ($value->status == 2) { ?>
													<span class="label label-primary">  Chờ gửi hồ sơ</span>
												<?php } ?>
												<?php if ($value->status == 3) { ?>
													<span class="label label-success">  Đã nhận hồ sơ</span>
												<?php } ?>
												<?php if ($value->status == 4) { ?>
													<span class="label label-danger">  Chưa nhận được hồ sơ</span>
												<?php } ?>
											<?php } ?>
										</td>

										<td>
											<?= !empty($value->receive) ? date("d/m/y", ($value->receive)) : "" ?>
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
													if (in_array('cua-hang-truong', $groupRoles) || in_array('giao-dich-vien', $groupRoles)) {
														?>
														<?php
														if (in_array($value->status, array(1))) { ?>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="editFileReturn('<?= $value->_id->{'$oid'} ?>')">
																	<i class="fa fa-edit"></i> Sửa yêu cầu
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
																   onclick="xu_ly_nhan_ho_so(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-check-square-o"></i> Xử lý nhận hồ
																	sơ
																</a>
															</li>
														<?php } ?>

														<?php
														if (in_array($value->status, array(2, 4))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xac_nhan_da_nhan_hs(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-clone"></i> Xác nhận đã nhận hồ sơ
																</a>
															</li>
														<?php } ?>

														<?php
														if (in_array($value->status, array(2))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="chua_nhan_duoc_ho_so(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : ""; ?>"
																>
																	<i class="fa fa-binoculars"></i> Chưa nhận được hồ sơ
																</a>
															</li>
														<?php } ?>
													<?php } ?>

													<li>
														<a href="javascript:void(0)" data-toggle="modal"
														   onclick="history_fileReturn('<?= $value->_id->{'$oid'} ?>')">
															<i class="fa fa-history"></i> Xem lịch gửi HS
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
					<label class="control-label col-md-3 col-xs-12">Ngày yêu cầu gửi <span
								class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="fileReturn_start">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="submit_fileReturn">Tạo</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
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
				 id="div_errorCreate_1">
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
					<label class="control-label col-md-3 col-xs-12">Ngày yêu cầu gửi: <span
								class="text-danger">*</span>:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyy" id="fileReturn_start_1"
							   name="fileReturn_start_1">
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

<div id="xulynhanhoso" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id_3" value="" name="fileReturn_id_3">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Xử lý nhận hồ sơ</h4>
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
							THÔNG TIN HỒ SƠ GỬI
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
								<div class="col-xs-12 col-md-6">
									<div class="checkbox">
										<label>
											<input type="checkbox" value="Sổ đỏ" name="file_2[]"
												   class="fileCheckBox_2"
												   id="file1_10" disabled> Sổ đỏ
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
							<label class="control-label col-md-3 col-xs-12">Ngày yêu cầu gửi <span
										class="text-danger">*</span>:</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="" class="form-control" placeholder="dd/mm/yyy" id="fileReturn_start_2"
									   name="fileReturn_start_2" disabled>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h4>
							THÔNG TIN XÁC NHẬN
						</h4>
						<div class="form-group">
							<div class="row">

							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Thời gian hẹn gửi <span
										class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="" class="form-control" placeholder="dd/mm/yyyy" id="fileReturn_start_3"
									   name="fileReturn_start_3">
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
					<button type="button" class="btn btn-primary" id="xulynhanhoso_submit">Xác nhận</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm_fileReturn" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
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
					<div id="SomeThing" class="simpleUploader">
						<div class="uploads " id="uploads_fileReturn">

						</div>
						<label for="uploadinput">
							<div class="block uploader">
								<span>+</span>
							</div>
						</label>
						<input id="uploadinput" type="file" name="file"
							   data-contain="uploads_fileReturn" data-title="Hồ sơ nhân thân" multiple
							   data-type="fileReturn" class="focus">
					</div>

					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id_1">
						<div style="text-align: center">

							<button type="button" id="fileReturn_confirm" class="btn btn-info">Đồng ý</button>
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
							<button type="button" id="fileReturn_cancel" class="btn btn-info">Đồng ý</button>
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
<!-- Modal -->
<div id="history_fileReturn" class="modal fade" role="dialog">
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
					<tbody id="history_return">
					</tbody>
				</table>
			</div>
			<div class="modal-footer ">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>

<!--<script src="--><?php //echo base_url();?><!--assets/js/pawn/upload_img.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/borrowed/file_return.js"></script>
<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});

</script>

