<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/heyU/validate.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<!-- page content -->
<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "vbi_utv";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";

$code = !empty($_GET['code']) ? $_GET['code'] : "";
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
					<h3>Danh sách thu tiền VBI_UTV</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url() ?>baoHiemVbi/form_vbi_utv" class="btn btn-info">
						<i class="fa fa-plus" aria-hidden="true"></i>
						Thêm giao dịch
					</a>
					<a href="<?php echo base_url() ?>baoHiemVbi/add_utv_transaction_pay_money" class="btn btn-success"
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
								<form action="<?php echo base_url('baoHiemVbi/utv') ?>" method="get"
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
									<!--									<div class="col-xs-12 col-md-6">-->
									<!--										<div class="form-group">-->
									<!--											<label> Tên khách hàng </label>-->
									<!--											<input type="text" name="customer_name" class="form-control">-->
									<!--										</div>-->
									<!--									</div>-->
									<?php if ($tab == 'vbi_utv'): ?>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label> Số điện thoại </label>
												<input type="text" name="customer_phone" class="form-control"
													   value="<?= !empty($customer_phone) ? $customer_phone : "" ?>">
											</div>
										</div>
									<?php endif; ?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<?php if ($tab == 'vbi_utv'): ?>
												<label> Mã giao dịch </label>
											<?php else: ?>
												<label> Mã phiếu thu </label>
											<?php endif; ?>
											<input type="text" name="code" class="form-control"
												   value="<?= !empty($code) ? $code : "" ?>">
										</div>
									</div>
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
					<?php if ($tab != "transaction") {
					if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles)) { ?>
						<a href="<?php echo base_url() ?>excel/exportVbiUtvBn?<?= 'tab='. $tab . '&fdate=' . $fdate . '&tdate=' . $tdate . '&customer_name=' . $customer_name . '&customer_phone=' . $customer_phone . '&code=' . $code . '&code_gic_plt=' . $code_gic_plt . '&filter_by_store=' . $filter_by_store;?>" class="btn btn-success"
						   target="_blank">
							<i class="fa fa-save" aria-hidden="true"></i>
							Xuất Excel
						</a>
					<?php } }?>
				</div>
			</div>
		</div>


		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">

						<div class="col-xs-12 text-right">

							<ul id="myTab1" class="nav nav-tabs bar_tabs left" role="tablist">
								<li role="presentation" class="<?= ($tab == 'vbi_utv') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>baoHiemVbi/utv?tab=vbi_utv"
									   id="naptientaixeheyu1-tabb"
									   aria-expanded="true"> Giao dịch KH</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'transaction') ? 'active' : '' ?>"><a
											href="<?php echo base_url() ?>baoHiemVbi/utv?tab=transaction"
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
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'vbi_utv') ? 'active' : '' ?>"
								 id="naptientaixeheyu1"
								 aria-labelledby="naptientaixeheyu1-tab">
								<?php if ($tab == 'vbi_utv') { ?>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">Mã giao dịch</th>
												<th style="text-align: center">Thời gian nộp tiền</th>
												<th style="text-align: center">Tên khách hàng</th>
												<th style="text-align: center">Số điện thoại</th>
												<th style="text-align: center">Mệnh giá</th>
												<th style="text-align: center">Người giao dịch</th>
												<th style="text-align: center">Người tạo</th>
												<th style="text-align: center">Địa điểm giao dịch</th>
												<th style="text-align: center">Trạng thái</th>
											</tr>
											</thead>

											<tbody>
											<?php if (!empty($transaction)) : ?>
												<?php foreach ($transaction as $key => $value) { ?>
													<tr style="text-align: center">
														<td><?php echo !empty($value->code) ? $value->code : '' ?></td>
														<td><?php echo !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : '' ?></td>
														<td><?php echo !empty($value->customer_info->customer_name) ? $value->customer_info->customer_name : '' ?></td>
														<td><?php echo !empty($value->customer_info->customer_phone) ? $value->customer_info->customer_phone : '' ?></td>
														<td><?php echo !empty($value->fee) ? number_format((int)$value->fee) . " VND" : '' ?></td>
														<td><?php echo !empty($value->created_by) ? $value->created_by : '' ?></td>
														<td><?php echo !empty($value->contract_info->created_by) ? $value->contract_info->created_by : '' ?></td>
														<td><?php echo !empty($value->store->name) ? $value->store->name : '' ?></td>
														<td>
															<?php if ($value->status == 10): ?>
																<span class="label label-info">PGD đã thu tiền</span>
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
												<th style="text-align: center">Chức năng</th>
												<th style="text-align: center">Mã phiếu thu</th>
												<th style="text-align: center">Người giao dịch</th>
												<th style="text-align: center">Thời gian nộp tiền</th>
												<th style="text-align: center">Số tiền đóng</th>
												<th style="text-align: center">Phòng giao dịch</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Kế toán ghi chú</th>

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
																		<a href="<?php echo base_url() ?>baoHiemVbi/detail_utv_transaction?code=<?php echo $value->code ?>">Xem
																			chi tiết
																		</a>
																	</li>
																	<?php
																	if ($value->status == 11) { ?>
																		<li><a class="dropdown-item"
																			   href="<?php echo base_url('transaction/sendApprove?id=' . $value->_id->{'$oid'}); ?>">
																				<?php echo "Gửi kế toán duyệt lại" ?>
																			</a>
																		</li>
																	<?php } ?>
																	<?php
																	if (!in_array($value->status, [1, 3])) {
																		?>
																		<li>
																			<a href="<?php echo base_url("transaction/upload?id=") . $value->_id->{'$oid'} ?>"
																			   class="dropdown-item">
																				Tải lên chứng từ
																			</a></li>
																	<?php } ?>
																	<li>
																		<a href="<?php echo base_url("transaction/viewImg?id=") . $value->_id->{'$oid'} ?>"
																		   class="dropdown-item " target="_blank">
																			Xem chứng từ
																		</a></li>

																</ul>

														</td>
														<td><?= !empty($value->code) ? $value->code : "" ?><br>
															<?php
															if ($value->status == 11) { ?>
																<a class="btn btn-primary" href="<?php echo base_url('transaction/sendApprove?id='.$value->_id->{'$oid'});?>">
																	Gửi duyệt lại
																</a>
															<?php } ?></td>
														<td><?= !empty($value->created_by) ? $value->created_by : "" ?><br>
															<?php
															if (!in_array($value->status, [1,3,11]) ) {
																?>
																<a href="<?php echo base_url("transaction/upload?id=") . $value->_id->{'$oid'} ?>"
																   class="btn btn-primary">
																	Tải lên chứng từ
																</a>
															<?php } ?></td>
														<td><?php echo !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>
														<td><?php echo !empty($value->total) ? number_format($value->total) . " VND" : 0 ?></td>
														<td><?= !empty($value->store->name) ? $value->store->name : ""?></td>
														<td>
															<?php if ($value->status == 2): ?>
																<span
																		class="label label-default">Chờ kế toán xác nhận</span>
															<?php elseif ($value->status == 1): ?>
																<span class="label label-success">Kế toán đã duyệt</span>
															<?php elseif ($value->status == 11): ?>
																<span class="label label-warning">Kế toán trả về</span>
															<?php endif; ?>
														</td>
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
<script src="<?php echo base_url() ?>assets/js/vbi_tnds/index.js"></script>
