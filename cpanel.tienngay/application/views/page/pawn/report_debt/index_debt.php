<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
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
						<h3>Báo cáo tổng hợp
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
							<li role="presentation" class="active"><a
									href="<?php echo base_url() ?>report_kpi/index_report_debt">Báo cáo chi tiết</a>
							</li>
							<li role="presentation"><a href="<?php echo base_url() ?>report_kpi/index_report_debt_total">Báo
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

					<form action="<?php echo base_url('report_kpi/index_report_debt') ?>" method="get" style="width: 100%;">
						<div class="row flex-search">
							<div class="col-lg-3 col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Từ ngày</span>
									<input type="date" name="fdate" class="form-control"
										   value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : "" ?>">
								</div>

							</div>
							<div class="col-lg-3 col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Đến ngày</span>
									<input type="date" name="tdate" class="form-control"
										   value="<?= isset($_GET['tdate']) ? $_GET['tdate'] : "" ?>">
								</div>
							</div>

							<div class="col-lg-2 col-md-2">
								<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																					   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
								</button>
							</div>
							<div class="col-lg-2 col-md-2">
								<a style="background-color: #18d102;" target="_blank"
								   href="<?= base_url() ?>excel/export_report_debt?fdate=<?= $fdate ?>&tdate=<?= $tdate ?>"
								   class="btn btn-primary w-100"><i class="fa fa-file-excel-o"
																	aria-hidden="true"></i>&nbsp; Xuất Excel</a>
							</div>

						</div>
					</form>


				</div>

				<div class="table-responsive-md col-xs-12 col-md-12 outer" style="overflow-x: scroll">
					<table class="table table-bordered m-table table-hover table-calendar table-report ">

						<thead style="position: sticky; position: -webkit-sticky; top: 0">
						<tr style="color: white">
							<th style="text-align: center">STT</th>
							<th style="text-align: center">Mã phiếu ghi</th>
							<th style="text-align: center">Mã hợp đồng</th>
							<th style="text-align: center">Số tiền vay</th>
							<th style="text-align: center">Sản phẩm vay</th>
							<th style="text-align: center">Kỳ hạn vay</th>
							<th style="text-align: center">Ngày giải ngân</th>
							<th style="text-align: center">Ngày đáo hạn</th>
							<th style="text-align: center">Ngày chậm trả</th>
							<th style="text-align: center">Phòng giao dịch</th>
							<th style="text-align: center">Gốc còn lại</th>
							<th style="text-align: center">Gốc còn lại trong hạn T+10</th>
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
								<?php
								$du_no_trong_han = 0;
								$du_no_b0 = 0;
								$du_no_b1 = 0;
								$du_no_b2 = 0;
								$du_no_b3 = 0;
								$du_no_b4 = 0;

								if($value->data->debt->so_ngay_cham_tra <= 10){
									$du_no_trong_han =  number_format($value->data->debt->tong_tien_goc_con);
								}
								if ($value->data->debt->so_ngay_cham_tra <= 0){
									$du_no_b0 = number_format($value->data->debt->tong_tien_goc_con);
								} elseif ($value->data->debt->so_ngay_cham_tra >= 1 && $value->data->debt->so_ngay_cham_tra <= 30){
									$du_no_b1 = number_format($value->data->debt->tong_tien_goc_con);
								} elseif ($value->data->debt->so_ngay_cham_tra >= 31 && $value->data->debt->so_ngay_cham_tra <= 60){
									$du_no_b2 = number_format($value->data->debt->tong_tien_goc_con);
								} elseif ($value->data->debt->so_ngay_cham_tra >= 61 && $value->data->debt->so_ngay_cham_tra <= 90){
									$du_no_b3 = number_format($value->data->debt->tong_tien_goc_con);
								} else {
									$du_no_b4 = number_format($value->data->debt->tong_tien_goc_con);
								}

								?>
								<tr>
									<td style="text-align: center"><?= ++$key ?></td>
									<td style="text-align: center"><?= !empty($value->data->code_contract) ? $value->data->code_contract : '' ?></td>
									<td><?= !empty($value->data->code_contract_disbursement) ? $value->data->code_contract_disbursement : '' ?></td>
									<td style="text-align: center"><?= !empty($value->data->loan_infor->amount_money) ? number_format($value->data->loan_infor->amount_money) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->data->loan_infor->type_property->text) ? ($value->data->loan_infor->type_property->text) : "" ?></td>
									<td style="text-align: center"><?= !empty($value->data->loan_infor->number_day_loan) ? $value->data->loan_infor->number_day_loan / 30 : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->data->disbursement_date) ? date('d/m/Y', $value->data->disbursement_date) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->data->debt->ky_tt_xa_nhat) ? date('d/m/Y', $value->data->debt->ky_tt_xa_nhat) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->data->debt->so_ngay_cham_tra) ? $value->data->debt->so_ngay_cham_tra : 0 ?></td>
									<td><?= !empty($value->data->store->name) ? $value->data->store->name : "" ?></td>
									<td style="text-align: center"><?= !empty($value->data->debt->tong_tien_goc_con) ? number_format($value->data->debt->tong_tien_goc_con) : 0 ?></td>
									<td style="text-align: center"><?= !empty($du_no_trong_han) ? $du_no_trong_han : 0 ?></td>
									<td style="text-align: center"><?= !empty($du_no_b0) ? $du_no_b0 : 0 ?></td>
									<td style="text-align: center"><?= !empty($du_no_b1) ? $du_no_b1 : 0 ?></td>
									<td style="text-align: center"><?= !empty($du_no_b2) ? $du_no_b2 : 0 ?></td>
									<td style="text-align: center"><?= !empty($du_no_b3) ? $du_no_b3 : 0 ?></td>
									<td style="text-align: center"><?= !empty($du_no_b4) ? $du_no_b4 : 0 ?></td>
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
</style>

