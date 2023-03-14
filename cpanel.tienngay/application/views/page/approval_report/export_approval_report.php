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
		$change_time = !empty($_GET['change_time']) ? $_GET['change_time'] : "";
		$stores_ad = !empty($_GET['stores_ad']) ? $_GET['stores_ad'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$customer_form_hs = !empty($_GET['customer_form_hs']) ? $_GET['customer_form_hs'] : "";

		?>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Báo cáo ban phê duyệt
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">Export
								Excel Ban Phê Duyệt</a>
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
								<form action="<?php echo base_url('approval_report/index_approval') ?>" method="get"
									  style="width: 100%;">
									<div class="col-lg-2">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
											<input type="date" id="fdate_approval" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>"
												   onchange="this.form.submit()">
										</div>
									</div>

									<div class="col-lg-2">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
											<input type="date" id="tdate_approval" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>"
												   onchange="this.form.submit()">
										</div>
									</div>

									<div class="col-lg-2">
										<label></label>
										<div>
											<select class="form-control" name="change_time"
													onchange="this.form.submit()">
												<option value="">Chọn thời gian</option>
												<option value="Từ ngày đến ngày" <?php echo $change_time == "Từ ngày đến ngày" ? 'selected' : '' ?>>
													Từ ngày đến ngày
												</option>
												<option value="Ngày hôm nay" <?php echo $change_time == "Ngày hôm nay" ? 'selected' : '' ?>>
													Ngày hôm nay
												</option>
												<option value="Tuần" <?php echo $change_time == "Tuần" ? 'selected' : '' ?>>
													Tuần
												</option>
												<option value="Tháng" <?php echo $change_time == "Tháng" ? 'selected' : '' ?>>
													Tháng
												</option>
												<option value="Quý" <?php echo $change_time == "Quý" ? 'selected' : '' ?>>
													Quý
												</option>
												<option value="Năm" <?php echo $change_time == "Năm" ? 'selected' : '' ?>>
													Năm
												</option>
											</select>
										</div>
									</div>

									<div class="col-lg-1">
										<label></label>
										<div>
											<select class="form-control" name="area" onchange="this.form.submit()">
												<option value="">Khu vực</option>
												<option value="Hà Nội" <?php echo $area == "Hà Nội" ? 'selected' : '' ?>>
													Hà Nội
												</option>
												<option value="Tp Hồ Chí Minh" <?php echo $area == "Tp Hồ Chí Minh" ? 'selected' : '' ?>>
													Tp Hồ Chí Minh
												</option>
												<option value="Mekong" <?php echo $area == "Mekong" ? 'selected' : '' ?>>
													Mekong
												</option>
											</select>
										</div>
									</div>

									<div class="col-lg-2">
										<label></label>
										<div>
											<select class="form-control" name="stores_ad" onchange="this.form.submit()">
												<option value="">Chọn phòng giao dịch</option>
												<?php
												foreach ($stores as $key => $value) {
													if ($value->status != 'active')
														continue;
													?>
													<option value="<?php echo $value->name ?>" <?php echo $value->name == $stores_ad ? 'selected' : "" ?>><?= !empty($value->name) ? $value->name : "" ?></option>
												<?php } ?>
											</select>

										</div>

									</div>

									<div class="col-lg-2">
										<label></label>
										<div>
											<select class="form-control" name="customer_form_hs"
													onchange="this.form.submit()">
												<option value="">Chọn người phê duyệt</option>
												<?php
												foreach ($list_hs as $key => $item) {
													?>

													<option value="<?php echo $item ?>" <?php echo $item == $customer_form_hs ? 'selected' : "" ?>><?= !empty($item) ? $item : "" ?></option>

												<?php } ?>
											</select>

										</div>
									</div>
									<div class="col-lg-1">
										<label></label>
										<a style="background-color: #18d102;"
										   href="<?= base_url() ?>excel/excel_approval_report?fdate=<?= $fdate . '&tdate=' . $tdate . '&change_time=' . $change_time . '&stores_ad=' . $stores_ad . '&area=' . $area . '&customer_form_hs=' . $customer_form_hs ?>"
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
