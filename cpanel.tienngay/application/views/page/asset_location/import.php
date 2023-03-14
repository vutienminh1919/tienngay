<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang xử lý...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Import danh sách thiết bị định vị
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">
								Import danh sách thiết bị định vị
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
				<div class="row flex justify-content-center">
					<div class="col-xs-12 col-md-8">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import danh sách thiết bị định vị
							</div>
							<div class="panel panel-default">
								<div class="row">
									<div class="col-sx-12 col-md-6 mb-3">
										<label class="form-label text-bold">Loại giao dịch :<span
													class="text-danger">*</span></label>
										<select class="form-control type" type="text"
												name="type">
											<option value="">Chọn loại giao dịch</option>
											<option value="1">Nhập mới</option>
											<option value="2">Điều chuyển</option>
											<option value="3">Nhập kho thiết bị cũ</option>
										</select>
									</div>
									<div class="col-sx-12 col-md-6 mb-3 div-partner" style="display: none">
										<label class="form-label text-bold">Nhà cung cấp :<span
													class="text-danger">*</span></label>
										<select class="form-control partner" type="text"
												name="partner">
											<option value="">Chọn nhà cung cấp</option>
											<?php foreach ($partners as $key => $partner): ?>
												<option value="<?php echo $partner->_id ?>"><?php echo $partner->name ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="col-sx-12 col-md-6 mb-3 div-warehouse-export" style="display: none">
										<label class="form-label text-bold">Kho xuất :<span
													class="text-danger">*</span></label>
										<select class="form-control warehouse_export" type="text"
												name="warehouse_export">
											<option value="">Chọn Kho xuất</option>
											<?php foreach ($warehouses as $key => $warehouse): ?>
												<option value="<?php echo $warehouse->_id ?>"><?php echo $warehouse->name ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="col-sx-12 col-md-6 mb-3">
										<label class="form-label text-bold">Kho nhập :<span
													class="text-danger">*</span></label>
										<select class="form-control warehouse_import" type="text"
												name="warehouse_import">
											<option value="">Chọn kho nhập</option>
											<!--											--><?php //foreach ($warehouses as $key => $warehouse): ?>
											<!--												<option value="-->
											<?php //echo $warehouse->_id ?><!--">-->
											<?php //echo $warehouse->name ?><!--</option>-->
											<!--											--><?php //endforeach; ?>
										</select>
									</div>
									<div class="col-sx-12 col-md-6 mb-3">
										<label class="form-label text-bold">File Upload
											&nbsp; <span
													class="text-danger">*</span></label>
										<div class="form-group">
											<input type="file" name="import_asset_location"
												   class="form-control file_import_asset_location"
												   placeholder="sothing" id="file_import_asset_location">
										</div>
									</div>
									<div class="col-sx-12 col-md-6 mb-3 div-stock-price" style="display: none">
										<label class="form-label text-bold">Giá tồn mới :<span
													class="text-danger">*</span></label>
										<input class="form-control stock_price text-danger" type="text"
											   name="stock_price" disabled>
									</div>
								</div>
							</div>
							<br>
						</div>
						<div class="x_panel">
							<div class="panel panel-body text-right">
								<a class="btn btn-warning" href="<?php echo base_url("assetLocation/example_import") ?>"
								   target="_blank">Mẫu import
								</a>
								<a class="btn btn-primary btn-upload-import" id="import_asset_location"
								   style="display: none">Upload
								</a>
							</div>
							<div class="x_content list_asset_location_fail" style="display:none">
								<div class="dashboarditem_line2 blue">
									<div class="thetitle">
										Danh sách dòng bị lỗi
									</div>
									<div class="panel panel-default">
										<ol class="text_list_asset_location_fail"></ol>
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
<script>
	$(document).ready(function () {
		$("#import_asset_location").click(function (event) {
			event.preventDefault();
			let partner = $("select[name='partner']").val();
			let type = $("select[name='type']").val();
			let warehouse_import = $("select[name='warehouse_import']").val();
			let warehouse_export = $("select[name='warehouse_export']").val();
			let inputimg = $('input[name=import_asset_location]');
			let fileToUpload = inputimg[0].files[0];
			let formData = new FormData();
			formData.append('upload_file', fileToUpload);
			formData.append('partner', partner);
			formData.append('type', type);
			formData.append('warehouse_import', warehouse_import);
			formData.append('warehouse_export', warehouse_export);
			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'assetLocation/importAssetLocation',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
					$(".list_asset_location_fail").hide();
					$(".text_list_asset_location_fail li").remove();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						if (data.data.length == 0) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.message);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.message || 'Thất bại');
							$(".list_asset_location_fail").show();
							$.each(data.data, function (key, value) {
								$('.text_list_asset_location_fail').append($('<li>', {text: 'Dòng ' + value.key + ': ' + value.message}));
							})
						}
					} else {
						$('#errorModal').modal('show');
						$('.msg_error').text(data.message || 'Thất bại');
					}
				},
				error: function (data) {
					$(".theloading").hide();
					$('#errorModal').modal('show');
					$('.msg_error').text(data.message);
				}
			});
		});

		$("#file_import_asset_location").on('change', function (event) {
			event.preventDefault();
			$(".btn-upload-import").hide();
			$(".div-stock-price").hide();
			$("input[name='stock_price']").val('');
			let partner = $("select[name='partner']").val();
			let type = $("select[name='type']").val();
			let warehouse_import = $("select[name='warehouse_import']").val();
			let warehouse_export = $("select[name='warehouse_export']").val();
			let inputimg = $('input[name=import_asset_location]');
			let fileToUpload = inputimg[0].files[0];
			let formData = new FormData();
			formData.append('upload_file', fileToUpload);
			formData.append('partner', partner);
			formData.append('type', type);
			formData.append('warehouse_import', warehouse_import);
			formData.append('warehouse_export', warehouse_export);
			$.ajax({
				enctype: 'multipart/form-data',
				url: _url.base_url + 'assetLocation/check_importAssetLocation',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
					$(".list_asset_location_fail").hide();
					$(".text_list_asset_location_fail li").remove();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						if (data.data.length == 0) {
							$(".btn-upload-import").show();
							if (type == 1) {
								$(".div-stock-price").show();
								$("input[name='stock_price']").val(data.stock_price);
							}
						} else {
							$(".btn-upload-import").hide();
							$(".div-stock-price").hide();
							$("input[name='stock_price']").val("");
							$('input[name=import_asset_location]').val('')
							$('#errorModal').modal('show');
							$('.msg_error').text(data.message || 'Thất bại');
							$(".list_asset_location_fail").show();
							$.each(data.data, function (key, value) {
								$('.text_list_asset_location_fail').append($('<li>', {text: 'Dòng ' + value.key + ': ' + value.message}));
							})
						}
					} else {
						$(".btn-upload-import").hide();
						$(".div-stock-price").hide();
						$("input[name='stock_price']").val("");
						$('input[name=import_asset_location]').val('')
						$('#errorModal').modal('show');
						$('.msg_error').text(data.message || 'Thất bại');
					}
				},
				error: function (data) {
					$(".theloading").hide();
					$(".btn-upload-import").hide();
					$("input[name='stock_price']").val("");
					$('input[name=import_asset_location]').val('')
					$(".div-stock-price").hide();
					$('#errorModal').modal('show');
					$('.msg_error').text(data.message);
				}
			});
		});

		$(".type").change(function () {
			let type = $(this).val()
			if (type == 2) {
				$(".div-warehouse-export").show();
				$(".div-partner").hide();
				$(".partner").val('')
			} else {
				$(".div-warehouse-export").hide();
				$(".div-partner").show();
				$(".partner").val('')
			}
		})

		$(".type").change(function () {
			let type = $(this).val()
			$('.warehouse_import option').remove()
			if (type) {
				$.ajax({
					url: _url.base_url + 'assetLocation/get_warehouse',
					type: 'GET',
					dataType: 'json',
					success: function (data) {
						if (data.status == 200) {
							$('.warehouse_import').append($('<option>', {value: '', text: 'Chọn kho nhập'}));
							$.each(data.data, function (k, v) {
								if (type == 1 && v.slug != 'kho-ho') {
									return;
								}
								$('.warehouse_import').append($('<option>', {value: v._id, text: v.name}));

							})
						} else {
							$('.warehouse_import').append($('<option>', {value: '', text: 'Chọn kho nhập'}));
						}
					},
					error: function () {
						alert('error')
					}
				})
			} else {
				$('.warehouse_import').append($('<option>', {value: '', text: 'Chọn kho nhập'}));
			}

		})
	});
</script>
