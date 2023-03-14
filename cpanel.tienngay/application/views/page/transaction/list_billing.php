<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/heyU/validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<!-- page content -->
<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "utilities";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$status = !empty($_GET['status']) ? $_GET['status'] : "";
$trading_code = !empty($_GET['trading_code']) ? $_GET['trading_code'] : "";
$service_name = !empty($_GET['service_name']) ? $_GET['service_name'] : "";
$publisher_name = !empty($_GET['publisher_name']) ? $_GET['publisher_name'] : "";
$service_code = !empty($_GET['service_code']) ? $_GET['service_code'] : "";
$code_transaction = !empty($_GET['code_transaction']) ? $_GET['code_transaction'] : "";
$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

?>
<div class="right_col" role="main">
	<div class="theloading" id="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">

			<div class="page-title">
				<div class="title_left">
					<h3>Danh sách Phiếu thu đa tiện ích</h3>
				</div>
				<div class="title_right text-right">
					<?php if ($tab == "utilities") { ?>
					<?php if ($userSession['is_superadmin'] == 1 || in_array("van-hanh", $groupRoles) || in_array("ke-toan", $groupRoles)) { ?>
					<button class="btn btn-info">
						<a href="<?= base_url() ?>excel/exportBillingUtilities?<?= 'tab=' . $tab . '&fdate=' . $fdate . '&tdate=' . $tdate . '&trading_code=' . $trading_code . '&service_name=' . $service_name . '&publisher_name=' . $publisher_name . '&service_code=' . $service_code . '&code_transaction=' . $code_transaction . '&filter_by_store=' . $filter_by_store . '&status=' . $status ?>"
						   class="w-100" target="_blank"
						   style="color: white; font-family: Roboto, Helvetica Neue, Helvetica, Arial">
							Xuất Excel
						</a>
					</button>
					<?php } } ?>
					<div class="dropdown" style="display:inline-block">
						<button class="btn btn-success dropdown-toggle"
								onclick="$('#lockdulieu').toggleClass('show');">
							<span class="fa fa-filter"></span>
							Lọc dữ liệu
						</button>
						<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
							style="padding:15px;width:430px;max-width: 85vw;">
							<div class="row">
								<form action="<?php echo base_url('transaction/getBillingUtilities') ?>" method="get"
									  style="width: 100%">
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Từ </label>
											<input type="date" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Đến </label>
											<input type="date" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>">

										</div>
									</div>
									<?php if ($tab == 'utilities') {?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>Dịch vụ</label>
											<select class="form-control service_code"
													id="service_code"
													placeholder="Tất cả"
													name="service_code">
												<option value="" selected>Tất cả</option>
												<?php if (!empty($services)) {
													foreach ($services as $service) { ?>
														<option <?php echo $service_code == $service->service_code ? 'selected' : '' ?>
																value="<?php echo $service->service_code; ?>">
															<?php echo $service->name; ?>
														</option>
													<?php }
												} ?>
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>Nhà phát hành</label>
											<select class="form-control service_name"
													id="service_name"
													placeholder="Tất cả"
													name="service_name">
												<option selected value="">Tất cả</option>
												
											</select>
										</div>
									</div>
									<?php }?>
									<?php if ($tab == 'transaction') {?>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label> Mã phiếu thu </label>
												<input type="text" name="code_transaction" class="form-control" placeholder="Nhập mã phiếu thu">
											</div>
										</div>
									<?php }?>
									<?php if ($tab == 'utilities') {?>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label> Mã giao dịch </label>
												<input type="text" name="trading_code" class="form-control" placeholder="Nhập mã giao dịch">
											</div>
										</div>
									<?php }?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>PGD:</label>
											<select class="form-control"
													placeholder="Tất cả"
													name="filter_by_store">
												<option value="" selected>Tất cả</option>
												<?php foreach ($storeData as $p) { ?>
													<option <?php echo $filter_by_store == $p->store_id ? 'selected' : '' ?>
															value="<?php echo $p->store_id; ?>"><?php echo $p->store_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php if ($tab == 'utilities') {?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>Trạng thái </label>
											<select class="form-control"
													placeholder="Tất cả"
													name="status">
												<option value="" selected>Tất cả</option>
												<option <?php echo $status == "success" ? 'selected' : ''?> value="success">Thanh toán thành công</option>
												<option <?php echo $status == "new" ? 'selected' : ''?> value="new">Chờ thanh toán</option>
												<option <?php echo $status == "failed" ? 'selected' : ''?> value="failed">Thanh toán thất bại</option>
												<option <?php echo $status == "vimo" ? 'selected' : ''?> value="failed">Đã gửi Vimo</option>
											</select>
										</div>
									</div>
									<?php } ?>
									<div class="col-xs-12 col-md-6">
										<input type="hidden" name="tab" class="form-control"
											   value="<?= !empty($tab) ? $tab : "" ?>">
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>&nbsp;</label> <br>
											<button class="btn btn-primary w-100">Tìm kiếm</button>
										</div>
									</div>
								</form>
							</div>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 text-right">
							<ul id="myTab1" class="nav nav-tabs bar_tabs left" role="tablist">
								<li role="presentation" class="<?= ($tab == 'utilities') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>transaction/getBillingUtilities?tab=utilities"
									   id=""
									   aria-expanded="true"> Giao dịch với KH</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'transaction') ? 'active' : '' ?>"><a
											href="<?php echo base_url() ?>transaction/getBillingUtilities?tab=transaction"
											id=""
											aria-expanded="false"> 
										Giao dịch với Kế toán</a>
								</li>

							</ul>
						</div>
					</div>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<div id="myTabContent2" class="tab-content">
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'utilities') ? 'active' : '' ?>"
								 id=""
								 aria-labelledby="">
								<?php if ($tab == 'utilities') { ?>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th>#</th>
												<th>In hóa đơn</th>
												<th>Mã giao dịch</th>
												<th>Thời gian nộp tiền</th>
												<th>Dịch vụ</th>
												<th>Nhà phát hành</th>
												<th>Tên khách hàng</th>
												<th>Số điện thoại</th>
												<th>Số tiền</th>
												<th>Trạng thái</th>
												<th>Nhân viên giao dịch</th>
												<th>Địa điểm giao dịch</th>
												<?php if ($userSession['is_superadmin'] == 1 || in_array("tpb-ke-toan", $groupRoles)) { ?>
													<th>Chức năng</th>
												<?php } ?>
												
											</tr>
											</thead>

											<tbody>
											<?php if (!empty($transaction)) : ?>
												<?php foreach ($transaction as $key => $value) { ?>
													<tr>
														<td><?php echo $key + 1;?></td>
														<td>
															<?php if ($value->status == "success") { ?>
															<a href="<?php echo base_url('transaction/detail/'.$value->transaction_id)?>" class="btn btn-info" target="_blank">
																<?php echo $this->lang->line('print_order')?>
															</a>
															<?php } ?>
														</td>
														<td><?= !empty($value->mc_request_id) ? $value->mc_request_id : "" ?></td>
														<td><?= !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>
														<td><?= !empty($value->service_name) ? $value->service_name : "" ?></td>
														<td><?= !empty($value->publisher_name) ? $value->publisher_name : "" ?></td>
														<td><?= !empty($value->customer_bill_name) ? $value->customer_bill_name : "" ?></td>
														<td><?= !empty($value->customer_bill_phone) ? hide_phone($value->customer_bill_phone) : "" ?></td>
														<td><?= !empty($value->money) ? number_format($value->money) . " VND" : "" ?></td>
														<td>
															<?php if ($value->status == "success"): ?>
																<span class="label label-success">Thanh toán thành công</span>
																	<?php if ( in_array("tpb-ke-toan", $groupRoles)) { ?>
												
												
				<a href="javascript:void(0)" onclick="show_popup_info_revert('<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>','<?= !empty($value->mc_request_id) ? $value->mc_request_id : "" ?>')"
				
					class="btn btn-info ke_toan_truong_revert"> Revert </a>
					<?php } ?>
															<?php elseif ($value->status == "new"): ?>
																<span class="label label-default">Chờ thanh toán</span>
															<?php elseif ($value->status == "vimo"): ?>
																<span class="label label-info">Đã gửi Vimo</span>
															<?php elseif ($value->status == "failed"): ?>
																<span class="label label-warning">Thanh toán thất bại</span>
																<?php elseif ($value->status == "revert"): ?>
																<span class="label label-warning">Đã gửi revert</span>
															<?php endif; ?>
														</td>
														<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
														<td><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
													
														
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center">
													<td colspan="10">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>

									<div>
										<nav class="text-right">
											<?php echo $pagination ?>
										</nav>
									</div>
								<?php } ?>
							</div>


							<div role="tabpanel"
								 class="tab-pane fade in <?= ($tab == 'transaction') ? 'active' : '' ?>"
								 id=""
								 aria-labelledby="">
								<?php if ($tab == 'transaction') { ?>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">Chức năng</th>
												<th style="text-align: center">Mã phiếu thu</th>
												<th style="text-align: center">Thời gian nộp tiền</th>
												<th style="text-align: center">Khách hàng</th>
												<th style="text-align: center">Số điện thoại</th>
												<th style="text-align: center">Số tiền đóng</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Người giao dịch</th>
												<th style="text-align: center">Phòng giao dịch</th>
												<th style="text-align: center">Kế toán ghi chú</th>
												
											</tr>
											</thead>

											<tbody>
											<?php if (!empty($transaction)) : ?>
												<?php foreach ($transaction as $key => $value) { ?>
													<tr style="text-align: center">
														<td><?php echo $key + 1;?></td>
														<td>
															<div class="dropdown">
																<button class="btn btn-secondary dropdown-toggle"
																		type="button" id="dropdownMenuButton"
																		data-toggle="dropdown"
																		aria-haspopup="true"
																		aria-expanded="false"
																		style="text-align: center;background-color: #5bc0de;color: white">
																	Chức năng
																	<span class="caret"></span></button>
																<ul class="dropdown-menu"
																	style="z-index: 99999;">
																	<li>
																		<a href="<?php echo base_url() ?>transaction/view/<?php echo $value->_id->{'$oid'} ?>" target="_blank">
																			Xem chi tiết
																		</a>
																	</li>
																	<?php if ($value->status_order == "success") { ?>
																	<li>
																		<a href="<?php echo base_url('transaction/detail/'.$value->_id->{'$oid'})?>" target="_blank">
																			In hóa đơn
																		</a>
																	</li>
																	<?php } ?>
																	<?php
																	if ($value->status == 11) { ?>
																		<li><a class="dropdown-item"
																			   href="<?php echo base_url('transaction/sendApprove?id=' . $value->_id->{'$oid'}); ?>" target="_blank">
																				<?php echo "Gửi kế toán duyệt lại" ?>
																			</a>
																		</li>
																	<?php } ?>
																	<?php
																	if (!in_array($value->status, [1, 3])) {
																		?>
																		<li>
																			<a href="<?php echo base_url("transaction/upload?id=") . $value->_id->{'$oid'} ?>"
																			   class="dropdown-item" target="_blank">
																				Tải lên chứng từ
																			</a></li>
																	<?php } ?>
																	<li>
																		<a href="<?php echo base_url("transaction/viewImg?id=") . $value->_id->{'$oid'} ?>"
																		   class="dropdown-item ">
																			Xem chứng từ
																		</a></li>

																</ul>

														</td>
														<td><?= !empty($value->code) ? $value->code : "" ?></td>
														<td><?php echo !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>
														<td><?= !empty($value->created_by) ? $value->customer_bill_name : "" ?></td>
														<td><?= !empty($value->created_by) ? hide_phone($value->customer_bill_phone) : "" ?></td>
														<td><?php echo !empty($value->total) ? number_format($value->total) . " VND" : 0 ?></td>
														<td>
															<?php if ($value->status == 1): ?>
																<span class="label label-success">Thanh toán thành công</span>
															<?php elseif ($value->status == "new"): ?>
																<span class="label label-default">Chờ thanh toán</span>
															<?php elseif ($value->status == 3): ?>
																<span class="label label-warning">Thanh toán thất bại</span>
															<?php endif; ?>
														</td>
														<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
														<td><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
														<td><?php echo !empty($value->approve_note) ? $value->approve_note : "" ?></td>
														
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center">
													<td colspan="10">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>
									<div>
										<nav class="text-right">
											<?php echo $pagination ?>
										</nav>
									</div>
								<?php } ?>
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>


	</div>
</div>
<!-- /page content -->

<style>
	.help-block {
		display: inline-block !important;
		margin: 0px !important;
	}

	.has-error {
		border-color: #9f041b !important;
	}

	.has-success {
		border-color: #35DB00 !important;
	}
</style>
<script>
	function show_popup_info_revert(id_order,code_order) {
	
			$("#message_revert_contract").text("Bạn có chắc chắn muốn revert giao dịch có mã : "+code_order+" ");
			
			$("input[name='id_order']").val(id_order);
			$("#modal_revert_order").modal('show');
		}
	const $menu = $('.dropdown');
	$(document).mouseup(e => {
		if (!$menu.is(e.target)
				&& $menu.has(e.target).length === 0) {
			$menu.removeClass('is-active');
			$('.dropdown-menu').removeClass('show');
		}
	});
	$('.dropdown-toggle').on('click', () => {
		$menu.toggleClass('is-active');
	});
	
	$(document).ready(function () {
		$('.service_code').on('change', function (event) {
			var data = $('#service_code').val();
			var formData = {
				service_code: data
			};
			console.log(formData);
			$("#service_name option").remove();
			$.ajax({
				url: _url.base_url + '/Transaction/get_service_name_by_service_code',
				type: 'POST',
				data: formData,
				dataType: 'json',
				beforeSend: function(){$("#loading").show();},
				success: function (response) {
					console.log(response);
					$.each(response.data, function (k, v) {
						$('#service_name').append($('<option>', {value: v.code, text: v.name}));
					})
				},
				error: function (response) {
					console.log(response);
				}
			});
		});
			$('.revert_order_btnSave').click(function (event) {
		event.preventDefault();
		
		var id_order = $("input[name='id_order']").val()
		

		var formData = new FormData();
		formData.append('id_order', id_order);
    	$.ajax({
			url: _url.base_url + 'transaction/revert_order',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$("#modal_revert_order").hide();
				$(".theloading").show();

			},
			success: function (data) {
				$(".theloading").hide();
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					
					setTimeout(function () {
						window.location.reload();
					}, 2000);

					
					
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				}

			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			}

		})
	});
			
	});
</script>

<div id="modal_revert_order" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title tittle_code text-center"></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 form-label-left input_mask">
						<div class="row">
							<div class="form-group">
					<p id='message_revert_contract'>Bạn có chắc chắn muốn revert giao dịch này  ?</p>
				
					
				</div>
						
							<input type="hidden" name="id_order">
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary revert_order_btnSave">OK</button>
			</div>
		</div>

	</div>
</div>