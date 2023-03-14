<!-- page content -->
<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<div class="right_col" role="main">

	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Quản lý hoa hồng
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Quản lý
								phí</a>
						</small>
					</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url('WebsiteCTVTienNgay/createCommission') ;?>" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i>Thêm mới</a>
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
									<th style="text-align: center">Tên gói hoa hồng</th>
									<th style="text-align: center">Từ ngày</th>
									<th style="text-align: center">Đến ngày</th>
									<th style="text-align: center">Người cập nhật</th>
									<th style="text-align: center" class="text-right">Trạng thái</th>
									<th style="text-align: center" class="text-right">Chi tiết</th>
								</tr>
								</thead>
								<tbody align="center">
								<?php if (!empty($listCommission)):
									foreach ($listCommission as $key => $list):
										?>
										<tr>
											<td><?php echo $key + 1; ?></td>
											<td><?= !empty($list->product_type->text) ? $list->product_type->text : "" ?></td>
											<td><?= !empty($list->start_date) ? date('d/m/Y H:i:s', strtotime($list->start_date)) : date('d/m/Y H:i:s', strtotime($list->start_date)) ?></td>
											<td><?= !empty($list->end_date) ? date('d/m/Y H:i:s', strtotime($list->end_date)) : date('d/m/Y H:i:s', strtotime($list->end_date)) ?></td>
											<td><?= !empty($list->created_by) ? $list->created_by : "" ?></td>
											<?php if (!empty($list->status) && $list->status == 'deactivate') { ?>
												<td>
													<center class="pointer-event">
														<input class='aiz_switchery' type="checkbox"
															   data-set='status'
															   data-id="<?php echo $list->_id->{'$oid'} ?>"
															   data-status="<?= !empty($list->status) ? $list->status : ""; ?>"
																<?php $status = !empty($list->status) ? $list->status : "";
																echo ($status == 'active') ? 'checked' : ''; ?>
														/></center>
												</td>
											<?php } else { ?>
												<td>
													<center class="parent_switchery">
														<input class='aiz_switchery' type="checkbox"
															   data-set='status'
															   data-id="<?php echo $list->_id->{'$oid'} ?>"
															   data-status="<?= !empty($list->status) ? $list->status : ""; ?>"
																<?php $status = !empty($list->status) ? $list->status : "";
																echo ($status == 'active') ? 'checked' : ''; ?>
														/></center>
												</td>
											<?php } ?>


											<td class="sorting_1">
												<button class="btn btn-primary text-right"
														data-toggle="modal"
														data-target="#modal_update_<?= !empty($list->_id->{'$oid'}) ? $list->_id->{'$oid'} : '' ?>">
													Xem chi tiết
												</button>
												<div id="modal_update_<?= !empty($list->_id->{'$oid'}) ? $list->_id->{'$oid'} : '' ?>"
													 class="modal fade"
													 role="dialog">
													<div class="modal-dialog modal-lg">
														<!-- Modal content-->
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close"
																		data-dismiss="modal">×
																</button>
																<h4 class="modal-title">Chi tiết hoa hồng</h4>
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
																					   value="<?= !empty($list->title_commission) ? $list->title_commission : ''; ?>">
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
																					   value="<?= !empty($list->start_date) ? date('Y-m-d', strtotime($list->start_date)) : date('Y-m-d', strtotime($list->start_date)) ?>">
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
																					   value="<?= !empty($list->end_date) ? date('Y-m-d', strtotime($list->end_date)) : date('Y-m-d', strtotime($list->end_date)) ?>">
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
																					<h4> <?= !empty($list->product_type->text) ? $list->product_type->text : "" ?>
																						: </h4>
																				</div>
																				<div name="div_detail" data-type="CC"
																					 class="col-xs-12 col-md-12"
																					 style="border-right: 1px solid #ccc;">
																					<div class="row">
																						<?php if (!empty($list->product_list)) :
																							foreach ($list->product_list as $pro) :
																								?>
																								<div class="col-xs-12 col-md-6"
																									 style="border-right: 1px solid #cccccc ">
																									<div class="form-group">
																										<div class="input-group">

																											<div class="input-group-addon">
																												<?= !empty($pro->name) ? $pro->name : ""; ?>
																											</div>

																											<input type="text"
																												   disabled=""
																												   value="<?= !empty($pro->percent) ? $pro->percent . '%' : ""; ?>"
																												   name="percent_interest_customer"
																												   data-name="percent_interest_customer"
																												   class="form-control number">
																										</div>
																									</div>
																								</div>
																							<?php endforeach;
																						endif; ?>
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
