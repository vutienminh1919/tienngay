<?php
$file = !empty($_FILES['upload_file']['tmp_name']) ? $_FILES['upload_file']['tmp_name'] : "";
$created_at = !empty($_GET['created_at']) ? $_GET['created_at'] : "";
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Import gia hạn , cơ cấu
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Import
								gia hạn , cơ cấu</a></small>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<span class='div_error'></span>
				</div>

				<?php if ($this->session->flashdata('error')) { ?>
					<div class="alert alert-danger alert-result">
						<?= $this->session->flashdata('error') ?>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import gia hạn
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_giahan" class="form-control" placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_giahan"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
							<a target="_blank" href="<?php echo base_url('importDatabase/list_import_gh') ?>"> Danh sách hợp đồng gia hạn</a>
						</div>
					</div>

				
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import cơ cấu
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_cocau" class="form-control"
										   placeholder="sothing">

								</div>
								<a class="btn btn-primary" id="import_cocau"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
							<a target="_blank" href="<?php echo base_url('importDatabase/list_import_cc') ?>"> Danh sách hợp đồng cơ cấu</a>
						</div>
					</div>
					

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("#import_giahan").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_giahan]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/import_giahan',
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
				//console.log(data);
				if (data.res) {

					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					$(".theloading").hide();
					// setTimeout(function () {
					// 	window.location.href = _url.base_url + 'pawn/contract_import';
					// }, 3000);
					console.log(data);
				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 5000);
					// setTimeout(function () {
					// 	window.location.href = _url.base_url + 'importDatabase/import_gh_cc';
					// }, 1000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	$("#import_cocau").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_cocau]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/import_cocau',
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
				//console.log(data);
				if (data.res) {

					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					$(".theloading").hide();
					// setTimeout(function () {
					// 	window.location.href = _url.base_url + 'investors/listInvestors';
					// }, 3000);
					console.log(data);
				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 5000);
					// setTimeout(function () {
					// 	window.location.href = _url.base_url + 'importDatabase';
					// }, 1000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	
</script>
