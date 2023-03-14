<!-- page content -->

<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

	$status_sendFile = !empty($_GET['status_sendFile']) ? $_GET['status_sendFile'] : "";
	?>
	<div class="row table-responsive">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>HCNS Gửi Văn Phòng Phẩm</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>

							<div class="dropdown" style="display:inline-block">
								<button class="btn btn-success dropdown-toggle"
										onclick="$('#lockdulieu').toggleClass('show');">
									<span class="fa fa-filter"></span>
									Lọc dữ liệu
								</button>
								<form action="<?php echo base_url('borrowed/search_sendFile') ?>" method="get">
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
											<select class="form-control" name="status_sendFile">
												<option value="">Tất cả trạng thái</option>
												<option value="1" <?= (!empty($status_sendFile) && $status_sendFile == "1") ? "selected" : "" ?>>
													Chờ xác nhận
												</option>
												<option value="2" <?= (!empty($status_sendFile) && $status_sendFile == "2") ? "selected" : "" ?>>
													Đã nhận
												</option>
												<option value="3" <?= (!empty($status_sendFile) && $status_sendFile == "3") ? "selected" : "" ?>>
													Hủy
												</option>
												<option value="4" <?= (!empty($status_sendFile) && $status_sendFile == "4") ? "selected" : "" ?>>
													Chưa nhận Vpp
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
				if (in_array('hanh-chinh', $groupRoles)) {
					?>
					<li>
						<button class="btn btn-info" data-toggle="modal" data-target="#addnewModal_send_file">
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
					<div class="col-xs-12">
						<!-- start project list -->
						<table class="table table-bordered m-table table-hover table-calendar table-report stacktable table-quanlytaisan">
							<thead style="background:#3f86c3; color: #ffffff;">
							<tr>
								<th style="width: 1%">#</th>
								<th>Thời gian gửi</th>
								<th>Thời gian dự kiến nhận</th>
								<th>Phòng ban</th>
								<th>Trạng thái</th>
								<th>Thời gian nhận thực tế</th>
								<th>Văn phòng phẩm gửi đi</th>
								<th>Công cụ gửi đi</th>
								<th>Ghi chú</th>
								<th>Hành động</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($sendFile)) { ?>
								<?php foreach ($sendFile as $key => $value) { ?>
									<tr>
										<td><?php echo ++$key ?></td>
										<td><?= !empty($value->send_start) ? date("d/m/y", $value->send_start) : "" ?></td>
										<td><?= !empty($value->send_end) ? date("d/m/y", $value->send_end) : "" ?></td>
										<td>
											<?php if (!empty($value->store_name)): ?>
												<?php foreach ($value->store_name as $store): ?>

													<div href="#"><?php echo $store ?></div>

												<?php endforeach; ?>
											<?php endif; ?>
										</td>
										<td>
											<?php if (!empty($value->status)) { ?>
												<?php if ($value->status == 1) { ?>
													<span class="label label-info" style="font-size: 100%">  Chờ xác nhận</span>
												<?php } elseif ($value->status == 2) { ?>
													<span class="label label-success"
														  style="font-size: 100%">  Đã nhận</span>
												<?php } elseif ($value->status == 3) { ?>
													<span class="label label-danger"
														  style="font-size: 100%">  Hủy</span>
												<?php } elseif ($value->status == 4) { ?>
													<span class="label label-warning"
														  style="font-size: 100%">  Chưa nhận Vpp</span>
												<?php } ?>
											<?php } ?>
										</td>
										<td><?= !empty($value->return_time) ? date("d/m/y", $value->return_time) : "" ?></td>
										<td>
											<?php if (!empty($value->van_phong_pham_value[0])): ?>
												<?php foreach ($value->van_phong_pham_value[0] as $van_phong_pham): ?>
													<div href="#"><?php echo $van_phong_pham ?></div>
												<?php endforeach; ?>
											<?php endif; ?>
										</td>
										<td>
											<?php if (!empty($value->cong_cu_value[0])): ?>
												<?php foreach ($value->cong_cu_value[0] as $cong_cu): ?>
													<div href="#"><?php echo $cong_cu ?></div>
												<?php endforeach; ?>
											<?php endif; ?>
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
													if (in_array('hanh-chinh', $groupRoles)) {
														?>

														<?php
														if (in_array($value->status, array(1))) { ?>
															<li>
																<a href="javascript:void(0)" data-toggle="modal"
																   onclick="editSendFile('<?= $value->_id->{'$oid'} ?>')">
																	<i class="fa fa-edit"></i> Sửa
																</a>
															</li>
														<?php } ?>

														<?php
														if (in_array($value->status, array(1))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>">
																	<i class="fa fa-window-close-o"></i> Hủy
																</a>
															</li>
														<?php } ?>
													<?php } else { ?>
														<?php
														if (in_array($value->status, array(1))) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xac_nhan_da_nhan_vpp(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>">
																	<i class="fa fa-clone"></i> Xác nhận đã nhận vpp
																</a>
															</li>
														<?php } ?>
													<?php } ?>
													<li>
														<a href="javascript:void(0)" data-toggle="modal"
														   onclick="history_sendFile('<?= $value->_id->{'$oid'} ?>')">
															<i class="fa fa-history"></i> Xem lịch sử
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
<div id="addnewModal_send_file" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
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
					<label class="control-label col-md-2 col-sm-2 col-xs-12">
						PGD nhận
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<select class="form-control" id="store_take" name="store_take[]"
								multiple="multiple">

							<?php
							foreach ($stores as $key => $value) {
								if ($value->status != 'active')
									continue;
								?>
								<option value="<?= !empty($value->slug) ? $value->slug : "" ?>"><?= !empty($value->name) ? $value->name : "" ?></option>
							<?php } ?>


						</select>
						<input id="store_take_value" style="display: none">
					</div>
				</div>


				<div class="form-group row">
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-4 col-sm-4 col-xs-12 text-nowrap">
							VPP gửi đi :
						</label>
						<div class="col-md-8 col-xs-12">
							<select class="form-control" id="van_phong_pham" name="van_phong_pham[]"
									multiple="multiple">
								<option value="Dập ghim 10 plus">Dập ghim 10 plus</option>
								<option value="Ruột ghim">Ruột ghim</option>
								<option value="Giấy nhớ 3x3">Giấy nhớ 3x3</option>
								<option value="Kẹp bướm nhỏ 19mm">Kẹp bướm nhỏ 19mm</option>
								<option value="Bút nhớ Steadler 364">Bút nhớ Steadler 364</option>
								<option value="Sổ tay A5">Sổ tay A5</option>
								<option value="Giá đựng tài liệu">Giá đựng tài liệu</option>
								<option value="Hộp đựng bút">Hộp đựng bút</option>
								<option value="Giấy in A4">Giấy in A4</option>
								<option value="Sơ mi lỗ">Sơ mi lỗ</option>
							</select>
							<input id="van_phong_pham_value" style="display: none">
						</div>
					</div>
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-3 col-sm-3 col-xs-12 text-nowrap">
							Công cụ gửi đi :
						</label>
						<div class="col-md-9 col-xs-12">
							<select class="form-control" id="cong_cu" name="cong_cu[]"
									multiple="multiple">
								<option value="Chổi lau nhà 360">Chổi lau nhà 360</option>
								<option value="Chổi quét nhà loại dày">Chổi quét nhà loại dày</option>
								<option value="Cốc uống nước">Cốc uống nước</option>
								<option value="Khăn lau bàn">Khăn lau bàn</option>
								<option value="Xịt kính">Xịt kính</option>
								<option value="Thảm lau chân to">Thảm lau chân to</option>
								<option value="Thùng đựng rác">Thùng đựng rác</option>
								<option value="Nước lau sàn">Nước lau sàn</option>
								<option value="Nước tẩy bồn cầu">Nước tẩy bồn cầu</option>
								<option value="Khóa chữ U">Khóa chữ U (Khóa cửa kính)</option>
								<option value="Cọ bồn cầu">Cọ bồn cầu</option>
								<option value="Hót rác cán dài">Hót rác cán dài</option>
							</select>
							<input id="cong_cu_value" style="display: none">
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-4 col-xs-12 text-nowrap">Ngày gửi VPP <span
									class="text-danger">*</span>:</label>
						<div class="col-md-8 col-xs-12">
							<input type="" class="form-control" placeholder="dd/mm/yyyy" id="send_start">
						</div>
					</div>
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-3 col-xs-12 text-nowrap">Ngày dự kiến nhận <span
									class="text-danger">*</span></label>
						<div class="col-md-9 col-xs-12">
							<input type="" class="form-control" placeholder="dd/mm/yyyy" id="send_end">
						</div>


					</div>

				</div>
				<br>


				<div class="row">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">
						Ghi chú:
					</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<textarea class="form-control" name="note" id="note" rows="5" cols="80"></textarea>
					</div>
				</div>

				<br>

				<div class="form-group row">
					<label class="control-label col-md-2 col-xs-12">Upload hình ảnh liên quan: </label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads " id="uploads_send_file">

							</div>
							<label for="uploadinput">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput" type="file" name="file"
								   data-contain="uploads_send_file" data-title="Ảnh liên quan" multiple
								   data-type="send_file" class="focus">
						</div>
					</div>

				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="submit_send_file">Tạo</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="editModal_send_file" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">SỬA</h4>
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
			<input id="sendFile" name="sendFile" type="hidden">
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">
						PGD nhận
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<select class="form-control" id="store_take_1" name="store_take_1[]"
								multiple="multiple" disabled>

							<?php
							foreach ($stores as $key => $value) {
								if ($value->status != 'active')
									continue;
								?>
								<option value="<?= !empty($value->slug) ? $value->slug : "" ?>"><?= !empty($value->name) ? $value->name : "" ?></option>
							<?php } ?>


						</select>
						<input id="store_take_value_1" style="display: none">
					</div>
				</div>


				<div class="form-group row">
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-4 col-sm-4 col-xs-12 text-nowrap">
							VPP gửi đi :
						</label>
						<div class="col-md-8 col-xs-12">
							<select class="form-control" id="van_phong_pham_1" name="van_phong_pham_1[]"
									multiple="multiple">
								<option value="Dập ghim 10 plus">Dập ghim 10 plus</option>
								<option value="Ruột ghim">Ruột ghim</option>
								<option value="Giấy nhớ 3x3">Giấy nhớ 3x3</option>
								<option value="Kẹp bướm nhỏ 19mm">Kẹp bướm nhỏ 19mm</option>
								<option value="Bút nhớ Steadler 364">Bút nhớ Steadler 364</option>
								<option value="Sổ tay A5">Sổ tay A5</option>
								<option value="Giá đựng tài liệu">Giá đựng tài liệu</option>
								<option value="Hộp đựng bút">Hộp đựng bút</option>
								<option value="Giấy in A4">Giấy in A4</option>
								<option value="Sơ mi lỗ">Sơ mi lỗ</option>
							</select>
							<input id="van_phong_pham_value_1" style="display: none">
						</div>
					</div>
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-3 col-sm-3 col-xs-12 text-nowrap">
							Công cụ gửi đi :
						</label>
						<div class="col-md-9 col-xs-12">
							<select class="form-control" id="cong_cu_1" name="cong_cu_1[]"
									multiple="multiple">
								<option value="Chổi lau nhà 360">Chổi lau nhà 360</option>
								<option value="Chổi quét nhà loại dày">Chổi quét nhà loại dày</option>
								<option value="Cốc uống nước">Cốc uống nước</option>
								<option value="Khăn lau bàn">Khăn lau bàn</option>
								<option value="Xịt kính">Xịt kính</option>
								<option value="Thảm lau chân to">Thảm lau chân to</option>
								<option value="Thùng đựng rác">Thùng đựng rác</option>
								<option value="Nước lau sàn">Nước lau sàn</option>
								<option value="Nước tẩy bồn cầu">Nước tẩy bồn cầu</option>
								<option value="Khóa chữ U">Khóa chữ U (Khóa cửa kính)</option>
								<option value="Cọ bồn cầu">Cọ bồn cầu</option>
								<option value="Hót rác cán dài">Hót rác cán dài</option>
							</select>
							<input id="cong_cu_value_1" style="display: none">
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-4 col-xs-12 text-nowrap">Ngày gửi VPP <span
									class="text-danger">*</span>:</label>
						<div class="col-md-8 col-xs-12">
							<input type="" class="form-control" placeholder="dd/mm/yyyy" id="send_start_1"
								   name="send_start_1">
						</div>
					</div>
					<div class="col-md-6 col-xs-12 p-0">
						<label class="control-label col-md-3 col-xs-12 text-nowrap">Ngày dự kiến nhận <span
									class="text-danger">*</span></label>
						<div class="col-md-9 col-xs-12">
							<input type="" class="form-control" placeholder="dd/mm/yyyy" id="send_end_1"
								   name="send_end_1">
						</div>


					</div>

				</div>
				<br>


				<div class="row">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">
						Ghi chú:
					</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<textarea class="form-control" name="note_1" id="note_1" rows="5" cols="80"></textarea>
					</div>
				</div>

				<br>

				<div class="form-group row">
					<label class="control-label col-md-2 col-xs-12">Upload hình ảnh liên quan: </label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads " id="uploads_send_file_1">

							</div>
							<label for="uploadinput_1">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_1" type="file" name="file"
								   data-contain="uploads_send_file_1" data-title="Ảnh liên quan" multiple
								   data-type="send_file" class="focus">
						</div>
					</div>

				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="edit_send_file">Sửa</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->

<div class="modal fade" id="confirm_sendFile" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
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
						<div class="uploads" id="uploads_sendFile_2">

						</div>
						<label for="uploadinput_2">
							<div class="block uploader">
								<span>+</span>
							</div>
						</label>
						<input id="uploadinput_2" type="file" name="file"
							   data-contain="uploads_sendFile_2" data-title="Hồ sơ nhân thân" multiple
							   data-type="sendFile" class="focus">
					</div>

					<div class="col-xs-12">
						<input type="hidden" id="sendFile_id">
						<div style="text-align: center">

							<button type="button" id="sendFile_confirm" class="btn btn-info">Đồng ý</button>
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

<div class="modal fade" id="cancel_sendFile" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
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
						<input type="hidden" id="sendFile_id_1">
						<div style="text-align: center">
							<button type="button" id="sendFile_cancel" class="btn btn-info">Đồng ý</button>
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
<div id="history_sendFile" class="modal fade" role="dialog">
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
						<th scope="col">Danh sách vpp</th>
						<th scope="col">Danh sách công cụ</th>
						<th scope="col">Ảnh</th>
					</tr>
					</thead>
					<tbody id="history_sendFile_1">
					</tbody>
				</table>
			</div>
			<div class="modal-footer ">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>assets/js/borrowed/send_file.js"></script>
<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>
