<!-- page content -->
<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<?php
$contract_id = !empty($_GET['id']) ? $_GET['id'] : "";
?>
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $this->lang->line('update_img_authentication') ?>
					<br>
				</h3>
			</div>
			<div class="title_right text-right">
				<a href="<?php echo base_url('contract_ksnb/index_list_contract_ksnb') ?>" class="btn btn-info ">
					<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
				</a>
				<button style="float: right;" type="button" class="btn btn-info submit_contract_img">Save</button>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<input type="hidden" id="contract_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>">

			<!--Start expertise-->
			<div class="x_content">
				<form class="form-horizontal form-label-left">
					<div class="form-group ">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Upload chứng từ <span
									class="red">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="uploads_expertise">
									<?php
									if (!empty($result)) {
										foreach ((array)$result as $key => $value) {
											if (empty($value)) continue;
											?>
											<div class="block">
												<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
													<a href="<?= $value->path ?>" class="magnifyitem"
													   data-magnify="gallery" data-src="" data-group="thegallery"
													   data-toggle="lightbox" data-gallery="uploads_expertise"
													   data-max-width="992" data-type="image">
														<img name="img_contract_ksnb" data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' src="<?= $value->path ?>" alt="">
													</a>
												<?php } ?>
												<!--Audio-->
												<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);"
															 src="https://image.flaticon.com/icons/png/512/81/81281.png"
															 alt="">
														<img style="display:none" name="img_contract_ksnb"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
													<!--                                                <audio controls>
                                                        <source src="<?= $value->path ?>" type="audio/mpeg">
                                                        <?= $value->file_name ?>
                                                    </audio>-->
												<?php } ?>
												<!--Video-->
												<?php if ($value->file_type == 'video/mp4') { ?>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);"
															 src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
															 alt="">
														<img style="display:none" name="img_contract_ksnb"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='expertise' class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
													<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path ?>" type="video/mp4">
                                                        <?= $value->file_name ?>
                                                    </video>-->
												<?php } ?>
												<button type="button" onclick="deleteImage(this)"
														data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
														data-type="expertise" data-key='<?= $key ?>'
														class="cancelButton "><i class="fa fa-times-circle"></i>
												</button>

											</div>
										<?php }
									} ?>
								</div>
								<label for="upload_expertise">
									<div class="block uploader">
										<span>+</span>
									</div>
								</label>
								<input id="upload_expertise" type="file" name="file" data-contain="uploads_expertise"
									   multiple data-type="expertise" class="focus">
							</div>
						</div>
					</div>
				</form>
			</div>
			<button style="float: right;" type="button" class="btn btn-info submit_contract_img">Save</button>
			<!--End-->
		</div>
	</div>
</div>
<!-- /page content -->
<!--<script src="--><?php //echo base_url();?><!--assets/js/pawn/contract.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<script>
	$(document).on('click', '[data-toggle="lightbox"]', function (event) {
		event.preventDefault();
		$(this).ekkoLightbox({
			alwaysShowClose: true,
		});
	});
</script>
<style>

	.ekko-lightbox .modal-header {
		padding-top: 5px;
		padding-bottom: 5px;
	}

	.ekko-lightbox .modal-body {
		padding: 5px;
	}
</style>
<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>

<script>

	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
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
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_contract_ksnb"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);

					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_contract_ksnb"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_contract_ksnb"  data-key="' + data.key + '" src="' + data.path + '" />';
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


	$(".submit_contract_img").on("click", function (event) {
		event.preventDefault();
		var contractId = $("#contract_id").val();
		var expertise = {};
		var img_contract = $("img[name='img_contract_ksnb']").length;
		if (img_contract > 0) {
			$("img[name='img_contract_ksnb']").each(function () {
				var data = {};
				type = $(this).data('type');
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				data['description'] = "";
				var key = $(this).data('key');
				expertise[key] = data;
			});
		}

		var formData = {
			contractId: contractId,
			expertise: expertise,
		};
		$.ajax({
			url: _url.base_url + '/contract_ksnb/updateDescriptionImage',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				if (data.code == 200) {
					$("#approve_disbursement").modal("hide");
					$("#successModal").modal("show");
					$(".msg_success").text("Thêm thành công");
					setTimeout(function () {
						window.location.href = _url.base_url + "contract_ksnb/index_list_contract_ksnb";
					}, 2000);
				} else {
					$("#approve_disbursement").modal("hide");
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);

				}
			},
			error: function (data) {
				$("#loading").hide();
			}
		});

	});


</script>
