<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$code = !empty($_GET['code']) ? $_GET['code'] : "";
	$total = !empty($_GET['total']) ? $_GET['total'] : "";
	$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
	$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";

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
					<h3>THỐNG KÊ PHIẾU THU TRẢ VỀ THEO PHÒNG GIAO DỊCH</h3>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>TỔNG CÁC PHÒNG GIAO DỊCH</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">
							<button class="btn btn-info show-hide-total-top-ten">
								Xem Top 10 phòng
							</button>
							<button class="btn btn-info show-hide-total-all">
								Xem Tất cả
							</button>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report">
							<thead style="background:#3f86c3; color: #ffffff;">
							<tr>
								<th>Phòng giao dịch</th>
								<th>Tiền phiếu thu</th>
							</tr>
							</thead>
							<tbody>
							<tr style="background: #8DEEEE; font-weight: bold">
								<td>Tổng</td>
								<td><?= !empty($sum_cod_not_yet_send_day) ? number_format($sum_cod_not_yet_send_day) . " đ" : 0 ?></td>
							</tr>
							<?php
							if (!empty($total_parent)) {
								$count = 0;
								foreach ($total_parent as $key => $amount_parent) {
									++$count;
									if ($count == 11) break;
									?>
									<tr>
										<td style="font-weight: bold"><?= !empty($amount_parent->store) ? "Phòng giao dịch - " . $amount_parent->store : "" ?></td>
										<td style="font-weight: bold"><?= !empty($amount_parent->store_child->total_cod_not_yet_send_day) ? number_format($amount_parent->store_child->total_cod_not_yet_send_day) . " đ" : 0 ?></td>
									</tr>
									<?php
								}
							} ?>
							</tbody>
						</table>
						<table id="detail-total"
							   class="table table-bordered m-table table-hover table-calendar table-report">
							<thead style="background:#3f86c3; color: #ffffff;">
							<tr>
								<th>Phòng giao dịch</th>
								<th>Tiền chưa nộp trong ngày</th>
							</tr>
							</thead>
							<tbody>
							<tr style="background: #8DEEEE; font-weight: bold">
								<td>Tổng</td>
								<td><?= !empty($sum_cod_not_yet_send_day) ? number_format($sum_cod_not_yet_send_day) . " đ" : 0 ?></td>
							</tr>
							<?php
							if (!empty($total_parent)) {
								foreach ($total_parent as $key => $amount_parent) {
									?>
									<tr>
										<td style="font-weight: bold"><?= !empty($amount_parent->store) ? "Phòng giao dịch - " . $amount_parent->store : "" ?></td>
										<td style="font-weight: bold"><?= !empty($amount_parent->store_child->total_cod_not_yet_send_day) ? number_format($amount_parent->store_child->total_cod_not_yet_send_day) . " đ" : 0 ?></td>
									</tr>
									<?php
								}
							} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>CHI TIẾT GIAO DỊCH</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">
							<?php
							if ($userSession['is_superadmin'] == 1 || in_array('ke-toan', $groupRoles)) { ?>
								<button id="btnExport" class="btn btn-primary" onclick="fnExcelReportTS();"> Export </button>
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
										<form action="<?php echo base_url('CashManagement/list_return') ?>" method="get"
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
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>
														Mã phiếu thu:
													</label>
													<input type="text" class="form-control" name="code"
														   placeholder="Nhập mã phiếu thu">
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Số tiền:</label>
													<input type="text" class="form-control" name="total"
														   placeholder="Nhập số tiền">
												</div>
											</div>
											<div class="col-xs-12 col-md-6" style="height: 66px">
												<div class="form-group">
													<label>PGD:</label>
													<select id="selectize_store"
															class="form-control selectize"
															multiple="multiple"
															placeholder="Tất cả"
															name="code_store[]">
														<option value="" <?php echo $store == '-' ? 'selected' : '' ?>>
															Tất cả
														</option>
														<?php foreach ($storeData as $p) { ?>
															<option <?php echo $store == $p->store_id ? 'selected' : '' ?>
																value="<?php echo $p->store_id; ?>"><?php echo $p->store_name; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Loại giao dịch:</label>
													<select class="form-control"
															placeholder="Tất cả"
															name="type_transaction">
														<option value="" <?php echo $type_transaction == '-' ? 'selected' : '' ?>>
															Tất cả
														</option>
														<?php foreach (type_transaction() as $key => $value) {
															if (in_array($key, [2, 5, 6, 9])) continue; ?>
															<option <?php echo $type_transaction == $key ? 'selected' : '' ?>
																value="<?= $key ?>"> <?= $value ?>
															</option>
														<?php } ?>
													</select>
												</div>
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
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div>
						<?php if (!empty($result_count)) {
							if ($result_count < 4000) {
								echo "";
							} else {
								echo "Hiển thị bị giới hạn " . "<span style='color: red'>  $result_count  </span>" . " giao dịch";
							}
						}; ?>
					</div>
					<div class="table-responsive" style="overflow-y: auto">
						<table id="table_detail_cod"
							   class="table table-bordered m-table table-hover table-calendar table-report ">
							<thead style="background:#3f86c3; color: #ffffff;">
							<tr>
								<th>STT</th>
								<th>Mã phiếu thu</th>
								<th>Loại phiếu thu</th>
								<th>Thời gian tạo PT</th>
								<th>Người thu</th>
								<th>Người nộp</th>
								<th>Tiền chưa nộp</th>
								<th>Trạng thái</th>
								<th>Người duyệt</th>
								<th>Thời gian trả về</th>
								<th>Chi tiết PT</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$n = 0;
							if (!empty($transactionData)) {
								foreach ($transactionData as $key => $transaction) {
									?>
									<tr style="background: #8DEEEE">
										<td colspan="6"
											style="font-weight: bold">
											<?php
											foreach ($storeData as $storeDatum) {
												if ($key == $storeDatum->store_id) {
													echo "Phòng giao dịch - " . $storeDatum->store_name;
													break;
												}
											}
											?>
										</td>
										<td style="font-weight: bold">
											<?php
											$total_not_yet_send_store = 0;
											foreach ($transaction as $key1 => $tran) {
												foreach ($tran as $key2 => $t) {
													$total_not_yet_send_store += $t->total_amount_not_yet_send_user;
												}
											}
											?>
											<?= number_format($total_not_yet_send_store) ?>
										</td>
										<td colspan="6"></td>
									</tr>
									<?php
									$count_lv1 = 0;
									foreach ($transaction as $key1 => $trans) {
										$tran = (array)$trans;
										?>
										<tr style="background: #ede8ab">
											<td style="font-weight: bold" colspan="6">
												<?php
												echo "&nbsp;&nbsp;" . $key1;
												?>
											</td>
											<td style="font-weight: bold">
												<?php
												echo number_format($tran[0]->total_amount_not_yet_send_user);
												?>
											</td>
											<td colspan="5"></td>
										</tr>
										<?php
										foreach ($tran as $key2 => $t) {
											?>
											<tr>
												<td><?php echo ++$n;?></td>
												<td><?= !empty($t->code) ? $t->code : (!empty($t->transaction_code) ? $t->transaction_code : (!empty($t->mic_code) ? $t->mic_code : (!empty($t->gic_code) ? $t->gic_code : (!empty($t->code_pti_vta) ? $t->code_pti_vta : "")))) ?></td>
												<td><?= !empty($t->type) ? type_transaction($t->type) : "" ?></td>
												<td>
													<?php
													if (!empty($t->created_at)) {
														echo date('d/m/Y <\b\r>H:i:s', $t->created_at);
													} else {
														echo date('d/m/Y <\b\r>H:i:s', $t->sent_approve_at);
													}
													?>
												</td>
												<td><?= !empty($t->user_full_name) ? $t->user_full_name : $t->created_by ?></td>
												<td>
													<?php
													if (!empty($t->customer_name)) {
														echo $t->customer_name;
													} elseif (!empty($t->customer_bill_name)) {
														echo $t->customer_bill_name;
													} elseif (!empty($t->name_driver)) {
														echo $t->name_driver;
													} elseif (!empty($t->customer_info->customer_name)) {
														echo $t->customer_info->customer_name;
													} else {
														echo '';
													}
													?>
												</td>
												<td>
													<?php
													if (in_array($t->status, [11])) {
														echo number_format($t->total);
													} elseif ($t->status == 10) {
														if (!empty($t->money)) {
															echo number_format($t->money);
														} elseif (!empty($t->mic_fee)) {
															echo number_format((int)$t->mic_fee);
														} elseif (!empty($t->fee)) {
															echo number_format((int)$t->fee);
														} elseif (!empty($t->price)) {
															echo number_format((int)$t->price);
														}
													} else {
														echo 0;
													}
													?>
												</td>
												<td>
													<?php if ($t->status == "new") : ?>
														<span class="label label-info">Mới</span>
													<?php elseif ($t->status == 2): ?>
														<span class="label label-default">Chờ xác nhận</span>
													<?php elseif ($t->status == 1): ?>
														<span class="label label-success">Thành công</span>
													<?php elseif ($t->status == 4): ?>
														<span class="label label-warning">Chưa gửi duyệt PT hợp đồng</span>
													<?php elseif ($t->status == 10): ?>
														<span class="label label-danger">Chưa gửi duyệt</span>
													<?php elseif ($t->status == 11): ?>
														<span class="label label-primary">Kế toán trả về PGD</span>
													<?php endif; ?>
												</td>
												<td><?= !empty($t->tran_created_by) ? $t->tran_created_by : "";?></td>
												<td><?php
													if ($t->status == 11) {
														if (!empty($t->tran_created_at)) {
															echo date('d/m/Y <\b\r>H:i:s', $t->tran_created_at);
														} else {
															echo date('d/m/Y <\b\r>H:i:s', $t->updated_at);
														}
													}
													?>
												</td>
												<td>
													<?php if (in_array($t->type, [1])) { ?>
														<a href="<?php echo base_url('transaction/view/' . $t->transaction_id) ?>"
														   class="dropdown-item"
														   target="_blank"
														   style="color: blue">
															Xem chi tiết
														</a>
													<?php } elseif (in_array($t->type, [3, 4])) { ?>
														<a href="<?php echo base_url('transaction/viewContract/' . $t->transaction_id) ?>"
														   class="dropdown-item"
														   target="_blank"
														   style="color: blue">
															Xem chi tiết
														</a>
													<?php } elseif ($t->type == 7 && $t->status != 10) { ?>
														<a href="<?php echo base_url('transaction/viewDetailHeyU/' . $t->transaction_id) ?>"
														   class="dropdown-item"
														   target="_blank"
														   style="color: blue">
															Xem chi tiết
														</a>
													<?php } elseif ($t->type == 8 && $t->status != 10) { ?>
														<a href="<?php echo base_url('transaction/viewDetailMicTnds/' . $t->transaction_id) ?>"
														   class="dropdown-item"
														   target="_blank"
														   style="color: blue">
															Xem chi tiết
														</a>
													<?php } elseif ($t->type == 10 && $t->status != 10) { ?>
														<a href="<?php echo base_url('transaction/viewDetailVbiTnds/' . $t->transaction_id) ?>"
														   class="dropdown-item"
														   target="_blank"
														   style="color: blue">
															Xem chi tiết
														</a>
													<?php } elseif ($t->type == 11 && $t->status != 10) { ?>
														<a href="<?php echo base_url('transaction/viewDetailVbiUtv/' . $t->transaction_id) ?>"
														   class="dropdown-item"
														   target="_blank"
														   style="color: blue">
															Xem chi tiết
														</a>
													<?php } elseif ($t->type == 12 && $t->status != 10) { ?>
														<a href="<?php echo base_url('transaction/viewDetailVbiSxh/' . $t->transaction_id) ?>"
														   class="dropdown-item"
														   target="_blank"
														   style="color: blue">
															Xem chi tiết
														</a>
													<?php } ?>
												</td>
											</tr>
										<?php }
									}
								}
								?>
								<?php
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#detail-total').hide();
		$('.show-hide-total-all').on('click', function () {
			$('#detail-total').show();
			$('#summary-total').hide();
		});
		$('.show-hide-total-top-ten').on('click', function () {
			$('#detail-total').hide();
			$('#summary-total').show();
		});

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
<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script>
	$('#selectize_store').selectize({
		create: false,
		valueField: 'code_address_store',
		labelField: 'name',
		searchField: 'name',
		maxItems: 100,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

	function fnExcelReportTS(e) {
		var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
		var textRange; var j=0;
		tab = document.getElementById('table_detail_cod'); // id of table

		for(j = 0 ; j < tab.rows.length ; j++)
		{
			tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
			//tab_text=tab_text+"</tr>";
		}

		tab_text=tab_text+"</table>";
		tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		var ua = window.navigator.userAgent;
		var msie = ua.indexOf("MSIE ");

		if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		{
			txtArea1.document.open("txt/html","replace");
			txtArea1.document.write(tab_text);
			txtArea1.document.close();
			txtArea1.focus();
			sa=txtArea1.document.execCommand("SaveAs",true,"data.xls");
		}
		else {
			var sa = document.createElement('a');
			var data_type = 'data:application/vnd.ms-excel';
			var table_html = encodeURIComponent(tab_text);
			sa.href = data_type + ', ' + table_html;
			let d = new Date();
			let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
			let mo = new Intl.DateTimeFormat('en', { month: 'numeric' }).format(d);
			let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
			let str_date = `${da}_${mo}_${ye}`;
			sa.download = 'RP_COD_STORE_'+ str_date +'.xls';
			sa.click();
			e.preventDefault();
		}
		return (sa);
	}
</script>







