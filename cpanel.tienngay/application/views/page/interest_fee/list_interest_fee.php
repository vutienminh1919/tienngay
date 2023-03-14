<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

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
								<h3>LỊCH SỬ LÃI PHÍ</h3>
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
								<div class="col-xs-12 col-md-6">
								</div>
								<div class="col-xs-12 col-md-6 text-right">
									<?php
									if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles)) { ?>
										<button class="btn btn-info d-none">
											<a href="<?= base_url() ?>excel/exportInterestFee?<?= 'fdate=' . $fdate . '&tdate=' . $tdate ?>"
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
												<form action="<?php echo base_url('Ksnb_report/getDataInterestFee') ?>"
													  method="get"
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
							<br>


						</div>
					</div>
					<div class="row table-responsive">
<!--						<div class="table-responsive" style="overflow-y: auto">-->
							<table class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
								<thead style="background:#3f86c3; color: #ffffff;">
								<tr>
									<th>Hình thức + Sản phẩm</th>
									<th>Thời gian vay (Số ngày)</th>
									<th>Lãi NĐT</th>
									<th>Phí tư vẫn</th>
									<th>Phí thẩm định</th>
									<th>Phí chậm trả (%)</th>
									<th>Phí phạt chậm trả (VNĐ)</th>
									<th>Phí gia hạn (VNĐ)</th>
									<th>Tất toán trước 1/3</th>
									<th>Tất toán trước 1/3 - 2/3</th>
									<th>Tất toán sau 2/3</th>
								</tr>
								</thead>

								<tbody>
								<?php
								if (!empty($dataInterestFee)) {
									foreach ($dataInterestFee as $key => $itemnterest_fee) {
										?>
										<tr style="background: #8DEEEE">
											<th colspan="11"><?= !empty($itemnterest_fee->created_at) ? "Từ ngày " . date('d/m/Y', $itemnterest_fee->created_at) : '' ?></th>
										</tr>
										<?php foreach ($itemnterest_fee as $key1 => $type_loan) {
											if ($key1 == 'created_at') continue; ?>
											<tr style="background: #ede8ab">
												<th colspan="11">
													<?php
													if ($key1 == "DKXM") {
														echo "Cho vay (Xe máy)";
													} elseif ($key1 == "DKXOTO") {
														echo "Cho vay (Ô tô)";
													} elseif ($key1 == "CC") {
														echo "Cầm cố xe";
													} elseif ($key1 == "TC") {
														echo "Tín chấp";
													} elseif ($key1 == "KDOL") {
														echo "Kinh doanh Online";
													} elseif ($key1 == "DKX") {
														echo 'Cho vay xe';
													} else {
														echo "";
													}
													?>
												</th>
											</tr>
											<?php foreach ($type_loan as $key2 => $item) { ?>
												<tr>
													<th></th>
													<td><?= !empty($key2) ? $key2 . " ngày" : "" ?></td>
													<td><?= !empty($item->percent_interest_customer) ? $item->percent_interest_customer . '%' : 0 . '%' ?></td>
													<td><?= !empty($item->percent_advisory) ? $item->percent_advisory . '%' : 0 . '%' ?></td>
													<td><?= !empty($item->percent_expertise) ? $item->percent_expertise . '%' : 0 . '%' ?></td>
													<td><?= !empty($item->penalty_percent) ? $item->penalty_percent . '%' : 0 . '%' ?></td>
													<td><?= !empty($item->penalty_amount) ? number_format($item->penalty_amount) . ' VNĐ' : 0 . '%' ?></td>
													<td><?= !empty($item->extend) ? number_format($item->extend) . ' VNĐ' : 0 . '%' ?></td>
													<td><?= !empty($item->percent_prepay_phase_1) ? $item->percent_prepay_phase_1 . '%' : 0 . '%' ?></td>
													<td><?= !empty($item->percent_prepay_phase_2) ? $item->percent_prepay_phase_2 . '%' : 0 . '%' ?></td>
													<td><?= !empty($item->percent_prepay_phase_3) ? $item->percent_prepay_phase_3 . '%' : 0 . '%' ?></td>

												</tr>
											<?php } ?>
											<?php
										}
									}
								} ?>
								</tbody>
							</table>
<!--						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
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

