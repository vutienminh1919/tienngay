<?php
$file = !empty($_FILES['upload_file']['tmp_name']) ? $_FILES['upload_file']['tmp_name'] : "";
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
					<h3>Import database nhân sự
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Import
								thông tin nhân sự</a></small>
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
			<div class="col-xs-12 col-md-6">
				<div class="dashboarditem_line2 blue">
					<div class="thetitle">
						<i class="fa fa-upload"></i> Import nhân sự
					</div>
					<div class="panel panel-default">

						<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
						<div class="form-group">
							<input type="file" name="upload_file_nhansu" class="form-control"
								   placeholder="sothing">
						</div>
						<a class="btn btn-primary" id="import_nhansu"
						   style="margin:0"><?= $this->lang->line('Upload') ?></a>

					</div>
					<a href="<?php echo base_url('personnel/listNhanSu') ?>"> Danh sách nhân sự</a>

				</div>
			</div>
		</div>
	</div>
</div>
<script>

	$("#import_nhansu").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_nhansu]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/importNhanSu',
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
						window.location.href = _url.base_url + 'personnel/listNhanSu';
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
						window.location.href = _url.base_url + 'ImportDatabase/buttonImport';
					}, 1000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});

</script>
