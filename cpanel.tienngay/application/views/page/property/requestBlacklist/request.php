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
		<?php $code_property = !empty($_POST['property_blacklist']) ? $_POST['property_blacklist'] : '' ;?>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Tạo yêu cầu
				</h3>
			</div>
		</div>
	</div>

	<div class="">
		<div class="x_panel">
			<div class="row col-xs-12">
				<h2>Tạo yêu cầu check thật/giả đăng ký/cavet xe</h2>
				<div class="clearfix"></div>

			</div>
			<div class="">
				<form class="form-horizontal form-label-left"
					  action="" method="post"
					  enctype="multipart/form-data">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Loại tài sản <span
											class="red">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control " id="property_blacklist" name="property_blacklist" onchange="get_property_infor(this);">
										<option value="">Chọn loại tài sản</option>
										<?php foreach ($mainPropertyData as $property) :
											if (in_array($property->code, ['TC','NĐ'])) continue;
											?>
											<option <?php echo $code_property == $property->code ? 'selected' : ''; ?>
													value="<?= !empty($property->code) ? $property->code : '' ?>">
												<?= !empty($property->name) ? $property->name : '' ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hãng xe<span
											class="red">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control" id="selectize_property_by_main">
										<option></option>
									</select>
								</div>
							</div>
							<div style="padding-left: 200px; padding-top: 30px">
								<button type="submit" class="btn btn-primary" id="submit_add_blacklist">Thêm mới
								</button>
								<a style="margin-left: 10px" class="btn btn-danger" href="<?= base_url('property/requestBlacklist') ?>">Quay
									lại</a>
							</div>
						</div>
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Ảnh đăng ký xe/cavet (Mặt trước) <span class="text-danger">*</span> </label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="img_front_append"></div>
								<div class="block_unique">
									<label for="img_front_input">
										<div class="block uploader img_front_append sigle_image">
											<span>+</span>
										</div>
									</label>
									<input id="img_front_input"
										   type="file"
										   name="file"
										   data-inputname="check_registrator"
										   data-unique="unique"
										   data-contain="img_front_append"
										   data-title="Ảnh đăng ký xe mặt trước"
										   data-type="front_registry" class="focus" onchange="upload_file_to_service(this)">
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Ảnh đăng ký xe/cavet (Mặt sau) <span class="text-danger">*</span> </label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="img_back_append"></div>
								<div class="block_unique">
									<label for="img_back_input">
										<div class="block uploader img_back_append sigle_image">
											<span>+</span>
										</div>
									</label>
									<input id="img_back_input"
										   type="file"
										   name="file"
										   data-inputname="check_registrator"
										   data-unique="unique"
										   data-contain="img_back_append"
										   data-title="Ảnh đăng ký xe mặt sau"
										   data-type="back_registry" class="focus" onchange="upload_file_to_service(this)">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6"></div>
						<div class="col-xs-12 col-md-3 img_dang_kiem_box" hidden>
							<label class="control-label">Ảnh đăng kiểm xe (Mặt trước) <span class="text-danger">*</span> </label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="img_sub_front_append"></div>
								<div class="block_unique">
									<label for="img_sub_front_input">
										<div class="block uploader img_sub_front_append sigle_image">
											<span>+</span>
										</div>
									</label>
									<input id="img_sub_front_input"
										   type="file"
										   name="file"
										   data-inputname="check_registrator"
										   data-unique="unique"
										   data-contain="img_sub_front_append"
										   data-title="Ảnh đăng kiểm xe mặt trước"
										   data-type="front_regis" class="focus" onchange="upload_file_to_service(this)">
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-3 img_dang_kiem_box" hidden>
							<label class="control-label">Ảnh đăng kiểm xe (Mặt sau) <span class="text-danger">*</span> </label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="img_sub_back_append"></div>
								<div class="block_unique">
									<label for="img_sub_back_input">
										<div class="block uploader img_sub_back_append sigle_image">
											<span>+</span>
										</div>
									</label>
									<input id="img_sub_back_input"
										   type="file"
										   name="file"
										   data-inputname="check_registrator"
										   data-unique="unique"
										   data-contain="img_sub_back_append"
										   data-title="Ảnh đăng kiểm xe mặt sau"
										   data-type="back_regis" class="focus" onchange="upload_file_to_service(this)">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6"></div>
						<div class="col-xs-12 col-md-6">
							<label class="control-label">Ảnh khác</label>
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="img_anothers"></div>
								<label for="img_another">
									<div class="block uploader">
										<span>+</span>
									</div>
								</label>
								<input id="img_another"
									   type="file"
									   name="file"
									   data-inputname="check_registrator"
									   data-unique="multiple"
									   data-contain="img_anothers"
									   data-title="Ảnh khác" multiple
									   data-type="img_another" class="focus" onchange="upload_file_to_service(this)">
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
				<a class="btn btn-primary" style="padding-top: 13px;font-size: 14px"
				   href="<?= base_url('property/valuation_property') ?>">Quay lại trang danh
					sách</a>
				<a class="btn btn-danger" style="padding-top: 13px;font-size: 14px"
				   href="<?= base_url('property/request_valuation_property') ?>">Ở lại</a>
			</div>
		</div>
	</div>
</div>


<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/upload_global/index.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<style type="text/css">
	.img {
		width: 100px !important;
		height: 100px !important;
	}

	.magnify-footer {
		bottom: 0%
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

		$('#property_blacklist').change(function (event) {
			event.preventDefault();
			if ($(this).val() == 'OTO') {
				$('.img_dang_kiem_box').show();
			}else{
				$('.img_dang_kiem_box').hide();
			}
		})


		$('#submit_add_blacklist').click(function (event) {
			event.preventDefault();
			let type_xm_oto = $("select[name='property_blacklist']").val()
			let property_id = $("#selectize_property_by_main").val()
			let count_img = $("img[name='check_registrator']").length;
			let front_registration_img = "";
			let back_registration_img = "";
			let front_regis_car_img = "";
			let back_regis_car_img = "";
			let another_img = {};
			if (count_img > 0) {
				$("img[name='check_registrator']").each(function () {
					let data_single_img = "";
					let data_multiple_img = {};
					let key = $(this).attr('data-key');
						type = $(this).data('type');
						data_single_img = $(this).attr('src');
						data_multiple_img['file_type'] = $(this).attr('data-filetype');
						data_multiple_img['file_name'] = $(this).attr('data-filename');
						data_multiple_img['path'] = $(this).attr('src');
						data_multiple_img['key'] = key;
					if (type == 'front_registry') {
						front_registration_img = data_single_img;
					}
					if (type == 'back_registry') {
						back_registration_img = data_single_img;
					}
					if (type == 'front_regis') {
						front_regis_car_img = data_single_img;
					}
					if (type == 'back_regis') {
						back_regis_car_img = data_single_img;
					}
					if (type == 'img_another') {
						another_img[key] = data_multiple_img;
					}
				});
			}
			let another_img_file = JSON.stringify(another_img)
			let formData = new FormData();
			formData.append('type_xm_oto', type_xm_oto);
			formData.append('property_id', property_id);
			formData.append('front_registration_img', front_registration_img);
			formData.append('back_registration_img', back_registration_img);
			formData.append('front_regis_car_img', front_regis_car_img);
			formData.append('back_regis_car_img', back_regis_car_img);
			formData.append('another_img_file', another_img_file);
			$.ajax({
				dataType: 'json',
				enctype: 'multipart/form-data',
				url: _url.base_url + 'property/requestBlacklistSave',
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
						$('#successModal').modal('show');
						setTimeout(function () {
							window.location.href = _url.base_url + 'property/requestBlacklist';
						}, 2000);
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

</script>


