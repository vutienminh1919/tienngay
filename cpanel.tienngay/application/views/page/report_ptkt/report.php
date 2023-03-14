<div class="right_col" role="main">
	<?php

	?>
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Xuất Excel phân loại phiếu thu
						</h3>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import file Bank
							</div>
							<div class="panel panel-default">

								<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
								<div class="form-group">
									<input type="file" name="upload_file_transaction" class="form-control"
										   placeholder="sothing">
								</div>
								<a class="btn btn-primary" id="import_transaction"
								   style="margin:0"><?= $this->lang->line('Upload') ?></a>

								<a style="margin:0" class="btn btn-warning"
								   href="<?php echo base_url('assets/mau_import/mau_file_bank_import.xlsx') ?>"> Tải mẫu
									import</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
									<div class="col-xs-12">
										<div class="row">
											<!--											<div class="col-xs-12 col-lg-2">-->
											<!--												<div class="form-group">-->
											<!--													<label> Từ </label>-->
											<!--													<input type="date" name="fdate" class="form-control"-->
											<!--														   value="-->
											<? //= !empty($fdate) ? $fdate : "" ?><!--">-->
											<!--												</div>-->
											<!--											</div>-->
											<!--											<div class="col-xs-12 col-lg-2">-->
											<!--												<div class="form-group">-->
											<!--													<label> Đến </label>-->
											<!--													<input type="date" name="tdate" class="form-control"-->
											<!--														   value="-->
											<? //= !empty($tdate) ? $tdate : "" ?><!--">-->
											<!---->
											<!--												</div>-->
										</div>
										<div class="col-xs-12 col-lg-2">
											<div class="form-group">
												<label> Khu vực </label>
												<select class="form-control" name="store" id="store">
													<option value="">--Chọn khu vực--</option>
													<option value="MB">Khu vực miền bắc</option>
													<option value="MN">Khu vực miền nam</option>
												</select>
											</div>
										</div>
										<div class="col-xs-12 col-lg-1">
											<label>&nbsp;</label>
											<div class="dropdown">
												<button type="button" class="btn btn-success dropdown-toggle"
														data-toggle="dropdown" aria-haspopup="true"
														aria-expanded="false"
														style="font-style: 14px; border-radius: 5px">
													Tính toán&nbsp;
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item btn btn-secondary w-100 excel_ptkt"
													   id="excel_ptkt"
													   style="margin-top: 10px">Tỷ lệ tổng hợp lệnh PT </a>
													<li role="separator" class="divider"></li>
													<a class="dropdown-item btn btn-secondary w-100 excel_ptkt_cancel">
														Tỷ lệ tổng hợp lệnh PT huỷ</a>
												</div>
											</div>
										</div>
									</div>
							</div>
						</div>

						<div class="PT" <?= !empty($pt) ? "" : 'style="display:none"' ?>>
							<table class="table" id="store_table">
								<thead>
								<tr>
									<th>Loại Lệnh Phiếu thu</th>
									<th>Số lệnh</th>
									<th>Phần trăm trên tổng lệnh</th>
									<th>Chi tiết</th>
								</tr>
								</thead>
								<tbody>
								<?php if (isset($pt)) : ?>
									<?php foreach ($pt as $key => $item) : ?>
										<tr>
											<td><?= $key ?></td>
											<td><?= $item->count ?? "" ?></td>
											<td><?= $item->rate ?? "" ?></td>
											<td><?= $item->detail ?? "" ?></td>

										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
							<button class="btn btn-success" onclick="Export('xlsx', 'Report_ptkt')">Xuất Excel</button>
						</div>

						<div class="PT_clone" hidden>
							<table class="table" id="clone_table">
								<thead>
								<tr>
									<th>Loại Lệnh Phiếu thu</th>
									<th>Số lệnh</th>
									<th>Phần trăm trên tổng lệnh</th>
								</tr>
								</thead>
								<tbody>
								<?php if (isset($pt)) : ?>
									<?php foreach ($pt as $key => $item) : ?>
										<tr>

											<td><?= $key ?></td>
											<td><?= $item->count ?? "" ?></td>
											<td><?= $item->rate ?? "" ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>


						<div class="CANCEL" <?= !empty($pt_cancel) ? "" : 'style="display:none"' ?>>
							<table class="table" id="cancel_table">
								<thead>
								<tr>
									<th>Lý do huỷ PT</th>
									<th>Tổng số lệnh:&nbsp; <span class="text-danger"><?= $count_pt_cancel ?></span></th>
									<th>Phần trăm trên tổng lệnh:&nbsp; 100%</th>
									<th>Chi tiết lệnh</th>
								</tr>
								</thead>
								<tbody>
								<?php if (isset($pt_cancel)) : ?>
									<?php foreach ($pt_cancel as $key => $item) : ?>
										<?php $count = $count_pt_cancel ?>
										<tr>
											<td><?= $key ?></td>
											<td><?= count($item->detail) ?></td>
											<td><?= ($count > 0) ? number_format(count($item->detail) / $count * 100, 2) : 0 ?></td>
											<td><?= !empty($item) && is_array($item->detail) ? implode(", ", $item->detail) : "" ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
							<button class="btn btn-success" onclick="ExportCancel('xlsx', 'Report_ptkt_cancel')">Xuất Excel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.19.0/package/dist/xlsx.full.min.js"></script>
<script type="text/javascript">

	function Export(fileExtension, fileName) {
		let el = document.getElementById("clone_table");
		let wb = XLSX.utils.table_to_book(el, {sheet: 'sheet1'});
		return XLSX.writeFile(wb, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
	}

	function ExportCancel(fileExtension, fileName) {
		let el = document.getElementById("cancel_table");
		let wb = XLSX.utils.table_to_book(el, {sheet: 'sheet1'});
		return XLSX.writeFile(wb, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
	}


	$(document).ready(function () {
		$('#excel_ptkt').click(function (event) {
			event.preventDefault();
			let store = $("select[name='store']").val()
			var formData = new FormData();
			formData.append('store', store);
			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'reportPtkt/sortPT',
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
					if (data.res) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						$(".theloading").hide();
						console.log(data);
						setTimeout(function () {
							window.location.reload();
						}, 1000);
						$('.PT').show();

					} else {
						console.log(data);
						$(".theloading").hide();
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
				}
			});
		})

		$('.excel_ptkt_cancel').click(function (event) {
			event.preventDefault();
			let store = $("select[name='store']").val()
			var formData = new FormData();
			formData.append('store', store);
			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'reportPtkt/sortPTCancel',
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
					if (data.res) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						$(".theloading").hide();
						console.log(data);
						setTimeout(function () {
							window.location.reload();
						}, 1000);
						$('.CANCEL').show();
					} else {
						console.log(data);
						$(".theloading").hide();
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
				}
			});
		})


		$("#import_transaction").click(function (event) {
			event.preventDefault();
			var inputimg = $('input[name=upload_file_transaction]');
			var fileToUpload = inputimg[0].files[0];
			var formData = new FormData();
			formData.append('upload_file', fileToUpload);

			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'reportPtkt/importFileBank',
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
						$(".theloading").hide();
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
				}
			});

		});

	});

</script>

