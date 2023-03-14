<div class="right_col" role="main">

	<?php
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";

	?>

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
				<div class="title_left">
					<h3>DANH SÁCH HỢP ĐỒNG KHÁCH HÀNG GIỚI THIỆU KHÁCH HÀNG</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách hợp đồng cần theo dõi</h2>
						</div>

						<div class="col-xs-12 col-md-6 text-right">

							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('accountant/search_list_200') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<label>Mã phiếu ghi: </label>
										<input type="text" name="code_contract" class="form-control"
											   value="<?= !empty($code_contract) ? $code_contract : "" ?>">
									</li>
									<li class="form-group">
										<label>Mã hợp đồng: </label>
										<input type="text" name="code_contract_disbursement_search" class="form-control"
											   value="<?= !empty($code_contract_disbursement_search) ? $code_contract_disbursement_search : "" ?>">
									</li>
									<li class="form-group">
										<label>Họ và tên: </label>
										<input type="text" name="customer_name" class="form-control"
											   value="<?= !empty($customer_name) ? $customer_name : "" ?>">
									</li>
									<li class="form-group">
										<label>Số điện thoại: </label>
										<input type="text" name="customer_phone_number" class="form-control"
											   value="<?= !empty($customer_phone_number) ? $customer_phone_number : "" ?>"
											   maxlength="10">
									</li>
									<li class="form-group">
										<label>Chứng minh thư: </label>
										<input type="text" name="customer_identify" class="form-control"
											   value="<?= !empty($customer_identify) ? $customer_identify : "" ?>">
									</li>


									<li class="text-right">
										<button class="btn btn-info" type="submit">
											<i class="fa fa-search" aria-hidden="true"></i>
											Tìm Kiếm
										</button>
									</li>

								</ul>
							</form>

						</div>

						<div class="col-xs-12 col-md-6">
							<h2>Tổng số: <?= !empty($count) ? $count : 0 ?></h2>
						</div>

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Khách hàng vay</th>
								<th style="text-align: center">Mã hợp đồng</th>
								<th style="text-align: center">SĐT khách hàng</th>
								<th style="text-align: center">Số tiền giải ngân</th>
								<th style="text-align: center">Thời hạn vay</th>
								<th style="text-align: center">Ngày giải ngân</th>
								<th style="text-align: center">Khách hàng giới thiệu</th>
								<th style="text-align: center">SĐT khách hàng giới thiệu</th>
								<th style="text-align: center">Trạng thái thanh toán</th>
								<th style="text-align: center">Ngân hàng</th>
								<th style="text-align: center">Số tài khoản</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center">Chức năng</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($contract)): ?>
								<?php foreach ($contract as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->customer_name) ? $value->customer_infor->customer_name : "" ?></td>
										<td style="text-align: center"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->customer_phone_number) ? $value->customer_infor->customer_phone_number : "" ?></td>
										<td style="text-align: center"><?= !empty($value->loan_infor->amount_loan) ? number_format($value->loan_infor->amount_loan) : "" ?></td>
										<td style="text-align: center"><?= !empty($value->loan_infor->number_day_loan) ? $value->loan_infor->number_day_loan / 30 . " Tháng" : "" ?></td>
										<td style="text-align: center"><?= !empty($value->disbursement_date) ? date("d/m/y" , $value->disbursement_date) : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->presenter_name) ? $value->customer_infor->presenter_name : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->customer_phone_introduce) ? $value->customer_infor->customer_phone_introduce : "" ?></td>
										<td style="text-align: center"><?= !empty($value->status_check) ? $value->status_check : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->presenter_bank) ? $value->customer_infor->presenter_bank : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->presenter_stk) ? $value->customer_infor->presenter_stk : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->status_presenter) ? "Đã thanh toán" : "Chưa thanh toán" ?></td>
										<td style="text-align: center">

											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													<i class="fa fa-cogs"></i>
													<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">

													<?php
													if (empty($value->customer_infor->status_presenter) && $value->status_check != "Chưa có khoản vay, thanh toán điện nước với VFC") { ?>
														<li>
															<a href="javascript:void(0)" data-toggle="modal"
															   onclick="approve('<?= $value->_id->{'$oid'} ?>')">
																<i class="fa fa-edit"></i> Xác nhận thanh toán
															</a>
														</li>
													<?php } ?>
													<li>
														<a href="<?php echo base_url("accountant/viewImageAccuracy?id=") . $value->_id->{'$oid'} ?>"
														   class="dropdown-item">
															<i class="fa fa-eye"></i> Xem chứng từ
														</a>
													</li>

												</ul>
											</div>


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


<!--Modal-->
<div id="approve" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">XÁC NHẬN THANH TOÁN</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<input type="hidden" id="contract_id" value="" name="contract_id">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Ngày thanh toán: <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="date" class="form-control" name="presenter_date" id="presenter_date">
						</div>
						<br><br><br>
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Số tiền: <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="presenter_money" id="presenter_money"
								   value="200000" disabled>
						</div>
						<br><br><br>
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Bút toán: <span class="text-danger">*</span>
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="presenter_buttoan" id="presenter_buttoan"
								   value="">
						</div>

						<br><br><br>
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Ảnh upload:
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">

							<div id="SomeThing" class="simpleUploader">
								<div class="uploads " id="uploads_presenter">

								</div>
								<label for="uploadinput">
									<div class="block uploader">
										<span>+</span>
									</div>
								</label>
								<input id="uploadinput" type="file" name="file"
									   data-contain="uploads_presenter" data-title="Hồ sơ nhân thân" multiple
									   data-type="presenter" class="focus">
							</div>


						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>

					<button type="button" class="btn btn-primary" id="presenter_submit">Xác nhận</button>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>


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
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);

					}
					//Mp3
					else if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
						var item = "";
						item += '<a  href="' + data.path + '" target="_blank"><span style="z-index: 9">' + fileName + '</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" /></a>';
						item += '<button type="button" onclick="deleteImage(this)" data-id="' + contractId + '" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						var data = $('<div ></div>').html(item);
						this.block.append(data);
					}
					//Image
					else {
						var content = "";
						content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"  data-gallery="' + contain + '" data-max-width="992" data-type="image" >';
						content += '<img data-type="' + type + '" data-fileType="' + fileType + '" data-fileName="' + fileName + '" name="img_borrowed"  data-key="' + data.key + '" src="' + data.path + '" />';
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

	function approve(thiz) {

		$('#contract_id').val(thiz)
		$('#approve').modal('show');
	}


	$("#presenter_submit").click(function (event) {
		event.preventDefault();

		var presenter_date = $("#presenter_date").val();

		var presenter_money = $("#presenter_money").val();
		var presenter_buttoan = $("#presenter_buttoan").val();

		var count = $("img[name='img_borrowed']").length;

		var img_approve = {};
		if (count > 0) {
			$("img[name='img_borrowed']").each(function () {
				var data = {};
				type = $(this).data('type');
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				data['key'] = $(this).attr('data-key');
				var key = $(this).data('key');
				if (type == 'presenter') {
					img_approve[key] = data;
				}

			});
		}

		$.ajax({
			url: _url.base_url + '/accountant/update_presenter',
			method: "POST",
			data: {
				id: $('#contract_id').val(),
				presenter_date: presenter_date,
				presenter_money: presenter_money,
				presenter_buttoan: presenter_buttoan,
				img_approve: img_approve,
			},

			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.data.status == 200) {
					console.log("xxx");
					$("#successModal").modal("show");
					$(".msg_success").text('Xác nhận thành công');
					sessionStorage.clear()
					setTimeout(function () {
						window.location.href = _url.base_url + 'accountant/index_list_contractMkt';
					}, 3000);
				} else {

					// $('#errorModal').modal('show');
					// $('.msg_error').text(data.data.message);
					$("#div_errorCreate").css("display", "block");
					$(".div_errorCreate").text(data.data.message);
					// window.scrollTo(0, 0);
					//
					setTimeout(function () {
						// $('#errorModal').modal('hide');
						$("#div_errorCreate").css("display", "none");
					}, 4000);
				}
			},
			error: function (data) {
				console.log("xxx");
				$(".theloading").hide();
			}
		});
	});






</script>


