<!-- page content -->
<div class="right_col" role="main">
	<?php
	$from_date = !empty($_GET['from_date']) ? $_GET['from_date'] : "";
	$to_date = !empty($_GET['to_date']) ? $_GET['to_date'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$code = !empty($_GET['code']) ? $_GET['code'] : "";
	$name_ctv = !empty($_GET['name_ctv']) ? $_GET['name_ctv'] : "";
	$sdt_ctv = !empty($_GET['sdt_ctv']) ? $_GET['sdt_ctv'] : "";
	$code_transaction_bank = !empty($_GET['code_transaction_bank']) ? $_GET['code_transaction_bank'] : "";
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
				<div class="row">
					<div class="col-xs-12">

						<div class="page-title">
							<div class="title_left">
								<h3>DANH SÁCH GIAO DỊCH THANH TOÁN HOA HỒNG CTV TIENNGAY</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<br>
							<div class="row">
								<div class="col-xs-12 col-md-3">&nbsp;</div>
								<div class="col-xs-12 col-md-3">
								</div>
								<div class="col-xs-12 col-md-6 text-right" style="margin-bottom: 10px;">
									<?php
									if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
										<button class="btn btn-info">
											<a href="<?= base_url() ?>excel/exportTransactionCtv?
											<?=
											'from_date=' . $from_date .
											'&to_date=' . $to_date .
											'&code=' . $code .
											'&code_transaction_bank=' . $code_transaction_bank .
											'&ctv_name=' . $ctv_name .
											'&ctv_phone=' . $ctv_phone .
											'&status=' . $status ?>"
											   class="w-100" target="_blank"
											   style="color: white; font-family: Roboto, Helvetica Neue, Helvetica, Arial">
												Xuất Excel
											</a>
										</button>
									<?php } ?>
									<div class="dropdown" style="display:inline-block">
										<button class="btn btn-success dropdown-toggle"
												onclick="$('#lockdulieu').toggleClass('show');">
											<span class="fa fa-filter"></span>
											Lọc dữ liệu
										</button>
										<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
											style="padding:15px;width:550px;max-width: 85vw;">
											<div class="row">
												<form action="<?php echo base_url('transaction/list_trans_ctv') ?>" method="get"
													  style="width: 100%">
													<div class="col-xs-12 col-md-6">
														<input type="hidden" name="tab" value="<?= $tab ?>">
														<div class="form-group">
															<label> Từ </label>
															<input type="date" name="from_date" class="form-control"
																   value="<?= !empty($from_date) ? $from_date : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Đến </label>
															<input type="date" name="to_date" class="form-control"
																   value="<?= !empty($to_date) ? $to_date : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Tên cộng tác viên:</label>
															<input type="text" class="form-control" name="name_ctv" placeholder="Nhập mã phiếu thu">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>SĐT CTV:</label>
															<input type="text" class="form-control" name="sdt_ctv" placeholder="Nhập mã phiếu thu">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Mã phiếu thu:</label>
															<input type="text" class="form-control" name="code" placeholder="Nhập mã phiếu thu">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Mã GD ngân hàng </label>
															<input type="text" name="code_transaction_bank"
																   class="form-control"
																   value="<?= $code_transaction_bank ?>"
																   placeholder="Nhập mã giao dịch ngân hàng">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Trạng thái:</label>
															<select class="form-control"
																	placeholder="Tất cả"
																	name="status">
																<option value="" <?php echo $status == '-' ? 'selected' : '' ?>>
																	Tất cả
																</option>
																<?php foreach (status_transaction() as $key => $value) {
																	if (!in_array($key, [1,2,3])) continue;
																	?>
																	<option <?php echo $status == $key ? 'selected' : '' ?>
																		value="<?= $key ?>"> <?= $value ?>
																	</option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>&nbsp;</label> <br>
															<button class="btn btn-primary w-100">Tìm kiếm</button>
														</div>
													</div>
												</form>
											</div>
											<script>
												$('.selectize').selectize({
													// sortField: 'text'
												});
											</script>
										</ul>
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<div><?php echo $result_count; ?></div>
								<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
									<thead style="background:#3f86c3; color: #ffffff;">
									<tr>
										<th>#</th>
										<th>Tên CTV</th>
										<th>SĐT CTV</th>
										<th>Mã PT</th>
										<th>Loại PT</th>
										<th>Số tiền</th>
										<th>Trạng thái</th>
										<th>Phương thức thanh toán</th>
										<th>Ngân hàng</th>
										<th>Mã giao dịch ngân hàng</th>
										<th>Ghi chú</th>
										<th>Ngày thanh toán</th>
										<th>Thanh toán bởi</th>
									</tr>
									</thead>

									<tbody>
									<?php
									if (!empty($transactionData)) {
										foreach ($transactionData as $key => $tran) {
											?>
											<tr>
												<td><?php echo $key + 1 ?></td>
												<td><?= !empty($tran->customer_bill_name) ? $tran->customer_bill_name : "" ?></td>
												<td><?= !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : "" ?></td>
												<td><?= !empty($tran->code) ? $tran->code : "" ?></td>
												<td><?= !empty($tran->type) ? type_transaction($tran->type) : "" ?></td>
												<td><?= !empty($tran->total) ? number_format($tran->total, 0, ',', ',') : "" ?></td>
												<td>
													<?php if ($tran->status == 1) : ?>
														<span class="label label-success">Thanh toán thành công</span>
													<?php elseif ($tran->status == 2): ?>
														<span class="label label-default">Chờ ngân lượng xử lý</span>
													<?php elseif ($tran->status == 3): ?>
														<span class="label label-danger">Thanh toán thất bại</span>
													<?php endif; ?>
												</td>
												<td><?= !empty($tran->payment_method) ? ($tran->payment_method) : "" ?></td>
												<td><?= !empty($tran->bank) ? $tran->bank : ""; ?></td>
												<td><?= !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : ""; ?></td>
												<td><?= !empty($tran->note) ? $tran->note : ""; ?></td>
												<td><?= !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : date('d/m/Y H:i:s', intval($tran->created_at)) ?></td>
												<td><?= !empty($tran->created_by) ? $tran->created_by : "" ?></td>
											</tr>
										<?php }
									} ?>
									</tbody>
								</table>
								<div class="pagination pagination-sm">
									<?php echo $pagination ?>
								</div>
							</div>
							<br>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<script src="<?php echo base_url(); ?>assets/js/transaction/upload.js"></script>
<script src="<?php echo base_url(); ?>assets/js/transaction/index.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
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
	});

</script>

