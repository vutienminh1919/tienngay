<?php
$file = !empty($_FILES['upload_file']['tmp_name']) ? $_FILES['upload_file']['tmp_name'] : "";
$created_at = !empty($_GET['created_at']) ? $_GET['created_at'] : "";
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
?>
<!-- Import HĐ cho Call: 6176817468cf1563d84bb224  -->
<?php if (in_array("6176817468cf1563d84bb224", $userRoles->role_access_rights)) { ?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Gán hợp đồng cho Call HĐ vay
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">
								Gán hợp đồng cho Call HĐ vay
							</a>
						</small>
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
								<i class="fa fa-upload"></i> Import hợp đồng
							</div>
							<div class="panel panel-default">
								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_contract_debt_bz_bo" class="form-control"
										   placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_contract_debt_bz_bo"
								   style="margin:0"><?= $this->lang->line('Upload') ?>
								</a>
							</div>
							<br>
							<br>
							<a class="btn btn-success" target="_blank"
							   href="<?php echo base_url('DebtCall/mission_caller') ?>"> Quản lý nhiệm vụ Call
							</a>
						</div>
						<div class="x_content list_contract_fail" style="display:none">
							<div class="dashboarditem_line2 blue">
								<div class="thetitle">
									Danh sách hợp đồng bị lỗi
								</div>
								<div class="panel panel-default">
									<ol class="text_list_contract_fail1"></ol>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 hidden">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Check Contract import yet?
							</div>
							<div class="panel panel-default">
								<strong>Check &nbsp;</strong>
								<div class="form-group">
									<input type="file" name="check_import_file_contract_debt" class="form-control"
										   placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="check_import_contract_debt"
								   style="margin:0">Upload
								</a>
							</div>
							<div class="x_content check_contract_fail" style="display:none">
								<div class="dashboarditem_line2 blue">
									<div class="thetitle">
										Danh sách hợp đồng chưa được gán cho Call
									</div>
									<div class="panel panel-default">
										<ol class="text_list_contract_fail3"></ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<script>
	$(document).ready(function () {
		$("#import_contract_debt_bz_bo").click(function (event) {
			event.preventDefault();
			var inputimg = $('input[name=upload_file_contract_debt_bz_bo]');
			var fileToUpload = inputimg[0].files[0];
			var formData = new FormData();
			formData.append('upload_file', fileToUpload);

			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'DebtCall/importContractDebtBzBo',
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
					if (data.status == 200) {
						$(".theloading").hide();
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.reload();
						}, 5000);
					} else if (data.status == 400) {
						$("#div_error").css("display", "block");
						$(".div_error").text(data.message);
						window.scrollTo(0, 0);
						$(".theloading").hide();
						$(".list_contract_fail").show();
						$.each(data.data2, function (key, value) {
							$('.text_list_contract_fail1').append($('<li>', {text: value}));
						});
						$.each(data.data1, function (key, value) {
							$('.text_list_contract_fail2').append($('<li>', {text: value}));
						});
					} else {
						console.log(data);
						$("#div_error").css("display", "block");
						$(".div_error").text(data.message);
						window.scrollTo(0, 0);
						$(".theloading").hide();
						$(".list_contract_fail").show();
						$.each(data.data2, function (key, value) {
							$('.text_list_contract_fail1').append($('<li>', {text: value}));
						});
						$.each(data.data1, function (key, value) {
							$('.text_list_contract_fail2').append($('<li>', {text: value}));
						});
					}
				},
				error: function (data) {
					//console.log(data);
					$(".theloading").hide();
				}
			});
		});

		$("#check_import_contract_debt").click(function (event) {
			event.preventDefault();
			var inputimg = $('input[name=check_import_file_contract_debt]');
			var fileToUpload = inputimg[0].files[0];
			var formData = new FormData();
			formData.append('upload_file', fileToUpload);

			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'DebtCall/checkImportContractDebt',
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
					console.log(data);
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						$(".theloading").hide();
					} else if(data.status == 401) {
						$("#div_error").css("display", "block");
						$(".div_error").text(data.message);
						window.scrollTo(0, 0);
						setTimeout(function () {
							$("#div_error").css("display", "none");
						}, 10000);
					} else {
						console.log(data);
						$("#div_error").css("display", "block");
						$(".div_error").text(data.message);
						window.scrollTo(0, 0);
						setTimeout(function () {
							$("#div_error").css("display", "none");
						}, 10000);
						$(".check_contract_fail").show();
						$.each(data.data2, function (key, value) {
							$('.text_list_contract_fail3').append($('<li>', {text: value}));
						});
						$.each(data.data1, function (key, value) {
							$('.text_list_contract_fail4').append($('<li>', {text: value}));
						});
					}
				},
				error: function (data) {
					//console.log(data);
					$(".theloading").hide();
				}
			});

		});
	});
</script>

