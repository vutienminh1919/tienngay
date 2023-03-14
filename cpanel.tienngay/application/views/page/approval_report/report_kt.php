<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">

<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử lý...</span>
	</div>
	<div class="row top_tiles">
		<?php
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$customer_form_hs = !empty($_GET['customer_form_hs']) ? $_GET['customer_form_hs'] : "";

		?>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Báo cáo kế toán
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">Export
								Excel Kế toán</a>
						</small>
					</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<div class="row">
								<form action="<?php echo base_url('Report_kt/index_report_kt') ?>" method="get"
									  style="width: 100%;">
									<div class="col-lg-2">

										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
											<input type="date" id="fdate_approval" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>"
												   >
										</div>
									</div>

									<div class="col-lg-2">

										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
											<input type="date" id="tdate_approval" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>"
												   >
										</div>
									</div>


									<div class="col-lg-2">

										<div>
											<select class="form-control" name="customer_form_hs"
													>
												<option value="">Chọn kế toán</option>
												<?php
												foreach ($list_kt as $key => $item) {
													?>

													<option value="<?php echo $item ?>" <?php echo $item == $customer_form_hs ? 'selected' : "" ?>><?= !empty($item) ? $item : "" ?></option>

												<?php } ?>
											</select>

										</div>
									</div>
									<div class="col-xs-12 col-lg-2">

										<button type="submit" class="btn btn-primary w-100"><i
													class="fa fa-search"
													aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>
									<div class="col-lg-1">

										<a style="background-color: #18d102;"
										   href="<?= base_url() ?>excel/excel_kt_report?fdate=<?= $fdate . '&tdate=' . $tdate . '&customer_form_hs=' . $customer_form_hs ?>"
										   class="btn btn-primary w-100"><i class="fa fa-file-excel-o"
																			aria-hidden="true"></i>&nbsp; Xuất Excel</a>
									</div>

								</form>
							</div>
						</div>


					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="x_content">
			<div class="row">
				<div class="col-xs-12">

					<div class="table-responsive">
						<table id="datatable-button" class="table table-striped">
							<thead>
							<tr>
								<th rowspan="2" style="text-align: center">STT</th>
								<th rowspan="2" style="text-align: center">Người thực hiện</th>
								<th rowspan="2" style="text-align: center">PGD</th>
								<th rowspan="2" style="text-align: center">Tên KH</th>
								<th rowspan="2" style="text-align: center">Mã phiếu ghi</th>
								<th rowspan="2" style="text-align: center">Số tiền YC</th>
								<th rowspan="2" style="text-align: center">Thời gian YC</th>
								<th colspan="3" style="text-align: center">Trạng thái</th>
								<th rowspan="2" style="text-align: center">Ghi chú</th>
								<th rowspan="2" style="text-align: center">Tổng số lần trả về</th>
								<th rowspan="2" style="text-align: center">Tổng thời gian xử lý</th>
							</tr>
							<tr>
								<th style="text-align: center; background-color: white; color: black">
									Trả về
								</th>
								<th style="text-align: center; background-color: white; color: black">
									Hủy
								</th>
								<th style="text-align: center; background-color: white; color: black">
									Duyệt
								</th>

							</tr>
							</thead>
							<tbody>

							<?php if (empty($view_report)): ?>
								<tr>
									<td>No data</td>
								</tr>
							<?php else: ?>
								<?php foreach ($view_report as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value['email_hs']) ? $value['email_hs'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['pgd']) ? $value['pgd'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['customer_name']) ? $value['customer_name'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['code_contract']) ? $value['code_contract'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['new_amount_loan']) ? $value['new_amount_loan'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['created_at_gdv']) ? $value['created_at_gdv'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['created_at_return']) ? $value['created_at_return'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['created_at_cancel']) ? $value['created_at_cancel'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['created_at_approval']) ? $value['created_at_approval'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['note']) ? $value['note'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['count_return']) ? $value['count_return'] : "" ?></td>
										<td style="text-align: center"><?= !empty($value['created_at_xl']) ? $value['created_at_xl'] : "" ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>

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
		$('#object').change(function () {
			var check_object = $('#object').val();

			if (check_object == "Phòng giao dịch") {
				$('#stores_ad_hide').show();
			}
			if (check_object == "Người phê duyệt") {
				$('.stores_ad').val("");
				$('#stores_ad_hide').hide();
			}
			if (check_object == "Khu vực") {
				$('.stores_ad').val("");
				$('#stores_ad_hide').hide();
			}


		})


	});

</script>
