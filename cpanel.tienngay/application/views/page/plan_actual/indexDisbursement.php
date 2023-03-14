<?php
$month = !empty($_GET['month']) ? $_GET['month'] : "";
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
						<h3>CF PLAN ACTUAL
						</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
<!--					<div class="row">-->
<!--						<ul class="nav nav-tabs" style="margin-bottom: 20px">-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexPlanActual">CF</a>-->
<!--							</li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexBankBalance">Số dư-->
<!--									các TK NH</a></li>-->
<!--							<li role="presentation"><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexFollowVPS">Theo dõi VPS</a></li>-->
<!--							<li role="presentation" ><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexFollowDebt">Quản lý hợp đồng vay</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexInvestor">Nhà đầu tư</a></li>-->
<!--							<li role="presentation" class="active"><a href="--><?php //echo base_url() ?><!--plan_actual/indexDisbursement">Giải ngân Actual</a></li>-->
<!--							<li role="presentation" ><a href="--><?php //echo base_url() ?><!--plan_actual/indexCpWork">CP hoạt động</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexHistorical">Historical Data CP</a></li>-->
<!--						</ul>-->
<!--					</div>-->
				</div>

				<style>
					@media screen and (max-width: 1440px) {
						.flex-search{
							display: flex;
							gap: 7%;
							padding-left: 10px;
						}
					}
				</style>

				<form action="<?php echo base_url('plan_actual/indexDisbursement') ?>" method="get"
					  style="width: 100%;">
					<div class="row flex-search">
						<div class="col-lg-2">
							<div class="input-group">
								<span class="input-group-addon">Tháng</span>
								<input type="month" name="month" class="form-control"
									   value="<?= isset($_GET['month']) ? $_GET['month'] : date('Y-m') ?>">
							</div>
						</div>

						<div class="col-lg-2" style="padding-left: 30px">
							<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																				   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
							</button>
						</div>
						<div class="col-lg-2">

							<a style="background-color: #18d102;" target="_blank"
							   href="<?= base_url() ?>excel/excel_disbursement?month=<?= $month ?>"
							   class="btn btn-primary w-100"><i class="fa fa-file-excel-o"
																aria-hidden="true"></i>&nbsp; Xuất Excel</a>
						</div>
					</div>
				</form>

				<div class="row">

					<div class="col-xs-12 col-md-6">
					</div>


					<div class="table-responsive col-xs-12 col-md-12" style="overflow-y: auto; padding-top: 20px">
						<table
							class="table table-bordered m-table table-hover table-calendar table-report">

							<thead style="color: white;">
							<tr>
								<th style="text-align: center">Ngày</th>
								<th style="text-align: center">KH PGD</th>
								<th style="text-align: center">KH (Priority + Nhà đất)</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<th style="text-align: center">Tổng</th>
								<th style="text-align: center"><?= number_format($total_kh_pgd) ?></th>
								<th style="text-align: center"><?= number_format($total_priority) ?></th>

							</tr>
							<?php if(!empty($data)): ?>
							<?php foreach ($data as $value): ?>
								<tr>
									<td style="text-align: center"><?= !empty($value->ngay_thang) ? $value->ngay_thang : "" ?></td>
									<td style="text-align: center"><?= !empty($value->kh_pgd) ? number_format($value->kh_pgd) : 0 ?></td>
									<td style="text-align: center"><?= !empty($value->priority) ? number_format($value->priority) : 0 ?></td>
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
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>

<style>
	.page-title {
		min-height: 0px;
		padding: 0px 0;
	}
</style>

