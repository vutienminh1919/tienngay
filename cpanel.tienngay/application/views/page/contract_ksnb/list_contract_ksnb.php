<div class="right_col" role="main">

	<?php
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
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
					<h3>CÁC KHOẢN VAY ƯU TIÊN</h3>
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
							<button style="background-color: #5A738E" class="btn btn-info show-hide-total-top-ten" data-toggle="modal"
									data-target="#addnewModal_themhopdong">
								Thêm mới
							</button>


							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('contract_ksnb/search') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<label>Phòng giao dịch: </label>
										<select class="form-control" name="store">
											<option value="">-- Tất cả --</option>
											<?php foreach ($stores as $key => $item): ?>
												<?php if ($item->status != "active"){
													continue;
												}
												$check = $item->_id->{'$oid'};
												?>
												<option value="<?= $item->_id->{'$oid'} ?>" <?= (!empty($store) && $store == "$check") ? "selected" : "" ?>><?= $item->name ?></option>
											<?php endforeach; ?>
										</select>

									</li>
									<li class="form-group">
										<label>Họ và tên: </label>
										<input type="text" name="customer_name" class="form-control" value="<?= !empty($customer_name) ? $customer_name : "" ?>">
									</li>
									<li class="form-group">
										<label>Số điện thoại: </label>
										<input type="text" name="customer_phone_number" class="form-control" value="<?= !empty($customer_phone_number) ? $customer_phone_number : "" ?>" maxlength="10">
									</li>
									<li class="form-group">
										<label>Chứng minh thư: </label>
										<input type="text" name="customer_identify" class="form-control" value="<?= !empty($customer_identify) ? $customer_identify : "" ?>">
									</li>
									<li class="form-group">
										<label>Mã phiếu ghi: </label>
										<input type="text" name="code_contract" class="form-control" value="<?= !empty($code_contract) ? $code_contract : "" ?>">
									</li>
									<li class="form-group">
										<label>Mã hợp đồng: </label>
										<input type="text" name="code_contract_disbursement_search" class="form-control" value="<?= !empty($code_contract_disbursement_search) ? $code_contract_disbursement_search : "" ?>">
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
							   class="table table-bordered m-table table-hover table-calendar table-report" style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Mã hợp đồng</th>
								<th style="text-align: center">Tên khách hàng</th>
								<th style="text-align: center">Tiền vay</th>
								<th style="text-align: center">Thời hạn vay</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center">Chức năng</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($contract_ksnb)): ?>
								<?php foreach ($contract_ksnb as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>

										<td style="text-align: center">
											<a href="<?php echo base_url("contract_ksnb/view?id=") . $value->contract->_id[0] ?>"
											   style="cursor:pointer;">
												<?= !empty($value->contract->code_contract_disbursement) ? $value->contract->code_contract_disbursement : "" ?>
											</a>
										</td>


										<td style="text-align: center"><?= !empty($value->contract->customer_infor->customer_name) ? $value->contract->customer_infor->customer_name : "" ?></td>
										<td style="text-align: center"><?= !empty($value->contract->loan_infor->amount_loan) ? number_format($value->contract->loan_infor->amount_loan) : "" ?></td>
										<td style="text-align: center"><?= !empty($value->contract->loan_infor->number_day_loan) ? ($value->contract->loan_infor->number_day_loan) / 30 . " Tháng" : "" ?></td>
										<td style="text-align: center">
											<?php
											$status = !empty($value->contract->status) ? $value->contract->status : "";
											foreach (contract_status() as $key1 => $item) {
												if ($status == $key1) {
													echo $item;
												}
											}
											?>
										</td>
										<td class="text-center">
											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													<i class="fa fa-cogs"></i>
													<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">
													<li>
														<a href="<?php echo base_url("pawn/detail?id=") . $value->contract->_id[0] ?>"
														   class="dropdown-item">
															<i class="fa fa-eye"></i> Chi tiết
														</a>
													</li>
													<li>
														<a href="<?php echo base_url("contract_ksnb/view?id=") . $value->contract->_id[0] ?>"
														   class="dropdown-item">
															<i class="fa fa-pencil-square-o"></i> Tạo phiếu thu
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
<div id="addnewModal_themhopdong" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="text-align: center">THÊM HỢP ĐỒNG ĐỂ THEO DÕI</h4>
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
			<br>
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" style="font-size: 15px">
						Mã hợp đồng
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="code_contract_disbursement" name="code_contract_disbursement[]"
								multiple="multiple">
							<?php if (!empty($code_contract_disbursement)) {
								foreach ($code_contract_disbursement as $key => $obj) { ?>
									<option class="form-control"
											value="<?= $obj ?>"><?= $obj ?></option>
								<?php }
							} ?>
						</select>
						<input id="code_contract_disbursement_value" style="display: none">

					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="submit_ksnb">Thêm</button>
			</div>
		</div>
	</div>
</div>



<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>

<script>
	$('#code_contract_disbursement').selectize({
		create: false,
		valueField: 'code_contract_disbursement',
		labelField: 'name',
		searchField: 'name',
		maxItems: 100,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	$('[name="code_contract_disbursement[]"]').on('change', function (event) {
		event.preventDefault();
		var value = $('#code_contract_disbursement').val();
		var data1 = [];
		if (value != null) {
			data1.push(value);
		}
		$('#code_contract_disbursement_value').val(JSON.stringify(data1));
	})

	$(document).ready(function () {

		$('#submit_ksnb').click(function (event) {
			event.preventDefault();

			if ($('#code_contract_disbursement_value').val() != "") {
				var code_contract_disbursement_value = JSON.parse($('#code_contract_disbursement_value').val());
			}

			console.log(code_contract_disbursement_value)

			$.ajax({
				url: _url.base_url + '/contract_ksnb/create_contract_ksnb',
				method: "POST",
				data: {
					code_contract_disbursement_value: code_contract_disbursement_value,
				},

				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					console.log(data)
					$(".theloading").hide();
					if (data.data.status == 200) {
						$("#successModal").modal("show");
						$(".msg_success").text('Thêm thành công');

						setTimeout(function () {
							window.location.href = _url.base_url + 'contract_ksnb/index_list_contract_ksnb';
						}, 3000);
					} else {

						$("#div_errorCreate").css("display", "block");
						$(".div_errorCreate").text(data.data.message);

						setTimeout(function () {
							$("#div_errorCreate").css("display", "none");
						}, 4000);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			});


		});
	});



</script>







