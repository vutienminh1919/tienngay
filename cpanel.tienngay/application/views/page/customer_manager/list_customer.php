<div class="right_col" role="main">
	<?php
	$customer_code = !empty($_GET['customer_code']) ? $_GET['customer_code'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
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
					<h3>QUẢN LÝ KHÁCH HÀNG</h3>
				</div>
			</div>
		</div>


		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách khách hàng</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">
							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('customer_manager/search') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<label>Mã khách hàng: </label>
										<input type="text" name="customer_code" class="form-control"
											   value="<?= !empty($customer_code) ? $customer_code : "" ?>">
									</li>
									<li class="form-group">
										<label>Tên khách hàng: </label>
										<input type="text" name="customer_name" class="form-control"
											   value="<?= !empty($customer_name) ? $customer_name : "" ?>">
									</li>
									<li class="form-group">
										<label>Số CMND/CCCD: </label>
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
								<th style="width: 1%">#</th>
								<th style="text-align: center">Mã khách hàng</th>
								<th style="text-align: center">Tên khách hàng</th>
								<th style="text-align: center">Loại giấy tờ</th>
								<th style="text-align: center">Số</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center"></th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($result)): ?>
								<?php foreach ($result as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value->customer_code) ? $value->customer_code : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->customer_name) ? $value->customer_infor->customer_name : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->customer_identify_name) ? $value->customer_infor->customer_identify_name : "" ?></td>
										<td style="text-align: center"><?= !empty($value->customer_infor->customer_identify) ? $value->customer_infor->customer_identify : "" ?></td>
										<td style="text-align: center">
											<?php
											$status = "";

											if (count((array)$value->status) > 1) {
												sort($value->status);

												foreach ($value->status as $item) {
													if ($item < 17 || $item == 35 || $item == 36) {
														$status = "Đã có hồ sơ";
													}
													if ($item >= 17 && $item != 35 && $item != 36) {
														$status = "Đang vay";
													}
													if ($item > 17 && $item != 35 && $item != 36) {
														$status = "Tái vay";
													}
													if ($item == 19) {
														$status = "Đã tất toán";
													}
													if ($item == 19) {
														$status = "Đã tất toán";
													}

												}

												if ($status == "Đã tất toán") {
													rsort($value->status);

													foreach ($value->status as $item) {
														if (count($value->status) == 2){
															if ($item < 17 || $item == 35 || $item == 36 || $item == 19) {
																$status = "Đã tất toán";
															}
														}
														if (count($value->status) >= 2){
															if ($item == 19) {
																$status = "Đã tất toán";
															}
														}
														if ($item >= 17 && $item != 35 && $item != 36 && $item != 19) {
															$status = "Tái vay";
														}
													}
												}
											} else {
												if ($value->status < 17 || $value->status == 35 || $value->status == 36) {
													$status = "Đã có hồ sơ";
												}
												if ($value->status >= 17 && $item != 35 && $item != 36) {
													$status = "Đang vay";
												}
												if ($value->status == 19) {
													$status = "Đã tất toán";
												}
												if ($value->status == -1) {
													$status = "App Khách Hàng";
												}
											}


											?>
											<?php if ($status == "Đã có hồ sơ"): ?>
												<span class="label label-success"
													  style="font-size: 15px; background-color: #EACA4A; padding: 7px;color: white">Đã có hồ sơ</span>
											<?php elseif ($status == "Đang vay") : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #56B6F7; padding: 7px; color: white">Đang vay</span>
											<?php elseif ($status == "Tái vay") : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #F3616D; padding: 7px; color: white">Tái vay</span>
											<?php elseif ($status == "Đã tất toán") : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #4FBE87; padding: 7px; color: white">Đã tất toán</span>
											<?php elseif ($status == "App Khách Hàng") : ?>
												<span class="label "
													  style="font-size: 15px; background-color: #96529cba; padding: 7px; color: white">Đăng ký app</span>
											<?php endif; ?>

										</td>
										<td class="text-center">
											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													<i class="fa fa-cogs"></i>
													<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">
													<?php if ($status != "App Khách Hàng"): ?>
														<li>
															<a href="<?php echo base_url("customer_manager/detail?id=") . $value->id_contract->{'$oid'} . '&customer_code=' . $value->customer_code . '&customer_identify_name=' . $value->customer_infor->customer_identify_name ?>"
															   class="dropdown-item">
																Xem chi tiết
															</a>
														</li>
														<li>
															<a href="<?php echo base_url("customer_manager/detail_edit?id=") . $value->id_contract->{'$oid'} . '&customer_code=' . $value->customer_code . '&customer_identify_name=' . $value->customer_infor->customer_identify_name ?>"
															   class="dropdown-item">
																Cập nhật CCCD
															</a>
														</li>

														<li>
															<a onclick="call_for_customer('<?= !empty($value->customer_infor->customer_phone_number) ? encrypt($value->customer_infor->customer_phone_number) : "" ?>' , '<?= !empty($value->id_contract->{'$oid'}) ? $value->id_contract->{'$oid'} : "" ?>', 'customer')"
															   class="call_for_customer">Gọi điện</a>
														</li>
													<?php endif; ?>
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










