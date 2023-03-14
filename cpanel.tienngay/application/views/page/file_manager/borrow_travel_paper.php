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
					<h3>CẤP GIẤY ĐI ĐƯỜNG</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">
							<?php
							if (!in_array("quan-ly-ho-so", $groupRoles)) { ?>
								<button style="background-color: #5A738E" class="btn btn-info show-hide-total-top-ten"
										data-toggle="modal"
										data-target="#addnewModal_giaydiduong">
									Thêm mới
								</button>
							<?php } ?>



							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('file_manager/search_borrow_travel_paper') ?>" method="get">
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
											<option value="1" <?= (1 == $status) ? "selected" : "" ?>>Cấp giấy đi đường</option>
											<option value="2" <?= (2 == $status) ? "selected" : "" ?>>Xác nhận gửi giấy</option>
											<option value="3" <?= (3 == $status) ? "selected" : "" ?>>Hủy</option>

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
								<th style="text-align: center">Tên KH</th>
								<th style="text-align: center">Mã hợp đồng</th>
								<th style="text-align: center">PGD</th>
								<th style="text-align: center">Thời gian tạo yêu cầu</th>
								<th style="text-align: center">Người tạo yêu cầu</th>
								<th style="text-align: center">Trạng thái</th>
								<?php if ($userSession['is_superadmin'] == 1 || in_array('quan-ly-ho-so', $groupRoles) || in_array('van-hanh', $groupRoles)) : ?>
								<th style="text-align: center">File Upload</th>
								<?php endif; ?>
								<th style="text-align: center">Trạng thái hợp đồng</th>
								<th style="text-align: center">Ghi chú</th>
								<th style="text-align: center"></th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($dataBorrowPaper)): ?>
								<?php foreach ($dataBorrowPaper as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td><?= !empty($value->customer_name) ? $value->customer_name : "" ?></td>
										<td><?= !empty($value->code_contract_disbursement_value) ? $value->code_contract_disbursement_value : "" ?></td>
										<td><?= !empty($value->store->store->name) ? $value->store->store->name : "" ?></td>
										<td style="text-align: center"><?= !empty($value->created_at) ? date("d/m/y H:i:s", $value->created_at) : "" ?></td>
										<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
										<td style="text-align: center">
											<?php if ($value->status == 1) : ?>
												<span class="label label-success"
													  style="font-size: 15px; background-color: #2A3F54; padding: 7px;color: white">Cấp giấy đi đường</span>
											<?php elseif ($value->status == 3) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #f2f2f2; padding: 7px; color: #828282">Hủy</span>
											<?php elseif ($value->status == 2) : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #199bdc">Xác nhận gửi giấy</span>
											<?php endif; ?>
										</td>

										<?php if ($userSession['is_superadmin'] == 1 || in_array('quan-ly-ho-so', $groupRoles) || in_array('van-hanh', $groupRoles)) : ?>
										<td style="text-align: center">
											<?php if (!empty($value->fileReturn)) : ?>
												<div id="SomeThing" class="simpleUploader simpleUploaderv1">
													<div class="uploads " id="uploads_identify">
														<?php
														$key_identify = 0;
														foreach ((array)$value->fileReturn as $key_1 => $item) {
															$key_identify++;
															if (empty($item)) continue; ?>
															<div class="block">
																<!--Video-->
																<?php if (!empty($item->file_type) && ($item->file_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')) { ?>
																	<a href="<?= $item->path ?>" target="_blank">
																		<img
																			style="transform: unset;"
																			src="https://icon-library.com/images/docx-icon/docx-icon-10.jpg"
																			alt="">
																		<span
																			style="z-index: 9"><?= $item->file_name ?></span>
																	</a>
																<?php } ?>
															</div>
														<?php } ?>
													</div>
												</div>
											<?php elseif (!empty($value->link_docx_file)) : ?>
													<div class="block">
														<a href="<?= $value->link_docx_file ?? '' ?>" target="_blank">
															<img
																	style="transform: unset; width: 18px;"
																	src="https://icon-library.com/images/docx-icon/docx-icon-10.jpg"
																	alt="">
															<span style="z-index: 9"><?php echo 'Giấy đi đường ' . $value->customer_name . '.docx' ;?></span>
														</a>
													</div>
												<?php endif; ?>
										</td>
										<?php endif; ?>

										<?php if ($value->status_hd == 19): ?>
											<td style="font-weight: bold; color: red">
												<?= !empty($value->status_hd) ? contract_status($value->status_hd) : "" ?>
											</td>
										<?php else: ?>
											<td style="font-weight: bold; color: green">
												<?= !empty($value->status_hd) ? contract_status($value->status_hd) : "" ?>
											</td>
										<?php endif; ?>
										<td><?= !empty($value->note) ? $value->note : "" ?></td>
										<td class="text-center">
											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													<i class="fa fa-cogs"></i>
													<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">

													<?php
													if (in_array("quan-ly-ho-so", $groupRoles)) { ?>
														<?php
														if ($value->status == 1) { ?>
															<li>
																<a href="javascript:void(0)"
																   onclick="xac_nhan_gui_giay_di_duong(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_value) ? $value->code_contract_disbursement_value : ""; ?>">
																	Xác nhận
																</a>
															</li>
															<li>
																<a href="javascript:void(0)"
																   onclick="huy_yeu_cau(this)"
																   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>"
																   data-mhd="<?= !empty($value->code_contract_disbursement_value) ? $value->code_contract_disbursement_value : ""; ?>">
																	Hủy
																</a>
															</li>
														<?php } ?>

													<?php } ?>
													<li>
														<a href="<?php echo base_url("pawn/detail?id=") . $value->store->_id->{'$oid'} ?>"
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
<div id="addnewModal_giaydiduong" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title" style="text-align: center">Gửi Yêu Cầu Cấp Giấy Đi Đường</h3>
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
											value="<?= $obj->code_contract_disbursement_text ?>"><?= $obj->code_contract_disbursement_text ?></option>
								<?php }
							} ?>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Lưu ý: </label>
					<div class="col-md-9 col-sm-9 col-xs-12" style="font-size: 16px;">
						<p><i>Từ bản cập nhật này, sau khi Hồ sơ được gửi về HO và Lưu kho</i></p>
						<p><i>Phòng giao dịch không cần tự soạn <span style="color: red;">giấy đi đường</span>, chỉ cần "Chọn mã hợp đồng" và "Xác nhận"</i></p>
					</div>
				</div>
			</div>



			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_giaydiduong">Xác nhận</button>
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
				<h3 class="modal-title" style="text-align: center" id="title_cancel"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="approve_borrow" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="cancel_file" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_cancel_huy"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id_huy">
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="note_return_paper"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
							<button type="button" id="cancel_borrow" class="btn btn-success">Xác nhận</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script>
	$('#code_contract_disbursement').selectize({
		create: false,
		valueField: 'name',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});


	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4","docx","pdf",'doc'],
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
					console.log(data)
					console.log(fileType)
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);

					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//docx
					else if (fileType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://icon-library.com/images/docx-icon/docx-icon-10.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}

					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn"  data-key="' + data.key + '" src="' + data.path + '" />';
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

	function deleteImage(thiz) {
		var thiz_ = $(thiz);
		var key = $(thiz).data("key");
		var type = $(thiz).data("type");
		var id = $(thiz).data("id");
		// var res = confirm("Bạn có chắc chắn muốn xóa");
		if (confirm("Bạn có chắc chắn muốn xóa ?")) {
			$(thiz_).closest("div .block").remove();
		}
	}

	$("#submit_giaydiduong").click(function (event) {
		event.preventDefault();
		let code_contract_disbursement_value = $('#code_contract_disbursement').val();
		if (code_contract_disbursement_value == null){
			$("#div_errorCreate").css("display", "block");
			$(".div_errorCreate").text("Vui lòng chọn mã hợp đồng");

			setTimeout(function () {
				$("#div_errorCreate").css("display", "none");
			}, 3000);
		}
		$.ajax({
			url: _url.base_url + '/file_manager/create_borrow_travel_paper',
			method: "POST",
			data: {
				code_contract_disbursement_value: code_contract_disbursement_value[0]
			},

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Thêm mới thành công');
					sessionStorage.clear()
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				} else {

					$("#div_errorCreate").css("display", "block");
					$(".div_errorCreate").text(data.data.message);

					setTimeout(function () {
						$("#div_errorCreate").css("display", "none");
					}, 4000);
				}
			},
			error: function (data) {
				console.log("xxx");
				$(".theloading").hide();
			}
		});
	});


	function xac_nhan_gui_giay_di_duong(thiz) {
		let fileReturn_id = $(thiz).data("id");
		let fileReturn_mhd = $(thiz).data("mhd");

		$("#fileReturn_id").val(fileReturn_id);
		$("#title_cancel").text("Bạn có chắc chắn XÁC NHẬN yêu cầu hợp đồng " + fileReturn_mhd);

		$("#approve_file").modal("show");
	}

	function huy_yeu_cau(thiz) {
		let fileReturn_id = $(thiz).data("id");
		let fileReturn_mhd = $(thiz).data("mhd");

		$("#fileReturn_id_huy").val(fileReturn_id);
		$("#title_cancel_huy").text("Hủy yêu cầu cấp giấy đi đường: " + fileReturn_mhd);

		$("#cancel_file").modal("show");
	}



	$('#approve_borrow').click(function (event) {
		event.preventDefault();

		var fileReturn_id = $('#fileReturn_id').val();

		var formData = new FormData();
		formData.append('fileReturn_id', fileReturn_id);

		$("#approve_file").modal("hide");

		$.ajax({
			url: _url.base_url + 'file_manager/approve_borrow_travel_paper',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();

				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					window.location.reload();
				}, 3000);
			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});

	});

	$('#cancel_borrow').click(function (event) {
		event.preventDefault();

		var fileReturn_id = $('#fileReturn_id_huy').val();
		var note_return_paper = $('#note_return_paper').val();

		var formData = new FormData();
		formData.append('fileReturn_id', fileReturn_id);
		formData.append('note_return_paper', note_return_paper);

		$("#approve_file").modal("hide");

		$.ajax({
			url: _url.base_url + 'file_manager/cancel_borrow_travel_paper',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();

				$("#successModal").modal("show");
				$(".msg_success").text('Thành công');
				setTimeout(function () {
					window.location.reload();
				}, 3000);
			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});

	});


</script>
<style type="text/css">
	.simpleUploaderv1 .block {
		position: relative;
		display: block;
		vertical-align: top;
		width: auto;
		height: auto;
		margin-right: 0px;
		margin-bottom: 0;
		background-color: white;
		border: unset;
		/* overflow: hidden; */
	}
	.simpleUploaderv1 .block img{
		position: unset;
		width: 5%;
	}
	.simpleUploaderv1 {
		 background-color: #fff;
		 padding: 0px;
		 padding-right: 0px;
		 margin-bottom: 0px;
		text-align: left;
	}
</style>







