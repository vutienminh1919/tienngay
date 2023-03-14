<?php
$date = !empty($_GET['date']) ? $_GET['date'] : "";

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Báo cáo tổng hợp gốc còn lại
						</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<ul class="nav nav-tabs" style="margin-bottom: 20px">
							<li role="presentation" ><a
									href="<?php echo base_url() ?>report_kpi/index_report_debt">Báo cáo chi tiết</a>
							</li>
							<li role="presentation" class="active"><a href="<?php echo base_url() ?>report_kpi/index_report_debt_total">Báo
									cáo tổng hợp</a></li>
							<li role="presentation"><a href="<?php echo base_url() ?>report_kpi/index_report_debt_total_bds">Báo
									cáo tổng hợp (Không tính bất động sản)</a></li>
						</ul>
					</div>

					<style>
						@media screen and (max-width: 1440px) {
							.flex-search {
								display: flex;
								gap: 1%;
								padding-left: 10px;
							}
						}
					</style>

					<form action="<?php echo base_url('report_kpi/index_report_debt_total') ?>" method="get" style="width: 100%;">
						<div class="row flex-search">
							<div class="col-lg-3 col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Ngày</span>
									<input type="date" name="date" class="form-control"
										   value="<?= isset($_GET['date']) ? $_GET['date'] : date('Y-m-d') ?>">
								</div>
							</div>

							<div class="col-lg-2 col-md-2">
								<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																					   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
								</button>
							</div>
							<div class="col-lg-2 col-md-2">
								<a style="background-color: #18d102;" target="_blank"
								   href="<?= base_url() ?>excel/index_report_debt_total?date=<?= $date ?>"
								   class="btn btn-primary w-100"><i class="fa fa-file-excel-o"
																	aria-hidden="true"></i>&nbsp; Xuất Excel</a>
							</div>

						</div>
					</form>


				</div>

				<div class="table-responsive-md col-xs-12 col-md-12 outer" style="overflow-x: scroll">
					<table class="table table-bordered m-table table-hover table-calendar table-report ">

						<thead style="position: sticky; position: -webkit-sticky; top: 0 ; z-index: 10;">
						<tr style="color: white">
							<th style="text-align: center;background: #037734 !important;top:0 ;" class="stick-one">STT</th>
							<th style="text-align: center;background: #037734 !important; top: 0; " class="stick-two">Tên PGD</th>
							<th style="text-align: center">Địa chỉ PGD</th>
							<th style="text-align: center">Tỉnh</th>
							<th style="text-align: center">Khu vực</th>
							<th style="text-align: center">Miền</th>
							<th style="text-align: center">Số HĐ xe máy</th>
							<th style="text-align: center">Số HĐ ô tô</th>
							<th style="text-align: center">Số HĐ vay 1T</th>
							<th style="text-align: center">Số HĐ vay 3T</th>
							<th style="text-align: center">Số HĐ vay lớn hơn 6T</th>
							<th style="text-align: center">Bảo hiểm</th>
							<th style="text-align: center">Tiền giải ngân mới trong kỳ</th>
							<th style="text-align: center">Gốc còn lại trong hạn T+10 kỳ trước</th>
							<th style="text-align: center">Gốc còn lại trong hạn T+10 hiện tại</th>
							<th style="text-align: center">Gốc còn lại tăng net T+10</th>
							<th style="text-align: center">Gốc còn lại quản lý</th>
							<th style="text-align: center">Gốc còn lại tăng net</th>
							<th style="text-align: center">Gốc còn lại B0 (B0 <= 0)</th>
							<th style="text-align: center">Gốc còn lại B1 (1 <= B1 <= 30)</th>
							<th style="text-align: center">Gốc còn lại B2 (31 <= B2 <= 60)</th>
							<th style="text-align: center">Gốc còn lại B3 (61 <= B3 <= 90)</th>
							<th style="text-align: center">Gốc còn lại B4+ (90 < B4+)</th>
						</tr>
						</thead>

						<tbody>
						<?php if (!empty($contractData)): ?>
							<?php foreach ($contractData as $key => $value): ?>
								<tr>
									<td style="text-align: center; background-color: white;" class="stick-one"><?= ++$key ?></td>
									<td class="stick-two" style="background-color: white;"><?= !empty($value->name) ? $value->name : '' ?></td>
									<td><?= !empty($value->address) ? $value->address : '' ?></td>
									<td><?= !empty($value->province) ? $value->province : '' ?></td>
									<td><?= !empty($value->code_area) ? $value->code_area : '' ?></td>
									<td><?= !empty($value->area) ? $value->area : '' ?></td>
									<td style="text-align: center"><?= !empty($value->count_hd_xm) ? number_format($value->count_hd_xm) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->count_hd_oto) ? number_format($value->count_hd_oto) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->count_hd_1) ? number_format($value->count_hd_1) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->count_hd_3) ? number_format($value->count_hd_3) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->count_hd_6) ? number_format($value->count_hd_6) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->bao_hiem) ? number_format($value->bao_hiem) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->amount_money) ? number_format($value->amount_money) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->du_no_trong_han_T10_ky_truoc) ? number_format($value->du_no_trong_han_T10_ky_truoc) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->du_no_trong_han_T10_hien_tai) ? number_format($value->du_no_trong_han_T10_hien_tai) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->du_no_tang_net_T10) ? number_format($value->du_no_tang_net_T10) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->du_no_quan_ly) ? number_format($value->du_no_quan_ly) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->du_no_tang_net) ? number_format($value->du_no_tang_net) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->total_du_no_b0) ? number_format($value->total_du_no_b0) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->total_du_no_b1) ? number_format($value->total_du_no_b1) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->total_du_no_b2) ? number_format($value->total_du_no_b2) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->total_du_no_b3) ? number_format($value->total_du_no_b3) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->total_du_no_b4) ? number_format($value->total_du_no_b4) : 0 ?></td>

								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>

					</table>
					<div class="">
						<?php echo $pagination ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<!--Modal-->
<style>
	.page-title {
		min-height: 0px;
		padding: 0px 0;
	}

	.stick-one{
	 position: sticky;
	 left: -15px;
	 text-align: left;
	 z-index: 5;
	
	}
	.stick-two{
	 position: sticky;
	 left: 25px;
	 text-align: left;
	 z-index: 5;
	}

	.outer{
		height: 800px;
	}
</style>

