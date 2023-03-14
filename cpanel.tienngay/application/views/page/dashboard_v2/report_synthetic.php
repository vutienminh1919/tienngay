
<div class="right_col" role="main">

	<?php
	$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
	$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
	?>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Báo cáo kinh doanh</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<?php if ($this->session->flashdata('error')) { ?>
								<div class="alert alert-danger alert-result">
									<?= $this->session->flashdata('error') ?>
								</div>
							<?php } ?>
							<?php if ($this->session->flashdata('success')) { ?>
								<div
									class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
							<?php } ?>
							<div class="row">
								<form action="<?php echo base_url('report_kpi/index_report_synthetic') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12">
										<div class="row">

											<div class="col-xs-12 col-lg-2 ">
												<label>&nbsp;</label>
												<input type="month" name="month" class="form-control"
													   value="<?= !empty($month) ? $month : "" ?>">
											</div>

											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary w-100"><i
														class="fa fa-search"
														aria-hidden="true"></i> <?= $this->lang->line('search') ?>
												</button>
											</div>

											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<a style="background-color: #18d102;"
												   href="<?= base_url() ?>excel/report_synthetic?month=<?= $month ?>"
												   class="btn btn-primary w-100"><i
														class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
													Export Excel
												</a>
											</div>
										</div>
									</div>
								</form>
								<br>
								<div class="col-xs-12">
									<div class="row">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Tên phòng giao dịch</th>
								<th style="text-align: center">Địa chỉ phòng giao dịch</th>
								<th style="text-align: center">Thời gian hoạt động</th>
								<th style="text-align: center">Số lượng CVKD</th>
								<th style="text-align: center">Khu vực</th>
								<th style="text-align: center">Tỉnh</th>
								<th style="text-align: center">Miền</th>
								<th style="text-align: center">Số lượng hợp đồng (Xe máy + Ô tô)</th>
								<th style="text-align: center">Số lượng HĐ thời gian vay</th>
								<th style="text-align: center">Tiền giải ngân mới kỳ này</th>
								<th style="text-align: center">Gốc còn lại tăng net T+10</th>
								<th style="text-align: center">Doanh số bảo hiểm kỳ này</th>
								<th style="text-align: center">Tổng tiền giải ngân</th>
								<th style="text-align: center">Gốc còn lại quản lý</th>
								<th style="text-align: center">Gốc còn lại trong hạn T+10 hiện tại</th>
								<th style="text-align: center">Gốc còn lại trong hạn T+10 kỳ trước</th>
								<th style="text-align: center">Gốc còn lại
									<br>(1 <= B1 <= 30)
									<br>(31 <= B2 <= 60)
									<br>(61 <= B3 <= 90)
									<br>(B4+ > 90)
								</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($data)): ?>
								<?php foreach ($data as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td style=""><?= !empty($value->name) ? $value->name : "" ?></td>
										<td style=""><?= !empty($value->address) ? $value->address : "" ?></td>
										<td style="text-align: center"><?= !empty($value->created_at) ? date('d/m/Y', $value->created_at) : '' ?></td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->nhanvien) ? $value->nhanvien : 0 ?>"> <?= !empty($value->nhanvien) ? number_format($value->nhanvien) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->nhanvien) ? $value->nhanvien : 0 ?>'
												   id='nhanvien-<?= !empty($value->_id) ? $value->_id : '' ?>-<?= !empty($value->nhanvien) ? $value->nhanvien : 0 ?>'/>
										</td>
										<td style="text-align: center"><?= !empty($value->code_area) ? $value->code_area : "" ?></td>
										<td style="text-align: center"><?= !empty($value->province) ? $value->province : "" ?></td>
										<td style="text-align: center"><?= !empty($value->area) ? $value->area : "" ?></td>
										<td style="">
											Hợp đồng xe
											máy: <?= !empty($value->count_hd_xm) ? number_format($value->count_hd_xm) : 0 ?>
											<br>
											Hợp đồng ô
											tô: <?= !empty($value->count_hd_oto) ? number_format($value->count_hd_oto) : 0 ?>

										</td>
										<td style="">
											Hợp đồng vay
											1T: <?= !empty($value->count_hd_1) ? number_format($value->count_hd_1) : 0 ?>
											<br>
											Hợp đồng vay
											3T: <?= !empty($value->count_hd_3) ? number_format($value->count_hd_3) : 0 ?>
											<br>
											Hợp đồng lớn hơn
											6T: <?= !empty($value->count_hd_6) ? number_format($value->count_hd_6) : 0 ?>
										</td>
										<td style="text-align: center"><?= !empty($value->amount_money) ? number_format($value->amount_money) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->du_no_tang_net) ? number_format($value->du_no_tang_net) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->insurance_sales) ? number_format($value->insurance_sales) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->total_amount_money) ? number_format($value->total_amount_money) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->total_du_no_dang_cho_vay_old) ? number_format($value->total_du_no_dang_cho_vay_old) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->du_no_trong_han_T10_hien_tai) ? number_format($value->du_no_trong_han_T10_hien_tai) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->du_no_trong_han_T10_ky_truoc) ? number_format($value->du_no_trong_han_T10_ky_truoc) : 0 ?></td>
										<td style="">
											B1: <?= !empty($value->total_du_no_b1) ? number_format($value->total_du_no_b1) : 0 ?>
											<br>
											B2: <?= !empty($value->total_du_no_b2) ? number_format($value->total_du_no_b2) : 0 ?>
											<br>
											B3: <?= !empty($value->total_du_no_b3) ? number_format($value->total_du_no_b3) : 0 ?>
											<br>
											B4+: <?= !empty($value->total_du_no_b4) ? number_format($value->total_du_no_b4) : 0 ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							</tbody>
						</table>
						<div class="">

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>

<style>
	.text_content {
		padding: 10px;
		border: 1px solid #ddd;
		font-size: 14px;
	}

	.text_content h4 {
		margin-top: 0;
		color: #ff0000;
		font-weight: 600;
	}
</style>

<script type="text/javascript">
	$(document).ready(function () {
		// Show Input element
		$('.edit').click(function () {
			var status = $(this).data('status');

			$('.txtedit').hide();
			$(this).next('.txtedit').show().focus();
			$(this).hide();

		});

		// Save data
		$(".txtedit").on('focusout', function () {

			// Get edit id, field name and value
			var id = this.id;
			var split_id = id.split("-");
			console.log(split_id)
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var value = $(this).val();

			// Hide Input element
			$(this).hide();

			// Hide and Change Text of the container with input elmeent
			$(this).prev('.edit').show();
			$(this).prev('.edit').text(numeral(value).format('0,0'));
			// Sending AJAX request
			$.ajax({
				url: _url.base_url + 'store/updateUserStore',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id},
				success: function (response) {
					console.log('Save successfully');
				}
			});
		});
	});
</script>
<script>
	$('ul.tabs li').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs li').removeClass('active');
		$('.tab-panel').removeClass('active');
		$(this).addClass('active');
		$("#" + tab_id).addClass('active');
	})
</script>









