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
					<h3>Import cập nhật trạng thái cho hợp đồng
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Import
								cập nhật trạng thái cho hợp đồng</a></small>
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
								<i class="fa fa-upload"></i> Import cập nhật trạng thái cho hợp đồng
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_contract" class="form-control" placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_contract"
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
	$("#import_contract").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file_contract]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'importDatabase/import_update_contract_status',
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
					}, 5000);
					
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	
	
</script>
