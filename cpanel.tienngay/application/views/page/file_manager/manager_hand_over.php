<div class="right_col" role="main">

	<?php
	$statusHandOver = !empty($_GET['statusHandOver']) ? $_GET['statusHandOver'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$code = !empty($_GET['code']) ? $_GET['code'] : "";
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
					<h3>QUẢN LÝ BÀN GIAO THIẾT BỊ</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách thiết bị</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">

							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('assetLocation/indexManagerHandOver') ?>"
								  method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<label>Mã hợp đồng: </label>
										<input type="text" name="code_contract_disbursement" class="form-control"
											   value="<?= !empty($code_contract_disbursement) ? $code_contract_disbursement : "" ?>">
									</li>
									<li class="form-group">
										<label>Mã seri định vị: </label>
										<input type="text" name="code" class="form-control"
											   value="<?= !empty($code) ? $code : "" ?>">
									</li>
									<li class="form-group">
										<label>Trạng thái: </label>
										<select class="form-control" name="statusHandOver">
											<option value="">-- Tất cả --</option>
											<option value="1" <?= (1 == $statusHandOver) ? "selected" : "" ?>>Gửi yêu
												cầu
											</option>
											<option value="2" <?= (2 == $statusHandOver) ? "selected" : "" ?>>Xác nhận
												về kho
											</option>

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
								<th style="text-align: center">Mã Seri</th>
								<th style="text-align: center">Số HĐ</th>
								<th style="text-align: center">Biển số xe</th>
								<th style="text-align: center">Tên khách hàng</th>
								<th style="text-align: center">Địa chỉ</th>
								<th style="text-align: center">CVKD</th>
								<th style="text-align: center">PGD</th>
								<th style="text-align: center">Tình Trạng</th>
								<th style="text-align: center">Vị trí</th>
								<th style="text-align: center">Người tạo yêu cầu</th>
								<th style="text-align: center">Chuyển đến kho</th>
								<th style="text-align: center">Ghi chú</th>
								<th style="text-align: center">Hình ảnh</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center"></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($contracts as $key => $contract) : ?>
								<tr style="text-align: center">
									<td><?php echo ++$key ?></td>
									<td>
										<a href="<?php echo base_url("assetLocation/detail?seri=") . $contract->loan_infor->device_asset_location->code ?>"
										   target="_blank"><?php echo $contract->loan_infor->device_asset_location->code ?? "" ?></a>
									</td>
									<td><a href="<?php echo base_url("pawn/detail?id=") . $contract->_id->{'$oid'} ?>"
										   target="_blank"><?php echo $contract->code_contract_disbursement ?></a>
									</td>
									<td><?php echo $contract->property_infor[2]->value ?? "" ?></td>
									<td><?php echo $contract->customer_infor->customer_name ?></td>
									<td>
										<?php echo $contract->current_address->current_stay . '<br>' .
											$contract->current_address->ward_name . '<br>' .
											$contract->current_address->district_name . '<br>' .
											$contract->current_address->province_name
										?>
									</td>
									<td>
										<?php echo $contract->created_by ?>
									</td>
									<td><?php echo $contract->store->name ?></td>
									<td><?php echo contract_status($contract->status) ?></td>
									<td>
										<button class="btn btn-success show-location" data-toggle="modal"
												data-target="#show-location"
												data-imei="<?php echo $contract->loan_infor->device_asset_location->code ?>"
												data-code="<?php echo $contract->code_contract_disbursement ?>"
										>Xem vị trí
										</button>
									</td>
									<td><?php echo $contract->loan_infor->device_asset_location->handOver->created_by ?></td>
									<td><?php echo $contract->loan_infor->device_asset_location->handOver->wareAssetLocationName ?></td>
									<td><?php echo $contract->loan_infor->device_asset_location->handOver->noteHandOver ?></td>
									<td>
										<?php if (!empty($contract->loan_infor->device_asset_location->handOver->handOverImg)): ?>
											<div id="SomeThing" class="simpleUploader">
												<div class="uploads " id="uploads_identify">
													<?php
													$key_identify = 0;
													foreach ((array)$contract->loan_infor->device_asset_location->handOver->handOverImg as $key => $value) {
														$key_identify++;
														if (empty($value)) continue; ?>
														<div class="block"
															 style="width: 100px; height: 100px; margin-bottom: 0px">
															<!--//Image-->
															<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
																<a href="<?= $value->path ?>"
																   class="magnifyitem" data-magnify="gallery"
																   data-src=""
																   data-group="thegallery"
																   data-caption="Hồ sơ nhân thân <?php echo $key_identify ?>">
																	<img class="w-100" src="<?= $value->path ?>" alt="">
																</a>

															<?php } ?>
															<!--Audio-->
															<?php if (!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) { ?>
																<span
																	class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
																<a href="<?= $value->path ?>" target="_blank"><span
																		style="z-index: 9"><?= $value->file_name ?></span>
																	<img
																		style="width: 50%;transform: translateX(50%)translateY(-50%);"
																		src="https://image.flaticon.com/icons/png/512/81/81281.png"
																		alt="">
																</a>

															<?php } ?>
															<!--Video-->
															<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>
																<span
																	class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
																<a href="<?= $value->path ?>" target="_blank"><span
																		style="z-index: 9"><?= $value->file_name ?></span>
																	<img
																		style="width: 50%;transform: translateX(50%)translateY(-50%);"
																		src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																		alt="">
																</a>

															<?php } ?>
														</div>
													<?php } ?>
												</div>
											</div>
										<?php endif; ?>
									</td>
									<td><?php echo status_hand_over($contract->loan_infor->device_asset_location->handOver->statusHandOver) ?></td>
									<td class="text-center">
										<div class="dropdown" style="display:inline-block">
											<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
													data-toggle="dropdown">
												<i class="fa fa-cogs"></i>
												<span class="caret"></span></button>
											<?php
											if (in_array("quan-ly-ho-so", $groupRoles) && $contract->loan_infor->device_asset_location->handOver->statusHandOver == 1) { ?>
												<ul class="dropdown-menu dropdown-menu-right">
													<li>
														<a href="javascript:void(0)"
														   onclick="equipmentHandoverConfirmation(this)"
														   data-code_contract="<?= !empty($contract->code_contract) ? $contract->code_contract : ""; ?>"
														   data-code="<?= !empty($contract->loan_infor->device_asset_location->code) ? $contract->loan_infor->device_asset_location->code : ""; ?>"
														   data-ware="<?= !empty($contract->loan_infor->device_asset_location->handOver->wareAssetLocationName) ? $contract->loan_infor->device_asset_location->handOver->wareAssetLocationName : ""; ?>">
															Xác nhận
														</a>
													</li>
												</ul>
											<?php } ?>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
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

<div class="modal fade" id="show-location" tabindex="-1" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title title_location">Vị trí</h5>
			</div>
			<div class="modal-body body_location">

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
	$(document).ready(function () {
		$('.show-location').click(function () {
			let imei = $(this).attr('data-imei');
			let code = $(this).attr('data-code');

			$.ajax({
				url: _url.base_url + 'assetLocation/location?imei=' + imei,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					if (data.status == 200) {
						$('.title_location').text('')
						$('.body_location').text('')
						$('.title_location').html('Vị trí thiết bị ' + '<span class="text-danger">' + imei + ' - ' + code + '</span>')
						$('.body_location').html('<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDU6vwuTA_eC2NKb0IuDJpa2XmrypkTSvA&q=' + data.data.lat + ',' + data.data.lng + '" width="570" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>')
					} else {
						alert('Không lấy được thông tin')
					}
				},
				error: function (data) {
					alert('Không lấy được thông tin')
				}
			});
		})
	});

	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4", "docx", "pdf", 'doc'],
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

	function equipmentHandoverConfirmation(thiz) {
		let code_contract = $(thiz).data("code_contract");
		let code = $(thiz).data("code");
		let ware = $(thiz).data("ware");

		$("#fileReturn_id").val(code_contract);
		$("#title_cancel").text("Bạn có chắc chắn XÁC NHẬN thiết bị có mã seri " + code + " về kho: " + ware);

		$("#approve_file").modal("show");
	}

	$('#approve_borrow').click(function (event) {
		event.preventDefault();

		$("#approve_file").modal("hide");

		$.ajax({
			url: _url.base_url + 'file_manager/approveHandOver',
			method: "POST",
			dateType: "JSON",
			data: {
				code_contract: $("#fileReturn_id").val(),
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Thành công');
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				}
			},
			error: function (data) {
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

	.simpleUploaderv1 .block img {
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







