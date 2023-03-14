<!-- page content -->
<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$area_search = !empty($_GET['area_search']) ? $_GET['area_search'] : "";
?>
<div class="right_col" role="main">
	<div class="report">
		<h1>BÁO CÁO HIỆU QUẢ KÊNH DIGITAL MẢNG CHO VAY</h1>
		<div class="report-nav">
			<small>

			</small>
			<a target="_blank" href="<?php echo base_url('dashboard/listHistory') ?>" type="button"
			   class="btn btn-success" style="margin-bottom: 2%;">lịch sử import <img
					src="https://service.tienngay.vn/uploads/avatar/1667377383-4612565c619acce608328c0da11a06dd.png"
					alt=""></a>
		</div>
		<div class="box1">
			<div class="box1-title">
				<h3>Báo cáo</h3>
				<div class="box1-btn">
					<a target="_blank" href="<?php echo base_url('dashboard/import_cost_mkt') ?>" type="button"
					   class="btn btn-outline-success">import file <img
							src="https://service.tienngay.vn/uploads/avatar/1667377208-c03ad235691d7f4280d85f3e33e343f7.png"
							alt=""></a>
					<a target="_blank" href="<?php echo base_url() ?>excel/export_digital_mkt?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&area_search=' . $area_search ?>" type="button" class="btn btn-outline-success">Xuất excel <img
							src="https://service.tienngay.vn/uploads/avatar/1667377271-115c1a99626e9cdc5e7369aa6a1cbcae.png"
							alt=""></a>
					<button type="button" class="btn btn-outline-success" data-toggle="modal"
							data-target="#exampleModal" style="background-color: #D2EADC !important;">Tìm kiếm <img
							src="https://service.tienngay.vn/uploads/avatar/1667377322-28321587346dc76b54b62085f6a9bace.png"
							alt=""></button>
					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
						 aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<form action="<?php echo base_url('dashboard/index_digital_mkt') ?>" method="get">

									<div class="modal-body">
										<div class="form-modal">
											<div class="form-ip">
												<label for="">Từ</label>
												<input type="datetime-local" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
											<div class="form-ip">
												<label for="">Đến</label>
												<input type="datetime-local" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">
											</div>
											<div class="form-ip">
												<label>Khu vực</label>
												<select name="area_search">
													<option value="" >Tất cả</option>
													<?php if (!empty($area)): ?>
														<?php foreach ($area as $value): ?>
															<option value="<?= $value->code ?>" <?= ($value == $area_search) ? "selected" : "" ?>  ><?= $value->title ?></option>
														<?php endforeach; ?>
													<?php endif; ?>

												</select>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary">Tìm
												kiếm
											</button>
										</div>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box1-table">
				<form action="">
					<div class="table-responsive">
						<table class="table ">
							<thead class="table-oder">
							<tr>
								<th scope="col"></th>
								<th scope="col" style="background-color: #1b74e4; color: white">Facebook</th>
								<th scope="col" style="background-color: #ea4335; color: white">Google</th>
								<th scope="col" style="background-color: #b6203e; color: white">Tiktok</th>
								<th scope="col">Khác</th>
								<th scope="col">Tổng</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($table_top)): ?>
								<?php foreach ($table_top as $key => $value): ?>
									<tr>
										<th scope="row"><?= !empty($value->name) ? $value->name : '' ?></php></th>
										<td><?= !empty($value->facebook) ? $value->facebook : 0 ?></td>
										<td><?= !empty($value->google) ? $value->google : 0 ?></td>
										<td><?= !empty($value->tiktok) ? $value->tiktok : 0 ?></td>
										<td><?= !empty($value->khac) ? $value->khac : 0 ?></td>
										<td><?= !empty($value->total) ? $value->total : 0 ?></td>
									</tr>
								<?php endforeach ?>
							<?php endif; ?>
							</tbody>
						</table>
					</div>
				</form>
				<form>
					<div class="card-body">
						<div class="outer">
							<table class="table table-hover bg-light">
								<thead>
								<tr>
									<th scope="col" rowspan="2" style="position: sticky; left: 0;">STT</th>
									<th scope="col" rowspan="2" style="position: sticky; left: 3%;">Phòng giao dịch</th>
									<th colspan="3" style="background-color: #1b74e4; color: white">Facebook</th>
									<th colspan="3" style="background-color: #ea4335; color: white">Google</th>
									<th colspan="3" style="background-color: #b6203e; color: white">Tiktok</th>
									<th colspan="3">Khác</th>
									<th colspan="2">Tổng</th>
								</tr>
								<tr>
									<th scope="col" style="background-color: #1b74e4; color: white">Lead qualified</th>
									<th scope="col" style="background-color: #1b74e4; color: white">Doanh số giải ngân</th>
									<th scope="col" style="background-color: #1b74e4; color: white">Chi phí MKT / Giải ngân</th>
									<th scope="col" style="background-color: #ea4335; color: white">Lead qualified</th>
									<th scope="col" style="background-color: #ea4335; color: white">Doanh số giải ngân</th>
									<th scope="col" style="background-color: #ea4335; color: white">Chi phí MKT / Giải ngân</th>
									<th scope="col" style="background-color: #b6203e; color: white">Lead qualified</th>
									<th scope="col" style="background-color: #b6203e; color: white">Doanh số giải ngân</th>
									<th scope="col" style="background-color: #b6203e; color: white">Chi phí MKT / Giải ngân</th>
									<th scope="col">Lead qualified</th>
									<th scope="col">Doanh số giải ngân</th>
									<th scope="col">Chi phí MKT / Giải ngân</th>
									<th scope="col">Lead qualified</th>
									<th scope="col">Doanh số giải ngân</th>

								</tr>
								</thead>
								<tbody>
								<?php if (!empty($data)): ?>
									<?php foreach ($data as $key => $value) : ?>

										<tr>
											<td  style="position: sticky; left: 0; background-color: #ffffff;"><?php echo ++$key ?></td>
											<td style="position: sticky; left: 3%; background-color: #ffffff;"><?= !empty($value->name_store) ? ($value->name_store) : "" ?></td>
											<td><?= !empty($value->facebook_leadQLF) ? number_format($value->facebook_leadQLF) : 0 ?></td>
											<td><?= !empty($value->facebook_amountMoney) ? number_format($value->facebook_amountMoney) : 0 ?></td>
											<td><?= !empty($value->facebook_costAmountMoney) ? ($value->facebook_costAmountMoney) : 0 ?></td>
											<td><?= !empty($value->google_leadQLF) ? number_format($value->google_leadQLF) : 0 ?></td>
											<td><?= !empty($value->google_amountMoney) ? number_format($value->google_amountMoney) : 0 ?></td>
											<td><?= !empty($value->google_costAmountMoney) ? ($value->google_costAmountMoney) : 0 ?></td>
											<td><?= !empty($value->tiktok_leadQLF) ? number_format($value->tiktok_leadQLF) : 0 ?></td>
											<td><?= !empty($value->tiktok_amountMoney) ? number_format($value->tiktok_amountMoney) : 0 ?></td>
											<td><?= !empty($value->tiktok_costAmountMoney) ? ($value->tiktok_costAmountMoney) : 0 ?></td>
											<td><?= !empty($value->khac_leadQLF) ? number_format($value->khac_leadQLF) : 0 ?></td>
											<td><?= !empty($value->khac_amountMoney) ? number_format($value->khac_amountMoney) : 0 ?></td>
											<td><?= !empty($value->khac_costAmountMoney) ? ($value->khac_costAmountMoney) : 0 ?></td>
											<td><?= !empty($value->total_leadQLF) ? number_format($value->total_leadQLF) : 0 ?></td>
											<td><?= !empty($value->total_amountMoney) ? number_format($value->total_amountMoney) : 0 ?></td>

										</tr>
									<?php endforeach ?>
								<?php endif; ?>
								</tbody>
								<thead>
								<tr>
									<th scope="col" colspan="2">Tổng</th>
									<?php if (!empty($table_total)): ?>
										<?php foreach ($table_total as $item) : ?>
											<th scope="col"><?php echo $item ?></th>
										<?php endforeach ?>
									<?php endif; ?>
								</tr>
								</thead>
							</table>
						</div>
					</div>

				</form>

			</div>

		</div>
	</div>
</div>

<style>
	.report h1 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.report-nav {
		display: flex;
		justify-content: space-between;
	}

	.box1-title {
		display: flex;
		justify-content: space-between;
	}

	td {
		word-wrap: break-word;
		text-align: center;
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: #676767;
	}

	.form-ip {
		display: flex;
		flex-direction: column;
	}

	.form-ip input {
		width: 100%;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding-left: 10px;
	}

	.form-ip select {
		width: 100%;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding-left: 10px;
	}

	.form-modal {
		display: flex;
		flex-direction: column;
		gap: 18px;

	}

	.modal-body {
		background-color: #FFFFFF !important;
		border-radius: 16px !important;
	}

	.box1 {
		background: #FFFFFF;
		/* Elevation 1 */
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.table-oder th {
		background-color: #E8F4ED;
		color: #262626;
		text-align: center;
	}

	.box1-title h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
		padding: 16px;
	}

	.box1-btn {
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.outer {
		overflow-y: auto;
		height: 600px;
	}

	.outer {
		width: 100%;
		-layout: fixed;
	}

	.outer thead {
		text-align: left;
		top: 0;
		z-index: 1000;
		position: sticky;
	}

	.outer th {
		background-color: #E8F4ED;
		text-align: center;
		padding: 10px 15px !important;
	}

	/* mobile :*/
	@media only screen and (max-width: 46.1875em) {
		.box1-title {
			display: flex;
			flex-direction: column;

		}
	}
</style>
