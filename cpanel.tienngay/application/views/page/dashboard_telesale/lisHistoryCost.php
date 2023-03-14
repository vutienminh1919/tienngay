<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	?>
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Lịch Sử Import</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2 style="color: black">Tổng số: <?= !empty($count) ? $count : 0 ?></h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">

							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>

							<form action="<?php echo base_url('dashboard/listHistory') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">
									<li class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Từ:</label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : date('Y-m-d') ?>">
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Đến:</label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : date('Y-m-d') ?>">
												</div>
											</div>
										</div>
									</li>

									<li class="text-right">
										<button class="btn btn-success" type="submit">
											<i class="fa fa-search" aria-hidden="true"></i>
											Tìm Kiếm
										</button>
									</li>

								</ul>
							</form>

						</div>

					</div>
					<div class="clearfix">

						<div class="x_content">
							<div class="table-responsive">
								<table id="summary-total"
									   class="table table-bordered m-table table-hover table-calendar table-report"
									   style="font-size: 14px;font-weight: 400;">
									<thead style="background:#E8F4ED !important; color: #000000 !important;">
									<tr>
										<th style="text-align: center">STT</th>
										<th style="text-align: center">Thời gian import</th>
										<th style="text-align: center">Người import</th>
										<th style="text-align: center">File import</th>
										<th style="text-align: center">Nguồn</th>
										<th style="text-align: center">Ảnh chứng từ đi kèm</th>
									</tr>
									</thead>
									<tbody>
									<?php if (!empty($getDataCost)): ?>
										<?php foreach ($getDataCost as $key => $value): ?>
											<tr>
												<td style="text-align: center"><?= ++$key ?></td>
												<td style="text-align: center"><?= !empty($value->created_at) ? date('H:i:s d/m/Y', $value->created_at) : '' ?></td>
												<td style="text-align: center"><?= !empty($value->created_by) ? $value->created_by : '' ?></td>
												<td>
													<a href="<?= !empty($value->path) ? $value->path : '' ?>">
														<i class="fa fa-file-excel-o"
														   style="font-size:30px;color:green"></i> <?= !empty($value->file_name) ? $value->file_name : '' ?>
													</a>

												</td>
												<td style="text-align: center"><?= !empty($value->source) ? $value->source : '' ?></td>
												<td style="text-align: center">
													<a class="btn btn-success" href="javascript:void(0)"
													   data-toggle="modal"
													   onclick="sua_yeu_cau('<?= $value->_id->{'$oid'} ?>')">
														Update ảnh chứng từ
													</a>
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
	</div>
</div>

<div id="editFileReturn" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload ảnh chứng từ</h4>
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
				<?php if (in_array('marketing', $groupRoles)): ?>
					<button type="button" class="btn btn-primary" id="edit_fileReturn">Upload chứng từ</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>


<style>
	.dashboarditem_line2.blue .thetitle {
		background: #1b74e4;
	}

	.dashboarditem_line2.red .thetitle {
		background: #ea4335;
	}

	.dashboarditem_line2.black .thetitle {
		background: #000000;
	}

	.page-title {
		min-height: 0px !important;
	}
</style>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>

<script>
	$("#on_loading").click(function (event) {
		$(".theloading").show()
	});
</script>

<script>
	$("#edit_fileReturn").click(function (event) {
		event.preventDefault();

		var count = $("img[name='img_fileReturn']").length;

		var fileReturn_img = {};

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
					fileReturn_img[key] = data;
				}
			});
		}

		$.ajax({
			url: _url.base_url + '/dashboard/update_image_cost',
			method: "POST",
			data: {
				id: $("#fileReturn_id").val(),
				fileReturn_img: fileReturn_img
			},
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data)
				$(".theloading").hide();
				if (data.data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Sửa thành công');

					setTimeout(function () {
						window.location.reload();
					}, 3000);
				} else {

					$("#div_errorCreate_100").css("display", "block");
					$(".div_errorCreate").text(data.data.message);

					setTimeout(function () {
						$("#div_errorCreate_1").css("display", "none");
					}, 4000);
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	});


	function sua_yeu_cau(id) {

		$("#uploads_fileReturn_edit").empty();

		$.ajax({
			url: _url.base_url + 'dashboard/showUpdate_image/' + id,
			type: "POST",
			dateType: "JSON",
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (result) {
				$(".theloading").hide();
				console.log(result);

				$('[name="fileReturn_id"]').val(result.data._id.$oid);

				var html = "";

				for (let j = 0; j < result.data.image.length; j++) {
					if (result.data.image[j].file_type == 'image/png' || result.data.image[j].file_type == 'image/jpg' || result.data.image[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<a href='" + result.data.image[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='image' data-title='Thông báo'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "' data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "'></a>";
						html += "<button type='button' onclick='deleteImage(this)' data-type='identify' data-key='" + result.data.image[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
						html += "</div>"
					}
					if (result.data.image[j].file_type == 'audio/mp3' || result.data.image[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>" + result.data.image[j].file_name + "</span><img name='img_fileReturn' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "'  data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "' ></a>";
						html += "<button type='button' onclick='deleteImage(this)' data-type='fileReturn' data-key='" + j + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
						html += "</div>"
					}
					if (result.data.image[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<a href='" + result.data.image[j].path + "' target='_blank'><span style='z-index: 9'>" + result.data.image[j].file_name + "</span><img name='img_fileReturn' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'><img name='img_fileReturn' data-key='" + result.data.image[j].key + "' data-fileName='" + result.data.image[j].file_name + "' data-fileType='" + result.data.image[j].file_type + "'  data-type='fileReturn' class='w-100' src='" + result.data.image[j].path + "' ></a>";
						html += "<button type='button' onclick='deleteImage(this)' data-type='fileReturn' data-key='" + result.data.image[j].key + "' class='cancelButton'><i class='fa fa-times-circle'></i></button>"
						html += "</div>"
					}
				}
				$("#uploads_fileReturn_edit").append(html);

				$('#editFileReturn').modal('show');
			}
		});
	}
</script>

<script>
	$('input[type=file]').change(function () {
		var contain = $(this).data("contain");
		var title = $(this).data("title");
		var type = $(this).data("type");
		var contractId = $("#contract_id").val();
		$(this).simpleUpload(_url.base_url + "pawn/upload_img", {

			allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4",'xlsx'],

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
		// var res = confirm("Bạn có chắc chắn muốn xóa");
		if (confirm("Bạn có chắc chắn muốn xóa ?")) {
			$(thiz_).closest("div .block").remove();
		}
	}
</script>







