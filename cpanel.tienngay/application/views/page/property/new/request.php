<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
		 <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Thêm mới tài sản
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('property/valuation_property') ?>">Tài sản</a>/ <a href="#">Thêm
							mới tài sản</a>
					</small>
				</h3>
			</div>
		</div>
	</div>

	<div class="">
		<div class="x_panel">
			<div class="row col-12">
				<h2>Yêu cầu định giá tài sản</h2>
				<div class="clearfix"></div>

			</div>
			<div class="">
				<form class="form-horizontal form-label-left"
					  action="<?php echo base_url("property/create_request_valuation_property") ?>" method="post"
					  enctype="multipart/form-data">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Loại tài sản <span
										class="red">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control " id="type_xm_oto" name="type_xm_oto">
									<option value="" selected>Chọn loại tài sản</option>
									<option value="XM">Xe máy</option>
									<option value="OTO">Ô tô</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Năm sản xuất <span
										class="red">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name='year_property' id="year_property"
									   class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group phan_khuc_oto_box" hidden>
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phân khúc tài sản
								<span class="red">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="form-control" name="phan_khuc_oto" id="phan_khuc_oto">
									<option value="" selected>Chọn phân khúc</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>

						<div class="form-group type_xm_box">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Loại xe <span class="red">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="type_property_xm" id="type_property_xm" class="form-control">
									<option value="" selected>Chọn loại xe</option>
									<option value="1">Xe ga</option>
									<option value="2">Xe số</option>
									<option value="3">Xe côn</option>
									<option value="4">Lithium</option>
									<option value="5">Ắc quy</option>
								</select>
							</div>
						</div>

						<div class="form-group type_oto_box" hidden>
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Loại xe <span class="red">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="type_property_oto" id="type_property_oto" class="form-control">
									<option value="" selected>Chọn loại xe</option>
									<option value="AT">AT</option>
									<option value="MT">MT</option>
								</select>
							</div>
						</div>

						<div class="form-group made_by_oto_box" hidden>
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Xuất xứ <span class="red">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name='made_in' id="made_in" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group gas_or_oil_oto_box" hidden>
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Bản Xăng/Dầu <span
										class="red">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select id="gas_or_oil" name="gas_or_oil" class="form-control">
									<option value="" selected>Chọn bản</option>
									<option value="Xăng">Xăng</option>
									<option value="Dầu">Dầu</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Hãng xe <span class="red">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name='brand_property' id="brand_property"
									   class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Model <span
										class="red">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name='model_property' class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Nội dung yêu cầu</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea name="description_property" id="" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Giá đề xuất</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name='price_suggest_property' id="price_suggest_property"
									   class="form-control col-md-7 col-xs-12">
							</div>
						</div>

						<div>
							<button type="submit" class="btn btn-primary" id="submit_add_property">Gửi yêu cầu</button>
						</div>
					</div>
					<div class="col-sm-6">
						<div>
							<label class="control-label">Ảnh tài sản (Tối đa 6 ảnh) </label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="uploads_fileReturn1"></div>
								<label for="uploadinput1">
									<div class="block uploader">
										<span>+</span>
									</div>
								</label>
								<input id="uploadinput1" type="file" name="file"
									   data-contain="uploads_fileReturn1" data-title="Ảnh chi tiết " multiple
									   data-type="fileReturn" class="focus">
							</div>
						</div>
						<div>
							<div>
								<label class="control-label">Ảnh đăng ký (2 ảnh) </label>

								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn2"></div>
									<label for="uploadinput2">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput2" type="file" name="file"
										   data-contain="uploads_fileReturn2" data-title="Ảnh đăng ký" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
							<div class="img_dang_kiem_box" hidden>
								<label class="control-label">Ảnh đăng kiểm (2 ảnh)</label>
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn3"></div>
									<label for="uploadinput3">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput3" type="file" name="file"
										   data-contain="uploads_fileReturn3" data-title="Ảnh đăng kiểm" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
							<div>
							</div>
						</div>
					</div>
					<br>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="successModalProperty" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title">Thành công</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<a class="btn btn-primary" style="padding-top: 13px;font-size: 14px"  href="<?= base_url('property/valuation_property') ?>">Quay lại trang danh
						sách</a>
				<a class="btn btn-danger" style="padding-top: 13px;font-size: 14px" href="<?= base_url('property/request_valuation_property') ?>">Ở lại</a>
			</div>
		</div>
	</div>
</div>


<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<style type="text/css">
	.img {
		width: 100px !important;
		height: 100px !important;
	}

</style>
<script>
	$(document).ready(function () {

		$('#price_suggest_property').keyup(function (event) {
			// skip for arrow keys
			if (event.which >= 37 && event.which <= 40) return;
			// format number
			$(this).val(function (index, value) {
				return value
					.replace(/\D/g, "")
					.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
					;
			});
		});

		$(".magnifyitem").magnify({
			initMaximized: true
		});

		$('#type_xm_oto').change(function () {
			if ($(this).val() == 'OTO') {
				$('.type_oto_box').show();
				$('.gas_or_oil_oto_box').show();
				$('.made_by_oto_box').show();
				$('.phan_khuc_oto_box').show();
				$('.type_xm_box').hide();
				$('.img_dang_kiem_box').show();

			} else if ($(this).val() == 'XM') {
				$('.type_oto_box').hide();
				$('.gas_or_oil_oto_box').hide();
				$('.made_by_oto_box').hide();
				$('.phan_khuc_oto_box').hide();
				$('.type_xm_box').show();
				$('.img_dang_kiem_box').hide();
			}
			// else {
			// 	$('.type_oto_box').hide();
			// 	$('.gas_or_oil_oto_box').hide();
			// 	$('.made_by_oto_box').hide();
			// 	$('.phan_khuc_oto_box').hide();
			// }
		})

		$('#submit_add_property').click(function (event) {
			event.preventDefault();
			let type_xm_oto = $("select[name='type_xm_oto']").val()
			let year = $("input[name='year_property']").val()
			let phan_khuc_oto = $("select[name='phan_khuc_oto']").val()
			let type_property_xm = $("select[name='type_property_xm']").val()
			let type_property_oto = $("select[name='type_property_oto']").val()
			let made_in = $("input[name='made_in']").val()
			let gas_or_oil = $("select[name='gas_or_oil']").val()
			let brand_property = $("input[name='brand_property']").val()
			let model_property = $("input[name='model_property']").val()
			let description = $("textarea[name='description_property']").val()
			let price_suggest_property = $("input[name='price_suggest_property']").val()
			var count1 = $("img[name='img_fileReturn1']").length;
			var count2 = $("img[name='img_fileReturn2']").length;
			var count3 = $("img[name='img_fileReturn3']").length;
			var fileReturn_img1 = {};
			var fileReturn_img2 = {};
			var fileReturn_img3 = {};
			if (count1 > 0) {
				$("img[name='img_fileReturn1']").each(function () {
					var data = {};
					type = $(this).data('type');
					data['file_type'] = $(this).attr('data-fileType');
					data['file_name'] = $(this).attr('data-fileName');
					data['path'] = $(this).attr('src');
					data['key'] = $(this).attr('data-key');
					var key = $(this).data('key');
					if (type == 'fileReturn') {
						fileReturn_img1[key] = data;
					}
				});
			}
			if (count2 > 0) {
				$("img[name='img_fileReturn2']").each(function () {
					var data = {};
					type = $(this).data('type');
					data['file_type'] = $(this).attr('data-fileType');
					data['file_name'] = $(this).attr('data-fileName');
					data['path'] = $(this).attr('src');
					data['key'] = $(this).attr('data-key');
					var key = $(this).data('key');
					if (type == 'fileReturn') {
						fileReturn_img2[key] = data;
					}
				});
			}
			if (count3 > 0) {
				$("img[name='img_fileReturn3']").each(function () {
					var data = {};
					type = $(this).data('type');
					data['file_type'] = $(this).attr('data-fileType');
					data['file_name'] = $(this).attr('data-fileName');
					data['path'] = $(this).attr('src');
					data['key'] = $(this).attr('data-key');
					var key = $(this).data('key');
					if (type == 'fileReturn') {
						fileReturn_img3[key] = data;
					}
				});
			}
			let img_tai_san = JSON.stringify(fileReturn_img1)
			let img_giay_to = JSON.stringify(fileReturn_img2)
			let img_dang_kiem = JSON.stringify(fileReturn_img3)
			console.log(fileReturn_img1.length, fileReturn_img2.length, fileReturn_img3.length);
			var formData = new FormData();
			formData.append('type_xm_oto', type_xm_oto);
			formData.append('year_property', year);
			formData.append('phan_khuc_oto', phan_khuc_oto);
			formData.append('type_property_xm', type_property_xm);
			formData.append('type_property_oto', type_property_oto);
			formData.append('made_in', made_in);
			formData.append('gas_or_oil', gas_or_oil);
			formData.append('brand_property', brand_property);
			formData.append('model_property', model_property);
			formData.append('img_tai_san', img_tai_san);
			formData.append('img_giay_to', img_giay_to);
			formData.append('img_dang_kiem', img_dang_kiem);
			formData.append('description', description);
			formData.append('price_suggest', price_suggest_property);
				$.ajax({
					dataType: 'json',
					enctype: 'multipart/form-data',
					url: _url.base_url + 'property/create_request_valuation_property',
					type: 'POST',
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						console.log(data)
						$(".theloading").hide();
						if (data.code == 200) {
							$(".theloading").hide();
							$('#successModalProperty').modal('show');
							$('.msg_success_property').text(data.msg);
							// setTimeout(function () {
							// 	window.location.href = _url.base_url + 'property/request_valuation_property';
							// }, 2000);
						} else {
							$(".theloading").hide();
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
							// setTimeout(function () {
							// 	window.location.href = _url.base_url + 'property/request_valuation_property';
							// }, 2000);
						}
					},
					error: function () {
						$(".theloading").hide();
						console.log('error')
						// setTimeout(function () {
						// 	window.location.href = _url.base_url + 'property/request_valuation_property';
						// }, 2000);
					}
				});
		});
	});


	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$('#uploadinput1').simpleUpload(_url.base_url + "property/upload_img_taisan", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
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
					//Video Mp4
					if (fileType == 'video/mp4') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn1"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn1"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn1"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div class="block1" ></div>').html(content);
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

		$('#uploadinput2').simpleUpload(_url.base_url + "property/upload_img_taisan", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 20000000, //10MB,
			multiple: true,
			limit: 2,
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
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn2"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn2"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn2"  data-key="' + data.key + '" src="' + data.path + '" />';
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

		$('#uploadinput3').simpleUpload(_url.base_url + "property/upload_img_taisan", {
			// 	$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
			//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
			maxFileSize: 20000000, //10MB,
			multiple: true,
			limit: 2,
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
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn3"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_fileReturn3"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_fileReturn3"  data-key="' + data.key + '" src="' + data.path + '" />';
						content += '</a>';
						content += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div class="block1" ></div>').html(content);
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

</script>
