<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/heyU/validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<!-- page content -->
<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "heyU";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";
$code_driver_filter = !empty($_GET['code_driver_filter']) ? $_GET['code_driver_filter'] : "";
$name_driver_filter = !empty($_GET['name_driver_filter']) ? $_GET['name_driver_filter'] : "";
$code_heyu = !empty($_GET['code_heyu']) ? $_GET['code_heyu'] : "";
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
					<h3>Danh sách thu tiền HeyU</h3>
				</div>
				<div class="title_right text-right">
					<button class="btn btn-info" data-toggle="modal" data-target="#themgiaodienModal" id="addtransaction">
						<i class="fa fa-plus" aria-hidden="true"></i>
						Thêm giao dịch
					</button>
					<a href="<?php echo base_url() ?>heyU/add_transaction_pay_money" class="btn btn-success"
					   target="_blank">
						<i class="fa fa-save" aria-hidden="true"></i>
						Tạo lệnh đóng tiền
					</a>
					<div class="dropdown" style="display:inline-block">
						<button class="btn btn-success dropdown-toggle"
								onclick="$('#lockdulieu').toggleClass('show');">
							<span class="fa fa-filter"></span>
							Lọc dữ liệu
						</button>
						<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
							style="padding:15px;width:430px;max-width: 85vw;">
							<div class="row">
								<form action="<?php echo base_url('heyU') ?>" method="get"
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
									<?php if ($tab == 'heyU') {?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Mã tài xế </label>
											<input type="text" name="code_driver_filter" class="form-control">

										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Tên tài xế </label>
											<input type="text" name="name_driver_filter" class="form-control">

										</div>
									</div>
									<?php } ?>
									<?php if ($tab == 'transaction') {?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Mã phiếu thu </label>
											<input type="text" name="code_transaction" class="form-control">
										</div>
									</div>
									<?php }?>
									<?php if ($tab == 'heyU') {?>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label> Mã giao dịch </label>
												<input type="text" name="code_heyu" class="form-control">
											</div>
										</div>
									<?php } ?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>PGD:</label>
											<select class="form-control"
													placeholder="Tất cả"
													name="filter_by_store">
												<option value="" selected><?= $this->lang->line('All') ?></option>
												<?php foreach ($storeData as $p) { ?>
													<option <?php echo $store == $p->store_id ? 'selected' : '' ?>
															value="<?php echo $p->store_id; ?>"><?php echo $p->store_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
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
					<?php
					if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles)) { ?>
					<a href="<?php echo base_url() ?>excel/exportHeyU?<?= 'tab='. $tab . '&fdate=' . $fdate . '&tdate=' . $tdate . '&code_driver_filter=' . $code_driver_filter . '&name_driver_filter=' . $name_driver_filter . '&code_transaction=' . $code_transaction . '&filter_by_store=' . $filter_by_store . '&code_heyu=' . $code_heyu ?>" class="btn btn-success"
					   target="_blank">
						<i class="fa fa-save" aria-hidden="true"></i>
						Xuất Excel
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 text-right">
							<ul id="myTab1" class="nav nav-tabs bar_tabs left" role="tablist">
								<li role="presentation" class="<?= ($tab == 'heyU') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>heyU?tab=heyU"
									   id="naptientaixeheyu1-tabb"
									   aria-expanded="true"> Giao dịch KH</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'transaction') ? 'active' : '' ?>"><a
											href="<?php echo base_url() ?>heyU?tab=transaction"
											id="naptientaixeheyu2-tabb"
											aria-expanded="false"> Giao
										dịch đóng tiền</a>
								</li>

							</ul>
						</div>
					</div>


					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<div id="myTabContent2" class="tab-content">
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'heyU') ? 'active' : '' ?>"
								 id="naptientaixeheyu1"
								 aria-labelledby="naptientaixeheyu1-tab">
								<?php if ($tab == 'heyU') { ?>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">Mã giao dịch</th>
												<th style="text-align: center">Thời gian nộp tiền</th>
												<th style="text-align: center">Mã tài xế</th>
												<th style="text-align: center">Tên tài xế</th>
												<th style="text-align: center">Mệnh giá</th>
												<th style="text-align: center">Người giao dịch</th>
												<th style="text-align: center">Địa điểm giao dịch</th>
												<th style="text-align: center">Trạng thái</th>
											</tr>
											</thead>

											<tbody>
											<?php if (!empty($transaction)) : ?>
												<?php foreach ($transaction as $key => $value) { ?>
													<tr style="text-align: center">
														<td><?php echo $value->transaction_code ?></td>
														<td><?php echo date('d/m/Y H:i:s', $value->created_at) ?></td>
														<td><?php echo $value->code_driver ?></td>
														<td><?php echo $value->name_driver ?></td>
														<td><?php echo number_format($value->money) . " VND" ?></td>
														<td><?php echo $value->created_by ?></td>
														<td><?php echo $value->store->name ?></td>
														<td>
															<?php if ($value->status == 10): ?>
																<span class="label label-info">Tài xế đã nạp tiền</span>
															<?php elseif ($value->status == 2): ?>
																<span class="label label-default">Chờ kế toán xác nhận</span>
															<?php elseif ($value->status == 1): ?>
																<span class="label label-success">Kế toán đã duyệt</span>
															<?php elseif ($value->status == 3): ?>
																<span class="label label-danger">Kế toán hủy</span>
															<?php elseif ($value->status == 11): ?>
																<span class="label label-warning">Kế toán trả về</span>
															<?php endif; ?>
														</td>
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
								 id="naptientaixeheyu2"
								 aria-labelledby="naptientaixeheyu2-tab">
								<?php if ($tab == 'transaction') { ?>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">Thao tác</th>
												<th style="text-align: center">Mã phiếu thu</th>
												<th style="text-align: center">Người giao dịch</th>
												<th style="text-align: center">Ngày tạo phiếu thu</th>
												<th style="text-align: center">Số tiền đóng</th>
												<th style="text-align: center">Phòng giao dịch</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Kế toán ghi chú</th>
												<th style="text-align: center">Lý do</th>
											</tr>
											</thead>

											<tbody>
											<?php if (!empty($transaction)) : ?>
												<?php foreach ($transaction as $value) { ?>
													<tr style="text-align: center">
														<td>
															<div class="dropdown">
																<button class="btn btn-secondary dropdown-toggle"
																		type="button" id="dropdownMenuButton"
																		data-toggle="dropdown"
																		aria-haspopup="true"
																		aria-expanded="false" 
																		style="text-align: center; background-color: #5bc0de; color: white">
																	Chức năng
																	<span class="caret"></span></button>
																<ul class="dropdown-menu"
																	style="z-index: 99999;">
																	<li>
																		<a href="<?php echo base_url() ?>heyU/detail_transaction?code=<?php echo $value->code ?>">Xem
																			chi tiết
																		</a>
																	</li>
																	<?php
																	if ($value->status == 11) { ?>
																		<li>
																			<a class="dropdown-item" href="<?php echo base_url('transaction/sendApprove?id='.$value->_id->{'$oid'});?>">
																				Gửi duyệt lại
																			</a>
																		</li>
																	<?php } ?>
																	<?php
																	if (!in_array($value->status, [1,3]) ) {
																		?>
																		<li>
																			<a href="<?php echo base_url("transaction/upload?id=") . $value->_id->{'$oid'} ?>"
																			   class="dropdown-item">
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
														<td style="text-align: center"><?= !empty($value->code) ? $value->code : ""?>
															<br>
															<?php
															if ($value->status == 11) { ?>
																	<a class="btn btn-primary" href="<?php echo base_url('transaction/sendApprove?id='.$value->_id->{'$oid'});?>">
																		Gửi duyệt lại
																	</a>
															<?php } ?>
														</td>
														<td style="text-align: center"><?= !empty($value->created_by) ? $value->created_by : ""?>
															<br>
															<?php
															if (!in_array($value->status, [1,3,11]) ) {
																?>
																	<a href="<?php echo base_url("transaction/upload?id=") . $value->_id->{'$oid'} ?>"
																	   class="btn btn-primary">
																		Tải lên chứng từ
																	</a>
															<?php } ?>
														</td>
														<td><?php  echo !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>
														<td><?php echo !empty($value->total) ? number_format($value->total) . " VND" : 0 ?></td>
														<td><?= !empty($value->store->name) ? $value->store->name : ""?></td>
														<td>
															<?php if ($value->status == 2): ?>
																<span class="label label-default">Chờ kế toán xác nhận</span>
															<?php elseif ($value->status == 1): ?>
																<span class="label label-success">Kế toán đã duyệt</span>
															<?php elseif ($value->status == 11): ?>
																<span class="label label-warning">Kế toán trả về</span>
															<?php elseif ($value->status == 3): ?>
																<span class="label label-danger">Kế toán hủy</span>
															<?php endif; ?>
														</td>
														<td><?php echo !empty($value->approve_note) ? $value->approve_note : ""?></td>
														<td>
														<?php if($value->status != 1 && !empty($value->reasons)) {?>
														<?php foreach ($value->reasons as $reason): ?>
															<div class="form-check" style="text-align: left;">
										  					<input class="form-check-input" type="checkbox" name="reason" value="<?= $reason->id ?>" id="reason<?= $reason->id ?>" checked disabled>
															  <label class="form-check-label" for="reason<?= $reason->id ?>" style="color: red;">
															    <?= $reason->value ?>
															  </label>
															</div>
														<?php endforeach ?>
												        <?php } ?>
														</td>
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


<div id="themgiaodienModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"> Nạp tiền thành viên</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form role="form" id="main_1" class="form-horizontal form-label-left" action="/example"
						  method="post" novalidate>
						<div class="col-xs-12 form-horizontal form-label-left input_mask">
							<div class="row">
								<label class="control-label col-md-4 col-xs-12">Mã tài xế</label>
								<div class="col-md-8 col-xs-12 error_messages">
									<input type="text" class="form-control" placeholder="Mã nhân viên"
										   name="code_driver" id="code_driver">
									<p class="messages"></p>
								</div>
								<label class="control-label col-md-4 col-xs-12 checkNameTaiXe1" style="display: none">Tên tài xế</label>
								<div class="col-md-8 col-xs-12 error_messages checkNameTaiXe1" style="display: none">
									<input type="text" class="form-control text-danger"
										   name="name_driver" id="name_driver" disabled>
									<p class="messages"></p>
								</div>
								<label class="control-label col-md-4 col-xs-12">Số tiền nạp <br> (100.000 - 1.000.0000 đ)
								</label>
								<div class="col-md-8 col-xs-12 error_messages">
									<input type="text" class="form-control" placeholder="Tiền nạp" name="money_driver"
										   id="money_driver">
									<p class="messages"></p>
								</div>
								<label class="control-label col-md-4 col-xs-12">Phòng giao dịch</label>
								<div class="col-md-8 col-xs-12">
									<select name="store" class="form-control">
										<?php foreach ($stores as $store) :
												if (in_array($store->_id->{'$oid'}, $storeDataCentral)) continue; ?>
											<option value="<?php echo $store->_id->{'$oid'} ?>"><?php echo $store->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary recharge_the_driver_btnSave" disabled>OK</button>
			</div>
		</div>

	</div>
</div>
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
	
</script>
<script src="<?php echo base_url() ?>assets/js/heyU/index.js"></script>
