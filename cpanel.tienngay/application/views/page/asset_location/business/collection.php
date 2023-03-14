<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>

<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="container container-xt">
		<div class="wrapper-top">
			<div class="container-top">
				<nav aria-label="breadcrumb">
					<a href="<?php echo base_url() ?>assetLocation/collection"><h3 class="d-inline-block">Quản lý hợp
							đồng
							gắn thiết bị định vị</h3></a>
				</nav>
			</div>
			<!--			<button type="button" class="btn btn-success btn-top">Gọi nhà cung cấp <img class="theavatar"-->
			<!--																						src="-->
			<?php //echo base_url("assets/imgs/ql_xnt/phone.svg") ?><!--"-->
			<!--																						alt=""></button>-->
		</div>
		<div class="panel">
			<div class="form-content">
				<div class="form-text">
					<h5>Danh sách thiết bị</h5>
				</div>
				<div class="form-button">
					<button type="button" class="btn btn-outline-success" data-toggle="modal"
							data-target="#exampleModal">
						Tìm kiếm <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/search.svg") ?>"
									  alt="">
					</button>
					<a type="button" class="btn btn-outline-success"
					   href="<?php echo base_url('assetLocation/excel_collection') . '?store=' . $_GET['store'] ?>"
					   target="_blank">
						Xuất excel <img class="theavatar" src="
					<?php echo base_url("assets/imgs/ql_xnt/excel.svg") ?>"
										alt="">
					</a>
					<!--					<button type="button" class="btn btn-outline-success">-->
					<!--						Import file <img class="theavatar" src="-->
					<?php //echo base_url("assets/imgs/ql_xnt/push.svg") ?><!--"-->
					<!--										 alt="">-->
					<!--					</button>-->
					<!-- Modal -->
					<form method="get" action="<?php echo base_url('assetLocation/collection') ?>">
						<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
							 aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
									</div>
									<div class="modal-body">
										<div class="modal-item">
											<p>Thời gian </p>
											<div class="modal-content11">
												<input placeholder="Từ ngày" class="textbox-n" type="date" name="start"
													   value="<?php echo $_GET['start'] ?? '' ?>">
												<input placeholder="Đến ngày" class="textbox-n" type="date" name="end"
													   value="<?php echo $_GET['end'] ?? '' ?>">
											</div>
										</div>
										<div class="modal-item">
											<p>Mã seri </p>
											<input type="text" placeholder="Nhập seri" name="seri"
												   value="<?php echo $_GET['seri'] ?? '' ?>">
										</div>
										<div class="modal-item">
											<p>Số hợp đồng</p>
											<input type="text" placeholder="Nhập số hợp đồng"
												   name="code_contract_disbursement"
												   value="<?php echo $_GET['code_contract_disbursement'] ?? '' ?>">
										</div>
										<div class="modal-item">
											<p>Biển số xe </p>
											<input type="text" placeholder="Nhập biển số xe" name="license"
												   value="<?php echo $_GET['license'] ?? '' ?>">
										</div>
										<!--										<div class="modal-item">-->
										<!--											<p>Trạng thái </p>-->
										<!--											<select required>-->
										<!--												<option value="" disabled selected hidden>Chọn trạng thái</option>-->
										<!--												<option value="0">Open when powered (most valves do this)</option>-->
										<!--												<option value="1">Closed when powered, auto-opens when power is cut-->
										<!--												</option>-->
										<!--											</select>-->
										<!--										</div>-->
										<div class="modal-item">
											<p>Tên khách hàng </p>
											<input type="text" placeholder="Nhập tên khách hàng" name="customer_name"
												   value="<?php echo $_GET['customer_name'] ?? '' ?>">
										</div>
										<!--										<div class="modal-item">-->
										<!--											<p>Chuyên viên kinh doanh </p>-->
										<!--											<select required>-->
										<!--												<option value="" disabled selected hidden>Chọn chuyên viên kinh doanh-->
										<!--												</option>-->
										<!--												<option value="0">Chuyên viên kinh doanh 1</option>-->
										<!--												<option value="1">Chuyên viên kinh doanh 2</option>-->
										<!--											</select>-->
										<!--										</div>-->

										<div class="modal-item">
											<p>Trạng thái</p>
											<select name="status">
												<option value="">Chọn trạng thái</option>
												<?php foreach (contract_status() as $k => $v): ?>
													<option
														value="<?php echo $k ?>" <?php echo $k == $_GET['status'] ? "selected" : "" ?>><?php echo $v ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="modal-item">
											<p>Phòng giao dịch</p>
											<select name="store">
												<option value="">Chọn PGD</option>
												<?php foreach ($stores as $t => $s): ?>
													<option
														value="<?php echo $t ?>" <?php echo $t == $_GET['store'] ? "selected" : "" ?>><?php echo $s ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="modal-item">
											<input type="hidden" name="location"
												   value="<?php echo $_GET['location'] ?? '' ?>">
										</div>
										<div class="modal-item">
											<input type="hidden" name="alarm"
												   value="<?php echo $_GET['alarm'] ?? '' ?>">
										</div>
										<div class="modal-item">
											<input type="hidden" name="email"
												   value="<?php echo $_GET['email'] ?? '' ?>">
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
										</button>
										<button type="submit" class="btn btn-primary">Tìm kiếm
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="form-table table-responsive">
				<table class="table">
					<thead class="thead-light">
					<tr>
						<th scope="col" style="text-align: center">STT</th>
						<th scope="col" style="text-align: center">Ngày tháng</th>
						<th scope="col" style="text-align: center">Mã Seri</th>
						<th scope="col" style="text-align: center">Số HĐ</th>
						<th scope="col" style="text-align: center">Biển số xe</th>
						<th scope="col" style="text-align: center">Tên khách hàng</th>
						<th scope="col" style="text-align: center">Địa chỉ</th>
						<th scope="col" style="text-align: center">CVKD</th>
						<th scope="col" style="text-align: center">Phòng giao dịch</th>
						<th scope="col" style="text-align: center">Tình trạng</th>
						<th scope="col" style="text-align: center">Ngày trễ</th>
						<th scope="col" style="text-align: center">Nhóm</th>
						<th scope="col" style="text-align: center">Vị trí</th>
						<th scope="col" style="text-align: center"></th>
					</tr>
					</thead>
					<tbody class="tbody-line">
					<?php foreach ($contracts as $key => $contract) : ?>
						<tr style="text-align: center">
							<td><?php echo ++$key ?></td>
							<td><?php echo !empty($contract->disbursement_date) ? date('d/m/Y', $contract->disbursement_date) : "" ?></td>
							<td>
								<a href="<?php echo base_url("assetLocation/detail?seri=") . $contract->loan_infor->device_asset_location->code ?>"
								   target="_blank"><?php echo $contract->loan_infor->device_asset_location->code ?? "" ?></a>
							</td>
							<td><a href="<?php echo base_url("pawn/detail?id=") . $contract->_id ?>"
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
							<td><?php echo !empty($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : '' ?></td>
							<td><?php echo !empty($contract->debt->so_ngay_cham_tra) ? get_bucket($contract->debt->so_ngay_cham_tra) : '' ?></td>
							<td>
								<button class="btn btn-success show-location" data-toggle="modal"
										data-target="#show-location"
										data-imei="<?php echo $contract->loan_infor->device_asset_location->code ?>"
										data-code="<?php echo $contract->code_contract_disbursement ?>"
								>Xem vị trí
								</button>
							</td>
							<td>
								<div class="dropdown">
									<button class="btn btn-secondary dropdown-toggle" type="button"
											id="dropdownMenuButton" data-toggle="dropdown"
											aria-haspopup="true" aria-expanded="false">
										Chức năng
										<span class="caret"></span></button>
									<?php
									if (in_array("tbp-thu-hoi-no", $groupRoles) && $contract->status == 19) { ?>
										<?php if (empty($contract->loan_infor->device_asset_location->handOver) || $contract->loan_infor->device_asset_location->handOver->status == 2): ?>
											<ul class="dropdown-menu" style="z-index: 99999">
												<li>
													<a href="javascript:void(0)" data-toggle="modal"
													   data-seri="<?= $contract->loan_infor->device_asset_location->code ?>"
													   data-code="<?= $contract->code_contract ?>"
													   onclick="equipmentHandover(this)">
														Bàn giao lại thiết bị định vị
													</a>
												</li>
											</ul>
										<?php endif; ?>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<div class="paginate" style="padding-left: 10px;">
					<?php echo $pagination; ?>
				</div>
			</div>
		</div>
	</div>
</div>
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

<?php $this->load->view('page/asset_location/business/modal_update_address'); ?>
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.breadcrumb {
		margin: 0px;
		padding: 0px;
	}

	.container-xt {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 24px;

	}

	.btn-top {
		padding: 8px 16px;
		gap: 8px;
		width: 169px;
		height: 40px;
		background: #1D9752;
	}

	.wrapper-top {
		display: flex;
		justify-content: space-between;
	}

	.container-top h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.container-cart {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 24px
	}

	.content {
		display: flex;
		gap: 16px;
		flex-wrap: wrap;
	}

	.content p {
		font-style: normal;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		color: #676767;
	}

	.content h5 {
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #1D9752;

	}

	.content-cart {
		width: 253.5px;
		height: 80px;
		padding-top: 16px;
		padding-left: 16px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.container-cart h6 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.content-cart-notify {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 16px 24px;
		gap: 8px;
		width: 307.4px;
		height: 64px;
		background: linear-gradient(0deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), #F4CDCD;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 4px;
	}

	.content-cart-notify p {
		margin: 0;
	}

	.content-cart-notify h5 {
		color: #3B3B3B;
	}

	.tbody-line {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: rgba(103, 103, 103, 1);
	}

	/* ------------------- */
	.container-form {
		width: 100%;
		height: 592px;
		background: #FFFFFF;
		border: 1px solid #EBEBEB;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.form-content {
		width: 100%;
		display: flex;
		justify-content: space-between;
		padding: 20px 16px;
	}

	.form-text h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.thead-light {
		background-color: #E8F4ED;
	}

	.thead-light {
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
	}

	/* ------modal-------- */
	.modal-body {
		display: flex;
		flex-direction: column;
		gap: 20px;
	}

	.modal-header h4 {
		text-align: center;
	}

	.modal-item input {
		padding: 16px;
		gap: 8px;
		width: 100%;
		height: 30px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.modal-item select {
		gap: 8px;
		width: 100%;
		height: 35px;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.modal-content11 {
		display: flex;
		gap: 24px;
	}

	@media only screen and (max-width: 1440px) {
		.content p {
			font-size: 12px;
		}
	}
</style>

<div id="equipment_handover" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title get_title"></h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_error">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="code_contract" value="" name="">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Kho điều chuyển: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="wareAssetLocation">
							<?php if (!empty($getWareHouseAssetLocation)): ?>
								<?php foreach ($getWareHouseAssetLocation as $value): ?>
									<option
										id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>"
										value="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>"><?= !empty($value->name) ? $value->name : '' ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú: </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="note"></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_img"></div>
							<label for="uploadinput_2">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_2" type="file" name="file"
								   data-contain="uploads_img" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submitEquipmentHandover">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


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

	function equipmentHandover(thiz) {

		let seri = $(thiz).attr('data-seri');
		let code_contract = $(thiz).attr('data-code')
		$('.get_title').text('Bàn giao lại thiết bị định vị có mã seri: ' + seri)
		$('#code_contract').val(code_contract);
		$('#equipment_handover').modal('show');

	}


	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
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
		if (confirm("Bạn có chắc chắn muốn xóa ?")) {
			$(thiz_).closest("div .block").remove();
			toastr.success('Xóa thành công!');
		}
	}

	$("#submitEquipmentHandover").click(function (event) {
		event.preventDefault();

		var noteHandOver = $("#note").val();
		var count = $("img[name='img_fileReturn']").length;
		var wareAssetLocation = $('#wareAssetLocation').val()
		var wareAssetLocationName = $("#" + wareAssetLocation).text();
		var handOverImg = {};
		if (count > 0) {
			$("img[name='img_fileReturn']").each(function () {
				var data = {};
				type = $(this).data('type');
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				data['key'] = $(this).attr('data-key');
				var key = $(this).data('key');
				if (type == 'fileReturn') {
					handOverImg[key] = data;
				}

			});
		}
		$.ajax({
			url: _url.base_url + 'assetLocation/updateStatusHandOver',
			method: "GET",
			dateType: "JSON",
			data: {
				code_contract: $("#code_contract").val(),
				handOverImg: handOverImg,
				noteHandOver: noteHandOver,
				wareAssetLocation: wareAssetLocation,
				wareAssetLocationName: wareAssetLocationName,
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				console.log(data)
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Thành công');
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();

			}
		});
	});


</script>
