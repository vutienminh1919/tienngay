<!-- page content -->
<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<div class="right_col" role="main">

	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Danh sách phí bảo hiểm PTI VTA
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Danh sách phí bảo hiểm PTI VTA
							</a>
						</small>
					</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url('Pti_vta_fee/createPtiFee') ;?>" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i>Thêm mới</a>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="title_right">

			</div>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-12">
					<div class="x_panel">
						<div class="x_content">
							<table id="datatable-button" class="table table-striped">
								<thead>
								<tr>
									<th style="text-align: center">#</th>
									<th style="text-align: center">Tên gói bảo hiểm</th>
									<th style="text-align: center">Từ ngày</th>
									<th style="text-align: center">Đến ngày</th>
									<th style="text-align: center">Người cập nhật</th>
									<th style="text-align: center" class="text-right">Trạng thái</th>
									<th style="text-align: center" class="text-right">Chi tiết</th>
								</tr>
								</thead>
								<tbody align="center">
								<?php if (!empty($pti_fee)):
									foreach ($pti_fee as $key => $fee):
										?>
										<tr>
											<td><?php echo $key + 1; ?></td>
											<td><?= !empty($fee->packet) ? $fee->packet : "" ?></td>
											<td><?= !empty($fee->start_date) ? date('d/m/Y H:i:s', ($fee->start_date)) : date('d/m/Y H:i:s', ($fee->start_date)) ?></td>
											<td><?= !empty($fee->end_date) ? date('d/m/Y H:i:s', ($fee->end_date)) : date('d/m/Y H:i:s', ($fee->end_date)) ?></td>
											<td><?= !empty($fee->created_by) ? $fee->created_by : "" ?></td>
											<?php if (!empty($fee->status) && $fee->status == 'deactivate') { ?>
												<td>
													<center class="pointer-event">
														<input class='aiz_switchery' type="checkbox" disabled
															   data-set='status'
															   data-id="<?php echo $fee->_id->{'$oid'} ?>"
															   data-status="<?= !empty($fee->status) ? $fee->status : ""; ?>"
															<?php $status = !empty($fee->status) ? $fee->status : "";
															echo ($status == 'active') ? 'checked' : ''; ?>
														/></center>
												</td>
											<?php } else { ?>
												<td>
													<center class="parent_switchery">
														<input class='aiz_switchery' type="checkbox" disabled
															   data-set='status'
															   data-id="<?php echo $fee->_id->{'$oid'} ?>"
															   data-status="<?= !empty($fee->status) ? $fee->status : ""; ?>"
															<?php $status = !empty($fee->status) ? $fee->status : "";
															echo ($status == 'active') ? 'checked' : ''; ?>
														/></center>
												</td>
											<?php } ?>


											<td class="sorting_1">
												<button class="btn btn-primary text-right"
														data-toggle="modal"
														data-target="#modal_update_<?= !empty($fee->_id->{'$oid'}) ? $fee->_id->{'$oid'} : '' ?>">
													Xem chi tiết
												</button>
												<div id="modal_update_<?= !empty($fee->_id->{'$oid'}) ? $fee->_id->{'$oid'} : '' ?>"
													 class="modal fade"
													 role="dialog">
													<div class="modal-dialog modal-lg">
														<!-- Modal content-->
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close"
																		data-dismiss="modal">×
																</button>
																<h4 class="modal-title">Chi tiết quyền lợi và phí bảo hiểm</h4>
															</div>
															<div class="modal-body">
																<div class="row">
																	<div class="col-md-12 col-xs-12">
																		<div class="form-group">
																			<div class="input-group">
																				<div class="input-group-addon">Title :
																				</div>
																				<input type="text" id="title"
																					   class="form-control"
																					   value="<?= !empty($fee->title_fee) ? $fee->title_fee : ''; ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xs-3">
																		<div class="form-group">
																			<div class="input-group">
																				<div class="input-group-addon">From :
																				</div>
																				<input type="date" id="from"
																					   class="form-control"
																					   value="<?= !empty($fee->start_date) ? date('Y-m-d', ($fee->start_date)) : date('Y-m-d', ($fee->start_date)) ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xs-3">
																		<div class="form-group">
																			<div class="input-group">
																				<div class="input-group-addon">To :
																				</div>
																				<input type="date" id="to"
																					   class="form-control"
																					   value="<?= !empty($fee->end_date) ? date('Y-m-d', ($fee->end_date)) : date('Y-m-d', ($fee->end_date)) ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xs-12">
																		<div role="tabpanel" name="div_type_30"
																			 class="tab-pane fade active in"
																			 id="day_30_5e3a3232d6612b35311f06e8"
																			 aria-labelledby="home-tab">

																			<div class="row">
																				<div name="div_detail" data-type="CC"
																					 class="col-xs-12 col-md-12"
																					 style="border-right: 1px solid #ccc;">
																					<h4> Gói <?= !empty($fee->number_packet) ? $fee->number_packet : "" ?>
																						: </h4>
																				</div>
																				<div name="div_detail" data-type="CC"
																					 class="col-xs-12 col-md-12"
																					 style="border-right: 1px solid #ccc;">
																					<div class="row">
																								<div class="col-xs-12 col-md-6"
																									 style="border-right: 1px solid #cccccc ">
																									<div class="form-group">
																										<div class="input-group">
																											<div class="input-group-addon">
																												Tên gói
																											</div>
																											<input type="text"
																												   disabled=""
																												   value="<?= !empty($fee->packet) ? $fee->packet : ""; ?>"
																												   name="percent_interest_customer"
																												   data-name="percent_interest_customer"
																												   class="form-control number">
																										</div>
																									</div>
																								</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Phí 3 tháng
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->three_month) ? $fee->three_month . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Tử vong do tai nạn
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->died_fee) ? $fee->died_fee . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Phí 6 tháng
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->six_month) ? $fee->six_month . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Chi phí y tế điều trị
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->therapy_fee) ? $fee->therapy_fee . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Phí 12 tháng
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->twelve_month) ? $fee->twelve_month . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																									 style="border-right: 1px solid #cccccc ">
																									<div class="form-group">
																										<div class="input-group">
																											<div class="input-group-addon">
																												Quyền lợi khi NĐBH tử vong
																											</div>
																											<input type="text"
																												   disabled=""
																												   value="<?= !empty($fee->quy_one) ? $fee->quy_one . ' VNĐ': ""; ?>"
																												   name="percent_interest_customer"
																												   data-name="percent_interest_customer"
																												   class="form-control number">
																										</div>
																									</div>
																								</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Quyền lợi khi điều trị
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->quy_two) ? $fee->quy_two . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Quỹ hỗ trợ khi NĐBH tử vong sau 03 ngày, từ ngày bắt đầu BH
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->quy_three) ? $fee->quy_three . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Quỹ trợ cấp nằm viện điều trị dịch bệnh
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->quy_four) ? $fee->quy_four . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Quỹ hỗ trợ NĐBH tử vong do sốc phản vệ
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->quy_five) ? $fee->quy_five . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
																								</div>
																							</div>
																						</div>
																						<div class="col-xs-12 col-md-6"
																							 style="border-right: 1px solid #cccccc ">
																							<div class="form-group">
																								<div class="input-group">
																									<div class="input-group-addon">
																										Quỹ trợ cấp điều trị sốc phản vệ
																									</div>
																									<input type="text"
																										   disabled=""
																										   value="<?= !empty($fee->quy_six) ? $fee->quy_six . ' VNĐ' : ""; ?>"
																										   name="percent_interest_customer"
																										   data-name="percent_interest_customer"
																										   class="form-control number">
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
															<div class="modal-footer">
																<button type="button" class="btn btn-default"
																		data-dismiss="modal">Đóng
																</button>
															</div>
														</div>
													</div>
												</div>
											</td>

										</tr>
									<?php endforeach;
								endif;
								?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/activeit.min.js"></script>

<style type="text/css">
	.w-25 {
		width: 8% !important;
	}
</style>
<script>
	$(document).ready(function () {
		set_switchery();

		function set_switchery() {
			$(".aiz_switchery").each(function () {
				new Switchery($(this).get(0), {
					color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'
				});
				var changeCheckbox = $(this).get(0);
				var id = $(this).data('id');
				var status = $(this).data('status');
				console.log(status);
				changeCheckbox.onchange = function () {
					$.ajax({
						url: _url.base_url + 'WebsiteCTVTienNgay/doUpdateStatus?id=' + id + '&status=' + changeCheckbox.checked,
						success: function (result) {
							console.log(result.res);
							if (changeCheckbox.checked == true) {
								$.activeitNoty({
									type: 'success',
									icon: 'fa fa-check',
									message: result.message,
									container: 'floating',
									timer: 3000
								});
							} else {
								$.activeitNoty({
									type: 'danger',
									icon: 'fa fa-check',
									message: result.message,
									container: 'floating',
									timer: 3000
								});
							}
							if (result.res == true) {
								toastr.success(result.message, {
									timeOut: 5000,
								});
							} else {
								toastr.error(result.message, {
									timeOut: 5000,
								});
							}
						}
					});
				};
			});
		}
	});
</script>
<style>
	.pointer-event {
		pointer-events: none;
	}
</style>
