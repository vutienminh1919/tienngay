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
					<h3>Import database
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Import
								database</a></small>
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
								<i class="fa fa-upload"></i> Import hợp đồng cũ
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file" class="form-control" placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_contract_old"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
							<a href="<?php echo base_url('pawn/contract_import') ?>"> Danh sách hợp đồng upload</a>
						</div>
					</div>

				<!-- 	<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import chuyển trạng thái hợp đồng đang vay
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_dang_vay" class="form-control"
										   placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_contract_dang_vay"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
							<a href="<?php echo base_url('importDatabase/import_change_status?type=dangvay') ?>"> Danh
								sách đang vay</a>
						</div>
					</div> -->
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import Transaction
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_transaction" class="form-control"
										   placeholder="sothing">

								</div>
								<a class="btn btn-primary" id="import_transaction"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
							<a href="<?php echo base_url('transaction/list_kt?tab=import') ?>"> Danh sách phiếu thu
								upload</a>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import Phiếu Thu Miễn Giảm
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_transaction_mg" class="form-control"
										   placeholder="sothing">

								</div>
								<a class="btn btn-primary" id="import_transaction_mg"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Chạy Lại Hợp Đồng
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_rerun_contract" class="form-control"
										   placeholder="sothing">

								</div>
								<a class="btn btn-primary" id="import_rerun_contract"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 d-none">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import Transaction Allow Duplicate
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_transaction_allow_duplicate" class="form-control"
										   placeholder="sothing">

								</div>
								<a class="btn btn-primary" id="import_transaction_allow_duplicate"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
							<a href="<?php echo base_url('transaction/list_kt?tab=import') ?>"> Danh sách phiếu thu
								upload</a>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import đánh dấu hợp đồng tất toán
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_tat_toan" class="form-control"
										   placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_contract_tat_toan"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>
							</div>
							<a href="<?php echo base_url('importDatabase/import_change_status?type=tattoan') ?>"> Danh
								sách tất toán</a>
						</div>
					</div>

					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import nhà đầu tư
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_investor" class="form-control"
										   placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_investor"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>
							<a href="<?php echo base_url('investors/listInvestors') ?>"> Danh sách nhà đầu tư</a>

						</div>
					</div>

					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import sửa hợp đồng
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_update_contract" class="form-control"
										   placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_update_contract"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("#import_contract_old").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importOldContract',
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
					setTimeout(function () {
						window.location.href = _url.base_url + 'pawn/contract_import';
					}, 3000);
					console.log(data);
				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 3000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 1000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	$("#import_investor").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_investor]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importContractNhadautu',
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
					setTimeout(function () {
						window.location.href = _url.base_url + 'investors/listInvestors';
					}, 3000);
					console.log(data);
				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 3000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 1000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	$("#import_update_contract").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_update_contract]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importContractUpdate',
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
					setTimeout(function () {
						window.location.href = _url.base_url + 'pawn/contract';
					}, 3000);
					console.log(data);
				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 3000);
					// setTimeout(function(){
					//     window.location.href = _url.base_url + 'importDatabase';
					// }, 1000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	$("#import_transaction").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_transaction]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importTransaction',
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
					setTimeout(function () {
						window.location.href = _url.base_url + 'transaction/list_kt?tab=import';
					}, 5000);

				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 30000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 30000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	$("#import_transaction_allow_duplicate").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_transaction_allow_duplicate]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importTransaction?allow_duplicate=1',
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
					setTimeout(function () {
						window.location.href = _url.base_url + 'transaction/list_kt?tab=import';
					}, 5000);

				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 30000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 30000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	$("#import_contract_dang_vay").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_dang_vay]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importContractDangVay',
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
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase/import_change_status?type=dangvay';
					}, 5000);

				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 30000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 30000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	$("#import_contract_tat_toan").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_tat_toan]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importContractTatToan',
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
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase/import_change_status?type=tattoan';
					}, 5000);

				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 30000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 30000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});

	$("#import_transaction_mg").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_transaction_mg]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/updatePhieuThuMienGiam',
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
					console.log(data);

				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 30000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 30000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});

	$("#import_rerun_contract").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_rerun_contract]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/rerunContract',
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
					console.log(data);

				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 30000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'importDatabase';
					}, 30000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
</script>
