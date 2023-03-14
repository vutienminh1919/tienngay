<style>
	.font-16 {
		font-style: normal;
		font-weight: 540;
		font-size: 18px;
		line-height: 20px;

	}

	.font-14 {
		font-size: 16px;
		padding-bottom: 5px;
	}

	.text-blue {
		color: #5A738E;
	}

	.text-gray {
		color: #828282;
	}

	.font-weight-600 {
		font-weight: 600;
	}

	.mb-30 {
		margin-bottom: 30px;
	}

	.mb-3 {
		margin-bottom: 10px;
		width: 378px;
		height: 50px;
		top: 402px;
		left: 271px;
		border-radius: 5px;
		background-color: #D5EBF8;
		border: none;

		font-weight: 550;
		color: #5a738e;

	}
</style>
<div class="right_col" role="main">

	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>
					<a href="<?= base_url("customer_manager/index_customer_manager") ?>" >Quản lý khách hàng</a> / <?= !empty($customer_code) ? $customer_code : "" ?>
					<br>
				</h3>
			</div>


			<div class="title_right text-right">
				<div class="btn-group">
					<button type="button" class="btn btn-info">Chức năng</button>
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
							aria-expanded="false">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">

						<li>
							<a href="<?php echo base_url("customer_manager/detail_edit?id=") . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>"
							   class="dropdown-item">
								Cập nhật CCCD
							</a>
						</li>
						<li>
							<a onclick="call_for_customer('<?= !empty($contract->customer_infor->customer_phone_number) ? encrypt($contract->customer_infor->customer_phone_number) : "" ?>' , '<?= !empty($contract->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>', 'customer')"
							   class="call_for_customer">Gọi điện</a>
						</li>

					</ul>
				</div>
			</div>

		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">

			<div class="x_content">
				<div class="row">
					<div class="col-md-3">
						<div class="text-center" style="margin-bottom: 45px;">
							<img
								src="https://service.egate.global/uploads/avatar/1624962474-aa91be45af455f8eb58eb995f3a1d8e4.png"
								class="img-circle">
						</div>
						<a class="btn btn-default btn-lg w-100 text-uppercase mb-3" type="button"
						   href="<?= base_url('customer_manager/detail?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin chính
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase " type="button"
						   style="border: none; background-color: #F2F2F2; margin-bottom: 10px;"
						   href="<?= base_url('customer_manager/detail_tthd?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin hợp đồng
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase " type="submit"
						   href="<?= base_url('customer_manager/detail_giaytotuythan?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>"
								style="border: none; background-color: #F2F2F2; margin-bottom: 10px;">Giấy tờ tùy thân
						</a>
					</div>
					<div class="col-md-9">

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin cá nhân</div>
						<hr class="mt-1">
						<div class="row">

							<div class="col-md-12">
								<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Upload thông tin
									CCCD
								</div>
								<br><br>
								<div class="col-xs-12 col-md-6 text-center form-add-image">
									<p class="text-center" style="text-align: center">Mặt trước CCCD</p>
									<img id="imgImg_mattruoc"
										 style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;"
										 src="https://service.egate.global/uploads/avatar/1625124067-8da7f095442375c0470ffe268c725116.png" alt="">
									<input id="input_cmt_search" type="file" data-preview="imgInp004" style="visibility: hidden;">
								</div>

								<div class="col-md-6 col-xs-12 text-center form-add-image">
									<p class="text-center" style="text-align: center">Mặt sau CCCD</p>
									<img id="imgImg_matsau"
										 style="max-width: 400px;max-height: 250px;width: 100%; border-radius: 8px;"
										 src="https://service.egate.global/uploads/avatar/1625124067-8da7f095442375c0470ffe268c725116.png" alt="">
									<input id="imgInp_Face" type="file" data-preview="imgInp005" style="visibility: hidden;">
								</div>

								<div class="col-md-12 col-xs-12 text-right checking-user p-0">
									<br>

									<button type="button" class="btn btn-github return_Face_Identify">Chọn lại</button>
									<a type="button" class="btn btn-info " id="save_cccd">Lưu
										lại
									</a>
									<br><br>
									<hr class="mt-1">
								</div>


							</div>

							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Mã khách hàng</div>
									<div
										class="font-16 text-blue"><?= !empty($customer_code) ? $customer_code : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">Loại giấy tờ</div>
									<div
										class="font-16 text-blue"><?= !empty($customer_identify_name) ? $customer_identify_name : "" ?></div>
								</div>
								<?php
								$current_address = "";
								if ($contract->current_address->current_stay != "") {
									$current_address = $contract->current_address->current_stay;
								}
								if ($contract->current_address->ward_name != "") {
									$current_address = $contract->current_address->current_stay . ", " . $contract->current_address->ward_name;
								}
								if ($contract->current_address->district_name != "") {
									$current_address = $contract->current_address->current_stay . ", " . $contract->current_address->ward_name . ", " . $contract->current_address->district_name;
								}
								if ($contract->current_address->province_name != "") {
									$current_address = $contract->current_address->current_stay . ", " . $contract->current_address->ward_name . ", " . $contract->current_address->district_name . ", " . $contract->current_address->province_name;
								}

								?>
								<div class="mb-30">
									<div class="text-gray font-14">Địa chỉ thường trú</div>
									<div
										class="font-16 text-blue"><?= !empty($current_address) ? $current_address : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Tên khách hàng</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">Số</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">SĐT</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->customer_infor->customer_phone_number) ? hide_phone_customer($contract->customer_infor->customer_phone_number) : "" ?></div>
								</div>
							</div>
						</div>

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin việc làm</div>
						<hr class="mt-1">
						<div class="row">
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Công ty</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->name_company) ? $contract->job_infor->name_company : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">Địa chỉ công ty</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->address_company) ? $contract->job_infor->address_company : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Nghề nghiệp</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->job) ? $contract->job_infor->job : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Chức vụ</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->job_position) ? $contract->job_infor->job_position : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">SĐT công ty</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->phone_number_company) ? $contract->job_infor->phone_number_company : "" ?></div>
								</div>
							</div>
						</div>

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin tham chiếu</div>
						<hr class="mt-1">
						<div class="table-responsive">
							<div class="table-responsive">
								<table id="summary-total"
									   class="table table-bordered m-table table-hover table-calendar table-report"
									   style="font-size: 14px;font-weight: 400;">
									<thead style="background:#5A738E; color: #ffffff;">
									<tr>
										<th style="text-align: center">STT</th>
										<th style="text-align: center">Họ và tên</th>
										<th style="text-align: center">Quan hệ</th>
										<th style="text-align: center">Số điện thoại</th>
										<th style="text-align: center">Địa chỉ</th>
									</tr>
									</thead>
									<tbody>
									<?php if (!empty($contract->relative_infor->fullname_relative_1)): ?>
										<tr>
											<td style="text-align: center">1</td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->fullname_relative_1) ? $contract->relative_infor->fullname_relative_1 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->type_relative_1) ? $contract->relative_infor->type_relative_1 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->phone_number_relative_1) ? hide_phone_customer($contract->relative_infor->phone_number_relative_1) : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->hoursehold_relative_1) ? $contract->relative_infor->hoursehold_relative_1 : "" ?></td>
										</tr>
									<?php endif; ?>
									<?php if (!empty($contract->relative_infor->fullname_relative_2)): ?>
										<tr>
											<td style="text-align: center">2</td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->fullname_relative_2) ? $contract->relative_infor->fullname_relative_2 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->type_relative_2) ? $contract->relative_infor->type_relative_2 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->phone_number_relative_2) ? hide_phone_customer($contract->relative_infor->phone_number_relative_2) : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->hoursehold_relative_2) ? $contract->relative_infor->hoursehold_relative_2 : "" ?></td>
										</tr>
									<?php endif; ?>
									<?php if (!empty($contract->relative_infor->fullname_relative_3)): ?>
										<tr>
											<td style="text-align: center">3</td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->fullname_relative_3) ? $contract->relative_infor->fullname_relative_3 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->type_relative_3) ? $contract->relative_infor->type_relative_3 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->phone_relative_3) ? hide_phone_customer($contract->relative_infor->phone_relative_3) : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->address_relative_3) ? $contract->relative_infor->address_relative_3 : "" ?></td>
										</tr>
									<?php endif; ?>
									</tbody>
								</table>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<?php
function hide_phone_customer($phone, $role = "")
{
	$result = str_replace(substr($phone, 4, 4), stars($phone), $phone);
	if ($role != "") {
		return $phone;
	} else {
		return $result;
	}

}

?>

<script>
	$(document).ready(function () {


		var isUploaded = false;
		if ($('#imgImg_mattruoc').attr('src') != "https://service.egate.global/uploads/avatar/1625124067-8da7f095442375c0470ffe268c725116.png") {
			isUploaded = true;
		}
		var imageId;
		$(".alert-danger").hide();
		$(".alert-success").hide();

		$('#imgImg_mattruoc').on('click', function () {
			isUploaded = false;
			$('#input_cmt_search').trigger('click');
			imageId = $(this).attr('id');

		});

		$('#imgImg_matsau').on('click', function () {
			isUploaded = false;
			$('#imgInp_Face').trigger('click');
			imageId = $(this).attr('id');

		});


		$('#input_cmt_search').on('change', function () {
			var files = $(this)[0].files[0];
			//console.log(files.size);
			if (files.size > 2097152) {
				$(".alert-danger").text("Ảnh dung lượng phải nhỏ hơn 2MB!");
				$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
					$(".alert-danger").slideUp(500);
				});
				return;
			}
			var formData = new FormData();
			console.log(imageId);
			formData.append('file', files);
			$.ajax({
				dataType: 'json',
				enctype: 'multipart/form-data',
				url: _url.base_url + 'ajax/upload_img',
				type: 'POST',
				data: formData,
				processData: false, // tell jQuery not to process the data
				contentType: false, // tell jQuery not to set contentType
				success: function (data) {
					if (data.code == 200 && data.path !== "") {

						if (data.path != null && data.path != "") {
							$('#' + imageId).attr('src', data.path);
							isUploaded = true;
						}

						// Set image for user avatar on the header

					} else {

						$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
					}
				}
			});
		});


		$('#imgInp_Face').on('change', function () {
			var files = $(this)[0].files[0];
			var formData = new FormData();
			console.log("xxx");
			formData.append('file', files);
			isUploaded = false;
			$.ajax({
				dataType: 'json',
				enctype: 'multipart/form-data',
				url: _url.base_url + 'ajax/upload_img',
				type: 'POST',
				data: formData,
				processData: false, // tell jQuery not to process the data
				contentType: false, // tell jQuery not to set contentType
				success: function (data) {
					if (data.code == 200 && data.path !== "") {
						if (data.path != null && data.path != "") {
							$('#' + imageId).attr('src', data.path);
							isUploaded = true;
						}
						// Set image for user avatar on the header

					} else {

						$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
					}
				}
			});
		});

		$('.return_Face_Identify').on('click', function () {
			location.reload();

		});

	});

	$("#save_cccd").click(function (event) {
		event.preventDefault();
		let img_id_front = $('#imgImg_mattruoc').attr('src');
		let img_id_back = $('#imgImg_matsau').attr('src');

		let customer_code = "<?= !empty($customer_code) ? $customer_code : "" ?>";
		$.ajax({
			url: _url.base_url + '/customer_manager/update',
			method: "POST",
			data: {
				img_id_front: img_id_front,
				img_id_back: img_id_back,
				customer_code: customer_code
			},

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data)
				$(".theloading").hide();
				if (data.data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Lưu thành công');

					setTimeout(function () {
						location.reload();
					}, 3000);
				} else {
					console.log(data.data.message);
					$("#errorModal").modal("show");
					$(".msg_error").text(data.data.message);
					setTimeout(function () {
						location.reload();
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}
		});
	});


//https://service.egate.global/uploads/avatar/1625124067-8da7f095442375c0470ffe268c725116.png
</script>
<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title title_modal_approve text-center"></h3>
				<hr>
				<div style="text-align: center; font-size: 18px">
					<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
					<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
					<input id="number" name="phone_number" type="hidden" value=""/>
					<p id="status" style="margin-left: 125px;"></p>
				</div>

				<div class="form-group">
					<input type="text" value="<?php echo $this->input->get('id') ?>" class="hidden"
						   class="form-control " id="contract_id">
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	function call_for_customer(phone_number, contract_id, type) {
		console.log(phone_number);
		if (phone_number == undefined || phone_number == '') {
			alert("Không có số");
		} else {
			if (type == "customer") {
				$(".title_modal_approve").text("Gọi cho khách hàng");
			}
			if (type == "rel1") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 1");
			}
			if (type == "rel2") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 2");
			}
			$("#number").val(phone_number);
			$(".contract_id").val(contract_id);
			$("#approve_call").modal("show");
		}
	}
</script>
